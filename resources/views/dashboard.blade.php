<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FixIT') }} - Newsfeed - Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('images/image1.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        /* Ensure gradient background works */
        .sidebar-gradient {
            background: linear-gradient(180deg, #4f46e5 0%, #9333ea 50%, #ec4899 100%);
        }
        
        /* Smooth scrollbar for sidebar */
        .sidebar-gradient::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar-gradient::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-gradient::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        
        .sidebar-gradient::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
        
        /* Layout structure */
        .dashboard-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {
            flex: 1;
            padding: 1.5rem;
        }
        
        /* Remove footer gaps */
        footer {
            margin: 0 !important;
            width: 100% !important;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Left Sidebar Navigation -->
        <aside class="w-72 sidebar-gradient text-white flex-shrink-0 overflow-y-auto shadow-2xl" x-data="{ open: false }">
            <div class="p-6">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 mb-8">
                    <div class="w-12 h-12">
                        <img src="{{ asset('images/image1.png') }}" alt="FixIt Solutions" class="object-contain">
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-bold text-white">FixIt</span>
                        <span class="text-xs text-purple-200 -mt-1">Repair & E-Commerce</span>
                    </div>
                </a>

                <!-- User Profile Card -->
                <div class="rounded-xl p-4 mb-6 border border-white border-opacity-20" style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px);">
                    <div class="flex items-center mb-3">
                        <img class="h-12 w-12 rounded-full ring-2 ring-white" src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                        <div class="ml-3 flex-1">
                            <h3 class="text-sm font-semibold text-white">{{ auth()->user()->name }}</h3>
                            <span class="inline-block px-2 py-0.5 text-xs rounded-full mt-1" style="background: rgba(255, 255, 255, 0.2);">
                                {{ auth()->user()->role_name }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-2">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'font-semibold' : '' }}"
                       style="{{ request()->routeIs('dashboard') ? 'background: rgba(255, 255, 255, 0.2); color: white;' : 'color: rgba(233, 213, 255, 1);' }}"
                       onmouseover="if(!this.classList.contains('font-semibold')) this.style.background='rgba(255, 255, 255, 0.1)'"
                       onmouseout="if(!this.classList.contains('font-semibold')) this.style.background='transparent'">
                        <i class="fas fa-stream w-5 mr-3"></i>
                        <span>Newsfeed</span>
                    </a>
                    
                    <a href="{{ route('requests.create') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('requests.create') ? 'font-semibold' : '' }}"
                       style="{{ request()->routeIs('requests.create') ? 'background: rgba(255, 255, 255, 0.2); color: white;' : 'color: rgba(233, 213, 255, 1);' }}"
                       onmouseover="if(!this.classList.contains('font-semibold')) this.style.background='rgba(255, 255, 255, 0.1)'"
                       onmouseout="if(!this.classList.contains('font-semibold')) this.style.background='transparent'">
                        <i class="fas fa-plus-circle w-5 mr-3"></i>
                        <span>New Request</span>
                    </a>
                    
                    <a href="{{ route('requests.my') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('requests.my') ? 'font-semibold' : '' }}"
                       style="{{ request()->routeIs('requests.my') ? 'background: rgba(255, 255, 255, 0.2); color: white;' : 'color: rgba(233, 213, 255, 1);' }}"
                       onmouseover="if(!this.classList.contains('font-semibold')) this.style.background='rgba(255, 255, 255, 0.1)'"
                       onmouseout="if(!this.classList.contains('font-semibold')) this.style.background='transparent'">
                        <i class="fas fa-tools w-5 mr-3"></i>
                        <span>My Requests</span>
                    </a>
                    
                    <a href="{{ route('blogs.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('blogs.*') ? 'font-semibold' : '' }}"
                       style="{{ request()->routeIs('blogs.*') ? 'background: rgba(255, 255, 255, 0.2); color: white;' : 'color: rgba(233, 213, 255, 1);' }}"
                       onmouseover="if(!this.classList.contains('font-semibold')) this.style.background='rgba(255, 255, 255, 0.1)'"
                       onmouseout="if(!this.classList.contains('font-semibold')) this.style.background='transparent'">
                        <i class="fas fa-blog w-5 mr-3"></i>
                        <span>Blog</span>
                    </a>
                    
                    <a href="{{ route('shop.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('shop.*') ? 'font-semibold' : '' }}"
                       style="{{ request()->routeIs('shop.*') ? 'background: rgba(255, 255, 255, 0.2); color: white;' : 'color: rgba(233, 213, 255, 1);' }}"
                       onmouseover="if(!this.classList.contains('font-semibold')) this.style.background='rgba(255, 255, 255, 0.1)'"
                       onmouseout="if(!this.classList.contains('font-semibold')) this.style.background='transparent'">
                        <i class="fas fa-store w-5 mr-3"></i>
                        <span>Shop</span>
                    </a>
                    
                    <a href="{{ route('user.orders') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('user.orders*') ? 'font-semibold' : '' }}"
                       style="{{ request()->routeIs('user.orders*') ? 'background: rgba(255, 255, 255, 0.2); color: white;' : 'color: rgba(233, 213, 255, 1);' }}"
                       onmouseover="if(!this.classList.contains('font-semibold')) this.style.background='rgba(255, 255, 255, 0.1)'"
                       onmouseout="if(!this.classList.contains('font-semibold')) this.style.background='transparent'">
                        <i class="fas fa-shopping-bag w-5 mr-3"></i>
                        <span>My Orders</span>
                    </a>
                    
                    <a href="{{ route('user.dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('user.dashboard*') ? 'font-semibold' : '' }}"
                       style="{{ request()->routeIs('user.dashboard*') ? 'background: rgba(255, 255, 255, 0.2); color: white;' : 'color: rgba(233, 213, 255, 1);' }}"
                       onmouseover="if(!this.classList.contains('font-semibold')) this.style.background='rgba(255, 255, 255, 0.1)'"
                       onmouseout="if(!this.classList.contains('font-semibold')) this.style.background='transparent'">
                        <i class="fas fa-tachometer-alt w-5 mr-3"></i>
                        <span>My Dashboard</span>
                    </a>
                    
                    <a href="{{ route('cart.index') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('cart.*') ? 'font-semibold' : '' }}"
                       style="{{ request()->routeIs('cart.*') ? 'background: rgba(255, 255, 255, 0.2); color: white;' : 'color: rgba(233, 213, 255, 1);' }}"
                       onmouseover="if(!this.classList.contains('font-semibold')) this.style.background='rgba(255, 255, 255, 0.1)'"
                       onmouseout="if(!this.classList.contains('font-semibold')) this.style.background='transparent'">
                        <i class="fas fa-shopping-cart w-5 mr-3"></i>
                        <span>Cart</span>
                        @php
                            $cartCount = \App\Models\Cart::where(function($query) {
                                if (Auth::id()) {
                                    $query->where('user_id', Auth::id());
                                } else {
                                    $query->where('session_id', Session::getId());
                                }
                            })->count();
                        @endphp
                        @if($cartCount > 0)
                            <span class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-0.5 font-bold shadow-lg">{{ $cartCount }}</span>
                        @endif
                    </a>
                    
                    @if(auth()->user()->isTechnician())
                    <a href="{{ route('requests.assigned') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('requests.assigned') ? 'font-semibold' : '' }}"
                       style="{{ request()->routeIs('requests.assigned') ? 'background: rgba(255, 255, 255, 0.2); color: white;' : 'color: rgba(233, 213, 255, 1);' }}"
                       onmouseover="if(!this.classList.contains('font-semibold')) this.style.background='rgba(255, 255, 255, 0.1)'"
                       onmouseout="if(!this.classList.contains('font-semibold')) this.style.background='transparent'">
                        <i class="fas fa-user-check w-5 mr-3"></i>
                        <span>Assigned to Me</span>
                    </a>
                    @endif
                    
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('admin.*') ? 'font-semibold' : '' }}"
                       style="{{ request()->routeIs('admin.*') ? 'background: rgba(255, 255, 255, 0.2); color: white;' : 'color: rgba(233, 213, 255, 1);' }}"
                       onmouseover="if(!this.classList.contains('font-semibold')) this.style.background='rgba(255, 255, 255, 0.1)'"
                       onmouseout="if(!this.classList.contains('font-semibold')) this.style.background='transparent'">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        <span>Admin Panel</span>
                    </a>
                    @endif

                    <div class="border-t my-4" style="border-color: rgba(255, 255, 255, 0.2);"></div>

                    <a href="{{ route('profile.edit') }}" 
                       class="flex items-center px-4 py-3 rounded-lg transition-all duration-200"
                       style="color: rgba(233, 213, 255, 1);"
                       onmouseover="this.style.background='rgba(255, 255, 255, 0.1)'"
                       onmouseout="this.style.background='transparent'">
                        <i class="fas fa-user w-5 mr-3"></i>
                        <span>Profile</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center px-4 py-3 rounded-lg transition-all duration-200"
                                style="color: rgba(233, 213, 255, 1);"
                                onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'"
                                onmouseout="this.style.background='transparent'">
                            <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                            <span>Log Out</span>
                        </button>
                    </form>
                </nav>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 overflow-y-auto">
            <div class="dashboard-container">
            <!-- Top Header Bar -->
            <header class="bg-white shadow-sm sticky top-0 z-40">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Newsfeed</h1>
                            <p class="text-sm text-gray-600">Stay updated with all service requests</p>
                        </div>

                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open; if(open) loadNotifications();" class="relative p-2 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition">
                                    <i class="fas fa-bell text-xl"></i>
                                    @php
                                        $unreadCount = auth()->user()->unreadNotifications->count();
                                    @endphp
                                    @if($unreadCount > 0)
                                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center animate-pulse">
                                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                        </span>
                                    @endif
                                </button>
                                
                                <!-- Notifications Dropdown -->
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 transform scale-95"
                                     x-transition:enter-end="opacity-100 transform scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 transform scale-100"
                                     x-transition:leave-end="opacity-0 transform scale-95"
                                     class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-2xl border border-gray-200"
                                     style="display: none; z-index: 99999; position: fixed; top: 60px; right: 20px;">
                                    <div class="p-4 border-b border-gray-200">
                                        <h3 class="text-lg font-semibold text-gray-800">Notifications</h3>
                                    </div>
                                    <div class="max-h-96 overflow-y-auto" id="notifications-container">
                                        <div class="p-4 text-center text-gray-500">Loading...</div>
                                    </div>
                                    <div class="p-3 border-t border-gray-200 text-center">
                                        <button onclick="markAllAsRead()" class="text-sm text-blue-600 hover:text-blue-700">
                                            Mark all as read
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                <div class="max-w-7xl mx-auto">
                    <div class="flex flex-col lg:flex-row gap-6">
        
        <!-- Left Sidebar - User Stats & Quick Actions -->
        <div class="lg:w-1/4">
            <!-- Welcome Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center mb-4">
                    <img class="h-12 w-12 rounded-full" src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-gray-900">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-600">{{ auth()->user()->role_name }}</p>
                    </div>
                </div>
                
                <!-- User Stats -->
                <div class="grid grid-cols-2 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-blue-600">{{ $userStats['my_requests'] }}</div>
                        <div class="text-xs text-gray-500">My Requests</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-600">{{ $userStats['my_completed'] }}</div>
                        <div class="text-xs text-gray-500">Completed</div>
                    </div>
                </div>
                
                @if(auth()->user()->isTechnician())
                <div class="grid grid-cols-2 gap-4 text-center mt-4 pt-4 border-t border-gray-200">
                    <div>
                        <div class="text-2xl font-bold text-orange-600">{{ $userStats['assigned_to_me'] }}</div>
                        <div class="text-xs text-gray-500">Assigned</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-purple-600">{{ $userStats['completed_by_me'] }}</div>
                        <div class="text-xs text-gray-500">Resolved</div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('requests.create') }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium text-center block transition duration-200">
                        Submit New Request
                    </a>
                    
                    <a href="{{ route('requests.my') }}" 
                       class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium text-center block transition duration-200">
                        View My Requests
                    </a>
                    
                    @if(auth()->user()->isTechnician())
                    <a href="{{ route('requests.assigned') }}" 
                       class="w-full bg-orange-100 hover:bg-orange-200 text-orange-700 px-4 py-2 rounded-lg font-medium text-center block transition duration-200">
                        My Assignments
                    </a>
                    @endif
                    
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" 
                       class="w-full bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg font-medium text-center block transition duration-200">
                        Admin Panel
                    </a>
                    @endif
                </div>
            </div>

            <!-- Category Filter -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter by Category</h3>
                
                <div class="space-y-2">
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-3 py-2 text-sm rounded-lg transition-all duration-200 {{ request()->get('category') ? 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' : 'bg-blue-100 text-blue-700 font-medium border-l-4 border-blue-500' }}">
                        <span class="inline-block w-3 h-3 rounded-full mr-3 bg-gray-400"></span>
                        All Categories
                    </a>
                    
                    @foreach($categories as $category)
                    <a href="{{ route('dashboard') }}?category={{ $category->id }}" 
                       class="flex items-center px-3 py-2 text-sm rounded-lg transition-all duration-200 {{ request()->get('category') == $category->id ? 'bg-blue-100 text-blue-700 font-medium border-l-4 border-blue-500' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-800' }}">
                        <span class="inline-block w-3 h-3 rounded-full mr-3" style="background-color: {{ $category->color }};"></span>
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- Main Content - Request Feed -->
        <div class="lg:w-3/4">
            <!-- Feed Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">
                            @if(auth()->user()->isAdmin()) All Requests
                            @elseif(auth()->user()->isTechnician()) Request Feed
                            @else Community Requests
                            @endif
                            @if(request()->get('category'))
                                @php
                                    $selectedCategory = $categories->firstWhere('id', request()->get('category'));
                                @endphp
                                @if($selectedCategory)
                                    <span class="text-lg font-normal text-gray-600"> - {{ $selectedCategory->name }}</span>
                                @endif
                            @endif
                        </h2>
                        <div class="flex items-center gap-4 mt-1">
                            <p class="text-gray-600">Stay updated with the latest maintenance requests</p>
                            @if(request()->get('category'))
                                <a href="{{ route('dashboard') }}" 
                                   class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                    ← Clear Filter
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <a href="{{ route('requests.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition duration-200">
                        + New Request
                    </a>
                </div>
            </div>

            <!-- Results Info -->
            @if($requests->total() > 0)
                <div class="bg-gray-50 rounded-lg p-4 mb-6 border border-gray-200">
                    <p class="text-sm text-gray-600">
                        Showing {{ $requests->count() }} of {{ $requests->total() }} requests
                        @if(request()->get('category'))
                            @php
                                $selectedCategory = $categories->firstWhere('id', request()->get('category'));
                            @endphp
                            @if($selectedCategory)
                                in <span class="font-medium text-gray-900">{{ $selectedCategory->name }}</span>
                            @endif
                        @endif
                    </p>
                </div>
            @endif

            <!-- Requests Feed -->
            @forelse($requests as $request)
                @php
                    $attachmentCount = $request->files->count();
                    $previewFiles = $request->files->take(3);
                    $extraAttachments = max($attachmentCount - $previewFiles->count(), 0);
                    $latestComment = $request->comments->sortByDesc('created_at')->first();
                @endphp
                <article class="relative bg-white rounded-3xl border border-gray-200/80 shadow-sm mb-6 overflow-hidden transition duration-200 hover:shadow-lg hover:-translate-y-1">
                    <span class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500"></span>

                    <div class="p-6 md:p-8 ">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 border-b border-blue-500 pb-6">
                            <div class="flex items-start gap-4">
                                <div class="relative shrink-0">
                                    <img class="h-14 w-14 rounded-2xl object-cover ring-4 ring-slate-100" 
                                         src="{{ $request->user->avatar_url }}" 
                                         alt="{{ $request->user->name }}">
                                    <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wider rounded-full bg-slate-900 text-black shadow-lg">#{{ $request->ticket_reference ?? $request->id }}</span>
                                </div>

                                <div>
                                    <div class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-400">
                                        <span>Maintenance Request</span>
                                        <span class="h-1.5 w-1.5 rounded-full bg-gray-200"></span>
                                        <span>{{ $request->created_at->format('M d, Y • g:i A') }}</span>
                                    </div>
                                    <h4 class="mt-1 text-xl md:text-2xl font-semibold text-gray-900 leading-tight">{{ $request->title }}</h4>
                                    <div class="mt-3 flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $request->user->name }}
                                        </span>
                                        <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"></path>
                                            </svg>
                                            {{ $request->location }}
                                        </span>
                                        <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 8v8a2 2 0 01-2 2H5a2 2 0 01-2-2V8" />
                                            </svg>
                                            {{ $request->user->email }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-end gap-2">
                                @if($request->category)
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full shadow-sm" 
                                          style="background-color: {{ $request->category->color }}20; color: {{ $request->category->color }};">
                                        {{ $request->category->name }}
                                    </span>
                                @endif

                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $request->priority_badge_color }}">
                                    {{ $request->priority_name }}
                                </span>

                                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $request->status_badge_color }}">
                                    {{ $request->status_name }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-6 space-y-6">
                            <p class="text-gray-700 leading-relaxed">{{ $request->description }}</p>

                            @if($attachmentCount > 0)
                                <div class="flex flex-col gap-3">
                                    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L20 7"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 5h5v5"></path>
                                        </svg>
                                        Attachments
                                    </div>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                        @foreach($previewFiles as $file)
                                            @if($file->is_image)
                                                <div class="relative overflow-hidden rounded-2xl group border border-gray-200">
                                                    <img src="{{ asset('storage/' . $file->file_path) }}" 
                                                         alt="Request attachment" 
                                                         class="w-full h-32 object-cover transition duration-200 group-hover:scale-105">
                                                    <span class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition"></span>
                                                </div>
                                            @else
                                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="flex items-center justify-between rounded-2xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm font-medium text-gray-600 hover:bg-gray-100">
                                                    <span>{{ basename($file->file_path) }}</span>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 5v14m7-7H5"></path>
                                                    </svg>
                                                </a>
                                            @endif
                                        @endforeach

                                        @if($extraAttachments > 0)
                                            <div class="flex items-center justify-center rounded-2xl border border-dashed border-gray-300 bg-white/60 text-gray-500 font-semibold text-sm">
                                                +{{ $extraAttachments }} more
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($latestComment)
                                <div class="rounded-2xl border border-gray-200 bg-gray-50/80 p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm">
                                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l3-3h4a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v6a2 2 0 002 2h3v5z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="flex flex-wrap items-center gap-2 text-sm text-gray-500">
                                                <span class="font-semibold text-gray-700">{{ $latestComment->user->name ?? 'Team Member' }}</span>
                                                <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                                                <span>{{ optional($latestComment->created_at)->diffForHumans() }}</span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-700 leading-relaxed">{{ \Illuminate\Support\Str::limit($latestComment->content ?? $latestComment->body ?? '', 180) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-8 border-t border-gray-100 pt-6 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                            <div class="flex flex-wrap items-center gap-5 text-sm text-gray-500">
                                @if($request->assignedTechnician)
                                    <span class="flex items-center gap-2 text-gray-600">
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-blue-50 text-blue-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </span>
                                        Assigned to {{ $request->assignedTechnician->name }}
                                    </span>
                                @endif

                                <span class="flex items-center gap-2">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-indigo-50 text-indigo-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m5 8l-4-4H7a2 2 0 01-2-2V7a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-3v5z"></path>
                                        </svg>
                                    </span>
                                    {{ $request->comments->count() }} comments
                                </span>

                                <span class="flex items-center gap-2">
                                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-purple-50 text-purple-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8a4 4 0 100 8 4 4 0 000-8z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </span>
                                    {{ $request->views_count }} views
                                </span>
                            </div>

                            <div class="flex flex-wrap items-center gap-3">
                                @if($request->user_id === auth()->id() || auth()->user()->isAdmin())
                                    <!-- Edit Button -->
                                    <a href="{{ route('requests.edit', $request) }}" 
                                       class="inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-4 py-2 text-sm font-semibold text-blue-600 hover:bg-blue-100 hover:border-blue-300 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    
                                    <!-- Delete Button -->
                                    <form action="{{ route('requests.destroy', $request) }}" method="POST" class="inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this request? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center gap-2 rounded-full border border-red-200 bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 hover:bg-red-100 hover:border-red-300 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                @endif
                                
                                <a href="{{ route('requests.show', $request) }}" 
                                   class="inline-flex items-center gap-2 rounded-full border border-gray-200 px-4 py-2 text-sm font-semibold text-gray-600 hover:text-gray-900 hover:border-gray-300 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No requests found</h3>
                    <p class="text-gray-500 mb-4">Be the first to submit a maintenance request!</p>
                    <a href="{{ route('requests.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                        Submit Request
                    </a>
                </div>
            @endforelse
            
            <!-- Pagination -->
            @if($requests->hasPages())
                <div class="mt-6">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
</main>

<!-- Footer -->
@include('components.footer')
</div>
</div>

<!-- Floating AI Assistant Button - TOP RIGHT POSITION -->
<div x-data="{ showAI: false }" x-init="$watch('showAI', value => { if (value) { $nextTick(() => { if ($refs.aiChatContainer) $refs.aiChatContainer.scrollTop = $refs.aiChatContainer.scrollHeight; }) } })">
    <!-- Purple Robot Floating Button - Professional Design -->
    <button 
        @click="showAI = true"
        class="fixed top-20 right-6 w-16 h-16 bg-gradient-to-br from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-purple-300 group"
        style="z-index: 9999;"
        aria-label="Open AI Assistant">
        <svg class="w-8 h-8 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        <!-- Pulse Animation -->
        <span class="absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75 animate-ping"></span>
        <!-- Badge -->
        <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white border-2 border-white">
            AI
        </span>
    </button>

    <!-- AI Chat Modal - Slide Over Panel -->
    <div 
        x-show="showAI" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 overflow-hidden"
        style="display: none; z-index: 9998;"
        @keydown.escape.window="showAI = false">
        
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm" @click="showAI = false"></div>
        
        <!-- Slide Over Panel -->
        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
            <div 
                x-show="showAI"
                x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="w-screen max-w-md"
                x-data="aiChat()">
                
                <div class="flex h-full flex-col bg-white shadow-2xl">
                    
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-6 text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold">AI Assistant</h2>
                                    <p class="text-sm text-purple-100 flex items-center">
                                        <span class="inline-block w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                                        Online & Ready to Help
                                    </p>
                                </div>
                            </div>
                            <button 
                                @click="showAI = false"
                                class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition-all duration-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Chat Messages Container -->
                    <div 
                        x-ref="aiChatContainer"
                        class="flex-1 overflow-y-auto bg-gray-50 px-6 py-4 space-y-4"
                        style="max-height: calc(100vh - 280px);">
                        
                        <!-- Welcome Message -->
                        <div class="flex items-start space-x-3 animate-fade-in">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-full flex items-center justify-center shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-md border border-gray-100">
                                    <p class="text-sm text-gray-800 leading-relaxed">
                                        👋 <strong>Hello!</strong> I'm your FixIT AI Assistant. I can help you with:
                                    </p>
                                    <ul class="mt-2 space-y-1 text-sm text-gray-700">
                                        <li class="flex items-center"><span class="mr-2">🔧</span> Plumbing & water issues</li>
                                        <li class="flex items-center"><span class="mr-2">⚡</span> Electrical problems</li>
                                        <li class="flex items-center"><span class="mr-2">🌡️</span> HVAC & temperature control</li>
                                        <li class="flex items-center"><span class="mr-2">💻</span> IT & technology support</li>
                                        <li class="flex items-center"><span class="mr-2">🧹</span> Cleaning services</li>
                                        <li class="flex items-center"><span class="mr-2">📝</span> Creating maintenance requests</li>
                                    </ul>
                                    <p class="text-sm text-gray-600 mt-3 italic">Ask me anything!</p>
                                </div>
                                <span class="text-xs text-gray-500 mt-1 block ml-1">Just now</span>
                            </div>
                        </div>

                        <!-- Dynamic Messages -->
                        <template x-for="message in messages" :key="message.id">
                            <div 
                                class="flex items-start space-x-3 animate-fade-in" 
                                :class="message.type === 'user' ? 'flex-row-reverse space-x-reverse' : ''">
                                
                                <!-- Avatar -->
                                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center shadow-md"
                                     :class="message.type === 'ai' ? 'bg-gradient-to-br from-purple-600 to-indigo-600' : 'bg-gradient-to-br from-blue-600 to-blue-700'">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path x-show="message.type === 'ai'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        <path x-show="message.type === 'user'" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                
                                <div class="flex-1">
                                    <!-- User Message Bubble -->
                                    <div x-show="message.type === 'user'" 
                                         class="p-4 rounded-2xl shadow-md border border-blue-500 rounded-tr-none text-white" 
                                         style="background: linear-gradient(to bottom right, #2563eb, #1d4ed8);">
                                        <p class="text-sm leading-relaxed whitespace-pre-line" x-html="message.content.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')"></p>
                                    </div>
                                    
                                    <!-- AI Message Bubble -->
                                    <div x-show="message.type === 'ai'" 
                                         class="p-4 rounded-2xl shadow-md border border-gray-100 rounded-tl-none bg-white text-gray-800">
                                        <p class="text-sm leading-relaxed whitespace-pre-line" x-html="message.content.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')"></p>
                                    </div>
                                    
                                    <span class="text-xs text-gray-500 mt-1 block ml-1" 
                                          :class="message.type === 'user' ? 'text-right mr-1' : ''"
                                          x-text="message.timestamp"></span>
                                </div>
                            </div>
                        </template>

                        <!-- Loading Indicator -->
                        <div x-show="loading" class="flex items-start space-x-3 animate-fade-in">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-purple-600 to-indigo-600 rounded-full flex items-center justify-center shadow-md">
                                <svg class="w-5 h-5 text-white animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-md border border-gray-100">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex space-x-1">
                                            <span class="w-2 h-2 bg-purple-600 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                                            <span class="w-2 h-2 bg-purple-600 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                                            <span class="w-2 h-2 bg-purple-600 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                                        </div>
                                        <p class="text-sm text-gray-600">AI is thinking...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Suggestions Chips -->
                    <div class="px-6 py-3 bg-white border-t border-gray-200">
                        <p class="text-xs font-medium text-gray-500 mb-2">Quick Questions:</p>
                        <div class="flex flex-wrap gap-2">
                            <button 
                                @click="askQuestion('How do I fix a water leak?')"
                                class="px-3 py-2 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 text-blue-700 rounded-full text-xs font-medium transition-all duration-200 border border-blue-200 shadow-sm hover:shadow-md transform hover:scale-105">
                                💧 Water Leak
                            </button>
                            <button 
                                @click="askQuestion('My computer won\'t start')"
                                class="px-3 py-2 bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 text-purple-700 rounded-full text-xs font-medium transition-all duration-200 border border-purple-200 shadow-sm hover:shadow-md transform hover:scale-105">
                                💻 IT Issue
                            </button>
                            <button 
                                @click="askQuestion('Room temperature is too hot')"
                                class="px-3 py-2 bg-gradient-to-r from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 text-orange-700 rounded-full text-xs font-medium transition-all duration-200 border border-orange-200 shadow-sm hover:shadow-md transform hover:scale-105">
                                🌡️ HVAC
                            </button>
                            <button 
                                @click="askQuestion('How to create a request?')"
                                class="px-3 py-2 bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 text-green-700 rounded-full text-xs font-medium transition-all duration-200 border border-green-200 shadow-sm hover:shadow-md transform hover:scale-105">
                                📝 Help
                            </button>
                        </div>
                    </div>

                    <!-- Input Area -->
                    <div class="px-6 py-4 bg-white border-t border-gray-200">
                        <form @submit.prevent="sendMessage()" class="relative">
                            <input 
                                type="text" 
                                x-model="currentMessage"
                                placeholder="Type your question here..."
                                class="w-full pl-4 pr-12 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm transition-all duration-200 shadow-sm"
                                :disabled="loading"
                                maxlength="500"
                                autofocus>
                            <button 
                                type="submit"
                                class="absolute right-2 top-1/2 transform -translate-y-1/2 p-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg transition-all duration-200 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="loading || currentMessage.trim() === ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </button>
                        </form>
                        <p class="text-xs text-gray-500 mt-2 text-center">
                            Powered by AI • <span x-text="currentMessage.length"></span>/500 characters
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

/* Custom scrollbar for chat */
[x-ref="aiChatContainer"]::-webkit-scrollbar {
    width: 6px;
}

[x-ref="aiChatContainer"]::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 10px;
}

