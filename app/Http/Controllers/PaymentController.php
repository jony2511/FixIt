<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\SSLCommerzService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    protected $sslcommerz;

    public function __construct(SSLCommerzService $sslcommerz)
    {
        $this->middleware('auth')->only(['initiatePayment']);
        $this->sslcommerz = $sslcommerz;
    }

    /**
     * Initiate payment with SSLCommerz
     */
    public function initiatePayment(Request $request)
    {
        // Get checkout data from session
        $checkoutData = session('checkout_data');
        
        if (!$checkoutData) {
            return redirect()->route('checkout')->with('error', 'Checkout session expired. Please try again.');
        }

        // Get cart items
        $cartItems = \App\Models\Cart::where(function($query) {
            if (auth()->id()) {
                $query->where('user_id', auth()->id());
            } else {
                $query->where('session_id', session()->getId());
            }
        })->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate total
        $totalAmount = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        // Create order
        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'payment_method' => 'online',
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'shipping_name' => $checkoutData['shipping_name'],
                'shipping_email' => $checkoutData['shipping_email'],
                'shipping_phone' => $checkoutData['shipping_phone'],
                'shipping_address' => $checkoutData['shipping_address'],
                'shipping_city' => $checkoutData['shipping_city'],
                'shipping_postal_code' => $checkoutData['shipping_postal_code'],
                'notes' => $checkoutData['notes'] ?? '',
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                ]);
            }

            // Generate unique transaction ID
            $transactionId = 'TXN' . time() . rand(1000, 9999);

            // Prepare payment data for SSLCommerz
            $paymentData = [
                'total_amount' => $totalAmount,
                'currency' => 'BDT',
                'transaction_id' => $transactionId,
                'customer_name' => $checkoutData['shipping_name'],
                'customer_email' => $checkoutData['shipping_email'],
                'customer_phone' => $checkoutData['shipping_phone'],
                'customer_address' => $checkoutData['shipping_address'],
                'customer_city' => $checkoutData['shipping_city'],
                'customer_postcode' => $checkoutData['shipping_postal_code'] ?? '1000',
                'customer_country' => 'Bangladesh',
                'product_name' => 'Order #' . $order->order_number,
                'product_category' => 'Maintenance Products',
                'order_id' => $order->id,
                'user_id' => auth()->id(),
                'notes' => $checkoutData['notes'] ?? '',
            ];

            // Store transaction ID in order
            $order->update(['transaction_id' => $transactionId]);

            // Initiate payment with SSLCommerz
            $paymentResponse = $this->sslcommerz->initiatePayment($paymentData);

            if ($paymentResponse['success']) {
                DB::commit();
                // Redirect to SSLCommerz payment gateway
                return redirect()->away($paymentResponse['gateway_url']);
            } else {
                DB::rollBack();
                return redirect()->route('checkout')->with('error', $paymentResponse['message']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Initiation Error', ['error' => $e->getMessage()]);
            return redirect()->route('checkout')->with('error', 'Payment initiation failed. Please try again.');
        }
    }

    /**
     * Handle successful payment callback
     */
    public function paymentSuccess(Request $request)
    {
        Log::info('Payment Success Callback', $request->all());

        $transactionId = $request->input('tran_id');
        $valId = $request->input('val_id');

        // Find order by transaction ID
        $order = Order::where('transaction_id', $transactionId)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        // Validate payment with SSLCommerz
        $validation = $this->sslcommerz->validatePayment([
            'val_id' => $valId,
            'store_id' => $request->input('store_id'),
            'store_passwd' => config('services.sslcommerz.store_password'),
        ]);

        if ($validation['success']) {
            DB::beginTransaction();
            try {
                // Update order status
                $order->update([
                    'payment_status' => 'paid',
                    'order_status' => 'processing',
                    'payment_details' => json_encode($request->all()),
                ]);

                // Update product stock
                foreach ($order->items as $item) {
                    $product = Product::find($item->product_id);
                    if ($product) {
                        $product->quantity -= $item->quantity;
                        $product->updateStockStatus();
                        $product->save();
                    }
                }

                // Clear cart
                \App\Models\Cart::where('user_id', auth()->id())->delete();

                // Clear checkout session
                session()->forget('checkout_data');

                DB::commit();

                return redirect()->route('orders.show', $order)
                    ->with('success', 'Payment successful! Your order has been placed.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Payment Success Processing Error', ['error' => $e->getMessage()]);
                return redirect()->route('orders.show', $order)
                    ->with('warning', 'Payment received but order processing encountered an issue. Please contact support.');
            }
        }

        return redirect()->route('orders.show', $order)
            ->with('error', 'Payment validation failed. Please contact support.');
    }

    /**
     * Handle failed payment callback
     */
    public function paymentFail(Request $request)
    {
        Log::warning('Payment Failed Callback', $request->all());

        $transactionId = $request->input('tran_id');
        $order = Order::where('transaction_id', $transactionId)->first();

        if ($order) {
            $order->update([
                'payment_status' => 'failed',
                'payment_details' => json_encode($request->all()),
            ]);
        }

        return redirect()->route('checkout')->with('error', 'Payment failed. Please try again or use a different payment method.');
    }

    /**
     * Handle cancelled payment callback
     */
    public function paymentCancel(Request $request)
    {
        Log::info('Payment Cancelled Callback', $request->all());

        $transactionId = $request->input('tran_id');
        $order = Order::where('transaction_id', $transactionId)->first();

        if ($order) {
            $order->update([
                'payment_status' => 'cancelled',
                'order_status' => 'cancelled',
                'payment_details' => json_encode($request->all()),
            ]);
        }

        return redirect()->route('checkout')->with('info', 'Payment was cancelled. You can try again.');
    }

    /**
     * Handle Instant Payment Notification (IPN)
     */
    public function paymentIPN(Request $request)
    {
        Log::info('Payment IPN Callback', $request->all());

        $transactionId = $request->input('tran_id');
        $valId = $request->input('val_id');

        // Find order by transaction ID
        $order = Order::where('transaction_id', $transactionId)->first();

        if (!$order) {
            Log::warning('IPN: Order not found', ['transaction_id' => $transactionId]);
            return response('Order not found', 404);
        }

        // Validate payment with SSLCommerz
        $validation = $this->sslcommerz->validatePayment([
            'val_id' => $valId,
            'store_id' => $request->input('store_id'),
            'store_passwd' => config('services.sslcommerz.store_password'),
        ]);

        if ($validation['success']) {
            // Update order if not already updated
            if ($order->payment_status === 'pending') {
                DB::beginTransaction();
                try {
                    $order->update([
                        'payment_status' => 'paid',
                        'order_status' => 'processing',
                        'payment_details' => json_encode($request->all()),
                    ]);

                    // Update product stock
                    foreach ($order->items as $item) {
                        $product = Product::find($item->product_id);
                        if ($product) {
                            $product->quantity -= $item->quantity;
                            $product->updateStockStatus();
                            $product->save();
                        }
                    }

                    DB::commit();
                    Log::info('IPN: Order updated successfully', ['order_id' => $order->id]);
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::error('IPN: Order update failed', ['error' => $e->getMessage()]);
                }
            }
        }

        return response('OK', 200);
    }
}
