@php
    $navLinkClass = 'px-3 py-2 text-sm font-medium transition-colors';
    $mobileNavLinkClass = 'block py-3 text-lg font-medium transition-colors border-b border-gray-100';
@endphp

<header class="sticky top-0 z-50 border-b border-white/10 bg-[#080808] text-white shadow-lg shadow-black/10">
    {{-- Top Announcement Bar --}}
    <div id="announcement-bar" class="max-h-20 overflow-hidden border-b border-gray-800 bg-gray-950 px-4 py-2 text-[11px] text-white opacity-100 transition-all duration-300 sm:text-xs">
        <div class="container mx-auto flex items-center justify-between gap-4">
            <div class="flex items-center gap-2 overflow-hidden whitespace-nowrap mx-auto md:mx-0">
                    <span class="inline-flex items-center gap-1.5 font-medium text-amber-300">
                    <svg class="w-3.5 h-3.5 text-amber-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                    </svg>
                    <span><strong>Footwear for every move</strong>. Shop the Mars Collection</span>
                </span>
                <span class="hidden md:inline text-gray-600">·</span>
                <span class="hidden md:inline-flex items-center gap-1 text-gray-300">
                    <svg class="w-3.5 h-3.5 text-yellow-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
                    </svg>
                    <span>Delivery across Kenya</span>
                </span>
                <span class="hidden md:inline text-gray-600">·</span>
                <span class="hidden lg:inline-flex items-center gap-1 text-emerald-400 font-semibold">
                    <svg class="w-3.5 h-3.5 text-emerald-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    <span>Lipa Na M-Pesa (Till / STK)</span>
                </span>
            </div>
            <div class="hidden md:flex items-center gap-4 text-gray-300 text-[11px]">
                <a href="{{ route('contact') }}" class="hover:text-amber-300 transition-colors flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Ask about your fit</span>
                </a>
                <a href="{{ route('products.index') }}" class="hover:text-amber-300 transition-colors font-bold text-amber-400 flex items-center gap-1">
                    <span>Shop new arrivals</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-[76px]">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" aria-label="Mars Collection">
                    <img src="{{ \App\Helpers\SettingsHelper::getBrandLogoUrl() }}" alt="Mars Collection" class="h-14 w-auto">
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="hidden lg:flex items-center gap-0 xl:gap-2">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-amber-300' : 'text-gray-200 hover:text-amber-300' }} px-2 xl:px-3 py-2 text-sm font-medium transition-colors">Home</a>
                <div class="group relative">
                    <a href="{{ route('brands.index') }}" aria-haspopup="true" class="inline-flex items-center gap-1 px-2 py-2 text-sm font-medium transition-colors xl:px-3 {{ request()->routeIs('brands.*') ? 'text-amber-300' : 'text-gray-200 hover:text-amber-300' }}">
                        Brand
                        <svg class="h-4 w-4 transition-transform group-hover:rotate-180 group-focus-within:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.09 1.03l-4.255 4.516a.75.75 0 01-1.09 0L5.21 8.26a.75.75 0 01.02-1.05z" clip-rule="evenodd"/></svg>
                    </a>
                    <div class="invisible absolute left-0 top-full z-50 mt-1 w-60 translate-y-1 rounded-xl border border-gray-200 bg-white p-2 text-gray-800 opacity-0 shadow-xl transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                        @forelse($activeBrands as $brand)
                            <a href="{{ route('brands.show', $brand) }}" class="block rounded-lg px-3 py-2.5 text-sm font-medium hover:bg-amber-50 hover:text-amber-800">{{ $brand->name }}</a>
                        @empty
                            <p class="px-3 py-2 text-sm text-gray-500">No brands available yet.</p>
                        @endforelse
                        <a href="{{ route('brands.index') }}" class="mt-1 block border-t border-gray-100 px-3 py-2.5 text-sm font-bold text-amber-800 hover:bg-amber-50">All brands <span aria-hidden="true">→</span></a>
                    </div>
                </div>
                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'text-amber-300' : 'text-gray-200 hover:text-amber-300' }} px-2 xl:px-3 py-2 text-sm font-medium transition-colors">Category</a>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'text-amber-300' : 'text-gray-200 hover:text-amber-300' }} px-2 xl:px-3 py-2 text-sm font-medium transition-colors">Shop</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-amber-300' : 'text-gray-200 hover:text-amber-300' }} px-2 xl:px-3 py-2 text-sm font-medium transition-colors">Our Story</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') || request()->routeIs('contact.submit') ? 'text-amber-300' : 'text-gray-200 hover:text-amber-300' }} px-2 xl:px-3 py-2 text-sm font-medium transition-colors">Contact Us</a>
            </nav>
            
            <!-- User Actions -->
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <form action="{{ route('products.index') }}" method="GET" class="hidden md:block">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search products..." 
                               value="{{ request('search') }}"
                               class="w-36 lg:w-40 xl:w-56 2xl:w-64 pl-10 pr-3 py-2 border border-gray-700 bg-gray-900 text-white placeholder-gray-400 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </form>
                

                
                <!-- Cart -->
                <div id="cart-dropdown" class="relative group">
                    <a href="{{ route('cart.index') }}" class="text-white hover:text-amber-300 p-2 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </a>
                    <span class="cart-count absolute top-2 -right-2 bg-amber-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold shadow-sm">0</span>
                    
                    <!-- Cart Dropdown -->
                    <div class="absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform origin-top-right">
                        <!-- Dropdown Arrow -->
                        <div class="absolute -top-2 right-4 w-4 h-4 bg-white border-t border-l border-gray-200 transform rotate-45"></div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Shopping Cart</h3>
                            
                            <!-- Cart Items Container -->
                            <div id="cart-dropdown-items" class="space-y-3 max-h-64 overflow-y-auto">
                                <!-- Cart items will be loaded here -->
                                <div class="text-center text-gray-500 py-4">
                                    <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                    <p class="text-sm">Your cart is empty</p>
                                </div>
                            </div>
                            
                            <!-- Cart Summary -->
                            <div id="cart-dropdown-summary" class="border-t border-gray-200 pt-3 mt-3 hidden">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm font-medium text-gray-700">Total:</span>
                                    <span id="cart-dropdown-total" class="text-lg font-bold text-amber-600">KES 0</span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('cart.index') }}" class="flex-1 bg-amber-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-amber-700 transition-colors text-center">
                                        View Cart
                                    </a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <button id="mobile-menu-button" aria-label="Open menu" aria-controls="mobile-menu" aria-expanded="false" class="lg:hidden text-white hover:text-amber-300 p-2 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
