@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="mb-6">
                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Successful!</h1>
            <p class="text-gray-600 mb-6">Thank you for your purchase. Your order has been placed successfully.</p>

            @if(session('order'))
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-1">Order Number</p>
                    <p class="text-xl font-bold text-blue-600">{{ session('order')->order_number }}</p>
                </div>
            @endif

            <div class="space-y-3">
                @if(session('order'))
                    <a href="{{ route('orders.show', session('order')) }}" class="block w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-150">
                        View Order Details
                    </a>
                @endif
                <a href="{{ route('orders.index') }}" class="block w-full bg-gray-200 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-300 transition duration-150">
                    View All Orders
                </a>
                <a href="{{ route('shop.index') }}" class="block w-full text-blue-600 py-2 hover:text-blue-700 transition duration-150">
                    Continue Shopping
                </a>
            </div>
        </div>

        <div class="mt-6 text-center text-sm text-gray-600">
            <p>You will receive an email confirmation shortly.</p>
        </div>
    </div>
</div>
@endsection