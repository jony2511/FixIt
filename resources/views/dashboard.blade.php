@extends('layouts.app')

@section('title', 'Newsfeed - Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-6">
        
        <!-- Left Sidebar - User Stats & Quick Actions -->
        <div class="lg:w-1/4">
            <!-- Welcome Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center mb-4">
                    <img class="h-12 w-12 rounded-full" src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-600">{{ auth()->user()->role_name }}</p>
                    </div>
                </div>
                
                <!-- User Stats -->
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-blue-600">{{ $userStats['my_requests'] }}</div>
                        <div class="text-xs text-gray-500">My Requests</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-600">{{ $userStats['my_completed'] }}</div>
                        <div class="text-xs text-gray-500">Completed</div>
                    </div>
                </div>
                
                @if(auth()->user()->isTechnician())
                <div class="grid grid-cols-2 gap-4 text-center mt-4 pt-4 border-t border-gray-200">
                    <div>
                        <div class="text-2xl font-bold text-orange-600">{{ $userStats['assigned_to_me'] }}</div>
                        <div class="text-xs text-gray-500">Assigned</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-purple-600">{{ $userStats['completed_by_me'] }}</div>
                        <div class="text-xs text-gray-500">Resolved</div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('requests.create') }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium text-center block transition duration-200">
                        Submit New Request
                    </a>
                    
                    <a href="{{ route('requests.my') }}" 
                       class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium text-center block transition duration-200">
                        View My Requests
                    </a>
                    
                    @if(auth()->user()->isTechnician())
                    <a href="{{ route('requests.assigned') }}" 
                       class="w-full bg-orange-100 hover:bg-orange-200 text-orange-700 px-4 py-2 rounded-lg font-medium text-center block transition duration-200">
                        My Assignments
                    </a>
                    @endif
                    
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" 
                       class="w-full bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg font-medium text-center block transition duration-200">
                        Admin Panel
                    </a>
                    @endif
                </div>
            </div>

            <!-- Category Filter -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter by Category</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" 
                       class="block px-3 py-2 text-sm rounded-lg {{ request()->get('category') ? 'text-gray-600 hover:bg-gray-50' : 'bg-blue-50 text-blue-600 font-medium' }}">
                        All Categories
                    </a>
                    
                    @foreach($categories as $category)
                    <a href="{{ route('dashboard') }}?category={{ $category->id }}" 
                       class="block px-3 py-2 text-sm rounded-lg {{ request()->get('category') == $category->id ? 'text-blue-600 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span class="inline-block w-3 h-3 rounded-full mr-2" style="background-color: {{ $category->color }};"></span>
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Main Content - Request Feed -->
        <div class="lg:w-3/4">
            <!-- Feed Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            @if(auth()->user()->isAdmin()) All Requests
                            @elseif(auth()->user()->isTechnician()) Request Feed
                            @else Community Requests
                            @endif
                        </h2>
                        <p class="text-gray-600 mt-1">Stay updated with the latest maintenance requests</p>
                    </div>
                    
                    <a href="{{ route('requests.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                        + New Request
                    </a>
                </div>
            </div>

            <!-- Requests Feed -->
            @forelse($requests as $request)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden hover:shadow-md transition duration-200">
                    <!-- Request Header -->
                    <div class="p-6 pb-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center flex-1">
                                <img class="h-12 w-12 rounded-full" 
                                     src="{{ $request->user->avatar_url }}" 
                                     alt="{{ $request->user->name }}">
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $request->title }}</h4>
                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                        <span>{{ $request->user->name }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $request->created_at->diffForHumans() }}</span>
                                        <span class="mx-2">•</span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            </svg>
                                            {{ $request->location }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                @if($request->category)
                                    <span class="px-3 py-1 text-xs font-medium rounded-full" 
                                          style="background-color: {{ $request->category->color }}20; color: {{ $request->category->color }};">
                                        {{ $request->category->name }}
                                    </span>
                                @endif
                                
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $request->priority_badge_color }}">
                                    {{ $request->priority_name }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Request Content -->
                    <div class="px-6 pb-4">
                        <p class="text-gray-700 leading-relaxed">{{ $request->description }}</p>
                        
                        @if($request->files->count() > 0)
                        <div class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($request->files->take(3) as $file)
                                @if($file->is_image)
                                    <img src="{{ asset('storage/' . $file->file_path) }}" 
                                         alt="Request attachment" 
                                         class="w-full h-32 object-cover rounded-lg">
                                @endif
                            @endforeach
                            
                            @if($request->files->count() > 3)
                                <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500 font-medium">+{{ $request->files->count() - 3 }} more</span>
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    
                    <!-- Request Footer -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $request->status_badge_color }}">
                                    {{ $request->status_name }}
                                </span>
                                
                                @if($request->assignedTechnician)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Assigned to {{ $request->assignedTechnician->name }}
                                    </span>
                                @endif
                                
                                @if($request->comments->count() > 0)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        {{ $request->comments->count() }} comments
                                    </span>
                                @endif
                                
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ $request->views_count }} views
                                </span>
                            </div>
                            
                            <a href="{{ route('requests.show', $request) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                View Details →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No requests found</h3>
                    <p class="text-gray-500 mb-4">Be the first to submit a maintenance request!</p>
                    <a href="{{ route('requests.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                        Submit Request
                    </a>
                </div>
            @endforelse
            
            <!-- Pagination -->
            @if($requests->hasPages())
                <div class="mt-6">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
