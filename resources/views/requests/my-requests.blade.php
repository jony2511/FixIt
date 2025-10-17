@extends('layouts.sidebar')

@section('title', 'My Requests')
@section('page-title', 'My Requests')
@section('page-description', 'Track all your submitted maintenance requests')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">My Requests</h1>
            <p class="text-gray-600 mt-2">Track all your submitted maintenance requests</p>
        </div>
        
        <a href="{{ route('requests.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition duration-200">
            + New Request
        </a>
    </div>

    <!-- Requests List -->
    @forelse($requests as $request)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden hover:shadow-md transition duration-200">
            <div class="p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-3">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $request->title }}</h3>
                            <span class="ml-3 px-3 py-1 text-sm font-medium rounded-full {{ $request->status_badge_color }}">
                                {{ $request->status_name }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 mb-4">{{ Str::limit($request->description, 200) }}</p>
                        
                        <div class="flex items-center space-x-4 text-sm text-gray-500">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                                {{ $request->location }}
                            </span>
                            
                            @if($request->category)
                                <span class="px-2 py-1 text-xs rounded-full" 
                                      style="background-color: {{ $request->category->color }}20; color: {{ $request->category->color }};">
                                    {{ $request->category->name }}
                                </span>
                            @endif
                            
                            <span class="px-2 py-1 text-xs rounded-full {{ $request->priority_badge_color }}">
                                {{ $request->priority_name }}
                            </span>
                            
                            <span>{{ $request->created_at->diffForHumans() }}</span>
                            
                            @if($request->assignedTechnician)
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ $request->assignedTechnician->name }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="ml-6">
                        <a href="{{ route('requests.show', $request) }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            View Details →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No requests yet</h3>
            <p class="text-gray-500 mb-4">You haven't submitted any maintenance requests yet.</p>
            <a href="{{ route('requests.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                Submit Your First Request
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
@endsection