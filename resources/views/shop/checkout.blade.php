<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-credit-card mr-2"></i>{{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('orders.place') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Checkout Form -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Shipping Information -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-shipping-fast mr-2"></i>Shipping Information
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                    <input type="text" name="shipping_name" id="shipping_name" required
                                        value="{{ old('shipping_name', auth()->user()->name) }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('shipping_name')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shipping_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                                    <input type="tel" name="shipping_phone" id="shipping_phone" required
                                        value="{{ old('shipping_phone', auth()->user()->phone) }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('shipping_phone')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Street Address *</label>
                                    <textarea name="shipping_address" id="shipping_address" rows="3" required
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('shipping_address', auth()->user()->address) }}</textarea>
                                    @error('shipping_address')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                                    <input type="text" name="shipping_city" id="shipping_city" required
                                        value="{{ old('shipping_city') }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('shipping_city')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="shipping_postal_code" class="block text-sm font-medium text-gray-700 mb-1">Postal Code *</label>
                                    <input type="text" name="shipping_postal_code" id="shipping_postal_code" required
                                        value="{{ old('shipping_postal_code') }}"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('shipping_postal_code')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-wallet mr-2"></i>Payment Method
                            </h3>
                            
                            <div class="space-y-3">
                                <label class="flex items-center p-4 border-2 border-blue-500 rounded-lg cursor-pointer bg-blue-50">
                                    <input type="radio" name="payment_method" value="cod" checked
                                        class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3 flex-grow">
                                        <span class="block font-semibold text-gray-800">
                                            <i class="fas fa-money-bill-wave mr-2"></i>Cash on Delivery
                                        </span>
                                        <span class="block text-sm text-gray-600">Pay when you receive your order</span>
                                    </div>
                                    <span class="px-3 py-1 bg-blue-600 text-white text-xs rounded-full">Recommended</span>
                                </label>

                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 opacity-50">
                                    <input type="radio" name="payment_method" value="online" disabled
                                        class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <div class="ml-3 flex-grow">
                                        <span class="block font-semibold text-gray-800">
                                            <i class="fas fa-credit-card mr-2"></i>Online Payment
                                        </span>
                                        <span class="block text-sm text-gray-600">Pay securely online (Coming Soon)</span>
                                    </div>
                                </label>
                            </div>
                            @error('payment_method')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Additional Notes -->
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-sticky-note mr-2"></i>Additional Notes (Optional)
                            </h3>
                            <textarea name="notes" id="notes" rows="4" 
                                placeholder="Any special instructions for delivery?"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h3>
                            
                            <!-- Cart Items -->
                            <div class="space-y-3 mb-4 max-h-64 overflow-y-auto">
                                @foreach($cartItems as $item)
                                    <div class="flex gap-3 pb-3 border-b">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" 
                                                class="w-16 h-16 object-cover rounded">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow">
                                            <p class="font-semibold text-sm text-gray-800">{{ $item->product->name }}</p>
                                            <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                            <p class="text-sm font-bold text-blue-600">${{ number_format($item->subtotal, 2) }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Totals -->
                            <div class="space-y-3 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600">
                                    <span>Shipping</span>
                                    <span class="text-green-600">FREE</span>
                                </div>
                                <div class="border-t pt-3 flex justify-between text-lg font-bold text-gray-800">
                                    <span>Total</span>
                                    <span class="text-blue-600">${{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition font-semibold">
                                <i class="fas fa-check-circle mr-2"></i>Place Order
                            </button>

                            <a href="{{ route('cart.index') }}" class="block w-full px-6 py-2 mt-3 text-center text-blue-600 hover:text-blue-700">
                                <i class="fas fa-arrow-left mr-2"></i>Back to Cart
                            </a>

                            <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded text-sm text-green-800">
                                <i class="fas fa-shield-alt mr-2"></i>
                                Secure checkout process
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
