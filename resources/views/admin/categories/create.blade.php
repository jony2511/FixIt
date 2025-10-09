@extends('layouts.app')

@section('title', 'Create Category - Admin Panel')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Category</h1>
            <p class="text-gray-600">Add a new maintenance request category</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            ← Back to Categories
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category Name -->
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Category Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                           placeholder="Enter category name"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                              placeholder="Enter category description">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon -->
                <div>
                    <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon Class</label>
                    <input type="text" 
                           id="icon" 
                           name="icon" 
                           value="{{ old('icon') }}"
                           class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('icon') border-red-500 @enderror"
                           placeholder="e.g., fas fa-wrench">
                    @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Font Awesome icon class (optional)</p>
                </div>

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Color Theme</label>
                    <select id="color" 
                            name="color" 
                            class="w-full border-gray-300 rounded-lg focus:border-blue-500 focus:ring-blue-500 @error('color') border-red-500 @enderror">
                        <option value="blue" {{ old('color') === 'blue' ? 'selected' : '' }}>Blue</option>
                        <option value="green" {{ old('color') === 'green' ? 'selected' : '' }}>Green</option>
                        <option value="yellow" {{ old('color') === 'yellow' ? 'selected' : '' }}>Yellow</option>
                        <option value="red" {{ old('color') === 'red' ? 'selected' : '' }}>Red</option>
                        <option value="purple" {{ old('color') === 'purple' ? 'selected' : '' }}>Purple</option>
                        <option value="orange" {{ old('color') === 'orange' ? 'selected' : '' }}>Orange</option>
                        <option value="pink" {{ old('color') === 'pink' ? 'selected' : '' }}>Pink</option>
                        <option value="gray" {{ old('color') === 'gray' ? 'selected' : '' }}>Gray</option>
                    </select>
                    @error('color')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               id="is_active" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-700">
                            Active Category
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Users can select this category when creating requests</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.categories.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Create Category
                </button>
            </div>
        </form>
    </div>

    <!-- Preview -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Preview</h3>
        
        <div class="inline-block bg-white rounded-xl shadow-sm border border-gray-200 p-4" x-data="categoryPreview()">
            <div class="flex items-center justify-between mb-3">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center" 
                         :class="`bg-${selectedColor}-100`">
                        <i :class="iconClass" :class="[`text-${selectedColor}-600`]" class="text-blue-600"></i>
                    </div>
                    <div class="ml-3">
                        <h4 class="text-lg font-semibold text-gray-900" x-text="categoryName || 'Category Name'"></h4>
                        <p class="text-sm text-gray-500">0 requests</p>
                    </div>
                </div>
                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full"
                      :class="isActive ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'"
                      x-text="isActive ? 'Active' : 'Inactive'">
                </span>
            </div>
            <p class="text-sm text-gray-600" x-text="categoryDescription || 'Category description will appear here'"></p>
        </div>
    </div>
</div>

<script>
function categoryPreview() {
    return {
        categoryName: '',
        categoryDescription: '',
        selectedColor: 'blue',
        iconClass: '',
        isActive: true,
        
        init() {
            // Watch for form changes
            document.getElementById('name').addEventListener('input', (e) => {
                this.categoryName = e.target.value;
            });
            
            document.getElementById('description').addEventListener('input', (e) => {
                this.categoryDescription = e.target.value;
            });
            
            document.getElementById('color').addEventListener('change', (e) => {
                this.selectedColor = e.target.value;
            });
            
            document.getElementById('icon').addEventListener('input', (e) => {
                this.iconClass = e.target.value;
            });
            
            document.getElementById('is_active').addEventListener('change', (e) => {
                this.isActive = e.target.checked;
            });
        }
    }
}
</script>
@endsection