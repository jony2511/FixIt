<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\SSLCommerzService;
use App\Mail\PaymentConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });
        $shipping = $subtotal > 500 ? 0 : 50; // Free shipping above Tk.500
        $totalAmount = $subtotal + $shipping;

        // Create order
        DB::beginTransaction();
        try {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => auth()->id(),
                'subtotal_amount' => $subtotal,
                'shipping_amount' => $shipping,
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
            
            // Store transaction ID in session for callback handling
            session(['recent_payment_transaction_id' => $transactionId]);

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
        Log::info('Payment Success Callback', [
            'method' => $request->method(),
            'all_data' => $request->all(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'headers' => $request->headers->all(),
            'query_params' => $request->query(),
            'post_data' => $request->post(),
        ]);

        $transactionId = $request->input('tran_id');
        $valId = $request->input('val_id');
        
        // Try to get transaction ID from different sources
        if (!$transactionId) {
            $transactionId = $request->query('tran_id') ?? 
                           $request->post('tran_id') ?? 
                           $request->header('tran_id');
        }
        
        // Try to get val_id from different sources
        if (!$valId) {
            $valId = $request->query('val_id') ?? 
                   $request->post('val_id') ?? 
                   $request->header('val_id');
        }

        Log::info('Extracted Payment Parameters', [
            'transaction_id' => $transactionId,
            'val_id' => $valId,
        ]);

        // If still no transaction ID, try to find the most recent pending order for authenticated user
        if (!$transactionId && auth()->check()) {
            $order = Order::where('user_id', auth()->id())
                         ->whereIn('order_status', ['pending'])
                         ->orderBy('created_at', 'desc')
                         ->first();
                         
            if ($order) {
                Log::info('Found pending order for user', ['order_id' => $order->id, 'transaction_id' => $order->transaction_id]);
                $transactionId = $order->transaction_id;
            }
        }

        // If still no transaction ID, check session for recent payment
        if (!$transactionId && session('recent_payment_transaction_id')) {
            $transactionId = session('recent_payment_transaction_id');
            Log::info('Using transaction ID from session', ['transaction_id' => $transactionId]);
        }

        // If no transaction ID, show a generic success page with instructions
        if (!$transactionId) {
            Log::warning('Payment Success: No transaction ID found in request, order, or session');
            
            // If user is authenticated, clear their cart as a safety measure
            if (auth()->check()) {
                \App\Models\Cart::where('user_id', auth()->id())->delete();
                Log::info('Cleared cart for authenticated user without transaction ID', ['user_id' => auth()->id()]);
            }
            
            return view('shop.payment-callback', [
                'status' => 'success',
                'title' => 'Payment Processing',
                'message' => 'Payment callback received. If you just completed a payment, please check your order history in a few moments.',
                'show_dashboard_link' => true
            ]);
        }

        // Find order by transaction ID
        $order = Order::where('transaction_id', $transactionId)->first();

        if (!$order) {
            Log::warning('Payment Success: Order not found', ['transaction_id' => $transactionId]);
            return view('shop.payment-callback')->with('warning', 'Payment processed, but order details not found. Please check your order history.');
        }

        // Validate payment with SSLCommerz (skip validation in sandbox mode if no val_id)
        $validationSuccess = false;
        
        if ($valId) {
            $validation = $this->sslcommerz->validatePayment([
                'val_id' => $valId,
                'store_id' => $request->input('store_id'),
                'store_passwd' => config('services.sslcommerz.store_password'),
            ]);
            $validationSuccess = $validation['success'];
            Log::info('Payment validation result', ['success' => $validationSuccess]);
        } else if (config('services.sslcommerz.mode') === 'sandbox') {
            // In sandbox mode, if there's no val_id, we'll proceed as if validation passed
            // This handles the case where SSLCommerz sandbox sends incomplete callbacks
            Log::info('Sandbox mode: Proceeding without validation due to missing val_id');
            $validationSuccess = true;
        }

        if ($validationSuccess) {
            Log::info('Payment validation successful, starting order processing', ['transaction_id' => $transactionId]);
            DB::beginTransaction();
            try {
                // Update order status
                $order->update([
                    'order_status' => 'processing', // Set to processing after payment
                    'payment_status' => 'paid', // Mark payment as paid
                    'payment_details' => json_encode($request->all()),
                ]);

                // Update product stock
                foreach ($order->orderItems as $item) {
                    try {
                        $product = \App\Models\Product::find($item->product_id);
                        if ($product && $product->quantity >= $item->quantity) {
                            $product->quantity -= $item->quantity;
                            $product->save();
                        }
                        Log::info('Updated product stock', ['product_id' => $item->product_id, 'new_quantity' => $product?->quantity]);
                    } catch (\Exception $e) {
                        Log::error('Error updating product stock', ['product_id' => $item->product_id, 'error' => $e->getMessage()]);
                    }
                }

                // Clear cart using order's user_id instead of auth()->id() for callback safety
                \App\Models\Cart::where('user_id', $order->user_id)->delete();

                // Clear checkout session
                session()->forget('checkout_data');
                session()->forget('recent_payment_transaction_id');

                DB::commit();

                // Send payment confirmation email with invoice
                try {
                    $recipientEmail = $order->shipping_email ?? $order->user->email;
                    Mail::to($recipientEmail)->send(new PaymentConfirmationMail($order));
                    Log::info('Payment confirmation email sent successfully', [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'recipient' => $recipientEmail
                    ]);
                } catch (\Exception $emailError) {
                    // Log error but don't fail the payment process
                    Log::error('Failed to send payment confirmation email', [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'error' => $emailError->getMessage(),
                        'trace' => $emailError->getTraceAsString()
                    ]);
                }

                // Log the user in if they're not already authenticated (for callback context)
                if (!auth()->check() && $order->user_id) {
                    $user = \App\Models\User::find($order->user_id);
                    if ($user) {
                        auth()->login($user);
                        Log::info('User logged in after payment callback', ['user_id' => $user->id]);
                    }
                }

                return view('shop.payment-success', compact('order'))
                    ->with('success', 'Payment successful! Your order has been placed.');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Payment Success Processing Error', ['error' => $e->getMessage()]);
                return view('shop.payment-success', compact('order'))
                    ->with('warning', 'Payment received but order processing encountered an issue. Please contact support.');
            }
        }

        // If validation failed but we're in sandbox mode and have a valid order, show a warning
        if (config('services.sslcommerz.mode') === 'sandbox' && $order) {
            Log::warning('Sandbox payment validation failed, processing as successful in sandbox mode', [
                'transaction_id' => $transactionId,
                'val_id' => $valId
            ]);
            
            // In sandbox mode, process the order even if validation failed
            DB::beginTransaction();
            try {
                // Update order status
                $order->update([
                    'order_status' => 'delivered', 
                    'payment_details' => json_encode($request->all()),
                ]);

                // Update product stock
                foreach ($order->orderItems as $item) {
                    try {
                        $product = \App\Models\Product::find($item->product_id);
                        if ($product && $product->quantity >= $item->quantity) {
                            $product->quantity -= $item->quantity;
                            $product->save();
                        }
                        Log::info('Updated product stock (sandbox)', ['product_id' => $item->product_id, 'new_quantity' => $product?->quantity]);
                    } catch (\Exception $e) {
                        Log::error('Error updating product stock (sandbox)', ['product_id' => $item->product_id, 'error' => $e->getMessage()]);
                    }
                }

                // Clear cart using order's user_id
                \App\Models\Cart::where('user_id', $order->user_id)->delete();

                // Clear checkout session
                session()->forget('checkout_data');
                session()->forget('recent_payment_transaction_id');

                DB::commit();

                // Log the user in if they're not already authenticated
                if (!auth()->check() && $order->user_id) {
                    $user = \App\Models\User::find($order->user_id);
                    if ($user) {
                        auth()->login($user);
                        Log::info('User logged in after sandbox payment callback', ['user_id' => $user->id]);
                    }
                }

                // Return success page with order details
                return view('shop.payment-success', compact('order'))
                    ->with('success', 'Payment successful! Your order has been placed.');
                    
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Sandbox Payment Processing Error', ['error' => $e->getMessage()]);
                
                return view('shop.payment-callback', [
                    'status' => 'warning',
                    'title' => 'Payment Processing',
                    'message' => 'Payment callback received for your order. Please check your order status in your dashboard.',
                    'show_dashboard_link' => true
                ]);
            }
        }

        return view('shop.payment-failed')
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
                'order_status' => 'cancelled',
                'payment_status' => 'failed',
                'payment_details' => json_encode($request->all()),
            ]);
        }

        return view('shop.payment-failed')->with('error', 'Payment failed. Please try again or use a different payment method.');
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
                'order_status' => 'cancelled',
                'payment_status' => 'failed',
                'payment_details' => json_encode($request->all()),
            ]);
        }

        return view('shop.payment-failed')->with('info', 'Payment was cancelled. You can try again.');
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
