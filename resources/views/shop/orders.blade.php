@extends('layouts.sidebar')

@section('title', 'My Orders')
@section('page-title', 'My Orders')
@section('page-description', 'Track your purchase history and order status')

@section('content')
    <div>
        <div class="max-w-7xl mx-auto">
            @if($orders->count() > 0)
                <div class="space-y-4">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                            <div class="p-6">
                                <!-- Order Header -->
                                <div class="flex flex-wrap justify-between items-start mb-4 gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">Order #{{ $order->order_number }}</h3>
                                        <p class="text-sm text-gray-500">
                                            <i class="fas fa-calendar mr-1"></i>
                                            Placed on {{ $order->created_at->format('M d, Y') }} at {{ $order->created_at->format('h:i A') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex gap-2 mb-2">
                                            @if($order->order_status == 'pending')
                                                <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-semibold">
                                                    <i class="fas fa-clock mr-1"></i>Pending
                                                </span>
                                            @elseif($order->order_status == 'processing')
                                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                                                    <i class="fas fa-cog mr-1"></i>Processing
                                                </span>
                                            @elseif($order->order_status == 'shipped')
                                                <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold">
                                                    <i class="fas fa-shipping-fast mr-1"></i>Shipped
                                                </span>
                                            @elseif($order->order_status == 'delivered')
                                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-semibold">
                                                    <i class="fas fa-check-circle mr-1"></i>Delivered
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-semibold">
                                                    <i class="fas fa-times-circle mr-1"></i>Cancelled
                                                </span>
                                            @endif

                                            @if($order->payment_status == 'paid')
                                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                                    <i class="fas fa-check mr-1"></i>Paid
                                                </span>
                                            @else
                                                <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm">
                                                    <i class="fas fa-clock mr-1"></i>{{ ucfirst($order->payment_status) }}
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-2xl font-bold text-blue-600">Tk.{{ number_format($order->total_amount, 2) }}</p>
                                    </div>
                                </div>

                                <!-- Order Items -->
                                <div class="border-t border-b py-4 mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($order->items as $item)
                                            <div class="flex gap-3">
                                                @if($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" 
                                                        class="w-20 h-20 object-cover rounded">
                                                @else
                                                    <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-400"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-grow">
                                                    <h4 class="font-semibold text-sm text-gray-800">{{ $item->product->name }}</h4>
                                                    <p class="text-xs text-gray-600">Qty: {{ $item->quantity }}</p>
                                                    <p class="text-sm font-bold text-blue-600">Tk.{{ number_format($item->subtotal, 2) }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Shipping Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <h4 class="font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-map-marker-alt mr-2"></i>Shipping Address
                                        </h4>
                                        <p class="text-sm text-gray-600">{{ $order->shipping_name }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->shipping_phone }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_postal_code }}</p>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-wallet mr-2"></i>Payment Method
                                        </h4>
                                        <p class="text-sm text-gray-600">
                                            @if($order->payment_method == 'cod')
                                                <span class="px-2 py-1 bg-gray-100 rounded">Cash on Delivery</span>
                                            @else
                                                <span class="px-2 py-1 bg-blue-100 rounded">Online Payment</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-2">
                                    <a href="{{ route('orders.show', $order) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                        <i class="fas fa-eye mr-2"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-semibold text-gray-700 mb-2">No Orders Yet</h3>
                    <p class="text-gray-500 mb-6">You haven't placed any orders yet. Start shopping now!</p>
                    <a href="{{ route('shop.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                        <i class="fas fa-store mr-2"></i>Go to Shop
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
