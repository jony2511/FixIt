@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-lg shadow-lg p-8 text-center">
            <div class="mb-6">
                <div class="mx-auto w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Failed</h1>
            <p class="text-gray-600 mb-6">Unfortunately, your payment could not be processed. Please try again or contact support.</p>

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-red-600">{{ session('error') }}</p>
                </div>
            @endif

            @if(session('order'))
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
                    <p class="text-sm text-gray-600 mb-1">Order Number</p>
                    <p class="text-xl font-bold text-gray-700">{{ session('order')->order_number }}</p>
                    <p class="text-xs text-gray-500 mt-2">Status: Payment Failed</p>
                </div>
            @endif

            <div class="space-y-3">
                <a href="{{ route('checkout') }}" class="block w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-150">
                    Try Again
                </a>
                <a href="{{ route('orders.index') }}" class="block w-full bg-gray-200 text-gray-700 py-3 px-6 rounded-lg hover:bg-gray-300 transition duration-150">
                    View My Orders
                </a>
                <a href="{{ route('shop.index') }}" class="block w-full text-blue-600 py-2 hover:text-blue-700 transition duration-150">
                    Back to Shop
                </a>
            </div>
        </div>

        <div class="mt-6 text-center text-sm text-gray-600">
            <p>Need help? <a href="#" class="text-blue-600 hover:text-blue-700">Contact Support</a></p>
        </div>
    </div>
</div>
@endsection