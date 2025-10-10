<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-gray-800 leading-tight">
                <i class="fas fa-box mr-2"></i>Order #{{ $order->order_number }}
            </h2>
            <a href="{{ route('orders.index') }}" class="text-blue-600 hover:text-blue-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Orders
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Status -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Order Status</h3>
                        
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                @if($order->order_status == 'pending')
                                    <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-semibold">
                                        <i class="fas fa-clock mr-2"></i>Pending
                                    </span>
                                @elseif($order->order_status == 'processing')
                                    <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-full font-semibold">
                                        <i class="fas fa-cog mr-2"></i>Processing
                                    </span>
                                @elseif($order->order_status == 'shipped')
                                    <span class="px-4 py-2 bg-purple-100 text-purple-800 rounded-full font-semibold">
                                        <i class="fas fa-shipping-fast mr-2"></i>Shipped
                                    </span>
                                @elseif($order->order_status == 'delivered')
                                    <span class="px-4 py-2 bg-green-100 text-green-800 rounded-full font-semibold">
                                        <i class="fas fa-check-circle mr-2"></i>Delivered
                                    </span>
                                @else
                                    <span class="px-4 py-2 bg-red-100 text-red-800 rounded-full font-semibold">
                                        <i class="fas fa-times-circle mr-2"></i>Cancelled
                                    </span>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">Payment Status</p>
                                @if($order->payment_status == 'paid')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                        <i class="fas fa-check mr-1"></i>Paid
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-semibold">
                                        <i class="fas fa-clock mr-1"></i>{{ ucfirst($order->payment_status) }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Order Timeline -->
                        <div class="relative">
                            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200"></div>
                            
                            <div class="relative space-y-4">
                                <!-- Order Placed -->
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Order Placed</p>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                </div>

                                <!-- Processing -->
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0 w-8 h-8 {{ in_array($order->order_status, ['processing', 'shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Processing</p>
                                        <p class="text-sm text-gray-600">
                                            {{ in_array($order->order_status, ['processing', 'shipped', 'delivered']) ? 'Being prepared' : 'Waiting to be processed' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Shipped -->
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0 w-8 h-8 {{ in_array($order->order_status, ['shipped', 'delivered']) ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Shipped</p>
                                        <p class="text-sm text-gray-600">
                                            {{ in_array($order->order_status, ['shipped', 'delivered']) ? 'Out for delivery' : 'Not shipped yet' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Delivered -->
                                <div class="flex gap-4">
                                    <div class="flex-shrink-0 w-8 h-8 {{ $order->order_status == 'delivered' ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center">
                                        <i class="fas fa-check text-white text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Delivered</p>
                                        <p class="text-sm text-gray-600">
                                            {{ $order->delivered_at ? $order->delivered_at->format('M d, Y h:i A') : 'Not delivered yet' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Order Items</h3>
                        
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex gap-4 pb-4 border-b last:border-b-0">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" 
                                            class="w-24 h-24 object-cover rounded">
                                    @else
                                        <div class="w-24 h-24 bg-gray-200 rounded flex items-center justify-center">
                                            <i class="fas fa-image text-2xl text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow">
                                        <h4 class="font-semibold text-lg text-gray-800">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-600">
                                            <i class="fas fa-tag mr-1"></i>{{ $item->product->category->name }}
                                        </p>
                                        @if($item->product->brand)
                                            <p class="text-sm text-gray-600">Brand: {{ $item->product->brand }}</p>
                                        @endif
                                        <div class="mt-2 flex justify-between items-center">
                                            <p class="text-gray-700">
                                                Qty: <span class="font-semibold">{{ $item->quantity }}</span> × 
                                                Tk.{{ number_format($item->price, 2) }}
                                            </p>
                                            <p class="text-xl font-bold text-blue-600">Tk.{{ number_format($item->subtotal, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-shipping-fast mr-2"></i>Shipping Information
                        </h3>
                        <div class="space-y-2">
                            <p class="text-gray-700"><span class="font-semibold">Name:</span> {{ $order->shipping_name }}</p>
                            <p class="text-gray-700"><span class="font-semibold">Phone:</span> {{ $order->shipping_phone }}</p>
                            <p class="text-gray-700"><span class="font-semibold">Address:</span> {{ $order->shipping_address }}</p>
                            <p class="text-gray-700"><span class="font-semibold">City:</span> {{ $order->shipping_city }}</p>
                            <p class="text-gray-700"><span class="font-semibold">Postal Code:</span> {{ $order->shipping_postal_code }}</p>
                        </div>

                        @if($order->notes)
                            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
                                <p class="font-semibold text-gray-800 mb-1">
                                    <i class="fas fa-sticky-note mr-2"></i>Notes:
                                </p>
                                <p class="text-gray-700">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h3>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Order Number:</span>
                                <span class="font-semibold">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Order Date:</span>
                                <span>{{ $order->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Items:</span>
                                <span>{{ $order->items->count() }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal:</span>
                                <span>Tk.{{ number_format($order->subtotal_amount ?? $order->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping:</span>
                                @if(($order->shipping_amount ?? 0) > 0)
                                    <span>Tk.{{ number_format($order->shipping_amount, 2) }}</span>
                                @else
                                    <span class="text-green-600">FREE</span>
                                @endif
                            </div>
                            <div class="border-t pt-3 flex justify-between text-lg font-bold text-gray-800">
                                <span>Total:</span>
                                <span class="text-blue-600">Tk.{{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-lg space-y-3">
                            <div>
                                <p class="text-sm text-gray-700 mb-2">
                                    <span class="font-semibold">Payment Method:</span>
                                </p>
                                @if($order->payment_method == 'cod')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded text-sm">
                                        <i class="fas fa-money-bill-wave mr-1"></i>Cash on Delivery
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded text-sm">
                                        <i class="fas fa-credit-card mr-1"></i>Online Payment (SSLCommerz)
                                    </span>
                                @endif
                            </div>

                            <div>
                                <p class="text-sm text-gray-700 mb-2">
                                    <span class="font-semibold">Payment Status:</span>
                                </p>
                                @if($order->payment_status === 'paid')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded text-sm">
                                        <i class="fas fa-check-circle mr-1"></i>Paid
                                    </span>
                                @elseif($order->payment_status === 'failed')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded text-sm">
                                        <i class="fas fa-times-circle mr-1"></i>Failed
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded text-sm">
                                        <i class="fas fa-clock mr-1"></i>Pending
                                    </span>
                                @endif
                            </div>

                            @if($order->transaction_id)
                                <div class="pt-3 border-t border-gray-200">
                                    <p class="text-xs text-gray-600 mb-1">Transaction ID:</p>
                                    <p class="text-sm font-mono text-gray-800">{{ $order->transaction_id }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('shop.index') }}" class="block w-full px-4 py-2 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 transition">
                                <i class="fas fa-store mr-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
