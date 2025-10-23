@extends('layouts.sidebar')

@section('title', 'Profile')
@section('page-title', 'Profile')
@section('page-description', 'Manage your account settings and preferences')

@section('content')
    <div class="max-w-7xl mx-auto">
        @if(session('status') === 'profile-updated')
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center">
                <i class="fas fa-check-circle mr-3"></i>
                <span>Profile updated successfully!</span>
            </div>
        @endif

        <!-- Profile Header Card -->
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- Avatar Section -->
                    <div class="relative group">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" 
                                class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-xl">
                        @else
                            <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center border-4 border-white shadow-xl">
                                <span class="text-5xl font-bold text-transparent bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                        <div class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow-lg">
                            <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                                <i class="fas fa-camera text-white text-sm"></i>
                            </div>
                        </div>
                    </div>

                    <!-- User Info -->
                    <div class="flex-1 text-center md:text-left">
                        <h2 class="text-3xl font-bold text-white mb-2">{{ $user->name }}</h2>
                        <p class="text-white/90 text-lg mb-1">{{ $user->email }}</p>
                        <div class="inline-flex items-center px-4 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white font-semibold text-sm mt-2">
                            @if($user->role === 'admin')
                                <i class="fas fa-crown mr-2 text-yellow-300"></i>
                                Administrator
                            @elseif($user->role === 'technician')
                                <i class="fas fa-tools mr-2 text-cyan-300"></i>
                                Technician
                            @else
                                <i class="fas fa-user mr-2"></i>
                                User
                            @endif
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center border border-white/20">
                            <div class="text-2xl font-bold text-white">{{ $user->requests()->count() }}</div>
                            <div class="text-white/80 text-sm">Requests</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4 text-center border border-white/20">
                            <div class="text-2xl font-bold text-white">{{ $user->orders()->count() }}</div>
                            <div class="text-white/80 text-sm">Orders</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Information Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-user-edit mr-3 text-blue-600"></i>
                            Profile Information
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Update your account's profile information and email address.</p>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <!-- Avatar Upload -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-image mr-2 text-blue-600"></i>Profile Photo
                                </label>
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        @if($user->avatar)
                                            <img id="avatar-preview" src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" 
                                                class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                                        @else
                                            <div id="avatar-preview" class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                                <span class="text-2xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="avatar" id="avatar" accept="image/*" 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            onchange="previewAvatar(event)">
                                        <p class="text-xs text-gray-500 mt-1">JPG, PNG or GIF (max 2MB)</p>
                                        @error('avatar')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2 text-blue-600"></i>Full Name
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                                    required>
                                @error('name')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-envelope mr-2 text-blue-600"></i>Email Address
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                                    required>
                                @error('email')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-2 text-blue-600"></i>Phone Number
                                </label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                                    placeholder="+1 (555) 123-4567">
                                @error('phone')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Address
                                </label>
                                <textarea name="address" id="address" rows="3" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                                    placeholder="Enter your full address">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bio -->
                            <div>
                                <label for="bio" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-info-circle mr-2 text-blue-600"></i>Bio
                                </label>
                                <textarea name="bio" id="bio" rows="4" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-50"
                                    placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Maximum 1000 characters</p>
                                @error('bio')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Save Button -->
                            <div class="flex items-center gap-4">
                                <button type="submit" 
                                    class="px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-300 shadow-lg">
                                    <i class="fas fa-save mr-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Update Password -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-50 to-red-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <i class="fas fa-lock mr-3 text-orange-600"></i>
                            Update Password
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">Ensure your account is using a long, random password to stay secure.</p>
                    </div>
                    <div class="p-6">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account (Only for non-admin users) -->
                @if($user->role !== 'admin')
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-red-200">
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 px-6 py-4 border-b border-red-200">
                            <h3 class="text-xl font-bold text-red-900 flex items-center">
                                <i class="fas fa-exclamation-triangle mr-3 text-red-600"></i>
                                Delete Account
                            </h3>
                            <p class="text-sm text-red-700 mt-1">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                        </div>
                        <div class="p-6">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Account Details -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <i class="fas fa-id-card mr-2 text-green-600"></i>
                            Account Details
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-calendar-alt text-blue-600 mt-1"></i>
                            <div>
                                <p class="text-xs text-gray-500">Member Since</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-clock text-purple-600 mt-1"></i>
                            <div>
                                <p class="text-xs text-gray-500">Last Updated</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $user->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($user->email_verified_at)
                            <div class="flex items-start gap-3">
                                <i class="fas fa-check-circle text-green-600 mt-1"></i>
                                <div>
                                    <p class="text-xs text-gray-500">Email Verified</p>
                                    <p class="text-sm font-semibold text-gray-900">{{ $user->email_verified_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl shadow-lg overflow-hidden text-white p-6">
                    <h3 class="text-lg font-bold mb-4 flex items-center">
                        <i class="fas fa-bolt mr-2"></i>
                        Quick Actions
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('dashboard') }}" class="block bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg px-4 py-3 transition-all duration-300 border border-white/30">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="{{ route('requests.my') }}" class="block bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg px-4 py-3 transition-all duration-300 border border-white/30">
                            <i class="fas fa-tasks mr-2"></i>My Requests
                        </a>
                        <a href="{{ route('user.orders') }}" class="block bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg px-4 py-3 transition-all duration-300 border border-white/30">
                            <i class="fas fa-shopping-bag mr-2"></i>My Orders
                        </a>
                    </div>
                </div>

                <!-- Help & Support -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="bg-gradient-to-r from-cyan-50 to-blue-50 px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <i class="fas fa-question-circle mr-2 text-cyan-600"></i>
                            Need Help?
                        </h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Have questions about your account? We're here to help!</p>
                        <a href="{{ route('home') }}#contact" class="block text-center bg-gradient-to-r from-cyan-600 to-blue-600 text-white px-4 py-2 rounded-lg hover:from-cyan-700 hover:to-blue-700 transition-all duration-300">
                            <i class="fas fa-envelope mr-2"></i>Contact Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Avatar Preview Script -->
    <script>
        function previewAvatar(event) {
            const preview = document.getElementById('avatar-preview');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.id = 'avatar-preview';
                        img.src = e.target.result;
                        img.className = 'w-20 h-20 rounded-full object-cover border-2 border-gray-300';
                        preview.replaceWith(img);
                    }
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
