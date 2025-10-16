@extends('layouts.app')

@section('title', 'Newsfeed - Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
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
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6 overflow-hidden hover:shadow-md transition duration-200">
                    <!-- Request Header -->
                    <div class="p-6 pb-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center flex-1">
                                <img class="h-12 w-12 rounded-full" 
                                     src="{{ $request->user->avatar_url }}" 
                                     alt="{{ $request->user->name }}">
                                <div class="ml-4">
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $request->title }}</h4>
                                    <div class="flex items-center text-sm text-gray-500 mt-1">
                                        <span>{{ $request->user->name }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $request->created_at->diffForHumans() }}</span>
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
                                    <span class="px-3 py-1 text-xs font-medium rounded-full" 
                                          style="background-color: {{ $request->category->color }}20; color: {{ $request->category->color }};">
                                        {{ $request->category->name }}
                                    </span>
                                @endif
                                
                                <span class="px-3 py-1 text-xs font-medium rounded-full {{ $request->priority_badge_color }}">
                                    {{ $request->priority_name }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Request Content -->
                    <div class="px-6 pb-4">
                        <p class="text-gray-700 leading-relaxed">{{ $request->description }}</p>
                        
                        @if($request->files->count() > 0)
                        <div class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($request->files->take(3) as $file)
                                @if($file->is_image)
                                    <img src="{{ asset('storage/' . $file->file_path) }}" 
                                         alt="Request attachment" 
                                         class="w-full h-32 object-cover rounded-lg">
                                @endif
                            @endforeach
                            
                            @if($request->files->count() > 3)
                                <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500 font-medium">+{{ $request->files->count() - 3 }} more</span>
                                </div>
                            @endif
                        </div>
                        @endif
                    </div>
                    
                    <!-- Request Footer -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $request->status_badge_color }}">
                                    {{ $request->status_name }}
                                </span>
                                
                                @if($request->assignedTechnician)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Assigned to {{ $request->assignedTechnician->name }}
                                    </span>
                                @endif
                                
                                @if($request->comments->count() > 0)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        {{ $request->comments->count() }} comments
                                    </span>
                                @endif
                                
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ $request->views_count }} views
                                </span>
                            </div>
                            
                            <a href="{{ route('requests.show', $request) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                View Details →
                            </a>
                        </div>
                    </div>
                </div>
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

@endsection
