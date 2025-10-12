@extends('layouts.app')

@section('title', 'Welcome to FixIT - Professional Maintenance Solutions')

@section('content')
<!-- Hero Section with Animation -->
<div class="relative min-h-screen bg-gradient-to-br from-purple-900 via-blue-900 to-indigo-900 overflow-hidden -mt-20">
    <!-- Animated Background Particles -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full blur-xl animate-float"></div>
        <div class="absolute top-40 right-20 w-20 h-20 bg-blue-300/20 rounded-full blur-lg animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-40 left-20 w-24 h-24 bg-purple-300/20 rounded-full blur-lg animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute bottom-20 right-40 w-16 h-16 bg-pink-300/20 rounded-full blur-lg animate-float" style="animation-delay: 0.5s;"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center min-h-screen">
            
            <!-- Left Content -->
            <div class="text-white space-y-8">
                <div class="space-y-6">
                    <h1 class="text-5xl lg:text-7xl font-black leading-tight">
                        It's our <span class="gradient-text text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-purple-400">mission</span>
                        <br>to make people's
                        <br><span class="gradient-text text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-yellow-400">lives easier.</span>
                    </h1>
                    
                    <p class="text-xl lg:text-2xl text-gray-300 font-light max-w-lg">
                        Let's get started with yours.
                    </p>
                </div>

                @guest
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" 
                           class="group relative px-8 py-4 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-2xl font-bold text-lg text-white overflow-hidden transition-all duration-300 transform hover:scale-105 animate-pulse-glow">
                            <span class="relative z-10 flex items-center justify-center">
                                <i class="fas fa-rocket mr-3"></i>
                                Get Started
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-pink-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        </a>
                        
                        <a href="{{ route('login') }}" 
                           class="px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl font-bold text-lg text-white hover:bg-white/20 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-3"></i>
                            Sign In
                        </a>
                    </div>
                @else
                    <a href="{{ route('dashboard') }}" 
                       class="inline-block px-8 py-4 bg-gradient-to-r from-green-500 to-blue-600 rounded-2xl font-bold text-lg text-white transition-all duration-300 transform hover:scale-105 animate-pulse-glow">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Go to Dashboard
                    </a>
                @endguest

                <!-- Feature Points -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-12">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <span class="text-gray-300">24/7 Support</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-purple-400 to-pink-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-bolt text-white text-sm"></i>
                        </div>
                        <span class="text-gray-300">Fast Response</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-yellow-400 to-orange-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-shield-alt text-white text-sm"></i>
                        </div>
                        <span class="text-gray-300">Secure Platform</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-white text-sm"></i>
                        </div>
                        <span class="text-gray-300">Expert Team</span>
                    </div>
                </div>
            </div>

            <!-- Right Animated Illustration -->
            <div class="relative lg:pl-12">
                <div class="relative animate-float">
                    <!-- Laptop with Screen -->
                    <div class="relative w-full max-w-md mx-auto">
                        <!-- Laptop Base -->
                        <div class="relative bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-6 shadow-2xl transform rotate-6 hover:rotate-3 transition-transform duration-500">
                            <!-- Screen -->
                            <div class="bg-gradient-to-br from-blue-900 to-purple-900 rounded-xl p-4 mb-4 relative overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-cyan-500/20 to-purple-500/20 animate-pulse"></div>
                                
                                <!-- Screen Content -->
                                <div class="relative z-10 space-y-2">
                                    <div class="flex items-center space-x-2 mb-3">
                                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    </div>
                                    
                                    <div class="text-white text-xs font-mono">
                                        <div class="text-cyan-400">> FixIT Terminal</div>
                                        <div class="text-green-400 animate-pulse">$ Initializing maintenance...</div>
                                        <div class="text-purple-400">✓ System Ready</div>
                                        <div class="text-pink-400">✓ Connected to Support</div>
                                        <div class="text-yellow-400 animate-bounce-slow">⚡ Processing requests...</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Keyboard -->
                            <div class="grid grid-cols-12 gap-1">
                                <div class="col-span-12 h-2 bg-gray-700 rounded mb-1"></div>
                                <div class="h-1 bg-gray-600 rounded"></div>
                                <div class="h-1 bg-gray-600 rounded"></div>
                                <div class="h-1 bg-gray-600 rounded"></div>
                                <div class="col-span-6 h-1 bg-gray-600 rounded"></div>
                                <div class="h-1 bg-gray-600 rounded"></div>
                                <div class="h-1 bg-gray-600 rounded"></div>
                                <div class="h-1 bg-gray-600 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Rocket -->
                <div class="absolute -top-12 -right-8 animate-rocket">
                    <div class="relative">
                        <div class="w-20 h-20 bg-gradient-to-br from-orange-400 to-red-500 rounded-full flex items-center justify-center shadow-xl">
                            <i class="fas fa-rocket text-white text-2xl transform rotate-45"></i>
                        </div>
                        
                        <!-- Rocket Trail -->
                        <div class="absolute -bottom-4 -left-2 w-6 h-6 bg-gradient-to-r from-orange-300 to-transparent rounded-full blur-sm animate-pulse"></div>
                        <div class="absolute -bottom-6 -left-1 w-4 h-4 bg-gradient-to-r from-red-300 to-transparent rounded-full blur-sm animate-pulse" style="animation-delay: 0.2s;"></div>
                    </div>
                </div>

                <!-- Floating Icons -->
                <div class="absolute top-20 -left-8 animate-float" style="animation-delay: 1s;">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-blue-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-tools text-white text-xl"></i>
                    </div>
                </div>
                
                <div class="absolute bottom-32 -left-12 animate-float" style="animation-delay: 2s;">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-cog text-white"></i>
                    </div>
                </div>

                <div class="absolute top-32 right-4 animate-float" style="animation-delay: 0.5s;">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-2xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-lightbulb text-white"></i>
                    </div>
                </div>

                <!-- Progress Indicators -->
                <div class="absolute bottom-8 right-8 space-y-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-white/70 text-sm">Online</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 0.3s;"></div>
                        <span class="text-white/70 text-sm">Processing</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <div class="w-6 h-10 border-2 border-white/50 rounded-full p-1">
            <div class="w-1 h-3 bg-white rounded-full mx-auto animate-bounce"></div>
        </div>
    </div>
