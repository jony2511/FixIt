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
              <!-- Footer -->
           @include('components.footer')

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
