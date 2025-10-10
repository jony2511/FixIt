<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Order #{{ $order->id }} Details
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('user.orders') }}" class="text-blue-600 hover:text-blue-800">
                    ← Back to Orders
                </a>
                @if($order->status === 'completed')
                    <a href="{{ route('user.orders.invoice', $order->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Invoice
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Order Status Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Order Status</h3>
                    @if($order->status === 'pending')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                            </svg>
                            Pending
                        </span>
                    @elseif($order->status === 'processing')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                            </svg>
                            Processing
                        </span>
                    @elseif($order->status === 'completed')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Completed
                        </span>
                    @elseif($order->status === 'cancelled')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            Cancelled
                        </span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ $order->created_at->format('M d') }}</div>
                        <div class="text-sm text-gray-500">Order Placed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold {{ $order->status === 'pending' ? 'text-gray-400' : 'text-blue-600' }}">
                            @if($order->status === 'pending')
                                --
                            @else
                                {{ $order->updated_at->format('M d') }}
                            @endif
                        </div>
                        <div class="text-sm text-gray-500">Processing Started</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold {{ in_array($order->status, ['pending', 'processing']) ? 'text-gray-400' : 'text-yellow-600' }}">
                            @if(in_array($order->status, ['pending', 'processing']))
                                --
                            @else
                                {{ $order->updated_at->format('M d') }}
                            @endif
                        </div>
                        <div class="text-sm text-gray-500">Shipped</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold {{ $order->status !== 'completed' ? 'text-gray-400' : 'text-green-600' }}">
                            @if($order->status !== 'completed')
                                --
                            @else
                                {{ $order->updated_at->format('M d') }}
                            @endif
                        </div>
                        <div class="text-sm text-gray-500">Delivered</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Order Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Order Items</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                @foreach($order->orderItems as $item)
                                <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                                    <!-- Product Image Placeholder -->
                                    <div class="flex-shrink-0 w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    </div>
                                    
                                    <!-- Product Details -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-900 truncate">{{ $item->product->name }}</h4>
                                        @if($item->product->description)
                                            <p class="text-sm text-gray-500 truncate">{{ Str::limit($item->product->description, 60) }}</p>
                                        @endif
                                        <div class="flex items-center mt-1">
                                            <span class="text-sm text-gray-500">Qty: {{ $item->quantity }}</span>
                                            <span class="mx-2 text-gray-300">•</span>
                                            <span class="text-sm text-gray-500">৳{{ number_format($item->price, 2) }} each</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Item Total -->
                                    <div class="flex-shrink-0 text-right">
                                        <div class="text-sm font-medium text-gray-900">৳{{ number_format($item->price * $item->quantity, 2) }}</div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary & Info -->
                <div class="space-y-6">
                    
                    <!-- Order Summary -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Order Summary</h3>
                        </div>
                        <div class="p-6">
                            @php
                                $subtotal = $order->orderItems->sum(function($item) {
                                    return $item->price * $item->quantity;
                                });
                                $shipping = 50; // Fixed shipping cost
                            @endphp
                            
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="font-medium text-gray-900">৳{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="font-medium text-gray-900">৳{{ number_format($shipping, 2) }}</span>
                                </div>
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-base font-medium text-gray-900">Total</span>
                                        <span class="text-lg font-bold text-gray-900">৳{{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Payment Information</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Payment Method</span>
                                <span class="font-medium text-gray-900">
                                    @if($order->payment_method === 'cod')
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            Cash on Delivery
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Online Payment
                                        </span>
                                    @endif
                                </span>
                            </div>
                            @if($order->transaction_id)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Transaction ID</span>
                                <span class="font-mono text-xs text-gray-900">{{ $order->transaction_id }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Payment Status</span>
                                <span class="font-medium">
                                    @if($order->status === 'completed')
                                        <span class="text-green-600">✓ Paid</span>
                                    @elseif($order->payment_method === 'cod')
                                        <span class="text-orange-600">◯ Cash on Delivery</span>
                                    @else
                                        <span class="text-red-600">◯ Pending</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Shipping Information</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $order->user->name }}</div>
                                <div class="text-sm text-gray-600 mt-1">
                                    {{ $order->shipping_address }}<br>
                                    {{ $order->shipping_city }}, {{ $order->shipping_postal_code }}<br>
                                    Phone: {{ $order->phone }}
                                </div>
                                @if($order->shipping_email)
                                    <div class="text-sm text-gray-600">
                                        Email: {{ $order->shipping_email }}
                                    </div>
                                @endif
                            </div>
                            @if($order->notes)
                            <div class="pt-3 border-t border-gray-200">
                                <div class="text-sm font-medium text-gray-900">Special Instructions</div>
                                <div class="text-sm text-gray-600 mt-1">{{ $order->notes }}</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Order Timeline -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Order Timeline</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Order Placed</div>
                                        <div class="text-xs text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                                    </div>
                                </div>
                                
                                @if($order->status !== 'pending')
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-2 h-2 bg-yellow-600 rounded-full mt-2"></div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Order Processing</div>
                                        <div class="text-xs text-gray-500">{{ $order->updated_at->format('M d, Y h:i A') }}</div>
                                    </div>
                                </div>
                                @endif
                                
                                @if($order->status === 'completed')
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-2 h-2 bg-green-600 rounded-full mt-2"></div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Order Completed</div>
                                        <div class="text-xs text-gray-500">{{ $order->updated_at->format('M d, Y h:i A') }}</div>
                                    </div>
                                </div>
                                @endif
                                
                                @if($order->status === 'cancelled')
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0 w-2 h-2 bg-red-600 rounded-full mt-2"></div>
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">Order Cancelled</div>
                                        <div class="text-xs text-gray-500">{{ $order->updated_at->format('M d, Y h:i A') }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>