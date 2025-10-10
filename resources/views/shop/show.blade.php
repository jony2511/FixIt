<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $product->name }}
            </h2>
            <a href="{{ route('shop.index') }}" class="text-blue-600 hover:text-blue-700">
                <i class="fas fa-arrow-left mr-2"></i>Back to Shop
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Product Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Product Image -->
                        <div>
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                    class="w-full h-96 object-cover rounded-lg">
                            @else
                                <div class="w-full h-96 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-6xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $product->name }}</h1>
                            
                            <div class="flex items-center gap-4 mb-4">
                                <span class="px-3 py-1 bg-{{ $product->category->color }}-100 text-{{ $product->category->color }}-800 rounded-full text-sm">
                                    <i class="{{ $product->category->icon }} mr-1"></i>{{ $product->category->name }}
                                </span>
                                
                                @if($product->stock_status == 'in_stock')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                        <i class="fas fa-check-circle mr-1"></i>In Stock ({{ $product->quantity }} available)
                                    </span>
                                @elseif($product->stock_status == 'low_stock')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">
                                        <i class="fas fa-exclamation-triangle mr-1"></i>Low Stock ({{ $product->quantity }} left)
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">
                                        <i class="fas fa-times-circle mr-1"></i>Out of Stock
                                    </span>
                                @endif
                            </div>

                            <div class="mb-6">
                                <p class="text-4xl font-bold text-blue-600 mb-2">Tk.{{ number_format($product->price, 2) }}</p>
                            </div>

                            @if($product->brand)
                                <div class="mb-4">
                                    <p class="text-gray-700"><span class="font-semibold">Brand:</span> {{ $product->brand }}</p>
                                </div>
                            @endif

                            @if($product->warranty)
                                <div class="mb-4">
                                    <p class="text-gray-700">
                                        <i class="fas fa-shield-alt text-green-600 mr-2"></i>
                                        <span class="font-semibold">Warranty:</span> {{ $product->warranty }}
                                    </p>
                                </div>
                            @endif

                            <div class="mb-6">
                                <h3 class="font-semibold text-lg text-gray-800 mb-2">Description</h3>
                                <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                            </div>

                            @if($product->stock_status != 'out_of_stock')
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                        <div class="flex items-center gap-4">
                                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->quantity }}"
                                                class="w-24 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition flex items-center">
                                                <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            @else
                                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <p class="text-red-800"><i class="fas fa-times-circle mr-2"></i>This product is currently out of stock.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6">Related Products</h2>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            @foreach($relatedProducts as $related)
                                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow">
                                    <a href="{{ route('shop.show', $related) }}">
                                        @if($related->image)
                                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" 
                                                class="w-full h-40 object-cover">
                                        @else
                                            <div class="w-full h-40 bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-image text-3xl text-gray-400"></i>
                                            </div>
                                        @endif
                                        <div class="p-4">
                                            <h3 class="font-semibold text-gray-800 mb-2 truncate">{{ $related->name }}</h3>
                                            <p class="text-xl font-bold text-blue-600">Tk.{{ number_format($related->price, 2) }}</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
