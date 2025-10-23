@extends('layouts.app')

@section('title', 'Blog - FixIt Solutions')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black gradient-text mb-4">Blog</h1>
            <p class="text-xl text-gray-600">Bringing the power of data science and artificial intelligence to every business</p>
        </div>
            
            <!-- Search and Filter Section -->
            <div class="mb-8 bg-white rounded-lg shadow-sm p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Search Bar -->
                    <form method="GET" action="{{ route('blogs.index') }}" class="flex gap-2">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Search Keyword..." 
                            value="{{ $search ?? '' }}"
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                        >
                        <button 
                            type="submit"
                            class="px-6 py-2 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-lg hover:from-pink-600 hover:to-purple-700 transition-all duration-300 font-semibold"
                        >
                            Search
                        </button>
                    </form>

                    <!-- Category Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('blogs.index') }}" 
                               class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ !$category ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                All
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('blogs.index', ['category' => $cat]) }}" 
                                   class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ $category == $cat ? 'bg-gradient-to-r from-pink-500 to-purple-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                    {{ $cat }}
                                    <span class="text-xs opacity-75">({{ \App\Models\Blog::where('category', $cat)->where('is_published', true)->count() }})</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                @if($search || $category)
                    <div class="mt-4 flex items-center justify-between">
                        <p class="text-gray-600">
                            Found <strong>{{ $blogs->total() }}</strong> 
                            @if($search) results for "<strong>{{ $search }}</strong>" @endif
                            @if($category) in <strong>{{ $category }}</strong> @endif
                        </p>
                        <a href="{{ route('blogs.index') }}" class="text-pink-600 hover:text-pink-700 font-medium">
                            Clear Filters
                        </a>
                    </div>
                @endif
            </div>

            <!-- Blog Grid -->
            @if($blogs->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($blogs as $blog)
                        <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                            <!-- Blog Image -->
                            <div class="relative overflow-hidden h-56 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
                                @if($blog->image)
                                    <img src="{{ asset('storage/' . $blog->image) }}" 
                                         alt="{{ $blog->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-20 h-20 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Date Badge -->
                                <div class="absolute top-4 left-4 bg-pink-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                    {{ $blog->published_at->format('d M') }}
                                </div>
                            </div>

                            <!-- Blog Content -->
                            <div class="p-6">
                                <!-- Category & Reading Time -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">
                                        {{ $blog->category }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $blog->reading_time }}</span>
                                </div>

                                <!-- Title -->
                                <h3 class="text-xl font-bold text-gray-800 mb-3 line-clamp-2 group-hover:text-pink-600 transition-colors duration-300">
                                    <a href="{{ route('blogs.show', $blog->slug) }}">
                                        {{ $blog->title }}
                                    </a>
                                </h3>

                                <!-- Excerpt -->
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                    {{ $blog->short_excerpt }}
                                </p>

                                <!-- Author & Views -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($blog->author->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-semibold text-gray-700">{{ $blog->author->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $blog->published_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-gray-500 text-xs">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        {{ $blog->views }}
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $blogs->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-700 mb-2">No blogs found</h3>
                    <p class="text-gray-500 mb-6">Try adjusting your search or filter criteria</p>
                    <a href="{{ route('blogs.index') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-pink-500 to-purple-600 text-white rounded-lg hover:from-pink-600 hover:to-purple-700 transition-all duration-300">
                        View All Blogs
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
