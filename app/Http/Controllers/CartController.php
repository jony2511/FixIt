<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $cartItems->sum('subtotal');

        return view('shop.cart', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($product->quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock available.');
        }

        $userId = Auth::id();
        $sessionId = Session::getId();

        $cartItem = Cart::where('product_id', $product->id)
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($product->quantity < $newQuantity) {
                return back()->with('error', 'Cannot add more items. Insufficient stock.');
            }
            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        return back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cart->product->quantity < $request->quantity) {
            return back()->with('error', 'Insufficient stock available.');
        }

        $cart->quantity = $request->quantity;
        $cart->save();

        return back()->with('success', 'Cart updated successfully!');
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Item removed from cart!');
    }

    public function clear()
    {
        $userId = Auth::id();
        $sessionId = Session::getId();

        Cart::where(function($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->delete();

        return back()->with('success', 'Cart cleared successfully!');
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
