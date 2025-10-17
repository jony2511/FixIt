@extends('layouts.sidebar')

@section('title', 'Shopping Cart')
@section('page-title', 'Shopping Cart')
@section('page-description', 'Review your items before checkout')

@section('content')
    <div>
        <div class="max-w-7xl mx-auto">
            @if($cartItems->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4">
                        @foreach($cartItems as $item)
                            <div class="bg-white rounded-lg shadow-sm p-4">
                                <div class="flex gap-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" 
                                                class="w-24 h-24 object-cover rounded">
                                        @else
                                            <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-image text-2xl text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h3 class="font-semibold text-lg text-gray-800">
                                                    <a href="{{ route('shop.show', $item->product) }}" class="hover:text-blue-600">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h3>
                                                <p class="text-sm text-gray-500">
                                                    <i class="fas fa-tag mr-1"></i>{{ $item->product->category->name }}
                                                </p>
                                                @if($item->product->brand)
                                                    <p class="text-sm text-gray-600">Brand: {{ $item->product->brand }}</p>
                                                @endif
                                            </div>
                                            <form action="{{ route('cart.remove', $item) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>

                                        <div class="mt-4 flex items-center justify-between">
                                            <!-- Quantity Update -->
                                            <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                @method('PUT')
                                                <label for="quantity_{{ $item->id }}" class="text-sm text-gray-700">Qty:</label>
                                                <input type="number" name="quantity" id="quantity_{{ $item->id }}" 
                                                    value="{{ $item->quantity }}" min="1" max="{{ $item->product->quantity }}"
                                                    class="w-20 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                                    onchange="this.form.submit()">
                                            </form>

                                            <!-- Price -->
                                            <div class="text-right">
                                                <p class="text-sm text-gray-500">Tk.{{ number_format($item->price, 2) }} each</p>
                                                <p class="text-lg font-bold text-blue-600">Tk.{{ number_format($item->subtotal, 2) }}</p>
                                            </div>
                                        </div>

                                        @if($item->product->quantity < $item->quantity)
                                            <div class="mt-2 p-2 bg-red-50 border border-red-200 rounded text-sm text-red-800">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Only {{ $item->product->quantity }} available in stock
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Clear Cart Button -->
                        <form action="{{ route('cart.clear') }}" method="POST" 
                            onsubmit="return confirm('Are you sure you want to clear your cart?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 transition">
                                <i class="fas fa-trash mr-2"></i>Clear Cart
                            </button>
                        </form>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h3>
                            
                            <div class="space-y-3 mb-6">
                                @php
                                    $subtotal = $cartItems->sum('subtotal');
                                    $shipping = $subtotal > 500 ? 0 : 50; // Free shipping above Tk.500
                                    $grandTotal = $subtotal + $shipping;
                                @endphp
                                <div class="flex justify-between text-gray-600">
                                    <span>Items ({{ $cartItems->count() }})</span>
                                    <span>Tk.{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    @if($shipping > 0)
                                        <span>Tk.{{ number_format($shipping, 2) }}</span>
                                    @else
                                        <span class="text-green-600">FREE</span>
                                    @endif
                                </div>
                                @if($subtotal > 0 && $subtotal <= 500)
                                    <div class="text-xs text-gray-500">
                                        Add Tk.{{ number_format(500 - $subtotal, 2) }} more for free shipping!
                                    </div>
                                @endif
                                <div class="border-t pt-3 flex justify-between text-lg font-bold text-gray-800">
                                    <span>Total</span>
                                    <span class="text-blue-600">Tk.{{ number_format($grandTotal, 2) }}</span>
                                </div>
                            </div>

                            @auth
                                <a href="{{ route('checkout') }}" class="block w-full px-6 py-3 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 transition font-semibold">
                                    <i class="fas fa-lock mr-2"></i>Proceed to Checkout
                                </a>
                            @else
                                <div class="space-y-3">
                                    <a href="{{ route('login') }}" class="block w-full px-6 py-3 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 transition font-semibold">
                                        <i class="fas fa-sign-in-alt mr-2"></i>Login to Checkout
                                    </a>
                                    <p class="text-sm text-gray-600 text-center">
                                        Don't have an account? 
                                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700">Register</a>
                                    </p>
                                </div>
                            @endauth

                            <a href="{{ route('shop.index') }}" class="block w-full px-6 py-2 mt-3 text-center text-blue-600 hover:text-blue-700">
                                <i class="fas fa-arrow-left mr-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-semibold text-gray-700 mb-2">Your Cart is Empty</h3>
                    <p class="text-gray-500 mb-6">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('shop.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        <i class="fas fa-store mr-2"></i>Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
