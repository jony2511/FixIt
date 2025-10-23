@extends('layouts.app')

@section('title', 'Welcome to FixIT - Repair and E-Commeerce Services')

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
<div id="services" class="py-20 bg-gradient-to-r from-green-100 to-blue-500">
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

        <!-- Key Features Section Inside Services -->
        <div class="mt-20">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-black gradient-text mb-4">Platform Features</h3>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">Experience the power of our modern maintenance management platform</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Easy Request Submission -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex justify-center mb-6">
                        <div class="bg-blue-50 w-20 h-20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m-6 4h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3 text-center">Easy Request Submission</h4>
                    <p class="text-gray-600 text-center leading-relaxed">Submit maintenance requests with just a few clicks. Add photos, descriptions, and priority levels.</p>
                    
                    <!-- Feature List -->
                    <div class="mt-6 space-y-2">
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            Photo & File Upload
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            Priority Level Selection
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                            Instant Confirmation
                        </div>
                    </div>
                </div>

                <!-- Real-time Tracking -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex justify-center mb-6">
                        <div class="bg-green-50 w-20 h-20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3 text-center">Real-time Tracking</h4>
                    <p class="text-gray-600 text-center leading-relaxed">Track the progress of your requests in real-time. Get notifications when status changes.</p>
                    
                    <!-- Feature List -->
                    <div class="mt-6 space-y-2">
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            Live Status Updates
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            Push Notifications
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-3"></div>
                            Progress Timeline
                        </div>
                    </div>
                </div>

                <!-- AI-Powered Categorization -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="flex justify-center mb-6">
                        <div class="bg-purple-50 w-20 h-20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <h4 class="text-xl font-bold text-gray-900 mb-3 text-center">AI-Powered Categorization</h4>
                    <p class="text-gray-600 text-center leading-relaxed">Our AI automatically categorizes your requests for faster assignment to the right technicians.</p>
                    
                    <!-- Feature List -->
                    <div class="mt-6 space-y-2">
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                            Smart Classification
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                            Auto-Assignment
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mr-3"></div>
                            Faster Resolution
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Client Testimonials Section -->
<div id="testimonials" class="relative py-24 bg-gray-900 overflow-hidden" style="background: linear-gradient(135deg, #1a202c 0%, #2d3748 30%, #1a202c 70%, #000000 100%);">
    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/40"></div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-10 left-10 w-72 h-72 bg-blue-500/30 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-purple-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-cyan-500/30 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-16 relative z-20">
            <div class="inline-flex items-center px-6 py-3 bg-white/25 backdrop-blur-sm rounded-full text-white border border-white/40 text-sm font-semibold mb-6 shadow-2xl">
                <i class="fas fa-quote-left mr-2 text-cyan-300"></i>
                Client Testimonials
            </div>
            <h2 class="text-5xl lg:text-6xl font-black mb-6" style="color: #ffffff; text-shadow: 2px 2px 8px rgba(0,0,0,0.8);">
                What Our <span style="background: linear-gradient(135deg, #00d4ff 0%, #5b21b6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: none;">Clients</span>
                <br>Say About Us
            </h2>
            <p class="text-xl max-w-3xl mx-auto leading-relaxed" style="color: #e2e8f0; text-shadow: 1px 1px 4px rgba(0,0,0,0.8);">
                Don't just take our word for it – hear from businesses that have transformed their maintenance operations with FixIT
            </p>
        </div>

        @if($testimonials->count() > 0)
            <!-- Testimonials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-20">
                @foreach($testimonials as $testimonial)
                    <div class="group relative">
                        <!-- Card -->
                        <div class="h-full rounded-3xl p-8 shadow-2xl transform transition-all duration-300 group-hover:scale-105 group-hover:-translate-y-2" 
                             style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.3);">
                            
                            <!-- Quote Icon -->
                            <div class="mb-6">
                                <i class="fas fa-quote-left text-4xl text-cyan-400 opacity-50"></i>
                            </div>

                            <!-- Testimonial Text -->
                            <p class="text-lg leading-relaxed mb-8 min-h-[120px]" style="color: #e2e8f0; text-shadow: 1px 1px 3px rgba(0,0,0,0.7);">
                                "{{ $testimonial->testimonial_text }}"
                            </p>

                            <!-- Client Info -->
                            <div class="flex items-center space-x-4 mt-auto">
                                <!-- Client Photo -->
                                @if($testimonial->client_photo)
                                    <img src="{{ asset('storage/' . $testimonial->client_photo) }}" 
                                         alt="{{ $testimonial->client_name }}" 
                                         class="w-16 h-16 rounded-full object-cover border-2 border-white/30 shadow-xl">
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-purple-600 rounded-full flex items-center justify-center border-2 border-white/30 shadow-xl">
                                        <span class="text-white font-bold text-2xl">{{ substr($testimonial->client_name, 0, 1) }}</span>
                                    </div>
                                @endif

                                <!-- Client Details -->
                                <div>
                                    <div class="font-bold text-lg" style="color: #ffffff; text-shadow: 1px 1px 3px rgba(0,0,0,0.8);">
                                        {{ $testimonial->client_name }}
                                    </div>
                                    <div class="text-sm" style="color: #cbd5e1; text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">
                                        {{ $testimonial->client_position }}
                                    </div>
                                </div>
                            </div>

                            <!-- Star Rating -->
                            <div class="flex space-x-1 mt-4">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                                @endfor
                            </div>
                        </div>

                        <!-- Glow Effect on Hover -->
                        <div class="absolute inset-0 rounded-3xl bg-gradient-to-r from-cyan-500/30 to-purple-600/30 blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 -z-10"></div>
                    </div>
                @endforeach
            </div>

            <!-- Learn More Button -->
            <div class="text-center mt-16">
                <a href="{{ route('about') }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-cyan-500 to-purple-600 rounded-2xl font-bold text-lg text-white shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-info-circle mr-3"></i>
                    Learn More About Us
                    <i class="fas fa-arrow-right ml-3"></i>
                </a>
            </div>
        @else
            <!-- No Testimonials Message -->
            <div class="text-center py-16">
                <i class="fas fa-quote-left text-white/20 text-6xl mb-6"></i>
                <p class="text-xl text-white/60">Testimonials coming soon...</p>
            </div>
        @endif
    </div>
</div>

<!-- Contact Us Section -->
<div id="contact" class="relative py-24 overflow-hidden" style="background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 30%, #312e81 70%, #1e1b4b 100%);">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-full h-full">
            <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="contact-pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="currentColor" opacity="0.3"/>
                        <circle cx="12" cy="12" r="1" fill="currentColor" opacity="0.3"/>
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#contact-pattern)" />
            </svg>
        </div>
    </div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-20 right-20 w-64 h-64 bg-white/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 left-20 w-48 h-48 bg-white/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            
            <!-- Left Side - Contact Information -->
            <div class="text-white space-y-8">
                <div class="space-y-6">
                    <h2 class="text-4xl lg:text-5xl font-black leading-tight">
                        CONTACT US
                    </h2>
                    <p class="text-xl text-blue-100 leading-relaxed">
                        We're here to help you!
                    </p>
                </div>

                <!-- Contact Details -->
                <div class="space-y-6">
                    <!-- Phone -->
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/20">
                            <i class="fas fa-phone text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-white">Phone</h4>
                            <p class="text-blue-200">+123-456-7890</p>
                        </div>
                    </div>

                    <!-- Website -->
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/20">
                            <i class="fas fa-globe text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-white">Website</h4>
                            <p class="text-blue-200">www.fixit.com</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/20">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-white">E-Mail</h4>
                            <p class="text-blue-200">hello@fixit.com</p>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-full flex items-center justify-center border border-white/20">
                            <i class="fas fa-map-marker-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-white">Address</h4>
                            <p class="text-blue-200">123 Anywhere St., Any City</p>
                        </div>
                    </div>
                </div>

                <!-- Features -->
                <div class="mt-12 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-blue-300 rounded-full"></div>
                        <span class="text-blue-100">Quick Response Time</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-blue-300 rounded-full"></div>
                        <span class="text-blue-100">24/7 Support Available</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-2 h-2 bg-blue-300 rounded-full"></div>
                        <span class="text-blue-100">Professional Service</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Contact Form -->
            <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20 shadow-2xl">
                <form id="contactForm" class="space-y-6">
                    @csrf
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-semibold text-white mb-2">Full Name :</label>
                        <input type="text" 
                               id="full_name" 
                               name="full_name" 
                               required
                               class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm transition-all duration-300"
                               placeholder="Enter your full name">
                        <span class="error-message text-red-300 text-sm hidden"></span>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-white mb-2">E-Mail :</label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm transition-all duration-300"
                               placeholder="Enter your email address">
                        <span class="error-message text-red-300 text-sm hidden"></span>
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-white mb-2">Phone Number :</label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm transition-all duration-300"
                               placeholder="Enter your phone number (optional)">
                        <span class="error-message text-red-300 text-sm hidden"></span>
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-semibold text-white mb-2">Message :</label>
                        <textarea id="message" 
                                  name="message" 
                                  rows="5" 
                                  required
                                  class="w-full px-4 py-3 bg-white/10 border border-white/30 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm transition-all duration-300 resize-none"
                                  placeholder="Enter your message here..."></textarea>
                        <span class="error-message text-red-300 text-sm hidden"></span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="submitBtn"
                            class="w-full bg-white text-blue-700 font-bold py-4 px-8 rounded-xl hover:bg-blue-50 focus:outline-none focus:ring-4 focus:ring-white/30 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <span class="submit-text">Send Messages</span>
                        <div class="loading-spinner hidden inline-block ml-2">
                            <div class="animate-spin rounded-full h-4 w-4 border-2 border-blue-700 border-t-transparent"></div>
                        </div>
                    </button>
                </form>

                <!-- Success/Error Messages -->
                <div id="alertMessage" class="mt-4 hidden">
                    <div class="p-4 rounded-xl backdrop-blur-sm border">
                        <p class="font-medium"></p>
                    </div>
                </div>
            </div>
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

// Contact Form Handling
document.getElementById('contactForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const submitText = submitBtn.querySelector('.submit-text');
    const loadingSpinner = submitBtn.querySelector('.loading-spinner');
    const alertMessage = document.getElementById('alertMessage');
    
    // Clear previous errors
    document.querySelectorAll('.error-message').forEach(el => {
        el.classList.add('hidden');
        el.textContent = '';
    });
    
    // Show loading state
    submitBtn.disabled = true;
    submitText.textContent = 'Sending...';
    loadingSpinner.classList.remove('hidden');
    alertMessage.classList.add('hidden');
    
    // Collect form data
    const formData = new FormData();
    formData.append('full_name', document.getElementById('full_name').value);
    formData.append('email', document.getElementById('email').value);
    formData.append('phone', document.getElementById('phone').value);
    formData.append('message', document.getElementById('message').value);
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    
    try {
        const response = await fetch('/contact', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Success message
            alertMessage.className = 'mt-4 block';
            alertMessage.innerHTML = `
                <div class="p-4 rounded-xl backdrop-blur-sm border border-green-300/30 bg-green-500/20">
                    <p class="font-medium text-green-100"><i class="fas fa-check-circle mr-2"></i>${result.message}</p>
                </div>
            `;
            
            // Reset form
            document.getElementById('contactForm').reset();
            
        } else {
            // Handle validation errors
            if (result.errors) {
                Object.keys(result.errors).forEach(field => {
                    const errorElement = document.querySelector(`input[name="${field}"], textarea[name="${field}"]`).nextElementSibling;
                    errorElement.textContent = result.errors[field][0];
                    errorElement.classList.remove('hidden');
                });
            }
            
            // Show error message
            alertMessage.className = 'mt-4 block';
            alertMessage.innerHTML = `
                <div class="p-4 rounded-xl backdrop-blur-sm border border-red-300/30 bg-red-500/20">
                    <p class="font-medium text-red-100"><i class="fas fa-exclamation-triangle mr-2"></i>${result.message || 'Please fix the errors above.'}</p>
                </div>
            `;
        }
        
    } catch (error) {
        console.error('Contact form error:', error);
        
        // Show error message
        alertMessage.className = 'mt-4 block';
        alertMessage.innerHTML = `
            <div class="p-4 rounded-xl backdrop-blur-sm border border-red-300/30 bg-red-500/20">
                <p class="font-medium text-red-100"><i class="fas fa-exclamation-triangle mr-2"></i>Something went wrong. Please try again later.</p>
            </div>
        `;
    } finally {
        // Reset button state
        submitBtn.disabled = false;
        submitText.textContent = 'Send Messages';
        loadingSpinner.classList.add('hidden');
        
        // Auto-hide success/error message after 5 seconds
        setTimeout(() => {
            alertMessage.classList.add('hidden');
        }, 5000);
    }
});

// Form field animations
document.querySelectorAll('#contactForm input, #contactForm textarea').forEach(field => {
    field.addEventListener('focus', function() {
        this.parentElement.classList.add('field-focused');
        this.style.transform = 'scale(1.02)';
        this.style.boxShadow = '0 8px 25px rgba(255, 255, 255, 0.15)';
    });
    
    field.addEventListener('blur', function() {
        this.parentElement.classList.remove('field-focused');
        this.style.transform = 'scale(1)';
        this.style.boxShadow = 'none';
    });
    
    // Add smooth transitions
    field.style.transition = 'all 0.3s ease';
});

// Add floating label effect
document.querySelectorAll('#contactForm input, #contactForm textarea').forEach(field => {
    const label = field.previousElementSibling;
    
    field.addEventListener('focus', function() {
        if (label && label.tagName === 'LABEL') {
            label.style.transform = 'translateY(-8px) scale(0.9)';
            label.style.color = '#ffffff';
        }
    });
    
    field.addEventListener('blur', function() {
        if (label && label.tagName === 'LABEL' && !this.value) {
            label.style.transform = 'translateY(0) scale(1)';
            label.style.color = '#cbd5e1';
        }
    });
    
    // Set initial state for fields with values
    if (field.value && label && label.tagName === 'LABEL') {
        label.style.transform = 'translateY(-8px) scale(0.9)';
        label.style.color = '#ffffff';
    }
});
</script>

@endsection