</div>

<!-- Dynamic Stats Section -->
<div class="py-20 bg-gradient-to-r from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-black gradient-text mb-4">Trusted by Thousands</h2>
            <p class="text-xl text-gray-600">See why businesses choose FixIT for their maintenance needs</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="glass-effect rounded-2xl p-8 text-center card-hover">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clipboard-list text-2xl text-white"></i>
                </div>
                <div class="text-4xl font-black gradient-text mb-2 counter" data-count="{{ $stats['total_requests'] }}">0</div>
                <div class="text-gray-600 font-medium">Total Requests</div>
                <div class="w-16 h-1 bg-gradient-to-r from-blue-500 to-purple-600 rounded mx-auto mt-3"></div>
            </div>
            
            <div class="glass-effect rounded-2xl p-8 text-center card-hover">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-2xl text-white"></i>
                </div>
                <div class="text-4xl font-black gradient-text mb-2 counter" data-count="{{ $stats['completed_requests'] }}">0</div>
                <div class="text-gray-600 font-medium">Completed</div>
                <div class="w-16 h-1 bg-gradient-to-r from-green-500 to-cyan-600 rounded mx-auto mt-3"></div>
            </div>
            
            <div class="glass-effect rounded-2xl p-8 text-center card-hover">
                <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-2xl text-white"></i>
                </div>
                <div class="text-4xl font-black gradient-text mb-2 counter" data-count="{{ $stats['pending_requests'] }}">0</div>
                <div class="text-gray-600 font-medium">Pending</div>
                <div class="w-16 h-1 bg-gradient-to-r from-yellow-500 to-orange-600 rounded mx-auto mt-3"></div>
            </div>
            
            <div class="glass-effect rounded-2xl p-8 text-center card-hover">
                <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-cogs text-2xl text-white"></i>
                </div>
                <div class="text-4xl font-black gradient-text mb-2 counter" data-count="{{ $stats['in_progress_requests'] }}">0</div>
                <div class="text-gray-600 font-medium">In Progress</div>
                <div class="w-16 h-1 bg-gradient-to-r from-red-500 to-pink-600 rounded mx-auto mt-3"></div>
            </div>
        </div>
    </div>
</div>

