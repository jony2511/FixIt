<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Orders') }}
            </h2>
            <a href="{{ route('user.dashboard') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg">
                
                <!-- Filter Tabs -->
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8 px-6" aria-label="Tabs">
                        <a href="{{ route('user.orders') }}" 
                           class="py-4 px-1 border-b-2 font-medium text-sm {{ !$status ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            All Orders
                            @if($statusCounts['all'] > 0)
                                <span class="ml-2 bg-gray-100 text-gray-600 py-0.5 px-2.5 rounded-full text-xs">{{ $statusCounts['all'] }}</span>
                            @endif
                        </a>
                        <a href="{{ route('user.orders', ['status' => 'pending']) }}" 
                           class="py-4 px-1 border-b-2 font-medium text-sm {{ $status === 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Pending
                            @if($statusCounts['pending'] > 0)
                                <span class="ml-2 bg-blue-100 text-blue-600 py-0.5 px-2.5 rounded-full text-xs">{{ $statusCounts['pending'] }}</span>
                            @endif
                        </a>
                        <a href="{{ route('user.orders', ['status' => 'processing']) }}" 
                           class="py-4 px-1 border-b-2 font-medium text-sm {{ $status === 'processing' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Processing
                            @if($statusCounts['processing'] > 0)
                                <span class="ml-2 bg-yellow-100 text-yellow-600 py-0.5 px-2.5 rounded-full text-xs">{{ $statusCounts['processing'] }}</span>
                            @endif
                        </a>
                        <a href="{{ route('user.orders', ['status' => 'delivered']) }}" 
                           class="py-4 px-1 border-b-2 font-medium text-sm {{ $status === 'delivered' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Delivered
                            @if($statusCounts['delivered'] > 0)
                                <span class="ml-2 bg-green-100 text-green-600 py-0.5 px-2.5 rounded-full text-xs">{{ $statusCounts['delivered'] }}</span>
                            @endif
                        </a>
                        <a href="{{ route('user.orders', ['status' => 'cancelled']) }}" 
                           class="py-4 px-1 border-b-2 font-medium text-sm {{ $status === 'cancelled' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                            Cancelled
                            @if($statusCounts['cancelled'] > 0)
                                <span class="ml-2 bg-red-100 text-red-600 py-0.5 px-2.5 rounded-full text-xs">{{ $statusCounts['cancelled'] }}</span>
                            @endif
                        </a>
                    </nav>
                </div>

                <!-- Orders List -->
                @if($orders->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($orders as $order)
                        <div class="p-6 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <!-- Order Header -->
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">Order #{{ $order->id }}</h3>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                                        @if($order->transaction_id)
                                            <p class="text-xs text-gray-400">TXN: {{ $order->transaction_id }}</p>
                                        @endif
                                    </div>
                                    <div class="flex flex-col items-center">
                                        @if($order->order_status === 'pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                Pending
                                            </span>
                                        @elseif($order->status === 'processing')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                                                </svg>
                                                Processing
                                            </span>
                                        @elseif($order->status === 'delivered')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                                Delivered
                                            </span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                Cancelled
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Order Total -->
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-900">৳{{ number_format($order->total_amount, 2) }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->orderItems->count() }} {{ Str::plural('item', $order->orderItems->count()) }}</p>
                                    <p class="text-xs text-gray-400">
                                        {{ $order->payment_method === 'cod' ? 'Cash on Delivery' : 'Online Payment' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Order Items Preview -->
                            <div class="mt-4">
                                <div class="flex space-x-4 overflow-x-auto pb-2">
                                    @foreach($order->orderItems->take(3) as $item)
                                    <div class="flex-shrink-0 flex items-center space-x-2 bg-gray-50 rounded-lg p-2">
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 truncate max-w-32">{{ $item->product->name }}</p>
                                            <p class="text-xs text-gray-500">Qty: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if($order->orderItems->count() > 3)
                                    <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-gray-100 rounded-lg">
                                        <span class="text-sm font-medium text-gray-500">+{{ $order->orderItems->count() - 3 }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex space-x-3">
                                    <a href="{{ route('user.orders.show', $order->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Details
                                    </a>
                                    
                                    @if($order->status === 'delivered')
                                    <a href="{{ route('user.orders.invoice', $order->id) }}" 
                                       class="inline-flex items-center px-3 py-1.5 border border-green-300 text-sm font-medium rounded-md text-green-700 bg-green-50 hover:bg-green-100 focus:outline-none focus:ring-2 focus:ring-green-500">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download Invoice
                                    </a>
                                    @endif
                                </div>

                                <!-- Track Order Button -->
                                <button onclick="trackOrder({{ $order->id }})" 
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-600 hover:text-blue-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Track Order
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $orders->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">
                            @if($status)
                                No {{ $status }} orders found
                            @else
                                No orders found
                            @endif
                        </h3>
                        <p class="mt-2 text-gray-500">
                            @if($status)
                                You don't have any {{ $status }} orders at the moment.
                            @else
                                You haven't placed any orders yet. Start shopping to see your orders here.
                            @endif
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Browse Products
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Track Order Modal -->
    <div id="trackOrderModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Order Tracking</h3>
                    <button onclick="closeTrackModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="trackingContent" class="text-center">
                    <!-- Tracking content will be loaded here -->
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
                    <p class="mt-2 text-gray-500">Loading order details...</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function trackOrder(orderId) {
            document.getElementById('trackOrderModal').classList.remove('hidden');
            
            fetch(`/user/orders/${orderId}/track`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const order = data.order;
                        const statusColors = {
                            'pending': 'text-blue-600 bg-blue-100',
                            'processing': 'text-yellow-600 bg-yellow-100',
                            'delivered': 'text-green-600 bg-green-100',
                            'cancelled': 'text-red-600 bg-red-100'
                        };
                        
                        document.getElementById('trackingContent').innerHTML = `
                            <div class="text-left space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Order ID:</span>
                                    <span class="text-sm text-gray-900">#${order.id}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Status:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${statusColors[order.status] || 'text-gray-600 bg-gray-100'}">
                                        ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Total Amount:</span>
                                    <span class="text-sm font-medium text-gray-900">৳${order.total_amount}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Payment Method:</span>
                                    <span class="text-sm text-gray-900">${order.payment_method}</span>
                                </div>
                                ${order.transaction_id ? `
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Transaction ID:</span>
                                    <span class="text-xs text-gray-600 font-mono">${order.transaction_id}</span>
                                </div>
                                ` : ''}
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Order Date:</span>
                                    <span class="text-sm text-gray-900">${order.created_at}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-medium text-gray-600">Last Updated:</span>
                                    <span class="text-sm text-gray-900">${order.updated_at}</span>
                                </div>
                            </div>
                        `;
                    } else {
                        document.getElementById('trackingContent').innerHTML = `
                            <div class="text-center text-red-600">
                                <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p>Error loading order details</p>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    document.getElementById('trackingContent').innerHTML = `
                        <div class="text-center text-red-600">
                            <svg class="mx-auto h-8 w-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p>Error loading order details</p>
                        </div>
                    `;
                });
        }

        function closeTrackModal() {
            document.getElementById('trackOrderModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('trackOrderModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTrackModal();
            }
        });
    </script>
    @endpush
</x-app-layout>