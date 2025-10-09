@extends('layouts.app')

@section('title', 'Categories Management - Admin Panel')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Categories Management</h1>
            <p class="text-gray-600">Configure request categories and settings</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.categories.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                + Add Category
            </a>
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                ← Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4H3m16 8H1m18 4H1"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Categories</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
                </div>
            </div>
        </div>

        @if($stats['most_used'])
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Most Used Category</h3>
                    <p class="text-lg font-bold text-gray-900">{{ $stats['most_used']->name }}</p>
                    <p class="text-sm text-gray-500">{{ $stats['most_used']->requests_count }} requests</p>
                </div>
            </div>
        </div>
        @endif

        @if($stats['least_used'])
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Least Used Category</h3>
                    <p class="text-lg font-bold text-gray-900">{{ $stats['least_used']->name }}</p>
                    <p class="text-sm text-gray-500">{{ $stats['least_used']->requests_count }} requests</p>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($categories as $category)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-{{ $category->color ?? 'blue' }}-100 rounded-lg flex items-center justify-center">
                        @if($category->icon)
                            <i class="{{ $category->icon }} text-{{ $category->color ?? 'blue' }}-600"></i>
                        @else
                            <svg class="w-5 h-5 text-{{ $category->color ?? 'blue' }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $category->requests_count }} requests</p>
                    </div>
                </div>
                
                <div class="text-right">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>

            @if($category->description)
            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($category->description, 100) }}</p>
            @endif

            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    Created: {{ $category->created_at->format('M d, Y') }}
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="text-blue-600 hover:text-blue-900 text-sm font-medium">Edit</a>
                    
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" 
                          class="inline"
                          onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No categories found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new category.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.categories.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Category
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    @if($categories->isNotEmpty())
    <!-- Category Usage Chart -->
    <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Category Usage Distribution</h2>
        
        <div class="space-y-4">
            @php
                $maxRequests = $categories->max('requests_count');
            @endphp
            
            @foreach($categories->sortByDesc('requests_count') as $category)
            <div class="flex items-center">
                <div class="w-32 text-sm font-medium text-gray-700 truncate">
                    {{ $category->name }}
                </div>
                <div class="flex-1 mx-4">
                    <div class="bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $maxRequests > 0 ? ($category->requests_count / $maxRequests) * 100 : 0 }}%"></div>
                    </div>
                </div>
                <div class="w-16 text-sm text-gray-500 text-right">
                    {{ $category->requests_count }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection