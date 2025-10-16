<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FixIT') }} - @yield('title', 'Repair and E-commerce Services')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Enhanced Styles -->
        <style>
            :root {
                --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
                --purple-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            }
            
            .gradient-text {
                background: var(--primary-gradient);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
            
            .glass-effect {
                background: rgba(255, 255, 255, 0.25);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.18);
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                33% { transform: translateY(-20px) rotate(2deg); }
                66% { transform: translateY(10px) rotate(-2deg); }
            }
            
            @keyframes rocket-fly {
                0% { transform: translateY(0px) translateX(0px) rotate(0deg); }
                25% { transform: translateY(-15px) translateX(5px) rotate(5deg); }
                50% { transform: translateY(-10px) translateX(-5px) rotate(-3deg); }
                75% { transform: translateY(-20px) translateX(3px) rotate(2deg); }
                100% { transform: translateY(0px) translateX(0px) rotate(0deg); }
            }
            
            @keyframes pulse-glow {
                0%, 100% { box-shadow: 0 0 20px rgba(102, 126, 234, 0.3); }
                50% { box-shadow: 0 0 40px rgba(102, 126, 234, 0.6), 0 0 60px rgba(118, 75, 162, 0.4); }
            }
            
            .animate-float { animation: float 6s ease-in-out infinite; }
            .animate-rocket { animation: rocket-fly 4s ease-in-out infinite; }
            .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
            
            .animate-bounce-slow {
                animation: bounce 3s infinite;
            }
            
            .card-hover {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }
            
            .card-hover:hover {
                transform: translateY(-10px) scale(1.02);
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            }
        </style>
        
        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            @endif

            <!-- Page Content -->
            <main class="py-6">
                @yield('content')
                {{ $slot ?? '' }}
            </main>

            <!-- Modern Footer -->  
            <footer class="mt-16" style="padding:50px ;background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 30%, #312e81 70%, #1e1b4b 100%);">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
                        <!-- Company Info -->
                        <div class="space-y-6">
                            <h3 class="text-3xl font-bold bg-gradient-to-r from-cyan-400 via-blue-300 to-purple-400 bg-clip-text text-transparent">
                                FixIT
                            </h3>
                            <p class="text-blue-100 text-sm leading-relaxed">
                                Your trusted partner for maintenance and repair services. Fast, reliable, and professional solutions for all your needs.
                            </p>
                            <div class="flex space-x-3">
                                <a href="#" class="w-11 h-11 bg-gray-900 hover:bg-blue-600 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg">
                                    <i class="fab fa-facebook-f text-white text-sm"></i>
                                </a>
                                <a href="#" class="w-11 h-11 bg-gray-900 hover:bg-sky-500 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg">
                                    <i class="fab fa-twitter text-white text-sm"></i>
                                </a>
                                <a href="#" class="w-11 h-11 bg-gray-900 hover:bg-gradient-to-br hover:from-purple-600 hover:to-pink-600 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg">
                                    <i class="fab fa-instagram text-white text-sm"></i>
                                </a>
                                <a href="#" class="w-11 h-11 bg-gray-900 hover:bg-blue-700 rounded-full flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg">
                                    <i class="fab fa-linkedin-in text-white text-sm"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div>
                            <h4 class="text-lg font-bold mb-6 text-blue-100">Quick Links</h4>
                            <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('home') }}" class="text-blue-200 hover:text-cyan-300 hover:pl-2 transition-all duration-300 flex items-center group">
                                        <i class="fas fa-home w-4 mr-3 text-blue-300 group-hover:text-cyan-300"></i> Home
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard') }}" class="text-blue-200 hover:text-cyan-300 hover:pl-2 transition-all duration-300 flex items-center group">
                                        <i class="fas fa-tachometer-alt w-4 mr-3 text-blue-300 group-hover:text-cyan-300"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('requests.create') }}" class="text-blue-200 hover:text-cyan-300 hover:pl-2 transition-all duration-300 flex items-center group">
                                        <i class="fas fa-plus-circle w-4 mr-3 text-blue-300 group-hover:text-cyan-300"></i> New Request
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('blogs.index') }}" class="text-blue-200 hover:text-cyan-300 hover:pl-2 transition-all duration-300 flex items-center group">
                                        <i class="fas fa-blog w-4 mr-3 text-blue-300 group-hover:text-cyan-300"></i> Blog
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('shop.index') }}" class="text-blue-200 hover:text-cyan-300 hover:pl-2 transition-all duration-300 flex items-center group">
                                        <i class="fas fa-shopping-bag w-4 mr-3 text-blue-300 group-hover:text-cyan-300"></i> Shop
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Services -->
                        <div>
                            <h4 class="text-lg font-bold mb-6 text-blue-100">Services</h4>
                            <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('requests.my') }}" class="text-blue-200 hover:text-cyan-300 hover:pl-2 transition-all duration-300 flex items-center group">
                                        <i class="fas fa-list-alt w-4 mr-3 text-blue-300 group-hover:text-cyan-300"></i> My Requests
                                    </a>
                                </li>
                                @if(auth()->check() && auth()->user()->isTechnician())
                                <li>
                                    <a href="{{ route('requests.assigned') }}" class="text-blue-200 hover:text-cyan-300 hover:pl-2 transition-all duration-300 flex items-center group">
                                        <i class="fas fa-tasks w-4 mr-3 text-blue-300 group-hover:text-cyan-300"></i> Assigned Tasks
                                    </a>
                                </li>
                                @endif
                                @if(auth()->check() && auth()->user()->isAdmin())
                                <li>
                                    <a href="{{ route('admin.dashboard') }}" class="text-blue-200 hover:text-cyan-300 hover:pl-2 transition-all duration-300 flex items-center group">
                                        <i class="fas fa-user-shield w-4 mr-3 text-blue-300 group-hover:text-cyan-300"></i> Admin Panel
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ route('cart.index') }}" class="text-blue-200 hover:text-cyan-300 hover:pl-2 transition-all duration-300 flex items-center group">
                                        <i class="fas fa-shopping-cart w-4 mr-3 text-blue-300 group-hover:text-cyan-300"></i> Cart
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="text-blue-200 hover:text-cyan-300 hover:pl-2 transition-all duration-300 flex items-center group">
                                        <i class="fas fa-user-cog w-4 mr-3 text-blue-300 group-hover:text-cyan-300"></i> Profile Settings
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Contact Info -->
                        <div>
                            <h4 class="text-lg font-bold mb-6 text-blue-100">Get In Touch</h4>
                            <ul class="space-y-4">
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 w-5 h-5 mt-0.5">
                                        <i class="fas fa-map-marker-alt text-blue-300"></i>
                                    </div>
                                    <span class="text-sm text-blue-200 ml-3 leading-relaxed">123 Maintenance Street<br>Repair City, RC 12345</span>
                                </li>
                                <li class="flex items-center">
                                    <div class="flex-shrink-0 w-5 h-5">
                                        <i class="fas fa-phone-alt text-green-400"></i>
                                    </div>
                                    <a href="tel:+1234567890" class="text-sm text-blue-200 hover:text-green-300 transition ml-3">+1 (234) 567-890</a>
                                </li>
                                <li class="flex items-center">
                                    <div class="flex-shrink-0 w-5 h-5">
                                        <i class="fas fa-envelope text-purple-400"></i>
                                    </div>
                                    <a href="mailto:support@fixit.com" class="text-sm text-blue-200 hover:text-purple-300 transition ml-3">support@fixit.com</a>
                                </li>
                                <li class="flex items-center">
                                    <div class="flex-shrink-0 w-5 h-5">
                                        <i class="fas fa-clock text-yellow-400"></i>
                                    </div>
                                    <span class="text-sm text-blue-200 ml-3">24/7 Support Available</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Bottom Bar -->
                    <div class="border-t border-blue-400/30 pt-8">
                        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                            <div class="text-blue-200 text-sm">
                                © {{ date('Y') }} <span class="text-blue-100 font-bold">FixIT</span>. All rights reserved.
                            </div>
                            <div class="flex space-x-6 text-sm">
                                <a href="#" class="text-blue-200 hover:text-cyan-300 transition duration-300">Privacy Policy</a>
                                <a href="#" class="text-blue-200 hover:text-cyan-300 transition duration-300">Terms of Service</a>
                                <a href="#" class="text-blue-200 hover:text-cyan-300 transition duration-300">Cookie Policy</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scroll to Top Button -->
                <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                        class="fixed bottom-8 right-8 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white w-14 h-14 rounded-full shadow-xl hover:shadow-2xl transform hover:scale-110 hover:rotate-12 transition-all duration-300 flex items-center justify-center z-50"
                        id="scrollToTop"
                        style="display: none;">
                    <i class="fas fa-arrow-up text-lg"></i>
                </button>
            </footer>

            <script>
                // Show/Hide Scroll to Top button
                window.addEventListener('scroll', function() {
                    const scrollButton = document.getElementById('scrollToTop');
                    if (scrollButton) {
                        if (window.pageYOffset > 300) {
                            scrollButton.style.display = 'flex';
                        } else {
                            scrollButton.style.display = 'none';
                        }
                    }
                });
            </script>
        </div>

        @stack('scripts')
    </body>
</html>
