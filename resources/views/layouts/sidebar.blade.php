<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FixIT') }} - @yield('title', 'Repair and E-commerce Services')</title>
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
        
        /* Force flex layout for main container */
        .main-layout-container {
            display: flex !important;
            flex-direction: row !important;
            height: 100vh !important;
            overflow: hidden !important;
        }
        
        .sidebar-container {
            width: 288px !important; /* w-72 = 288px */
            min-width: 288px !important;
            max-width: 288px !important;
            flex-shrink: 0 !important;
            flex-grow: 0 !important;
            overflow-y: auto !important;
            position: relative !important;
        }
        
        .content-container {
            flex: 1 !important;
            flex-grow: 1 !important;
            overflow-y: auto !important;
            min-width: 0 !important;
        }
        
        /* Ensure no CSS is breaking the layout */
        body {
            margin: 0 !important;
            padding: 0 !important;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="main-layout-container flex h-screen overflow-hidden">
        
        <!-- Left Sidebar Navigation -->
        <aside class="sidebar-container w-72 sidebar-gradient text-white flex-shrink-0 overflow-y-auto shadow-2xl" x-data="{ open: false }">
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
        <div class="content-container flex-1 overflow-y-auto">
            <!-- Top Header Bar -->
            <header class="bg-white shadow-sm sticky top-0 z-40">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                            <p class="text-sm text-gray-600">@yield('page-description', '')</p>
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

                            <!-- AI Assistant Button - Next to Notifications -->
                            <div x-data="{ showAI: false }" x-init="$watch('showAI', value => { if (value) { $nextTick(() => { if ($refs.aiChatContainer) $refs.aiChatContainer.scrollTop = $refs.aiChatContainer.scrollHeight; }) } })">
                                <!-- AI Assistant Button -->
                                <button 
                                    @click="showAI = true"
                                    class="relative p-2 text-gray-600 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition"
                                    aria-label="Open AI Assistant">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    <!-- AI Badge -->
                                    <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-purple-500 text-xs font-bold text-white">
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
                                    class="fixed inset-0 overflow-hidden z-50" 
                                    style="display: none;">
                                    
                                    <!-- Backdrop -->
                                    <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm"></div>
                                    
                                    <!-- Slide-over Panel -->
                                    <div class="absolute inset-y-0 right-0 flex max-w-md w-full"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="transform translate-x-full"
                                         x-transition:enter-end="transform translate-x-0"
                                         x-transition:leave="transition ease-in duration-200"
                                         x-transition:leave-start="transform translate-x-0"
                                         x-transition:leave-end="transform translate-x-full">
                                        
                                        <div class="flex h-full flex-col bg-white shadow-2xl" x-data="aiChat()">
                                            
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
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @yield('content')
            </main>
        </div>
    </div>

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

    // AI Chat Function
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
                    const container = this.$refs.aiChatContainer;
                    if (container) container.scrollTop = container.scrollHeight;
                });
            }
        }
    }
    </script>

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

    @stack('scripts')
</body>
</html>