<!-- Services Section -->
<div class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-black gradient-text mb-6">Our Services</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">Professional maintenance solutions with cutting-edge technology and expert support</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- IT Support -->
            <div class="group relative bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl p-8 card-hover overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-200/30 rounded-full blur-2xl transform translate-x-8 -translate-y-8"></div>
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-laptop-code text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">IT Support</h3>
                    <p class="text-gray-700 mb-6 leading-relaxed">Complete computer repairs, network setup, software installation, and technical support services.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            Hardware Diagnostics & Repair
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            Network Configuration
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            Software Solutions
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Electrical Services -->
            <div class="group relative bg-gradient-to-br from-yellow-50 to-orange-100 rounded-3xl p-8 card-hover overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-200/30 rounded-full blur-2xl transform translate-x-8 -translate-y-8"></div>
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-bolt text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Electrical</h3>
                    <p class="text-gray-700 mb-6 leading-relaxed">Licensed electricians for all electrical installations, repairs, and safety inspections.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-orange-500 rounded-full mr-3"></div>
                            Wiring & Installation
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-orange-500 rounded-full mr-3"></div>
                            Safety Inspections
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-orange-500 rounded-full mr-3"></div>
                            Emergency Repairs
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Plumbing -->
            <div class="group relative bg-gradient-to-br from-cyan-50 to-blue-100 rounded-3xl p-8 card-hover overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-200/30 rounded-full blur-2xl transform translate-x-8 -translate-y-8"></div>
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-wrench text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Plumbing</h3>
                    <p class="text-gray-700 mb-6 leading-relaxed">Professional plumbers for pipes, fixtures, drainage, and emergency plumbing services.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-cyan-500 rounded-full mr-3"></div>
                            Pipe Installation & Repair
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-cyan-500 rounded-full mr-3"></div>
                            Leak Detection
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-cyan-500 rounded-full mr-3"></div>
                            24/7 Emergency Service
                        </li>
                    </ul>
                </div>
            </div>

            <!-- HVAC -->
            <div class="group relative bg-gradient-to-br from-green-50 to-emerald-100 rounded-3xl p-8 card-hover overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-green-200/30 rounded-full blur-2xl transform translate-x-8 -translate-y-8"></div>
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-fan text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">HVAC</h3>
                    <p class="text-gray-700 mb-6 leading-relaxed">Heating, ventilation, and air conditioning systems maintenance and repair services.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            System Maintenance
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            Installation & Upgrade
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            Energy Efficiency
                        </li>
                    </ul>
                </div>
            </div>

            <!-- General Repairs -->
            <div class="group relative bg-gradient-to-br from-purple-50 to-pink-100 rounded-3xl p-8 card-hover overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-200/30 rounded-full blur-2xl transform translate-x-8 -translate-y-8"></div>
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-hammer text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">General Repairs</h3>
                    <p class="text-gray-700 mb-6 leading-relaxed">Comprehensive building maintenance, carpentry, painting, and general repair services.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                            Carpentry & Woodwork
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                            Painting & Finishing
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                            General Maintenance
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Emergency Services -->
            <div class="group relative bg-gradient-to-br from-red-50 to-orange-100 rounded-3xl p-8 card-hover overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-red-200/30 rounded-full blur-2xl transform translate-x-8 -translate-y-8"></div>
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-exclamation-triangle text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Emergency</h3>
                    <p class="text-gray-700 mb-6 leading-relaxed">24/7 emergency response for urgent maintenance issues and critical system failures.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                            24/7 Availability
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                            Rapid Response
                        </li>
                        <li class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-red-500 rounded-full mr-3"></div>
                            Critical Repairs
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Key Features Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Easy Request Submission -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-lg transition duration-300">
            <div class="flex justify-center mb-6">
                <div class="bg-blue-50 w-20 h-20 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m-6 4h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Easy Request Submission</h3>
            <p class="text-gray-600 text-center leading-relaxed">Submit maintenance requests with just a few clicks. Add photos, descriptions, and priority levels.</p>
        </div>

        <!-- Real-time Tracking -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-lg transition duration-300">
            <div class="flex justify-center mb-6">
                <div class="bg-green-50 w-20 h-20 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">Real-time Tracking</h3>
            <p class="text-gray-600 text-center leading-relaxed">Track the progress of your requests in real-time. Get notifications when status changes.</p>
        </div>

        <!-- AI-Powered Categorization -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-lg transition duration-300">
            <div class="flex justify-center mb-6">
                <div class="bg-purple-50 w-20 h-20 rounded-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3 text-center">AI-Powered Categorization</h3>
            <p class="text-gray-600 text-center leading-relaxed">Our AI automatically categorizes your requests for faster assignment to the right technicians.</p>
        </div>
    </div>