</header>

<!-- Mobile Menu Drawer -->
<div id="mobile-menu" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div id="mobile-menu-backdrop" class="absolute inset-0 bg-black/50 transition-opacity duration-300"></div>
    
    <!-- Drawer -->
    <div id="mobile-menu-drawer" class="absolute right-0 top-0 flex h-full w-[min(20rem,100vw)] flex-col overflow-y-auto bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out">
        <!-- Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Menu</h2>
            <button id="mobile-menu-close" class="text-gray-500 hover:text-gray-700 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <!-- Navigation -->
        <nav class="p-6">
            <div class="space-y-4">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-amber-600' : 'text-gray-700 hover:text-amber-600' }} {{ $mobileNavLinkClass }}">Home</a>
                <details class="border-b border-gray-100 py-3" {{ request()->routeIs('brands.*') ? 'open' : '' }}>
                    <summary class="cursor-pointer list-none text-lg font-medium {{ request()->routeIs('brands.*') ? 'text-amber-600' : 'text-gray-700 hover:text-amber-600' }}">Brand</summary>
                    <div class="mt-2 space-y-1 pl-4">
                        @forelse($activeBrands as $brand)
                            <a href="{{ route('brands.show', $brand) }}" class="block py-2 text-sm font-medium text-gray-600 hover:text-amber-600">{{ $brand->name }}</a>
                        @empty
                            <p class="py-2 text-sm text-gray-500">No brands available yet.</p>
                        @endforelse
                        <a href="{{ route('brands.index') }}" class="block border-t border-gray-100 py-2 text-sm font-bold text-amber-800">All brands</a>
                    </div>
                </details>
                <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'text-amber-600' : 'text-gray-700 hover:text-amber-600' }} {{ $mobileNavLinkClass }}">Category</a>
                <a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'text-amber-600' : 'text-gray-700 hover:text-amber-600' }} {{ $mobileNavLinkClass }}">Shop</a>
                <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-amber-600' : 'text-gray-700 hover:text-amber-600' }} {{ $mobileNavLinkClass }}">Our Story</a>
                <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') || request()->routeIs('contact.submit') ? 'text-amber-600' : 'text-gray-700 hover:text-amber-600' }} {{ $mobileNavLinkClass }}">Contact Us</a>
            </div>
        </nav>
        
        <!-- Search -->
        <div class="p-6 border-t border-gray-200">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="relative">
                    <input type="text" name="search" placeholder="Search products..." 
                           value="{{ request('search') }}"
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- User Actions -->
        <div class="p-6 border-t border-gray-200">
            <div class="space-y-4">
                <a href="{{ route('cart.index') }}" class="flex items-center space-x-3 text-gray-700 hover:text-amber-600 py-3 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="text-lg font-medium">Shopping Cart</span>
                    <span class="cart-count ml-auto bg-amber-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold">0</span>
                </a>
                <button class="flex items-center space-x-3 text-gray-700 hover:text-amber-600 py-3 transition-colors w-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-lg font-medium">My Account</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Keep the main navigation visible while the announcement strip collapses on scroll.
    const announcementBar = document.getElementById('announcement-bar');
    if (announcementBar) {
        let announcementCollapsed = false;
        const updateAnnouncementBar = () => {
            const scrollY = window.scrollY;
            const shouldCollapse = announcementCollapsed ? scrollY > 8 : scrollY > 64;
            if (shouldCollapse === announcementCollapsed) return;

            announcementCollapsed = shouldCollapse;
            announcementBar.classList.toggle('max-h-0', announcementCollapsed);
            announcementBar.classList.toggle('opacity-0', announcementCollapsed);
            announcementBar.classList.toggle('py-0', announcementCollapsed);
            announcementBar.classList.toggle('border-b-0', announcementCollapsed);
            announcementBar.classList.toggle('max-h-20', !announcementCollapsed);
            announcementBar.classList.toggle('opacity-100', !announcementCollapsed);
            announcementBar.classList.toggle('py-2', !announcementCollapsed);
            announcementBar.classList.toggle('border-b', !announcementCollapsed);
            announcementBar.setAttribute('aria-hidden', announcementCollapsed ? 'true' : 'false');
        };

        updateAnnouncementBar();
        window.addEventListener('scroll', updateAnnouncementBar, { passive: true });
    }

    // Mobile menu functionality
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    
    function openMobileMenu() {
        mobileMenu.classList.remove('hidden');
        mobileMenuButton.setAttribute('aria-expanded', 'true');
        // Trigger reflow to ensure transition works
        mobileMenu.offsetHeight;
        mobileMenuDrawer.classList.remove('translate-x-full');
    }
    
    function closeMobileMenu() {
        mobileMenuButton.setAttribute('aria-expanded', 'false');
        mobileMenuDrawer.classList.add('translate-x-full');
        setTimeout(() => {
            mobileMenu.classList.add('hidden');
        }, 300);
    }
    
    // Open mobile menu
    mobileMenuButton.addEventListener('click', openMobileMenu);
    
    // Close mobile menu
    mobileMenuClose.addEventListener('click', closeMobileMenu);
    mobileMenuBackdrop.addEventListener('click', closeMobileMenu);
    
    // Close on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
            closeMobileMenu();
        }
    });

    // Cart dropdown functionality
    const cartDropdown = document.getElementById('cart-dropdown');
    const cartItemsContainer = document.getElementById('cart-dropdown-items');
    const cartSummary = document.getElementById('cart-dropdown-summary');
    const cartDropdownTotal = document.getElementById('cart-dropdown-total');
    let cartLoaded = false;
    let cartLoading = false;

    // Load details as soon as the actual cart dropdown is opened or focused.
    cartDropdown.addEventListener('mouseenter', loadCartItemsIfNeeded);
    cartDropdown.addEventListener('focusin', loadCartItemsIfNeeded);

    function loadCartItemsIfNeeded() {
        if (!cartLoaded && !cartLoading) loadCartItems();
    }

    function loadCartItems() {
        cartLoading = true;
        fetch('/cart/dropdown', { headers: { 'Accept': 'application/json' }, cache: 'no-store' })
            .then(response => {
                if (!response.ok) throw new Error(`Unable to load cart (HTTP ${response.status})`);
                return response.json();
            })
            .then(cartData => {
                if (cartData.items?.length) {
                    displayCartItems(cartData.items, cartData.total);
                } else {
                    displayEmptyCart();
                }
                cartLoaded = true;
            })
            .catch(error => {
                console.error('Error loading cart items:', error);
            })
            .finally(() => {
                cartLoading = false;
            });
    }

    function displayCartItems(items, total) {
        let html = '';
        
        items.forEach(item => {
            const itemName = item.bundle_id ? item.bundle_name : item.product_name;
            const itemImage = item.bundle_id ? (item.bundle_image || 'https://via.placeholder.com/48x48/f3f4f6/6b7280?text=Bundle') : (item.product_image || 'https://via.placeholder.com/48x48/f3f4f6/6b7280?text=Product');
            const itemType = item.bundle_id ? 'Bundle' : 'Product';
            
            html += `
                <div class="flex items-center space-x-3">
                    <img src="${itemImage}" alt="${itemName}" class="w-12 h-12 object-cover rounded-md">
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-gray-900 truncate">${itemName}</h4>
                        <p class="text-xs text-gray-500">${itemType} • Qty: ${item.quantity}</p>
                    </div>
                    <div class="text-sm font-medium text-gray-900">
                        KES ${parseInt(item.price).toLocaleString()}
                    </div>
                </div>
            `;
        });
        
        cartItemsContainer.innerHTML = html;
        cartDropdownTotal.textContent = `KES ${parseInt(total).toLocaleString()}`;
        cartSummary.classList.remove('hidden');
    }

    function displayEmptyCart() {
        cartItemsContainer.innerHTML = `
            <div class="text-center text-gray-500 py-4">
                <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <p class="text-sm">Your cart is empty</p>
            </div>
        `;
        cartSummary.classList.add('hidden');
    }

    // Update cart count when items are added
    function updateCartCount() {
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                const cartCounts = document.querySelectorAll('.cart-count');
                cartCounts.forEach(cartCount => {
                cartCount.textContent = data.count;
                });
                
                // Reset cart loaded flag when count changes
                if (data.count === 0) {
                    cartLoaded = false;
                }
            })
            .catch(error => {
                console.error('Error updating cart count:', error);
            });
    }

    // Update cart count on page load
    updateCartCount();

    // Listen for cart updates (you can trigger this from other parts of the app)
    window.addEventListener('cartUpdated', function() {
        updateCartCount();
        cartLoaded = false;
        if (cartDropdown.matches(':hover') || cartDropdown.contains(document.activeElement)) {
            loadCartItemsIfNeeded();
        }
    });
});
</script> 
