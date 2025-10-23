<!-- Modern Footer -->  
<footer class="mt-auto w-full" style="padding:50px 0; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 30%, #312e81 70%, #1e1b4b 100%);">
    <div class="max-w-full px-8 sm:px-12 lg:px-16 py-16">
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
            class="fixed bottom-8 right-8 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600 text-white w-14 h-14 rounded-full shadow-xl hover:shadow-2xl transform hover:scale-110 hover:rotate-12 transition-all duration-300 flex items-center justify-center"
            id="scrollToTopBtn"
            style="display: none; z-index: 40;">
        <i class="fas fa-arrow-up text-lg"></i>
    </button>
</footer>

<script>
    // Show/Hide Scroll to Top button
    window.addEventListener('scroll', function() {
        const scrollButton = document.getElementById('scrollToTopBtn');
        if (scrollButton) {
            if (window.pageYOffset > 300) {
                scrollButton.style.display = 'flex';
            } else {
                scrollButton.style.display = 'none';
            }
        }
    });
</script>
