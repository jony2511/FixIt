<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout()
    {
        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = $cartItems->sum('subtotal');
        $shipping = $subtotal > 500 ? 0 : 50; // Free shipping above Tk.500
        $total = $subtotal + $shipping;

        return view('shop.checkout', compact('cartItems', 'total', 'subtotal', 'shipping'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'shipping_city' => 'required|string|max:100',
            'shipping_postal_code' => 'required|string|max:20',
            'payment_method' => 'required|in:cod,online',
            'notes' => 'nullable|string',
        ]);

        $cartItems = $this->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty!');
        }

        // For online payment, redirect to payment initiation
        if ($request->payment_method === 'online') {
            // Store shipping info in session temporarily
            Session::put('checkout_data', $request->except('_token'));
            return redirect()->route('payment.initiate');
        }

        try {
            DB::beginTransaction();

            // Check stock availability
            foreach ($cartItems as $item) {
                if ($item->product->quantity < $item->quantity) {
                    throw new \Exception("Insufficient stock for {$item->product->name}");
                }
            }

            // Calculate totals
            $subtotal = $cartItems->sum('subtotal');
            $shipping = $subtotal > 500 ? 0 : 50; // Free shipping above Tk.500
            $totalAmount = $subtotal + $shipping;

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'subtotal_amount' => $subtotal,
                'shipping_amount' => $shipping,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'shipping_name' => $request->shipping_name,
                'shipping_email' => $request->shipping_email,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_postal_code' => $request->shipping_postal_code,
                'notes' => $request->notes,
            ]);

            // Create order items and update product stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->subtotal,
                ]);

                // Update product quantity
                $product = Product::find($item->product_id);
                $product->quantity -= $item->quantity;
                $product->updateStockStatus();
            }

            // Clear cart
            $userId = Auth::id();
            $sessionId = Session::getId();
            
            Cart::where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully! Order Number: ' . $order->order_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to place order: ' . $e->getMessage())->withInput();
        }
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('shop.orders', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $order->load('items.product', 'user');

        return view('shop.order-detail', compact('order'));
    }

    private function getCartItems()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        return Cart::with('product.category')
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->get();
    }
}
