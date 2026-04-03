<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
    <title>@yield('title', 'Zayn\'s Beauty | Makeup Products & Beauty Shop in Nairobi, Kenya')</title>
    <meta name="title" content="@yield('title', 'Zayn\'s Beauty | Makeup Products & Beauty Shop in Nairobi, Kenya')">
    <meta name="description" content="@yield('description', 'Shop authentic makeup products, skincare & beauty supplies in Nairobi, Kenya. Same-day delivery within CBD. Book professional makeup appointments online.')">
    <meta name="keywords" content="@yield('keywords', 'makeup products Nairobi, beauty shop Nairobi, makeup Nairobi Kenya, skincare Nairobi, buy makeup online Kenya, beauty products Kenya, makeup store Nairobi, professional makeup Nairobi')">
    <meta name="author" content="Zayn's Beauty">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <meta name="theme-color" content="#ec4899">

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', request()->url())">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical', request()->url())">
    <meta property="og:title" content="@yield('title', 'Zayn\'s Beauty - Premium Beauty Products & Professional Services')">
    <meta property="og:description" content="@yield('description', 'Discover premium beauty products, professional beauty services, and expert beauty consultations. Shop the latest trends in skincare, makeup, and beauty accessories.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-image.jpg'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Zayn's Beauty">
    <meta property="og:locale" content="en_US">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="@yield('canonical', request()->url())">
    <meta property="twitter:title" content="@yield('title', 'Zayn\'s Beauty - Premium Beauty Products & Professional Services')">
    <meta property="twitter:description" content="@yield('description', 'Discover premium beauty products, professional beauty services, and expert beauty consultations. Shop the latest trends in skincare, makeup, and beauty accessories.')">
    <meta property="twitter:image" content="@yield('og_image', asset('images/og-image.jpg'))">

    <!-- Additional SEO Meta Tags -->
    <meta name="geo.region" content="KE">
    <meta name="geo.placename" content="Kenya">
    <meta name="geo.position" content="@yield('geo_position', '')">
    <meta name="ICBM" content="@yield('icbm', '')">
    
    <!-- LocalBusiness Schema -->
    @php
        $s_phone     = \App\Models\Setting::get('contact_phone_primary', '');
        $s_email     = \App\Models\Setting::get('contact_email_primary', '');
        $s_address   = \App\Models\Setting::get('contact_address_full', '');
        $s_city      = \App\Models\Setting::get('contact_address_city', 'Nairobi');
        $s_instagram = \App\Models\Setting::get('social_instagram', '');
        $s_facebook  = \App\Models\Setting::get('social_facebook', '');
        $s_twitter   = \App\Models\Setting::get('social_twitter', '');
        $s_hours_wk  = \App\Models\Setting::get('business_hours_monday_friday', 'Mo-Fr 09:00-18:00');
        $s_hours_sat = \App\Models\Setting::get('business_hours_saturday', 'Sa 10:00-17:00');
        $s_sameAs    = array_filter([$s_instagram, $s_facebook, $s_twitter]);
    @endphp
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": ["BeautySalon", "Store"],
        "name": "Zayn's Beauty",
        "description": "Authentic makeup products, skincare and beauty supplies in Nairobi, Kenya. Shop online with same-day CBD delivery or book a professional makeup appointment.",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('logo.svg') }}",
        "image": "{{ asset('images/og-image.jpg') }}",
        @if($s_phone)"telephone": "{{ $s_phone }}",@endif
        @if($s_email)"email": "{{ $s_email }}",@endif
        "address": {
            "@@type": "PostalAddress",
            "streetAddress": "{{ $s_address }}",
            "addressLocality": "{{ $s_city }}",
            "addressRegion": "Nairobi County",
            "addressCountry": "KE"
        },
        "openingHoursSpecification": [
            {
                "@@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday"],
                "opens": "09:00",
                "closes": "18:00"
            },
            {
                "@@type": "OpeningHoursSpecification",
                "dayOfWeek": "Saturday",
                "opens": "10:00",
                "closes": "17:00"
            }
        ],
        "areaServed": {
            "@@type": "City",
            "name": "Nairobi"
        },
        "priceRange": "KES",
        "currenciesAccepted": "KES",
        "paymentAccepted": "Cash, Mobile Money",
        "hasMap": "https://maps.google.com/?q=Nairobi+Kenya",
        @if(count($s_sameAs))"sameAs": {{ json_encode(array_values($s_sameAs)) }}@endif
    }
    </script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional CSS for SEO enhancements -->
    <style>
        /* Breadcrumb styles */
        .breadcrumb {
            @apply text-sm text-gray-500 mb-4;
        }
        .breadcrumb a {
            @apply text-pink-600 hover:text-pink-700 transition-colors;
        }
        .breadcrumb span {
            @apply mx-2 text-gray-400;
        }
        
        /* Schema markup for products */
        .product-schema {
            display: none;
        }
        
        /* Hide scrollbar for horizontal scrolling categories */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* Internet Explorer 10+ */
            scrollbar-width: none;  /* Firefox */
        }
        .scrollbar-hide::-webkit-scrollbar { 
            display: none;  /* Safari and Chrome */
        }
    </style>

    @yield('head')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        @include('components.banner')
        @include('components.header')

        <!-- Breadcrumbs -->
        @if(View::hasSection('breadcrumbs'))
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    @yield('breadcrumbs')
                </nav>
            </div>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        @include('components.footer')
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-4 right-4 z-50 space-y-2 max-w-sm"></div>

    <!-- Structured Data for Current Page -->
    @yield('structured_data')

    <!-- Cart Count Script -->
    <script>
        // Toast notification function
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            
            // Set background color based on type
            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            
            toast.className = `${bgColor} text-white px-6 py-3 rounded-md shadow-lg transform translate-x-full transition-all duration-300 flex items-center space-x-2 opacity-90 hover:opacity-100`;
            toast.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' ? 
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                    }
                </svg>
                <span>${message}</span>
            `;
            
            container.appendChild(toast);
            
            // Animate in from right
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Auto-remove after 4 seconds (unless hovered)
            let autoRemoveTimeout = setTimeout(() => {
                if (!toast.matches(':hover')) {
                    removeToast(toast);
                }
            }, 4000);
            
            // Pause auto-remove on hover
            toast.addEventListener('mouseenter', () => {
                clearTimeout(autoRemoveTimeout);
            });
            
            // Resume auto-remove when mouse leaves
            toast.addEventListener('mouseleave', () => {
                autoRemoveTimeout = setTimeout(() => {
                    removeToast(toast);
                }, 2000);
            });
        }
        
        function removeToast(toast) {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }

        // Update cart count in header
        function updateCartCount() {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    const cartBadge = document.querySelector('.cart-count');
                    if (cartBadge) {
                        cartBadge.textContent = data.count;
                    }
                })
                .catch(error => {
                    console.error('Error updating cart count:', error);
                });
        }

        // Add to cart functionality
        function addToCart(productId, quantity = 1) {
            console.log('Adding to cart:', productId, quantity);
            
            // Validate productId
            if (!productId || productId === 'null' || productId === 'undefined') {
                console.error('Invalid product ID:', productId);
                showToast('Error: Invalid product ID', 'error');
                return;
            }
            
            const requestData = {
                product_id: productId,
                quantity: quantity
            };
            
            console.log('Request data:', requestData);
            
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                updateCartCount();
                
                // Trigger cart update event
                window.dispatchEvent(new Event('cartUpdated'));
                
                // Show toast message
                if (data.success) {
                    showToast(data.message || 'Product added to cart!', 'success');
                } else {
                    showToast(data.message || 'Error adding to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                showToast('Error adding to cart. Please try again.', 'error');
            });
        }

        // Add bundle to cart functionality
        function addBundleToCart(bundleId, quantity = 1) {
            console.log('Adding bundle to cart:', bundleId, quantity);
            
            // Validate bundleId
            if (!bundleId || bundleId === 'null' || bundleId === 'undefined') {
                console.error('Invalid bundle ID:', bundleId);
                showToast('Error: Invalid bundle ID', 'error');
                return;
            }
            
            const requestData = {
                bundle_id: bundleId,
                quantity: quantity
            };
            
            console.log('Request data:', requestData);
            
            fetch('/cart/add-bundle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(requestData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                updateCartCount();
                
                // Trigger cart update event
                window.dispatchEvent(new Event('cartUpdated'));
                
                // Show toast message
                if (data.success) {
                    showToast(data.message || 'Bundle added to cart!', 'success');
                } else {
                    showToast(data.message || 'Error adding bundle to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error adding bundle to cart:', error);
                showToast('Error adding bundle to cart. Please try again.', 'error');
            });
        }

        // Initialize cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });
    </script>

    @yield('scripts')
</body>
</html> 