</div>

<!-- Enhanced JavaScript for Animations -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter Animation
    function animateCounters() {
        const counters = document.querySelectorAll('.counter');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-count'));
                    let current = 0;
                    const increment = target / 60; // Animation duration control
                    
                    const updateCounter = () => {
                        if (current < target) {
                            current += increment;
                            counter.textContent = Math.floor(current);
                            requestAnimationFrame(updateCounter);
                        } else {
                            counter.textContent = target;
                        }
                    };
                    
                    updateCounter();
                    observer.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });
        
        counters.forEach(counter => observer.observe(counter));
    }
    
    // Initialize counter animations
    animateCounters();
    
    // Parallax effect for floating elements
    let ticking = false;
    
    function updateParallax() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.animate-float');
        const rate = scrolled * -0.5;
        
        parallaxElements.forEach((element, index) => {
            const offset = rate * (index + 1) * 0.1;
            element.style.transform = `translateY(${offset}px)`;
        });
        
        ticking = false;
    }
    
    function requestTick() {
        if (!ticking) {
            requestAnimationFrame(updateParallax);
            ticking = true;
        }
    }
    
    window.addEventListener('scroll', requestTick);
    
    // Service cards hover effect
    const serviceCards = document.querySelectorAll('.card-hover');
    serviceCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-15px) scale(1.03)';
            this.style.boxShadow = '0 25px 50px rgba(0, 0, 0, 0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.1)';
        });
    });
    
    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Dynamic typing effect for terminal text
    const terminalLines = [
        { text: '$ Initializing maintenance...', delay: 1000 },
        { text: '✓ System Ready', delay: 2000 },
        { text: '✓ Connected to Support', delay: 3000 },
        { text: '⚡ Processing requests...', delay: 4000 }
    ];
    
    let currentLine = 0;
    const terminalElement = document.querySelector('.text-green-400');
    
    function typeText() {
        if (currentLine < terminalLines.length && terminalElement) {
            setTimeout(() => {
                terminalElement.textContent = terminalLines[currentLine].text;
                currentLine++;
                typeText();
            }, terminalLines[currentLine]?.delay || 1000);
        } else {
            // Reset and loop
            currentLine = 0;
            setTimeout(typeText, 2000);
        }
    }
    
    // Start typing effect
    setTimeout(typeText, 2000);
    
    // Add intersection observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const animationObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all service cards for scroll animations
    document.querySelectorAll('.card-hover').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease-out';
        animationObserver.observe(card);
    });
    
    // Add mouse movement effect to hero section
    const hero = document.querySelector('.min-h-screen');
    if (hero) {
        hero.addEventListener('mousemove', (e) => {
            const { clientX, clientY } = e;
            const { innerWidth, innerHeight } = window;
            
            const xPos = (clientX / innerWidth - 0.5) * 20;
            const yPos = (clientY / innerHeight - 0.5) * 20;
            
            const floatingElements = hero.querySelectorAll('.animate-float');
            floatingElements.forEach((element, index) => {
                const multiplier = (index + 1) * 0.5;
                element.style.transform = `translateX(${xPos * multiplier}px) translateY(${yPos * multiplier}px)`;
            });
        });
        
        hero.addEventListener('mouseleave', () => {
            const floatingElements = hero.querySelectorAll('.animate-float');
            floatingElements.forEach(element => {
                element.style.transform = 'translateX(0) translateY(0)';
            });
        });
    }
    
    // Performance optimization: Throttle scroll events
    let scrollTimeout;
    window.addEventListener('scroll', () => {
        if (scrollTimeout) {
            clearTimeout(scrollTimeout);
        }
        scrollTimeout = setTimeout(() => {
            // Update navigation background on scroll
            const nav = document.querySelector('nav');
            if (nav) {
                if (window.scrollY > 100) {
                    nav.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                    nav.style.backdropFilter = 'blur(20px)';
                } else {
                    nav.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
                    nav.style.backdropFilter = 'blur(10px)';
                }
            }
        }, 10);
    });
});

// Preload animations for better performance
function preloadAnimations() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }
    `;
    document.head.appendChild(style);
}

preloadAnimations();
</script>

@endsection