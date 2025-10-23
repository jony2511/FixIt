<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="fas fa-edit mr-2"></i>{{ __('Edit Testimonial') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Client Name -->
                        <div class="mb-4">
                            <label for="client_name" class="block text-sm font-medium text-gray-700 mb-2">Client Name *</label>
                            <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $testimonial->client_name) }}" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            @error('client_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Client Position -->
                        <div class="mb-4">
                            <label for="client_position" class="block text-sm font-medium text-gray-700 mb-2">Client Position *</label>
                            <input type="text" name="client_position" id="client_position" value="{{ old('client_position', $testimonial->client_position) }}" 
                                placeholder="e.g., CEO at Tech Corp"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            @error('client_position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Testimonial Text -->
                        <div class="mb-4">
                            <label for="testimonial_text" class="block text-sm font-medium text-gray-700 mb-2">Testimonial *</label>
                            <textarea name="testimonial_text" id="testimonial_text" rows="5" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('testimonial_text', $testimonial->testimonial_text) }}</textarea>
                            @error('testimonial_text')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Current Photo Preview -->
                        @if($testimonial->client_photo)
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Photo</label>
                                <img src="{{ asset('storage/' . $testimonial->client_photo) }}" alt="{{ $testimonial->client_name }}" 
                                    class="w-24 h-24 rounded-full object-cover border-2 border-gray-300">
                            </div>
                        @endif

                        <!-- Client Photo -->
                        <div class="mb-4">
                            <label for="client_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $testimonial->client_photo ? 'Change Photo' : 'Add Photo' }}
                            </label>
                            <input type="file" name="client_photo" id="client_photo" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Leave empty to keep current photo{{ $testimonial->client_photo ? '' : ' (or use placeholder)' }}</p>
                            @error('client_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Display Order -->
                        <div class="mb-4">
                            <label for="display_order" class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
                            <input type="number" name="display_order" id="display_order" value="{{ old('display_order', $testimonial->display_order) }}" min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Lower numbers appear first</p>
                            @error('display_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Is Active -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $testimonial->is_active) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Active (show on website)</span>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-md hover:from-blue-700 hover:to-purple-700">
                                <i class="fas fa-save mr-2"></i>Update Testimonial
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
