@extends('layouts.app')

@section('title', 'FixIt Shop - Browse Products')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black gradient-text mb-4">FixIt Shop</h1>
            <p class="text-xl text-gray-600">Browse and purchase quality products</p>
        </div>
    <div>
        <div class="max-w-7xl mx-auto">
            <!-- Search and Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('shop.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div class="md:col-span-2">
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search Products</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                    placeholder="Search by name, brand, description..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Category Filter -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                <select name="category" id="category" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Stock Filter -->
                            <div>
                                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Status</label>
                                <select name="stock" id="stock" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">All</option>
                                    <option value="in_stock" {{ request('stock') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                                    <option value="low_stock" {{ request('stock') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Min Price -->
                            <div>
                                <label for="min_price" class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                                <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                                    placeholder="0" min="0" step="0.01"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Max Price -->
                            <div>
                                <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                                <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" 
                                    placeholder="10000" min="0" step="0.01"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            </div>

                            <!-- Sort By -->
                            <div>
                                <label for="sort" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                                <select name="sort" id="sort" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                                    <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                                </select>
                            </div>

                            <!-- Order -->
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Order</label>
                                <select name="order" id="order" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>Descending</option>
                                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                <i class="fas fa-search mr-2"></i>Apply Filters
                            </button>
                            <a href="{{ route('shop.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                <i class="fas fa-times mr-2"></i>Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                            <a href="{{ route('shop.show', $product) }}">
                                <div class="relative">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                            class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-image text-4xl text-gray-400"></i>
                                        </div>
                                    @endif

                                    <!-- Stock Badge -->
                                    <div class="absolute top-2 right-2">
                                        @if($product->stock_status == 'in_stock')
                                            <span class="px-2 py-1 bg-green-500 text-white text-xs rounded">In Stock</span>
                                        @elseif($product->stock_status == 'low_stock')
                                            <span class="px-2 py-1 bg-yellow-500 text-white text-xs rounded">Low Stock</span>
                                        @else
                                            <span class="px-2 py-1 bg-red-500 text-white text-xs rounded">Out of Stock</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-4">
                                    <h3 class="font-semibold text-lg text-gray-800 mb-1 truncate">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-500 mb-2">
                                        <i class="fas fa-tag mr-1"></i>{{ $product->category->name }}
                                    </p>
                                    @if($product->brand)
                                        <p class="text-sm text-gray-600 mb-2">Brand: {{ $product->brand }}</p>
                                    @endif
                                    <p class="text-2xl font-bold text-blue-600 mb-3">Tk.{{ number_format($product->price, 2) }}</p>
                                    
                                    @if($product->stock_status != 'out_of_stock')
                                        @auth
                                            <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-3">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                                    <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('login') }}" class="block w-full px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center rounded-md hover:from-blue-700 hover:to-purple-700 transition">
                                                <i class="fas fa-sign-in-alt mr-2"></i>Login to Buy
                                            </a>
                                        @endauth
                                    @else
                                        <button disabled class="w-full px-4 py-2 bg-gray-300 text-gray-500 rounded-md cursor-not-allowed">
                                            Out of Stock
                                        </button>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="bg-white p-4 rounded-lg shadow">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700 mb-2">No Products Found</h3>
                    <p class="text-gray-500 mb-4">Try adjusting your filters or search criteria.</p>
                    <a href="{{ route('shop.index') }}" class="text-blue-600 hover:text-blue-700">
                        <i class="fas fa-arrow-left mr-2"></i>Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
