@extends('layouts.app')

@section('title', 'Welcome to FixIT')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section -->
    <div class="text-center py-16 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-2xl mb-8">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-5xl font-bold text-gray-900 mb-4">
                Welcome to <span class="text-blue-600">FixIT</span>
            </h1>
            <p class="text-xl text-gray-600 mb-8">
                Your one-stop maintenance request platform. Submit issues, track progress, and get things fixed efficiently.
            </p>
            
            @guest
                <div class="space-x-4">
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition duration-200">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}" class="bg-white hover:bg-gray-50 text-gray-700 px-8 py-3 rounded-lg font-semibold text-lg border border-gray-300 transition duration-200">
                        Sign In
                    </a>
                </div>
            @else
                <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition duration-200">
                    Go to Dashboard
                </a>
            @endguest
        </div>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
            <div class="text-3xl font-bold text-blue-600 mb-2">{{ $stats['total_requests'] }}</div>
            <div class="text-gray-600">Total Requests</div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
            <div class="text-3xl font-bold text-green-600 mb-2">{{ $stats['completed_requests'] }}</div>
            <div class="text-gray-600">Completed</div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
            <div class="text-3xl font-bold text-yellow-600 mb-2">{{ $stats['pending_requests'] }}</div>
            <div class="text-gray-600">Pending</div>
        </div>
        
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200 text-center">
            <div class="text-3xl font-bold text-blue-600 mb-2">{{ $stats['in_progress_requests'] }}</div>
            <div class="text-gray-600">In Progress</div>
        </div>
    </div>

    <!-- Recent Requests Feed -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Recent Requests</h2>
            <p class="text-gray-600 mt-1">Latest maintenance requests from the community</p>
        </div>
        
        <div class="divide-y divide-gray-200">
            @forelse($recentRequests as $request)
                <div class="p-6 hover:bg-gray-50 transition duration-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <!-- Request Header -->
                            <div class="flex items-center mb-3">
                                <img class="h-10 w-10 rounded-full" 
                                     src="{{ $request->user->avatar_url }}" 
                                     alt="{{ $request->user->name }}">
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $request->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $request->created_at->diffForHumans() }}</p>
                                </div>
                                @if($request->category)
                                    <span class="ml-auto px-3 py-1 text-xs font-medium rounded-full" 
                                          style="background-color: {{ $request->category->color }}20; color: {{ $request->category->color }};">
                                        {{ $request->category->name }}
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Request Content -->
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $request->title }}</h3>
                            <p class="text-gray-600 mb-3">{{ Str::limit($request->description, 200) }}</p>
                            
                            <!-- Request Meta -->
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $request->location }}
                                </span>
                                
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h16"></path>
                                    </svg>
                                    Priority: <span class="capitalize ml-1 font-medium">{{ $request->priority }}</span>
                                </span>
                                
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $request->status_badge_color }}">
                                    {{ $request->status_name }}
                                </span>
                                
                                @if($request->views_count > 0)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ $request->views_count }} views
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No requests yet</h3>
                    <p class="text-gray-500">Be the first to submit a maintenance request!</p>
                </div>
            @endforelse
        </div>
        
        @if($recentRequests->count() > 0)
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        View all requests →
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        Login to view all requests →
                    </a>
                @endauth
            </div>
        @endif
    </div>

    <!-- Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <div class="text-center">
            <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Easy Request Submission</h3>
            <p class="text-gray-600">Submit maintenance requests with just a few clicks. Add photos, descriptions, and priority levels.</p>
        </div>
        
        <div class="text-center">
            <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Real-time Tracking</h3>
            <p class="text-gray-600">Track the progress of your requests in real-time. Get notifications when status changes.</p>
        </div>
        
        <div class="text-center">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">AI-Powered Categorization</h3>
            <p class="text-gray-600">Our AI automatically categorizes your requests for faster assignment to the right technicians.</p>
        </div>
    </div>
</div>
@endsection