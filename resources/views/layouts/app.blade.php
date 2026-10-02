<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
    <title>@yield('title', 'Mars Collection | Shoes & Sneakers in Kenya')</title>
    <meta name="title" content="@yield('title', 'Mars Collection | Shoes & Sneakers in Kenya')">
    <meta name="description" content="@yield('description', 'Shop sneakers, everyday shoes and smart footwear at Mars Collection. Find your fit and order online in Kenya.')">
    <meta name="keywords" content="@yield('keywords', 'shoes Kenya, sneakers Nairobi, footwear Kenya, buy shoes online Kenya, Mars Collection')">
    <meta name="author" content="Mars Collection">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <meta name="theme-color" content="#0b0b0b">

    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', request()->url())">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical', request()->url())">
    <meta property="og:title" content="@yield('title', 'Mars Collection - Footwear for Every Move')">
    <meta property="og:description" content="@yield('description', 'Shop sneakers, smart classics and everyday footwear at Mars Collection.')">
    <meta property="og:image" content="@yield('og_image', asset('images/mars-footwear-hero.png'))">
    <meta property="og:image:alt" content="@yield('og_image_alt', 'Footwear from Mars Collection Kenya')">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Mars Collection">
    <meta property="og:locale" content="en_US">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="@yield('canonical', request()->url())">
    <meta name="twitter:title" content="@yield('title', 'Mars Collection | Shoes & Sneakers in Kenya')">
    <meta name="twitter:description" content="@yield('description', 'Shop sneakers, smart classics and everyday footwear at Mars Collection Kenya.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/mars-footwear-hero.png'))">
    <meta name="twitter:image:alt" content="@yield('og_image_alt', 'Footwear from Mars Collection Kenya')">

    <!-- Additional SEO Meta Tags -->
    <meta name="geo.region" content="KE">
    <meta name="geo.placename" content="Kenya">
    <meta name="geo.position" content="@yield('geo_position', '')">
    <meta name="ICBM" content="@yield('icbm', '')">

    <!-- Store schema -->
    @php
        $s_phone     = \App\Models\Setting::get('contact_phone_primary', '');
        $s_email     = \App\Models\Setting::get('contact_email_primary', '');
        $s_instagram = \App\Models\Setting::get('social_instagram', '');
        $s_facebook  = \App\Models\Setting::get('social_facebook', '');
        $s_twitter   = \App\Models\Setting::get('social_twitter', '');
        $s_tiktok    = \App\Models\Setting::get('social_tiktok', '');
        $s_sameAs    = array_values(array_filter([$s_facebook, $s_instagram, $s_twitter, $s_tiktok]));
        $storeUrl = route('home');
        $storeSchema = [
            '@context' => 'https://schema.org',
            '@id' => $storeUrl . '#store',
            '@type' => 'OnlineStore',
            'name' => 'Mars Collection',
            'description' => 'Shop sneakers, formal shoes and everyday footwear from Mars Collection in Kenya.',
            'url' => $storeUrl,
            'logo' => \App\Helpers\SettingsHelper::getBrandLogoUrl(),
            'image' => asset('images/mars-footwear-hero.png'),
            'areaServed' => ['@type' => 'Country', 'name' => 'Kenya'],
        ];
        $contactPoint = ['@type' => 'ContactPoint', 'contactType' => 'customer service'];
        if ($s_phone) $contactPoint['telephone'] = $s_phone;
        if ($s_email) $contactPoint['email'] = $s_email;
        if (count($contactPoint) > 2) $storeSchema['contactPoint'] = $contactPoint;
        if (count($s_sameAs)) $storeSchema['sameAs'] = array_values($s_sameAs);
    @endphp
    <script type="application/ld+json">@json($storeSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ \App\Helpers\SettingsHelper::getBrandFaviconUrl() }}">
    <link rel="apple-touch-icon" href="{{ \App\Helpers\SettingsHelper::getBrandFaviconUrl() }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional CSS for SEO enhancements -->
    <style>
        /* Breadcrumb styles */
        .breadcrumb {
            @apply text-sm text-gray-500 mb-4;
        }
        .breadcrumb a {
            @apply text-amber-600 hover:text-amber-700 transition-colors;
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

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        @include('components.footer')
    </div>

    <!-- WhatsApp Floating Inquiry Chat -->
    @include('components.whatsapp-floating')
    @include('components.floating-checkout')

    <!-- Toast Container -->
    <div id="toast-container" class="fixed bottom-4 left-4 z-50 space-y-2 max-w-sm"></div>

    <!-- Quick size picker used by product cards -->
    <div id="card-size-picker" class="fixed inset-0 z-[100010] hidden items-end justify-center bg-gray-950/60 p-0 opacity-0 backdrop-blur-sm transition-opacity duration-200 sm:items-center sm:p-4" aria-hidden="true">
        <button type="button" id="card-size-picker-backdrop" class="absolute inset-0 cursor-default" aria-label="Close size picker"></button>
        <section id="card-size-picker-panel" role="dialog" aria-modal="true" aria-labelledby="card-size-picker-title" class="relative z-10 w-full max-w-md translate-y-8 rounded-t-3xl bg-white p-6 shadow-2xl transition-transform duration-300 sm:translate-y-4 sm:rounded-3xl">
            <div class="mx-auto mb-5 h-1 w-10 rounded-full bg-gray-200 sm:hidden"></div>
            <div class="flex items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-amber-700">Quick add</p>
                    <h2 id="card-size-picker-title" class="mt-1 text-xl font-black text-gray-950">Choose your size</h2>
                    <p id="card-size-picker-product" class="mt-1 truncate text-sm text-gray-500"></p>
                </div>
                <button type="button" id="card-size-picker-close" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition hover:bg-gray-200" aria-label="Close size picker">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 6 12 12M18 6 6 18"/></svg>
                </button>
            </div>
            <div id="card-size-picker-options" class="mt-6 grid grid-cols-4 gap-2.5" aria-label="Available shoe sizes"></div>
            <p id="card-size-picker-stock-note" class="mt-3 text-xs text-gray-500">Tap a size to select it.</p>
            <button type="button" id="card-size-picker-add" disabled class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-full bg-gray-950 px-5 py-3.5 text-sm font-bold text-white shadow-lg transition hover:bg-amber-500 hover:text-gray-950 disabled:cursor-not-allowed disabled:bg-gray-200 disabled:text-gray-400 disabled:shadow-none">
                Add selected size to cart
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </button>
        </section>
    </div>

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
                    document.querySelectorAll('.cart-count').forEach(cartBadge => {
                        cartBadge.textContent = data.count;
                    });
                    window.dispatchEvent(new CustomEvent('cartCountChanged', { detail: { count: data.count } }));
                })
                .catch(error => {
                    console.error('Error updating cart count:', error);
                });
        }

        // Add to cart functionality
        function addToCart(productId, quantity = 1, color = null, size = null) {
            console.log('Adding to cart:', productId, quantity, color);

            // Validate productId
            if (!productId || productId === 'null' || productId === 'undefined') {
                console.error('Invalid product ID:', productId);
                showToast('Error: Invalid product ID', 'error');
                return;
            }

            const requestData = {
                product_id: productId,
                quantity: quantity,
                selected_color: color,
                selected_size: size
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
                return response.json().then(data => {
                    if (!response.ok) {
                        throw new Error(data.message || `Unable to add item (HTTP ${response.status})`);
                    }
                    return data;
                });
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
                showToast(error.message || 'Error adding to cart. Please try again.', 'error');
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

        // Card color selection helpers
        function selectCardColor(dot, name) {
            const container = dot.closest('.color-swatches-container');
            const card = dot.closest('article');
            const addBtn = card.querySelector('.card-add-btn');
            const label = container.querySelector('.selected-color-text');

            // Update button data attribute
            if (addBtn) addBtn.setAttribute('data-selected-color', name);
            if (label) label.textContent = name;

            // Reset all dots in this card
            container.querySelectorAll('.swatch-dot').forEach(d => {
                d.classList.remove('ring-2', 'ring-amber-400', 'ring-offset-1', 'scale-110');
            });

            // Highlight selected dot
            dot.classList.add('ring-2', 'ring-amber-400', 'ring-offset-1', 'scale-110');
        }

        function handleCardAddToCart(btn, productId) {
            const color = btn.getAttribute('data-selected-color');
            const card = btn.closest('article');
            const swatches = card.querySelector('.color-swatches-container');

            // If colors exist on card but none selected
            if (swatches && !color) {
                showToast('Please select a color first', 'error');
                swatches.classList.add('animate-pulse', 'bg-amber-50', 'rounded', 'p-1');
                setTimeout(() => swatches.classList.remove('animate-pulse', 'bg-amber-50'), 1500);
                return;
            }

            let sizes = [];
            let variantStock = {};
            try { sizes = JSON.parse(btn.dataset.sizeOptions || '[]'); } catch (_) {}
            try { variantStock = JSON.parse(btn.dataset.variantStock || '{}'); } catch (_) {}
            if (sizes.length) {
                openCardSizePicker(btn, productId, color, sizes, variantStock, Number(btn.dataset.baseStock || 0));
                return;
            }

            addToCart(productId, 1, color);
        }

        let cardSizeSelection = null;
        let cardSizePickerCloseTimer = null;
        function openCardSizePicker(button, productId, color, sizes, variantStock, baseStock) {
            const picker = document.getElementById('card-size-picker');
            const panel = document.getElementById('card-size-picker-panel');
            const options = document.getElementById('card-size-picker-options');
            const addButton = document.getElementById('card-size-picker-add');
            const stockNote = document.getElementById('card-size-picker-stock-note');
            const normalizedColor = (color || '').trim().toLowerCase();
            window.clearTimeout(cardSizePickerCloseTimer);
            cardSizeSelection = { productId, color, size: null, trigger: button };
            document.getElementById('card-size-picker-product').textContent = button.dataset.productName || '';
            options.replaceChildren();
            addButton.disabled = true;

            const hasInventory = Object.keys(variantStock || {}).length > 0;
            sizes.forEach(rawSize => {
                const size = String(rawSize).trim();
                if (!size) return;
                const sizeKey = size.toLowerCase();
                const stockKey = normalizedColor
                    ? `color:${normalizedColor}|size:${sizeKey}`
                    : `size:${sizeKey}`;
                const stock = hasInventory
                    ? Number(variantStock[stockKey] ?? 0)
                    : baseStock;
                const available = !hasInventory || stock > 0;
                const option = document.createElement('button');
                option.type = 'button';
                option.textContent = size;
                option.dataset.size = size;
                option.disabled = !available;
                option.setAttribute('aria-pressed', 'false');
                option.className = 'min-h-12 rounded-xl border px-3 py-2 text-sm font-bold transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-500';
                if (available) {
                    option.classList.add('border-gray-200', 'bg-white', 'text-gray-800', 'hover:border-amber-500', 'hover:bg-amber-50');
                    option.addEventListener('click', () => {
                        options.querySelectorAll('button').forEach(item => {
                            item.setAttribute('aria-pressed', 'false');
                            item.classList.remove('border-amber-500', 'bg-amber-400', 'text-gray-950', 'ring-2', 'ring-amber-200');
                            if (!item.disabled) item.classList.add('border-gray-200', 'bg-white', 'text-gray-800');
                        });
                        option.setAttribute('aria-pressed', 'true');
                        option.classList.remove('border-gray-200', 'bg-white', 'text-gray-800');
                        option.classList.add('border-amber-500', 'bg-amber-400', 'text-gray-950', 'ring-2', 'ring-amber-200');
                        cardSizeSelection.size = size;
                        addButton.disabled = false;
                        stockNote.textContent = hasInventory ? `${stock} available in this size.` : 'Size selected and ready to add.';
                    });
                } else {
                    option.classList.add('cursor-not-allowed', 'border-gray-100', 'bg-gray-50', 'text-gray-300', 'line-through');
                    option.title = 'Out of stock';
                    option.setAttribute('aria-label', `${size}, out of stock`);
                }
                options.appendChild(option);
            });

            stockNote.textContent = hasInventory ? 'Choose an in-stock size.' : 'Tap a size to select it.';
            picker.classList.remove('hidden');
            picker.classList.add('flex');
            picker.setAttribute('aria-hidden', 'false');
            document.body.classList.add('overflow-hidden');
            requestAnimationFrame(() => {
                picker.classList.remove('opacity-0');
                panel.classList.remove('translate-y-8', 'sm:translate-y-4');
                panel.querySelector('#card-size-picker-close').focus();
            });
        }

        function closeCardSizePicker() {
            const picker = document.getElementById('card-size-picker');
            const panel = document.getElementById('card-size-picker-panel');
            if (!picker || picker.classList.contains('hidden')) return;
            picker.classList.add('opacity-0');
            panel.classList.add('translate-y-8', 'sm:translate-y-4');
            picker.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('overflow-hidden');
            const trigger = cardSizeSelection?.trigger;
            cardSizePickerCloseTimer = window.setTimeout(() => {
                picker.classList.add('hidden'); picker.classList.remove('flex');
                trigger?.focus();
            }, 220);
        }

        document.getElementById('card-size-picker-close').addEventListener('click', closeCardSizePicker);
        document.getElementById('card-size-picker-backdrop').addEventListener('click', closeCardSizePicker);
        document.getElementById('card-size-picker-add').addEventListener('click', () => {
            if (!cardSizeSelection?.size) return;
            const { productId, color, size } = cardSizeSelection;
            closeCardSizePicker();
            addToCart(productId, 1, color, size);
        });
        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') closeCardSizePicker();
        });

        // Initialize cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });
    </script>

    @yield('scripts')
    <script>
        (() => {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrf) return;
            const heartbeat = () => fetch('{{ route('traffic.heartbeat') }}', {
                method: 'POST',
                credentials: 'same-origin',
                keepalive: true,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ path: window.location.pathname })
            }).catch(() => {});
            heartbeat();
            window.setInterval(heartbeat, 60000);
        })();
    </script>
</body>
</html>
