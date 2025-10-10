<nav x-data="{ open: false }" class="glass-effect backdrop-blur-md sticky top-0 z-50 transition-all duration-300">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Enhanced Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 rounded-xl flex items-center justify-center transform group-hover:scale-110 transition-all duration-300 animate-pulse-glow">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 via-purple-600 to-pink-500 rounded-xl blur-lg opacity-30 -z-10 group-hover:opacity-50 transition-opacity duration-300"></div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-bold gradient-text">FixIT</span>
                            <span class="text-xs text-gray-500 -mt-1">Maintenance Pro</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                @auth
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Newsfeed') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('requests.create')" :active="request()->routeIs('requests.create')">
                        {{ __('New Request') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('requests.my')" :active="request()->routeIs('requests.my')">
                        {{ __('My Requests') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*')">
                        <i class="fas fa-store mr-1"></i>{{ __('Shop') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('user.orders')" :active="request()->routeIs('user.orders*')">
                        <i class="fas fa-shopping-bag mr-1"></i>{{ __('My Orders') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('user.dashboard')" :active="request()->routeIs('user.dashboard*')">
                        <i class="fas fa-tachometer-alt mr-1"></i>{{ __('My Dashboard') }}
                    </x-nav-link>
                    
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
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <!-- Notification Bell -->
                    <div class="relative mr-4" x-data="{ open: false }">
                        <button @click="open = !open; if(open) loadNotifications();" class="relative text-gray-600 hover:text-blue-600 transition focus:outline-none">
                            <i class="fas fa-bell text-xl"></i>
                            @php
                                $unreadCount = auth()->user()->unreadNotifications->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center animate-pulse">
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
                             class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50"
                             style="display: none;">
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

                    <!-- Cart Icon -->
                    <a href="{{ route('cart.index') }}" class="relative mr-4 text-gray-600 hover:text-blue-600 transition">
                        <i class="fas fa-shopping-cart text-xl"></i>
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
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

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
                            
                            <x-dropdown-link :href="route('requests.my')">
                                <i class="fas fa-tools mr-2"></i>{{ __('My Requests') }}
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
