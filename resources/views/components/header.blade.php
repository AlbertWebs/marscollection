<header class="bg-white border-b-2 border-gray-100 sticky top-0 z-50">
    <!-- Main Header -->
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" aria-label="Zayn's Beauty">
                    <img src="{{ asset('logo.svg') }}" alt="Zayn's Beauty" class="h-10 w-auto">
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium transition-colors">Home</a>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium transition-colors">Products</a>
                <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium transition-colors">Categories</a>
                <a href="{{ route('brands.index') }}" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium transition-colors">Brands</a>
                <a href="{{ route('appointments.create') }}" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium transition-colors">Book Appointment</a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium transition-colors">About</a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium transition-colors">Contact</a>
            </nav>
            
            <!-- User Actions -->
            <div class="flex items-center space-x-4">
                <!-- Search -->
                <form action="{{ route('products.index') }}" method="GET" class="hidden md:block">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search products..." 
                               class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </form>
                

                
                <!-- Cart -->
                <div class="relative group">
                    <a href="{{ route('cart.index') }}" class="text-gray-700 hover:text-pink-600 p-2 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </a>
                    <span class="cart-count absolute top-2 -right-2 bg-pink-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold shadow-sm">0</span>
                    
                    <!-- Cart Dropdown -->
                    <div class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform origin-top-right">
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
                                    <span id="cart-dropdown-total" class="text-lg font-bold text-pink-600">KES 0</span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('cart.index') }}" class="flex-1 bg-pink-600 text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-pink-700 transition-colors text-center">
                                        View Cart
                                    </a>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden text-gray-700 hover:text-pink-600 p-2 transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    
    <!-- Split Line between Main Header and Categories -->
    <div class="h-px bg-gray-200"></div>
    
    <!-- Categories Navigation -->
    @if($activeCategories->count() > 0)
        <div class="border-gray-100">
            <div class="container mx-auto px-0 sm:px-6 lg:px-8">
                <div class="h-10 flex items-center gap-0 sm:gap-4">
                    <!-- Categories Label -->
                    <div class="bg-pink-600 text-white px-3 py-2 flex-shrink-0">
                        <a href="{{ route('categories.index') }}" class="text-xs font-medium text-white uppercase tracking-wide">Categories</a>
                    </div>
                    
                    <!-- Category Links with Horizontal Scroll -->
                    <div class="flex gap-0 overflow-x-auto scrollbar-hide flex-1">
                        @foreach($activeCategories as $category)
                        <a href="{{ route('products.index', ['category_id' => $category->id]) }}" 
                        class="inline-flex items-center px-4 py-2 h-10 text-sm font-medium {{ request('category_id') == $category->id ? 'text-pink-600 ' : 'text-gray-700 hover:text-pink-600 hover:bg-pink-100' }} transition-all duration-200 whitespace-nowrap flex-shrink-0">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</header>

<!-- Mobile Menu Drawer -->
<div id="mobile-menu" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div id="mobile-menu-backdrop" class="absolute inset-0 bg-black/50 transition-opacity duration-300"></div>
    
    <!-- Drawer -->
    <div id="mobile-menu-drawer" class="absolute right-0 top-0 h-full w-80 bg-white shadow-xl transform translate-x-full transition-transform duration-300 ease-in-out">
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
                <a href="{{ route('home') }}" class="block text-gray-700 hover:text-pink-600 py-3 text-lg font-medium transition-colors border-b border-gray-100">Home</a>
                <a href="{{ route('products.index') }}" class="block text-gray-700 hover:text-pink-600 py-3 text-lg font-medium transition-colors border-b border-gray-100">Products</a>
                <a href="{{ route('categories.index') }}" class="block text-gray-700 hover:text-pink-600 py-3 text-lg font-medium transition-colors border-b border-gray-100">Categories</a>
                <a href="{{ route('brands.index') }}" class="block text-gray-700 hover:text-pink-600 py-3 text-lg font-medium transition-colors border-b border-gray-100">Brands</a>
                <a href="{{ route('appointments.create') }}" class="block text-gray-700 hover:text-pink-600 py-3 text-lg font-medium transition-colors border-b border-gray-100">Book Appointment</a>
                <a href="{{ route('about') }}" class="block text-gray-700 hover:text-pink-600 py-3 text-lg font-medium transition-colors border-b border-gray-100">About</a>
                <a href="{{ route('contact') }}" class="block text-gray-700 hover:text-pink-600 py-3 text-lg font-medium transition-colors border-b border-gray-100">Contact</a>
            </div>
        </nav>
        
        <!-- Search -->
        <div class="p-6 border-t border-gray-200">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="relative">
                    <input type="text" name="search" placeholder="Search products..." 
                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
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
                <a href="{{ route('cart.index') }}" class="flex items-center space-x-3 text-gray-700 hover:text-pink-600 py-3 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="text-lg font-medium">Shopping Cart</span>
                    <span class="cart-count ml-auto bg-pink-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-semibold">0</span>
                </a>
                <button class="flex items-center space-x-3 text-gray-700 hover:text-pink-600 py-3 transition-colors w-full">
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
    // Mobile menu functionality
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuDrawer = document.getElementById('mobile-menu-drawer');
    const mobileMenuBackdrop = document.getElementById('mobile-menu-backdrop');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    
    function openMobileMenu() {
        mobileMenu.classList.remove('hidden');
        // Trigger reflow to ensure transition works
        mobileMenu.offsetHeight;
        mobileMenuDrawer.classList.remove('translate-x-full');
    }
    
    function closeMobileMenu() {
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
    const cartDropdown = document.querySelector('.group');
    const cartItemsContainer = document.getElementById('cart-dropdown-items');
    const cartSummary = document.getElementById('cart-dropdown-summary');
    const cartDropdownTotal = document.getElementById('cart-dropdown-total');
    let cartLoaded = false;

    // Load cart items on hover
    cartDropdown.addEventListener('mouseenter', function() {
        if (!cartLoaded) {
            loadCartItems();
            cartLoaded = true;
        }
    });

    function loadCartItems() {
        fetch('/cart/count')
            .then(response => response.json())
            .then(data => {
                if (data.count > 0) {
                    // Load detailed cart items
                    fetch('/cart/dropdown')
                        .then(response => response.json())
                        .then(cartData => {
                            displayCartItems(cartData.items, cartData.total);
                        })
                        .catch(error => {
                            console.error('Error loading cart items:', error);
                        });
                } else {
                    // Show empty cart
                    displayEmptyCart();
                }
            })
            .catch(error => {
                console.error('Error loading cart count:', error);
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
                    <img src="${itemImage}" alt="${itemName}" class="w-12 h-12 object-cover rounded">
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
        cartLoaded = false; // Reload cart items on next hover
    });
});
</script> 