<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Mobile menu overlay -->
        <div id="mobile-menu-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 lg:hidden hidden"></div>
        
        <!-- Sidebar -->
        <div id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0">
            <div class="flex items-center justify-between min-h-20 bg-white border-b border-gray-200 px-4 py-3">
                <a href="{{ route('admin.dashboard') }}" aria-label="Zayn's Beauty Admin" class="flex items-center">
                    <img src="{{ asset('logo.svg') }}" alt="Zayn's Beauty" class="h-12 w-auto">
                </a>
                <button id="close-sidebar" class="lg:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <nav class="mt-8">
                <div class="px-4 space-y-6">
                    <!-- Dashboard -->
                    <div>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-pink-100 text-pink-700' : '' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            Dashboard
                        </a>
                    </div>

                    <!-- E-commerce Management -->
                    <div>
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">E-commerce</h3>
                        <div class="space-y-1">
                            <a href="{{ route('admin.products.index') }}" 
                               class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.products.*') ? 'bg-pink-100 text-pink-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Products
                            </a>
                            
                            <a href="{{ route('admin.bundles.index') }}" 
                               class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.bundles.*') ? 'bg-pink-100 text-pink-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l2.5 2.5L17 3l2 2.5-2 2.5h2a1 1 0 011 1v3H4V9a1 1 0 011-1h2L5 5.5 7 3l2.5 2.5L12 3z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12h16v7a2 2 0 01-2 2H6a2 2 0 01-2-2v-7z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v11"></path>
                                </svg>
                                Bundles
                            </a>
                            
                            <a href="{{ route('admin.categories.index') }}" 
                               class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.categories.*') ? 'bg-pink-100 text-pink-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Categories
                            </a>
                            
                            <a href="{{ route('admin.brands.index') }}" 
                               class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.brands.*') ? 'bg-pink-100 text-pink-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Brands
                            </a>
                        </div>
                    </div>

                    <!-- Orders & Customers -->
                    <div>
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Orders & Customers</h3>
                        <div class="space-y-1">
                            <a href="{{ route('admin.orders.index') }}" 
                               class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.orders.*') ? 'bg-pink-100 text-pink-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Orders
                            </a>
                            
                            <a href="{{ route('admin.users.index') }}" 
                               class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'bg-pink-100 text-pink-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Users
                            </a>
                            
                            <a href="{{ route('admin.contacts.index') }}" 
                               class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.contacts.*') ? 'bg-pink-100 text-pink-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Contact Messages
                            </a>

                            <a href="{{ route('admin.newsletter-subscribers.index') }}" 
                               class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.newsletter-subscribers.*') ? 'bg-pink-100 text-pink-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16v12H4z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8l8 5 8-5"></path>
                                </svg>
                                Newsletter
                            </a>
                        </div>
                    </div>

                    <!-- Services & Appointments -->
                    <div>
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Services & Appointments</h3>
                        <div class="space-y-1">
                            <a href="{{ route('admin.services.index') }}" 
                               class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.services.*') ? 'bg-pink-100 text-pink-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Services
                            </a>
                            
                            <a href="{{ route('admin.appointments.index') }}" 
                               class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.appointments.*') ? 'bg-pink-100 text-pink-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Appointments
                            </a>
                        </div>
                    </div>

                    <!-- Content & Reviews -->
                    <div>
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Content & Reviews</h3>
                        <div class="space-y-1">
                            <a href="{{ route('admin.reviews.index') }}" 
                               class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.reviews.*') ? 'bg-pink-100 text-pink-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Reviews
                            </a>
                        </div>
                    </div>

                    <!-- System -->
                    <div>
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">System</h3>
                        <div class="space-y-1">
                            <a href="{{ route('admin.settings.index') }}" 
                               class="flex items-center px-4 py-2 text-gray-700 rounded-md hover:bg-gray-100 {{ request()->routeIs('admin.settings.*') ? 'bg-pink-100 text-pink-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Settings
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main content -->
        <div class="lg:ml-64">
            <!-- Top navigation -->
            <div class="bg-white shadow-sm border-b">
                <div class="flex items-center justify-between px-4 lg:px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <button id="open-sidebar" class="lg:hidden text-gray-600 hover:text-gray-900">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        <h2 class="text-lg lg:text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
                    </div>
                    
                    <div class="flex items-center space-x-2 lg:space-x-4">
                        <span class="text-xs lg:text-sm text-gray-600 hidden sm:inline">Welcome, {{ auth()->user()->name }}</span>
                        
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs lg:text-sm text-gray-600 hover:text-gray-900 px-2 lg:px-0">
                                Logout
                            </button>
                        </form>
                        
                        <a href="{{ route('home') }}" class="text-xs lg:text-sm text-pink-600 hover:text-pink-700 px-2 lg:px-0">
                            <span class="hidden sm:inline">View Site</span>
                            <span class="sm:hidden">Site</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <main class="p-4 lg:p-6">
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('mobile-menu-overlay');
        const openBtn = document.getElementById('open-sidebar');
        const closeBtn = document.getElementById('close-sidebar');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        if (openBtn) {
            openBtn.addEventListener('click', openSidebar);
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', closeSidebar);
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        // Close sidebar when clicking on a link (mobile only)
        const sidebarLinks = sidebar.querySelectorAll('a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html> 
