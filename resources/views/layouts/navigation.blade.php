<nav x-data="{ open: false }" class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 glass-effect backdrop-blur-md sticky top-0 z-50 transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class=" max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Enhanced Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <div class="w-14 h-14 ">
                                <!-- <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg> -->
                             <img src="{{ asset('images/image1.png') }}" alt="FixIt Solutions" width="80" height="80" class="object-contain">

                            </div>
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 rounded-xl blur-lg opacity-30 -z-10 group-hover:opacity-50 transition-opacity duration-300"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold gradient-text">FixIt</span>
                            <span class="text-xs text-gray-500 -mt-1">Repair &<br> E-Commerce Services</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                  
                    
                   
            
                
                    
                    @if(auth()->user()->isTechnician())
                    <x-nav-link :href="route('requests.assigned')" :active="request()->routeIs('requests.assigned')">
                        {{ __('Assigned to Me') }}
                    </x-nav-link>
                    @endif
                    
                    @if(auth()->user()->isAdmin())
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                        {{ __('Admin Panel') }}
                    </x-nav-link>
                    @endif
                </div>
                @endauth
                
                <!-- Public Navigation Links (for all users) -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex items-center">
                    <a href="{{ route('home') }}#services" class="text-black hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                        <i class="fas fa-tools mr-1"></i>{{ __('Our Services') }}
                    </a>
                    <a href="{{ route('home') }}#testimonials" class="text-black hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                        <i class="fas fa-info-circle mr-1"></i>{{ __('About Us') }}
                    </a>
                    <a href="{{ route('home') }}#contact" class="text-black hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                        <i class="fas fa-envelope mr-1"></i>{{ __('Contact Us') }}
                    </a>
                    <a href="{{ route('blogs.index') }}" class="text-black hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                        <i class="fas fa-blog mr-1"></i>{{ __('Blog') }}
                    </a>
                    <a href="{{ route('shop.index') }}" class="text-black hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-300">
                        <i class="fas fa-store mr-1"></i>{{ __('Shop') }}
                    </a>

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <!-- Notification Bell -->
                    
                    <!-- User Role Badge -->
                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ Auth::user()->role_badge_color }} mr-3">
                        {{ Auth::user()->role_name }}
                    </span>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <img class="h-8 w-8 rounded-full mr-2" src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                <i class="fas fa-user mr-2"></i>{{ __('Profile') }}
                            </x-dropdown-link>
                            
                              <x-dropdown-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                              <i class="fas fa-tachometer-alt mr-2"></i>{{ __('Dashboard') }}
                              </x-dropdown-link>
                            <x-dropdown-link :href="route('user.orders')">
                                <i class="fas fa-shopping-bag mr-2"></i>{{ __('My Orders') }}
                            </x-dropdown-link>

                            @if(auth()->user()->isAdmin())
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    <i class="fas fa-cog mr-2"></i>{{ __('Admin Panel') }}
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Guest Links -->
                    <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                        {{ __('Log in') }}
                    </a>
                    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            {{ __('Register') }}
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        @auth
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                
                @if(auth()->user()->role === 'admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')">
                        {{ __('Admin') }}
                    </x-responsive-nav-link>
                @endif
                
                @if(auth()->user()->canManageRequests())
                    <x-responsive-nav-link :href="route('requests.assigned')" :active="request()->routeIs('requests.assigned')">
                        {{ __('Assigned Requests') }}
                    </x-responsive-nav-link>
                @endif
                
                <x-responsive-nav-link :href="route('requests.index')" :active="request()->routeIs('requests.*')">
                    {{ __('All Requests') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('requests.my')" :active="request()->routeIs('requests.my')">
                    {{ __('My Requests') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('blogs.index')" :active="request()->routeIs('blogs.*')">
                    <i class="fas fa-blog mr-1"></i>{{ __('Blog') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*')">
                    <i class="fas fa-store mr-1"></i>{{ __('Shop') }}
                </x-responsive-nav-link>
                
                <!-- Public Links in Mobile Menu -->
                <div class="pt-2 pb-3 border-t border-gray-200">
                    <x-responsive-nav-link :href="route('home') . '#services'">
                        <i class="fas fa-tools mr-1"></i>{{ __('Our Services') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('about')">
                        <i class="fas fa-info-circle mr-1"></i>{{ __('About Us') }}
                    </x-responsive-nav-link>
                    
                    <x-responsive-nav-link :href="route('home') . '#contact'">
                        <i class="fas fa-envelope mr-1"></i>{{ __('Contact Us') }}
                    </x-responsive-nav-link>
                </div>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <!-- Guest Responsive Menu -->
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('home')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('home') . '#services'">
                    <i class="fas fa-tools mr-1"></i>{{ __('Our Services') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('about')">
                    <i class="fas fa-info-circle mr-1"></i>{{ __('About Us') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('home') . '#contact'">
                    <i class="fas fa-envelope mr-1"></i>{{ __('Contact Us') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('blogs.index')">
                    <i class="fas fa-blog mr-1"></i>{{ __('Blog') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('shop.index')">
                    <i class="fas fa-store mr-1"></i>{{ __('Shop') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                @if (Route::has('register'))
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        @endauth
    </div>
</nav>

@auth
<script>
function loadNotifications() {
    fetch('/notifications/get')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('notifications-container');
            if (data.notifications && data.notifications.length > 0) {
                container.innerHTML = data.notifications.map(notification => {
                    const isUnread = !notification.read_at;
                    const iconClass = getNotificationIcon(notification.data.type);
                    const colorClass = getNotificationColor(notification.data.type);
                    
                    return `
                        <a href="/notifications/${notification.id}/read" 
                           class="block p-3 border-b border-gray-100 hover:bg-gray-50 transition ${isUnread ? 'bg-blue-50' : ''}">
                            <div class="flex items-start">
                                <div class="mr-3 mt-1">
                                    <i class="fas fa-${iconClass} text-${colorClass}-500"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">${notification.data.title || 'Notification'}</p>
                                    <p class="text-xs text-gray-600 mt-1">${notification.data.message || ''}</p>
                                    <p class="text-xs text-gray-400 mt-1">${formatTime(notification.created_at)}</p>
                                </div>
                                ${isUnread ? '<div class="w-2 h-2 bg-blue-500 rounded-full ml-2 mt-2"></div>' : ''}
                            </div>
                        </a>
                    `;
                }).join('');
            } else {
                container.innerHTML = '<div class="p-4 text-center text-gray-500">No notifications yet</div>';
            }
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
            document.getElementById('notifications-container').innerHTML = 
                '<div class="p-4 text-center text-red-500">Error loading notifications</div>';
        });
}

function markAllAsRead() {
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        }
    }).then(() => {
        location.reload();
    });
}

function getNotificationIcon(type) {
    const icons = {
        'comment': 'comment',
        'technician_assigned': 'user-cog',
        'request_assigned': 'clipboard-check',
        'order_status': 'shopping-bag'
    };
    return icons[type] || 'bell';
}

function getNotificationColor(type) {
    const colors = {
        'comment': 'blue',
        'technician_assigned': 'green',
        'request_assigned': 'purple',
        'order_status': 'orange'
    };
    return colors[type] || 'gray';
}

function formatTime(timestamp) {
    const date = new Date(timestamp);
    const now = new Date();
    const diff = Math.floor((now - date) / 1000); // difference in seconds
    
    if (diff < 60) return 'Just now';
    if (diff < 3600) return Math.floor(diff / 60) + ' minutes ago';
    if (diff < 86400) return Math.floor(diff / 3600) + ' hours ago';
    if (diff < 604800) return Math.floor(diff / 86400) + ' days ago';
    
    return date.toLocaleDateString();
}

// Auto-refresh notifications every 30 seconds
setInterval(() => {
    const container = document.getElementById('notifications-container');
    if (container && container.innerHTML.indexOf('Loading') === -1) {
        loadNotifications();
    }
}, 30000);
</script>
@endauth
