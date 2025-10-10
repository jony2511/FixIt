@extends('layouts.app')

@section('title', $request->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Request Details -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <!-- Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-start justify-between">
                <div class="flex items-center">
                    <img class="h-12 w-12 rounded-full" 
                         src="{{ $request->user->avatar_url }}" 
                         alt="{{ $request->user->name }}">
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $request->title }}</h1>
                        <div class="flex items-center text-sm text-gray-500 mt-1">
                            <span>{{ $request->user->name }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $request->created_at->format('M j, Y \a\t g:i A') }}</span>
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
                        <span class="px-3 py-1 text-sm font-medium rounded-full" 
                              style="background-color: {{ $request->category->color }}20; color: {{ $request->category->color }};">
                            {{ $request->category->name }}
                        </span>
                    @endif
                    
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $request->priority_badge_color }}">
                        {{ $request->priority_name }} Priority
                    </span>
                    
                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $request->status_badge_color }}">
                        {{ $request->status_name }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="p-6">
            <div class="prose max-w-none">
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $request->description }}</p>
            </div>
            
            <!-- Files -->
            @if($request->files->count() > 0)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Attachments</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($request->files as $file)
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                @if($file->is_image)
                                    <img src="{{ $file->file_url }}" 
                                         alt="{{ $file->original_name }}" 
                                         class="w-full h-32 object-cover">
                                @else
                                    <div class="w-full h-32 bg-gray-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                                <div class="p-2">
                                    <p class="text-xs text-gray-600 truncate" title="{{ $file->original_name }}">
                                        {{ $file->original_name }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $file->formatted_size }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Admin Actions -->
        @if(auth()->user()->canManageRequests())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div>
                        @if($request->assignedTechnician)
                            <p class="text-sm text-gray-600">
                                Assigned to: <span class="font-medium">{{ $request->assignedTechnician->name }}</span>
                            </p>
                        @else
                            <p class="text-sm text-gray-600">Not assigned yet</p>
                        @endif
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        @if($request->canBeAssigned() && count($technicians) > 0)
                            <form method="POST" action="{{ route('requests.assign', $request) }}" class="inline">
                                @csrf
                                <select name="technician_id" class="text-sm border-gray-300 rounded">
                                    <option value="">Assign to...</option>
                                    @foreach($technicians as $technician)
                                        <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="ml-2 px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                                    Assign
                                </button>
                            </form>
                        @endif
                        
                        @if($request->canBeStarted() && $request->assigned_to === auth()->id())
                            <form method="POST" action="{{ route('requests.start', $request) }}" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                                    Start Work
                                </button>
                            </form>
                        @endif
                        
                        @if($request->canBeCompleted() && ($request->assigned_to === auth()->id() || auth()->user()->isAdmin()))
                            <form method="POST" action="{{ route('requests.complete', $request) }}" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-purple-600 text-white text-sm rounded hover:bg-purple-700">
                                    Mark Complete
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Product Suggestions Section (for Technicians/Admins) -->
    @if(auth()->user()->canManageRequests() && $request->status !== 'rejected')
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-shopping-cart mr-2 text-blue-600"></i>
                    Suggest Replacement Products
                </h2>
                <p class="text-sm text-gray-600 mt-1">Recommend products from the shop for this maintenance request</p>
            </div>
            
            <!-- Suggested Products List -->
            @if($suggestedProductsList->count() > 0)
                <div class="p-6 bg-green-50 border-b border-green-100">
                    <h3 class="font-semibold text-green-800 mb-3 flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        Currently Suggested Products
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($suggestedProductsList as $product)
                            <div class="flex items-center gap-3 bg-white p-3 rounded-lg border border-green-200">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                        class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="flex-grow">
                                    <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                                    <p class="text-sm text-gray-600">Tk.{{ number_format($product->price, 2) }}</p>
                                    <a href="{{ route('shop.show', $product) }}" target="_blank" class="text-xs text-blue-600 hover:text-blue-700">
                                        View in Shop <i class="fas fa-external-link-alt ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($request->replacement_notes)
                        <div class="mt-3 p-3 bg-white rounded-lg border border-green-200">
                            <p class="text-sm text-gray-700"><strong>Notes:</strong> {{ $request->replacement_notes }}</p>
                        </div>
                    @endif
                </div>
            @endif
            
            <!-- Product Suggestion Form -->
            <div class="p-6">
                <form method="POST" action="{{ route('requests.suggest-products', $request) }}">
                    @csrf
                    
                    @if($availableProducts->count() > 0)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Select Products to Suggest
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 max-h-96 overflow-y-auto p-2 border border-gray-200 rounded-lg">
                                @foreach($availableProducts as $product)
                                    <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-blue-50 cursor-pointer transition">
                                        <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" 
                                            {{ in_array($product->id, $request->suggested_products ?? []) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                                class="w-12 h-12 object-cover rounded">
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400 text-sm"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow">
                                            <p class="font-semibold text-sm text-gray-800">{{ $product->name }}</p>
                                            <p class="text-xs text-gray-600">Tk.{{ number_format($product->price, 2) }} • Stock: {{ $product->quantity }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('product_ids')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="replacement_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Replacement Notes (Optional)
                            </label>
                            <textarea name="replacement_notes" id="replacement_notes" rows="2"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Add notes about why these products are recommended...">{{ old('replacement_notes', $request->replacement_notes) }}</textarea>
                            @error('replacement_notes')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            <i class="fas fa-paper-plane mr-2"></i>{{ $suggestedProductsList->count() > 0 ? 'Update' : 'Suggest' }} Products
                        </button>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-box-open text-4xl mb-3"></i>
                            <p>No products available in this category yet.</p>
                            <p class="text-sm">Products will appear here once they are added to the {{ $request->category->name ?? 'relevant' }} category.</p>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    @endif

    <!-- Display Suggested Products for Regular Users -->
    @if(!auth()->user()->canManageRequests() && $suggestedProductsList->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-blue-50">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                    <i class="fas fa-tools mr-2 text-green-600"></i>
                    Recommended Products for This Request
                </h2>
                <p class="text-sm text-gray-600 mt-1">The technician has recommended the following products</p>
            </div>
            
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    @foreach($suggestedProductsList as $product)
                        <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                    class="w-20 h-20 object-cover rounded">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                            @endif
                            <div class="flex-grow">
                                <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600 mb-2">Tk.{{ number_format($product->price, 2) }}</p>
                                <div class="flex gap-2">
                                    <a href="{{ route('shop.show', $product) }}" class="text-sm px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="text-sm px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                            <i class="fas fa-shopping-cart mr-1"></i>Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($request->replacement_notes)
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-gray-700"><strong>Technician Notes:</strong> {{ $request->replacement_notes }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Comments Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">
                Comments ({{ $request->comments->count() }})
            </h2>
        </div>
        
        <!-- Add Comment Form -->
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <form method="POST" action="{{ route('requests.comments.store', $request) }}">
                @csrf
                <div class="flex items-start space-x-4">
                    <img class="h-10 w-10 rounded-full" src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                    <div class="flex-1">
                        <textarea name="content" 
                                  rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Add a comment..."
                                  required></textarea>
                        
                        <div class="flex items-center justify-between mt-3">
                            @if(auth()->user()->canManageRequests())
                                <label class="flex items-center text-sm text-gray-600">
                                    <input type="checkbox" name="is_internal" value="1" class="mr-2">
                                    Internal comment (visible to technicians/admin only)
                                </label>
                            @else
                                <div></div>
                            @endif
                            
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                                Post Comment
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Comments List -->
        <div class="divide-y divide-gray-200">
            @forelse($request->comments as $comment)
                <div class="p-6 {{ $comment->is_internal ? 'bg-yellow-50' : '' }}">
                    <div class="flex items-start space-x-4">
                        <img class="h-10 w-10 rounded-full" 
                             src="{{ $comment->user->avatar_url }}" 
                             alt="{{ $comment->user->name }}">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2">
                                <h4 class="font-medium text-gray-900">{{ $comment->user->name }}</h4>
                                <span class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                                
                                @if($comment->is_internal)
                                    <span class="px-2 py-1 text-xs bg-yellow-200 text-yellow-800 rounded-full">
                                        Internal
                                    </span>
                                @endif
                                
                                @if($comment->is_update)
                                    <span class="px-2 py-1 text-xs bg-blue-200 text-blue-800 rounded-full">
                                        System Update
                                    </span>
                                @endif
                            </div>
                            <p class="mt-2 text-gray-700 whitespace-pre-line">{{ $comment->content }}</p>
                            
                            {{-- Display Suggested Products Cards if this is a product suggestion comment --}}
                            @if($comment->is_update && str_contains($comment->content, 'Suggested') && str_contains($comment->content, 'replacement product'))
                                @if($request->suggested_products && count($request->suggested_products) > 0)
                                    @php
                                        $commentProducts = \App\Models\Product::whereIn('id', $request->suggested_products)->get();
                                    @endphp
                                    @if($commentProducts->count() > 0)
                                        <div class="mt-4 p-4 bg-gradient-to-r from-green-50 to-blue-50 border border-green-200 rounded-lg">
                                            <h5 class="text-sm font-semibold text-green-800 mb-3 flex items-center">
                                                <i class="fas fa-shopping-bag mr-2"></i>
                                                Suggested Products:
                                            </h5>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                @foreach($commentProducts as $product)
                                                    <div class="flex items-center gap-3 bg-white p-3 rounded-lg border border-green-200 shadow-sm hover:shadow-md transition">
                                                        @if($product->image)
                                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                                                class="w-20 h-20 object-cover rounded">
                                                        @else
                                                            <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                                                <i class="fas fa-box text-gray-400 text-xl"></i>
                                                            </div>
                                                        @endif
                                                        <div class="flex-grow">
                                                            <h6 class="font-semibold text-sm text-gray-900">{{ $product->name }}</h6>
                                                            <p class="text-xs text-gray-600 mb-2">
                                                                <span class="font-bold text-green-600">Tk.{{ number_format($product->price, 2) }}</span>
                                                                @if($product->brand)
                                                                    • {{ $product->brand }}
                                                                @endif
                                                            </p>
                                                            <div class="flex gap-2">
                                                                <a href="{{ route('shop.show', $product) }}" 
                                                                   class="text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition flex items-center">
                                                                    <i class="fas fa-eye mr-1"></i>View Details
                                                                </a>
                                                                @if(!auth()->user()->canManageRequests())
                                                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                                                                        @csrf
                                                                        <input type="hidden" name="quantity" value="1">
                                                                        <button type="submit" 
                                                                                class="text-xs px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition flex items-center">
                                                                            <i class="fas fa-cart-plus mr-1"></i>Add to Cart
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    <p>No comments yet. Be the first to comment!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" 
                class="absolute top-4 right-4 text-white bg-black bg-opacity-50 hover:bg-opacity-75 rounded-full p-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full rounded-lg shadow-lg">
        <div class="absolute bottom-4 left-4 right-4 text-center">
            <p id="modalImageName" class="text-white bg-black bg-opacity-50 rounded px-3 py-1 text-sm"></p>
        </div>
    </div>
</div>

<script>
function openImageModal(imageSrc, imageName) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalImageName').textContent = imageName;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal when clicking outside the image
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection