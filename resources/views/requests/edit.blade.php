@extends('layouts.sidebar')

@section('title', 'Edit Request')
@section('page-title', 'Edit Request')
@section('page-description', 'Update your maintenance request details')

@section('content')
<div class="max-w-4xl mx-auto">
        
        <!-- Header Section with Modern Design -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg mb-4">
                <i class="fas fa-edit text-2xl text-white"></i>
            </div>
            <h1 class="text-4xl font-bold text-slate-900 mb-3">Edit Request</h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">Update your maintenance request details</p>
            <div class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-slate-100 rounded-full text-sm text-slate-600">
                <i class="fas fa-hashtag"></i>
                <span class="font-semibold">Request #{{ $request->id }}</span>
            </div>
        </div>

        <!-- Main Form Card with Glass Effect -->
        <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl border border-slate-200 overflow-hidden">
            
            <!-- Form Header Accent -->
            <div class="h-2 bg-gradient-to-r from-emerald-500 via-teal-500 to-cyan-600"></div>
            
            <form method="POST" action="{{ route('requests.update', $request) }}" enctype="multipart/form-data" class="p-8 lg:p-10 space-y-8">
                @csrf
                @method('PUT')

                <!-- Title with Icon -->
                <div class="space-y-2">
                    <label for="title" class="flex items-center text-sm font-semibold text-slate-700 mb-3">
                        <i class="fas fa-heading text-blue-500 mr-2"></i>
                        Request Title <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $request->title) }}"
                               class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-900 placeholder-slate-400"
                               placeholder="Brief description of the issue..."
                               required>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <i class="fas fa-pen text-slate-300"></i>
                        </div>
                    </div>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Category and Priority Row with Enhanced Design -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Category -->
                    <div class="space-y-2">
                        <label for="category_id" class="flex items-center text-sm font-semibold text-slate-700 mb-3">
                            <i class="fas fa-folder text-indigo-500 mr-2"></i>
                            Category <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <select id="category_id" 
                                    name="category_id" 
                                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-900 appearance-none cursor-pointer"
                                    required>
                                <option value="">Select a category...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $request->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-slate-400"></i>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Priority with Color Indicators -->
                    <div class="space-y-2">
                        <label for="priority" class="flex items-center text-sm font-semibold text-slate-700 mb-3">
                            <i class="fas fa-flag text-orange-500 mr-2"></i>
                            Priority <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <select id="priority" 
                                    name="priority" 
                                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-900 appearance-none cursor-pointer"
                                    required>
                                <option value="low" {{ old('priority', $request->priority) == 'low' ? 'selected' : '' }}>🟢 Low</option>
                                <option value="medium" {{ old('priority', $request->priority) == 'medium' ? 'selected' : '' }}>🟡 Medium</option>
                                <option value="high" {{ old('priority', $request->priority) == 'high' ? 'selected' : '' }}>🟠 High</option>
                                <option value="urgent" {{ old('priority', $request->priority) == 'urgent' ? 'selected' : '' }}>🔴 Urgent</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-slate-400"></i>
                            </div>
                        </div>
                        @error('priority')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Location with Icon -->
                <div class="space-y-2">
                    <label for="location" class="flex items-center text-sm font-semibold text-slate-700 mb-3">
                        <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                        Location <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="location" 
                               name="location" 
                               value="{{ old('location', $request->location) }}"
                               class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-900 placeholder-slate-400"
                               placeholder="Room number, building, floor, etc..."
                               required>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                            <i class="fas fa-building text-slate-300"></i>
                        </div>
                    </div>
                    @error('location')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Description with Enhanced Design -->
                <div class="space-y-2">
                    <label for="description" class="flex items-center text-sm font-semibold text-slate-700 mb-3">
                        <i class="fas fa-align-left text-purple-500 mr-2"></i>
                        Description <span class="text-red-500 ml-1">*</span>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="6"
                              class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 text-slate-900 placeholder-slate-400 resize-none"
                              placeholder="Provide detailed description of the issue, what happened, when it started, any error messages, etc..."
                              required>{{ old('description', $request->description) }}</textarea>
                    <div class="flex justify-between items-center text-xs text-slate-500 mt-2">
                        <span><i class="fas fa-info-circle mr-1"></i>Be as detailed as possible</span>
                        <span id="charCount" class="font-medium">{{ strlen($request->description) }} characters</span>
                    </div>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Existing Files -->
                @if($request->files->count() > 0)
                <div class="space-y-2">
                    <label class="flex items-center text-sm font-semibold text-slate-700 mb-3">
                        <i class="fas fa-images text-indigo-500 mr-2"></i>
                        Current Attachments
                    </label>
                    <div class="bg-slate-50 rounded-xl p-4 border-2 border-slate-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($request->files as $file)
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-slate-200">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    @if($file->is_image)
                                        <img src="{{ asset('storage/' . $file->file_path) }}" 
                                             alt="{{ $file->original_name }}" 
                                             class="w-12 h-12 object-cover rounded-lg">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                                            <i class="fas fa-file text-blue-600"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-900 truncate">{{ $file->original_name }}</p>
                                        <p class="text-xs text-slate-500">{{ number_format($file->file_size / 1024, 2) }} KB</p>
                                    </div>
                                </div>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" 
                                           name="remove_files[]" 
                                           value="{{ $file->id }}"
                                           class="w-4 h-4 text-red-600 focus:ring-2 focus:ring-red-500 border-slate-300 rounded">
                                    <span class="text-xs text-red-600 font-medium">Remove</span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- File Upload with Modern Design and Preview -->
                <div class="space-y-2">
                    <label for="files" class="flex items-center text-sm font-semibold text-slate-700 mb-3">
                        <i class="fas fa-paperclip text-pink-500 mr-2"></i>
                        Add New Attachments <span class="text-slate-400 text-xs font-normal ml-2">(Optional)</span>
                    </label>
                    <div id="dropZone" class="relative border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:border-blue-400 hover:bg-blue-50/30 transition-all duration-300 cursor-pointer group">
                        <input id="files" 
                               name="files[]" 
                               type="file" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                               multiple
                               accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx">
                        
                        <div id="uploadPrompt" class="pointer-events-none">
                            <div class="mx-auto flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 group-hover:bg-blue-200 transition-colors duration-300 mb-4">
                                <i class="fas fa-cloud-upload-alt text-3xl text-blue-500"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-slate-700 mb-2">Upload photos or documents</h3>
                            <p class="text-sm text-slate-500 mb-3">Drag and drop files here, or click to browse</p>
                            <div class="flex items-center justify-center gap-2 text-xs text-slate-400">
                                <span class="px-3 py-1 bg-slate-100 rounded-full">PNG</span>
                                <span class="px-3 py-1 bg-slate-100 rounded-full">JPG</span>
                                <span class="px-3 py-1 bg-slate-100 rounded-full">PDF</span>
                                <span class="px-3 py-1 bg-slate-100 rounded-full">Max 10MB each</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- File Preview Container -->
                    <div id="filePreview" class="hidden mt-4 space-y-2"></div>
                    
                    @error('files.*')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Buttons with Enhanced Design -->
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 border-t-2 border-slate-200">
                    <div class="flex items-center text-sm text-slate-600">
                        <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                        <span>Changes will be saved immediately</span>
                    </div>
                    
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <a href="{{ route('requests.show', $request) }}" 
                           class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3.5 border-2 border-slate-300 rounded-xl text-slate-700 font-semibold hover:bg-slate-50 hover:border-slate-400 transition-all duration-200 shadow-sm">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </a>
                        <!-- <button type="submit" 
                                class="flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-black font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-save mr-2"></i>
                            Update Request
                        </button> -->
                         <button type="submit" 
                                class="flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-3.5 bg-gradient-to-r from-green-500 to-cyan-500 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Update Request
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Character count for description
    const descriptionField = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    
    descriptionField.addEventListener('input', function() {
        const count = this.value.length;
        charCount.textContent = `${count} characters`;
        
        if (count > 500) {
            charCount.classList.add('text-green-600', 'font-bold');
        } else {
            charCount.classList.remove('text-green-600', 'font-bold');
        }
    });

    // File upload with preview and name display
    const fileInput = document.getElementById('files');
    const dropZone = document.getElementById('dropZone');
    const filePreview = document.getElementById('filePreview');
    const uploadPrompt = document.getElementById('uploadPrompt');
    let selectedFiles = [];

    // Handle file selection
    fileInput.addEventListener('change', function(e) {
        handleFiles(e.target.files);
    });

    // Drag and drop functionality
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
        
        const dt = e.dataTransfer;
        handleFiles(dt.files);
    });

    function handleFiles(files) {
        if (files.length === 0) return;

        selectedFiles = Array.from(files);
        displayFilePreview(selectedFiles);
    }

    function displayFilePreview(files) {
        if (files.length === 0) {
            filePreview.classList.add('hidden');
            uploadPrompt.classList.remove('hidden');
            return;
        }

        uploadPrompt.classList.add('hidden');
        filePreview.classList.remove('hidden');
        
        filePreview.innerHTML = `
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border border-green-200">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-semibold text-slate-900 flex items-center">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                        ${files.length} new file${files.length > 1 ? 's' : ''} selected
                    </h4>
                    <button type="button" onclick="clearFiles()" class="text-xs text-red-600 hover:text-red-800 font-medium">
                        <i class="fas fa-times-circle mr-1"></i>Clear all
                    </button>
                </div>
                <div class="space-y-2">
                    ${files.map((file, index) => {
                        const fileSize = (file.size / 1024).toFixed(2);
                        const fileIcon = getFileIcon(file.name);
                        const fileColor = getFileColor(file.name);
                        
                        return `
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-slate-200 hover:border-blue-300 transition-all duration-200">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0 w-10 h-10 rounded-lg ${fileColor} flex items-center justify-center">
                                        <i class="${fileIcon} text-lg"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-slate-900 truncate">${file.name}</p>
                                        <p class="text-xs text-slate-500">${fileSize} KB</p>
                                    </div>
                                </div>
                                <button type="button" onclick="removeFile(${index})" class="flex-shrink-0 ml-2 text-red-500 hover:text-red-700 transition-colors">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        `;
                    }).join('')}
                </div>
            </div>
        `;
    }

    function getFileIcon(fileName) {
        const extension = fileName.split('.').pop().toLowerCase();
        const icons = {
            'pdf': 'fas fa-file-pdf text-red-600',
            'doc': 'fas fa-file-word text-blue-600',
            'docx': 'fas fa-file-word text-blue-600',
            'jpg': 'fas fa-file-image text-purple-600',
            'jpeg': 'fas fa-file-image text-purple-600',
            'png': 'fas fa-file-image text-purple-600',
            'gif': 'fas fa-file-image text-purple-600'
        };
        return icons[extension] || 'fas fa-file text-slate-600';
    }

    function getFileColor(fileName) {
        const extension = fileName.split('.').pop().toLowerCase();
        const colors = {
            'pdf': 'bg-red-100',
            'doc': 'bg-blue-100',
            'docx': 'bg-blue-100',
            'jpg': 'bg-purple-100',
            'jpeg': 'bg-purple-100',
            'png': 'bg-purple-100',
            'gif': 'bg-purple-100'
        };
        return colors[extension] || 'bg-slate-100';
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        
        // Update the file input
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
        
        displayFilePreview(selectedFiles);
    }

    function clearFiles() {
        selectedFiles = [];
        fileInput.value = '';
        displayFilePreview([]);
    }
</script>

@endsection