[x-ref="aiChatContainer"]::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #9333ea, #4f46e5);
    border-radius: 10px;
}

[x-ref="aiChatContainer"]::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #7e22ce, #4338ca);
}
</style>

<script>
function aiChat() {
    return {
        messages: [],
        currentMessage: '',
        loading: false,
        messageId: 1,

        sendMessage() {
            if (this.currentMessage.trim() === '' || this.loading) return;

            const message = this.currentMessage.trim();
            
            // Add user message
            this.messages.push({
                id: this.messageId++,
                type: 'user',
                content: message,
                timestamp: this.getCurrentTime()
            });

            // Clear input and show loading
            this.currentMessage = '';
            this.loading = true;
            this.scrollToBottom();

            // Send to AI API
            fetch('{{ route("ai.chat") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    question: message
                })
            })
            .then(response => response.json())
            .then(data => {
                this.loading = false;
                
                // Add AI response
                this.messages.push({
                    id: this.messageId++,
                    type: 'ai',
                    content: data.response || 'Sorry, I encountered an error. Please try again.',
                    timestamp: data.timestamp || this.getCurrentTime()
                });
                
                this.scrollToBottom();
            })
            .catch(error => {
                this.loading = false;
                console.error('AI Chat Error:', error);
                
                this.messages.push({
                    id: this.messageId++,
                    type: 'ai',
                    content: 'I\'m having trouble connecting right now. Please try again in a moment, or create a maintenance request for immediate help.',
                    timestamp: this.getCurrentTime()
                });
                
                this.scrollToBottom();
            });
        },

        askQuestion(question) {
            this.currentMessage = question;
            this.sendMessage();
        },

        getCurrentTime() {
            return new Date().toLocaleTimeString('en-US', { 
                hour: '2-digit', 
                minute: '2-digit',
                hour12: false
            });
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.chatContainer;
                container.scrollTop = container.scrollHeight;
            });
        }
    }
}
</script>

