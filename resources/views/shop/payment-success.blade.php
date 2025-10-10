@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12">
    <div class="max-w-lg w-full">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="mb-6">
                <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Successful!</h1>
            <p class="text-gray-600 mb-6">Thank you for your purchase. Your order has been placed successfully and is being processed.</p>

            @if(isset($order) && $order)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600 mb-1">Order Number</p>
                            <p class="font-bold text-blue-600">#{{ $order->id }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Total Amount</p>
                            <p class="font-bold text-blue-600">Tk.{{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>
                    @if($order->transaction_id)
                        <div class="mt-3 pt-3 border-t border-blue-200">
                            <p class="text-xs text-gray-600">Transaction ID: {{ $order->transaction_id }}</p>
                        </div>
                    @endif
                </div>
            @endif

            <div class="space-y-3">
                @if(isset($order) && $order)
                    <a href="{{ route('user.orders.invoice', $order->id) }}" 
                       class="block w-full bg-red-600 text-white py-3 px-6 rounded-lg hover:bg-red-700 transition duration-150 font-medium">
                        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download Invoice PDF
                    </a>
                    
                    <a href="{{ route('user.orders.show', $order->id) }}" 
                       class="block w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition duration-150 font-medium">
                        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        View Order Details
                    </a>
                @endif

                <a href="{{ route('user.orders') }}" 
                   class="block w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-150 font-medium">
                    <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    View My Orders
                </a>
                
                <a href="{{ route('user.dashboard') }}" 
                   class="block w-full bg-gray-200 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-300 transition duration-150 font-medium">
                    <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    Go to Dashboard
                </a>
                
                <a href="{{ route('shop.index') }}" 
                   class="block w-full text-blue-600 py-2 hover:text-blue-700 transition duration-150 font-medium">
                    <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Continue Shopping
                </a>
            </div>
        </div>

        <div class="mt-6 text-center text-sm text-gray-600">
            <p>📧 You will receive an email confirmation shortly.</p>
            <p class="mt-2">Need help? <a href="mailto:support@fixit.com" class="text-blue-600 hover:underline">Contact Support</a></p>
        </div>
    </div>
</div>
@endsection