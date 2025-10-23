<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - FixIT Solutions</title>
    <link rel="icon" type="image/png" href="{{ asset('images/image1.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient 3s ease infinite;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <img src="{{ asset('images/image1.png') }}" alt="FixIT" class="h-10 w-auto">
                        <span class="ml-3 text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">FixIT</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Shop</a>
                    <a href="{{ route('blogs.index') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Blog</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:from-blue-700 hover:to-purple-700">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:from-blue-700 hover:to-purple-700">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-20 left-20 w-96 h-96 bg-white rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-20 right-20 w-80 h-80 bg-white rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            </div>
        </div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl lg:text-7xl font-black text-white mb-6">
                    About <span class="text-cyan-300">FixIT</span> Solutions
                </h1>
                <p class="text-xl lg:text-2xl text-white/90 max-w-3xl mx-auto leading-relaxed">
                    Transforming maintenance services through innovation, expertise, and cutting-edge technology
                </p>
            </div>
        </div>
    </div>

    <!-- Metrics Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($metrics as $metric)
                <div class="bg-white rounded-2xl shadow-xl p-8 text-center transform hover:scale-105 transition-all duration-300">
                    <div class="text-5xl font-black bg-gradient-to-r {{ $metric['gradient'] }} bg-clip-text text-transparent mb-3">
                        {{ $metric['value'] }}
                    </div>
                    <div class="text-lg font-bold text-gray-900 mb-2">{{ $metric['label'] }}</div>
                    <div class="text-sm text-gray-600">{{ $metric['description'] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Our Story Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-4xl font-black text-gray-900 mb-6">Our Story</h2>
                <div class="space-y-4 text-lg text-gray-700 leading-relaxed">
                    <p>
                        Founded with a vision to revolutionize the maintenance industry, FixIT Solutions has grown from a small team of passionate technicians into a comprehensive platform serving thousands of clients worldwide.
                    </p>
                    <p>
                        We believe that maintenance shouldn't be a hassle. That's why we've built an intelligent platform that streamlines every aspect of the service process, from initial request to final completion, ensuring transparency and efficiency at every step.
                    </p>
                    <p>
                        Our commitment to innovation drives us to continuously improve and adapt, leveraging the latest technology including AI-powered categorization and real-time tracking to deliver exceptional service experiences.
                    </p>
                </div>
            </div>
            <div class="relative">
                <div class="rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=800&q=80" alt="Team" class="w-full h-auto">
                </div>
                <div class="absolute -bottom-6 -left-6 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-2xl p-6 shadow-xl max-w-xs">
                    <div class="text-white">
                        <div class="text-3xl font-bold mb-2">Mission</div>
                        <div class="text-sm">Empowering businesses with seamless, technology-driven maintenance solutions</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Platform Pillars -->
    <div class="bg-gray-100 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-gray-900 mb-4">Why Choose FixIT?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">Our platform is built on three core pillars that ensure exceptional service delivery</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($pillars as $pillar)
                    <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-shadow duration-300">
                        <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas {{ $pillar['icon'] }} text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $pillar['title'] }}</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $pillar['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Timeline Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black text-gray-900 mb-4">Our Journey</h2>
            <p class="text-xl text-gray-600">Milestones that shaped FixIT Solutions</p>
        </div>
        <div class="relative">
            <!-- Timeline Line -->
            <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-gradient-to-b from-blue-600 to-purple-600 hidden lg:block"></div>
            
            <div class="space-y-12">
                @foreach($timeline as $index => $item)
                    <div class="relative">
                        <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                            @if($index % 2 == 0)
                                <!-- Left side -->
                                <div class="lg:text-right">
                                    <div class="bg-white rounded-2xl p-6 shadow-lg inline-block">
                                        <div class="text-3xl font-black text-transparent bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text mb-2">{{ $item['year'] }}</div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $item['headline'] }}</h3>
                                        <p class="text-gray-700">{{ $item['details'] }}</p>
                                    </div>
                                </div>
                                <div class="hidden lg:block"></div>
                            @else
                                <!-- Right side -->
                                <div class="hidden lg:block"></div>
                                <div>
                                    <div class="bg-white rounded-2xl p-6 shadow-lg inline-block">
                                        <div class="text-3xl font-black text-transparent bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text mb-2">{{ $item['year'] }}</div>
                                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $item['headline'] }}</h3>
                                        <p class="text-gray-700">{{ $item['details'] }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <!-- Timeline Dot -->
                        <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 w-6 h-6 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full border-4 border-white shadow-lg hidden lg:block"></div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Leadership Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-white mb-4">Meet Our Leadership</h2>
                <p class="text-xl text-white/90">The team behind FixIT's success</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($leadership as $leader)
                    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 text-center border border-white/20 hover:bg-white/20 transition-all duration-300">
                        <img src="{{ $leader['avatar'] }}" alt="{{ $leader['name'] }}" class="w-32 h-32 rounded-full mx-auto mb-6 border-4 border-white shadow-xl">
                        <h3 class="text-2xl font-bold text-white mb-2">{{ $leader['name'] }}</h3>
                        <div class="text-cyan-300 font-semibold mb-4">{{ $leader['role'] }}</div>
                        <p class="text-white/90 leading-relaxed">{{ $leader['bio'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Platform Capabilities -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-black text-gray-900 mb-4">Platform Capabilities</h2>
            <p class="text-xl text-gray-600">Built for the modern enterprise</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($capabilities as $capability)
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-6 text-center border border-blue-100 hover:shadow-lg transition-all duration-300">
                    <div class="w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas {{ $capability['icon'] }} text-2xl text-white"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $capability['title'] }}</h3>
                    <p class="text-sm text-gray-600">{{ $capability['subtitle'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-black text-white mb-6">Ready to Transform Your Maintenance?</h2>
            <p class="text-xl text-white/90 mb-8">Join thousands of satisfied clients who trust FixIT for their maintenance needs</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}" class="inline-block px-8 py-4 bg-white text-blue-600 rounded-2xl font-bold text-lg hover:bg-gray-100 transition-all duration-300 shadow-xl">
                        <i class="fas fa-rocket mr-2"></i>Get Started Free
                    </a>
                    <a href="{{ route('home') }}#contact" class="inline-block px-8 py-4 bg-white/20 backdrop-blur-sm border border-white/40 text-white rounded-2xl font-bold text-lg hover:bg-white/30 transition-all duration-300">
                        <i class="fas fa-envelope mr-2"></i>Contact Sales
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="inline-block px-8 py-4 bg-white text-blue-600 rounded-2xl font-bold text-lg hover:bg-gray-100 transition-all duration-300 shadow-xl">
                        <i class="fas fa-tachometer-alt mr-2"></i>Go to Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>

   
    <!-- Footer -->
@include('components.footer')
</body>
</html>
