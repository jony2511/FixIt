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

            <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Processing Complete!</h1>
            <p class="text-gray-600 mb-6">Thank you for your payment. Please check your order status in your dashboard.</p>

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-green-800">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <p class="text-yellow-800">{{ session('warning') }}</p>
                </div>
            @endif

            <div class="space-y-3">
                <a href="{{ route('user.orders') }}" 
                   class="block w-full bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition duration-150 font-medium">
                    <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Check My Orders
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

            <!-- Debug Info for Development -->
            @if(config('app.debug'))
                <div class="mt-8 p-4 bg-gray-100 rounded-lg text-left">
                    <h4 class="font-medium text-gray-900 mb-2">Debug Information:</h4>
                    <div class="text-sm text-gray-700 space-y-1">
                        <p><strong>Method:</strong> {{ request()->method() }}</p>
                        <p><strong>URL:</strong> {{ request()->fullUrl() }}</p>
                        @if(request()->all())
                            <p><strong>Parameters:</strong></p>
                            <pre class="text-xs bg-white p-2 rounded mt-1">{{ json_encode(request()->all(), JSON_PRETTY_PRINT) }}</pre>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="mt-6 text-center text-sm text-gray-600">
            <p>📧 You will receive an email confirmation if the payment was successful.</p>
            <p class="mt-2">Need help? <a href="mailto:support@fixit.com" class="text-blue-600 hover:underline">Contact Support</a></p>
        </div>
    </div>
</div>
@endsection