<!-- Notification Script -->
<script>
function loadNotifications() {
    fetch('{{ route("notifications.get") }}')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('notifications-container');
            const notifications = data.notifications || [];
            
            if (notifications.length === 0) {
                container.innerHTML = '<div class="p-4 text-center text-gray-500">No notifications</div>';
                return;
            }
            
            container.innerHTML = notifications.map(notification => `
                <div class="p-4 border-b border-gray-200 hover:bg-gray-50 transition ${notification.read_at ? '' : 'bg-blue-50'}">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            ${notification.read_at ? 
                                '<i class="fas fa-envelope-open text-gray-400"></i>' : 
                                '<i class="fas fa-envelope text-blue-600"></i>'
                            }
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-medium text-gray-900">${notification.data.title || 'Notification'}</p>
                            <p class="text-sm text-gray-600 mt-1">${notification.data.message}</p>
                            <p class="text-xs text-gray-400 mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            document.getElementById('notifications-container').innerHTML = 
                '<div class="p-4 text-center text-red-500">Failed to load notifications</div>';
        });
}

function markAllAsRead() {
    fetch('{{ route("notifications.mark-all-read") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(() => {
        loadNotifications();
        location.reload();
    })
    .catch(error => console.error('Error marking notifications as read:', error));
}
</script>

</main>
        </div>
    </div>
</body>
</html>
