@extends('layouts.app')

@section('title', $blog->title . ' - FixIt Blog')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('blogs.index') }}" class="inline-flex items-center text-pink-600 hover:text-pink-700 font-medium transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Blogs
                </a>
            </div>

            <!-- Main Blog Card -->
            <article class="bg-white rounded-2xl shadow-xl overflow-hidden">
                
                <!-- Featured Image -->
                <div class="relative h-96 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
                    @if($blog->image)
                        <img src="{{ asset('storage/' . $blog->image) }}" 
                             alt="{{ $blog->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-32 h-32 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Blog Content -->
                <div class="p-8 md:p-12">
                    
                    <!-- Meta Information -->
                    <div class="flex flex-wrap items-center gap-4 mb-6">
                        <span class="inline-flex items-center text-sm font-semibold text-purple-600 bg-purple-100 px-4 py-2 rounded-full">
                            {{ $blog->category }}
                        </span>
                        <span class="text-sm text-gray-500">{{ $blog->published_at->format('F d, Y') }}</span>
                        <span class="text-sm text-gray-500">{{ $blog->reading_time }}</span>
                        <span class="inline-flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            {{ $blog->views }} views
                        </span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                        {{ $blog->title }}
                    </h1>

                    <!-- Author Info -->
                    <div class="flex items-center space-x-4 pb-8 mb-8 border-b border-gray-200">
                        <div class="w-12 h-12 bg-gradient-to-r from-pink-500 to-purple-600 rounded-full flex items-center justify-center text-white text-lg font-bold">
                            {{ strtoupper(substr($blog->author->name, 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ $blog->author->name }}</p>
                            <p class="text-sm text-gray-500">Admin at FixIt Solutions</p>
                        </div>
                    </div>

                    <!-- Excerpt -->
                    <div class="bg-gradient-to-r from-pink-50 to-purple-50 border-l-4 border-pink-500 p-6 mb-8 rounded-r-lg">
                        <p class="text-lg text-gray-700 italic">{{ $blog->excerpt }}</p>
                    </div>

                    <!-- Main Content -->
                    <div class="prose prose-lg max-w-none">
                        <div class="text-gray-700 leading-relaxed space-y-4">
                            {!! $blog->content !!}
                        </div>
                    </div>

                    <!-- Call to Action -->
                    <div class="mt-12 bg-gradient-to-r from-pink-500 to-purple-600 rounded-2xl p-8 text-white">
                        <h3 class="text-2xl font-bold mb-4">Need Professional Appliance Repair?</h3>
                        <p class="mb-6 text-pink-100">FixIt Solutions is here to help! Our certified technicians are ready to diagnose and fix your appliance issues quickly and efficiently.</p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('requests.create') }}" class="inline-block px-8 py-3 bg-white text-pink-600 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-300 shadow-lg">
                                Create Service Request
                            </a>
                            <a href="{{ route('shop.index') }}" class="inline-block px-8 py-3 bg-purple-700 text-white rounded-lg font-semibold hover:bg-purple-800 transition-all duration-300">
                                Browse Shop
                            </a>
                        </div>
                    </div>

                </div>
            </article>

            <!-- Comments Section -->
            <div class="mt-12 bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-pink-500 to-purple-600 p-6">
                    <h3 class="text-2xl font-bold text-white">
                        {{ $blog->approvedComments->count() }} Comments
                    </h3>
                </div>

                <div class="p-8">
                    
                    @if(session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Comment Form -->
                    <div class="mb-12">
                        <h4 class="text-xl font-bold text-gray-900 mb-6">Leave a Reply</h4>
                        <form action="{{ route('blogs.comments.store', $blog->slug) }}" method="POST">
                            @csrf
                            
                            <div class="mb-6">
                                <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Comment <span class="text-red-500">*</span></label>
                                <textarea name="comment" 
                                          id="comment" 
                                          rows="5" 
                                          required
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('comment') border-red-500 @enderror"
                                          placeholder="Write your comment here...">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            @guest
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                    <div>
                                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name <span class="text-red-500">*</span></label>
                                        <input type="text" 
                                               name="name" 
                                               id="name" 
                                               value="{{ old('name') }}"
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                               placeholder="Your Name">
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                        <input type="email" 
                                               name="email" 
                                               id="email" 
                                               value="{{ old('email') }}"
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('email') border-red-500 @enderror"
                                               placeholder="your@email.com">
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                                        <input type="url" 
                                               name="website" 
                                               id="website" 
                                               value="{{ old('website') }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent @error('website') border-red-500 @enderror"
                                               placeholder="https://yoursite.com">
                                        @error('website')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            @endguest

                            <button type="submit" class="bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 shadow-lg">
                                Post Comment
                            </button>
                        </form>
                    </div>

                    <!-- Comments List -->
                    <div class="space-y-8">
                        @forelse($blog->approvedComments as $comment)
                            <div class="border-b border-gray-200 pb-8 last:border-0" id="comment-{{ $comment->id }}">
                                <div class="flex items-start space-x-4">
                                    <img src="{{ $comment->commenter_avatar }}" 
                                         alt="{{ $comment->commenter_name }}" 
                                         class="w-12 h-12 rounded-full">
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-2">
                                            <div>
                                                <h5 class="font-semibold text-gray-900">{{ $comment->commenter_name }}</h5>
                                                <p class="text-sm text-gray-500">{{ $comment->created_at->format('F d, Y \a\t g:i A') }}</p>
                                            </div>
                                            <button onclick="showReplyForm({{ $comment->id }})" class="text-pink-600 hover:text-pink-700 text-sm font-medium">
                                                Reply
                                            </button>
                                        </div>
                                        
                                        <p class="text-gray-700 leading-relaxed">{{ $comment->comment }}</p>

                                        <!-- Reply Form (Hidden by default) -->
                                        <div id="reply-form-{{ $comment->id }}" class="mt-4 hidden">
                                            <form action="{{ route('blogs.comments.store', $blog->slug) }}" method="POST" class="bg-gray-50 p-4 rounded-lg">
                                                @csrf
                                                <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                                
                                                <textarea name="comment" 
                                                          rows="3" 
                                                          required
                                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent mb-3"
                                                          placeholder="Write your reply..."></textarea>
                                                
                                                @guest
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-3">
                                                        <input type="text" name="name" required class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" placeholder="Your Name">
                                                        <input type="email" name="email" required class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500" placeholder="your@email.com">
                                                    </div>
                                                @endguest
                                                
                                                <div class="flex gap-2">
                                                    <button type="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg text-sm font-medium">
                                                        Post Reply
                                                    </button>
                                                    <button type="button" onclick="hideReplyForm({{ $comment->id }})" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium">
                                                        Cancel
                                                    </button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Replies -->
                                        @if($comment->replies->count() > 0)
                                            <div class="mt-6 ml-8 space-y-6">
                                                @foreach($comment->replies as $reply)
                                                    <div class="flex items-start space-x-4">
                                                        <img src="{{ $reply->commenter_avatar }}" 
                                                             alt="{{ $reply->commenter_name }}" 
                                                             class="w-10 h-10 rounded-full">
                                                        
                                                        <div class="flex-1">
                                                            <div class="flex items-center justify-between mb-2">
                                                                <div>
                                                                    <h6 class="font-semibold text-gray-900">{{ $reply->commenter_name }}</h6>
                                                                    <p class="text-sm text-gray-500">{{ $reply->created_at->format('F d, Y \a\t g:i A') }}</p>
                                                                </div>
                                                            </div>
                                                            <p class="text-gray-700 leading-relaxed">{{ $reply->comment }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <h3 class="text-lg font-semibold text-gray-700 mb-2">No comments yet</h3>
                                <p class="text-gray-500">Be the first to share your thoughts!</p>
                            </div>
                        @endforelse
                    </div>

                </div>
            </div>

            <!-- Related Blogs -->
            @if($relatedBlogs->count() > 0)
                <div class="mt-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Related Articles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedBlogs as $relatedBlog)
                            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group">
                                <!-- Image -->
                                <div class="relative overflow-hidden h-48 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500">
                                    @if($relatedBlog->image)
                                        <img src="{{ asset('storage/' . $relatedBlog->image) }}" 
                                             alt="{{ $relatedBlog->title }}" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Content -->
                                <div class="p-5">
                                    <span class="text-xs font-semibold text-purple-600 bg-purple-100 px-3 py-1 rounded-full">
                                        {{ $relatedBlog->category }}
                                    </span>
                                    <h3 class="text-lg font-bold text-gray-800 mt-3 mb-2 line-clamp-2 group-hover:text-pink-600 transition-colors duration-300">
                                        <a href="{{ route('blogs.show', $relatedBlog->slug) }}">
                                            {{ $relatedBlog->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-gray-600 line-clamp-2">
                                        {{ $relatedBlog->short_excerpt }}
                                    </p>
                                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                                        <span>{{ $relatedBlog->published_at->format('M d, Y') }}</span>
                                        <span>{{ $relatedBlog->views }} views</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        function showReplyForm(commentId) {
            // Hide all reply forms first
            document.querySelectorAll('[id^="reply-form-"]').forEach(form => {
                form.classList.add('hidden');
            });
            
            // Show the clicked reply form
            document.getElementById('reply-form-' + commentId).classList.remove('hidden');
        }

        function hideReplyForm(commentId) {
            document.getElementById('reply-form-' + commentId).classList.add('hidden');
        }
    </script>
</div>
@endsection
