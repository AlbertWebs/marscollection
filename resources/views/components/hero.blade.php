@php
    $heroEnabled = \App\Models\Setting::get('hero_enabled', '1');
    $heroTitle = \App\Models\Setting::get('hero_title', 'Beauty, Curated For You');
    $heroSubtitle = \App\Models\Setting::get('hero_subtitle', 'Skincare, makeup & salon services, all in one place. Real products, real results.');
    $heroImage = \App\Models\Setting::get('hero_image', 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?auto=format&fit=crop&w=1600&q=85');
    $heroStatsCustomers = \App\Models\Setting::get('hero_stats_customers', '500+');
    $heroStatsProducts = \App\Models\Setting::get('hero_stats_products', '100+');
    $heroStatsRating = \App\Models\Setting::get('hero_stats_rating', '4.9');
@endphp

@if($heroEnabled)
<section class="relative w-full overflow-hidden" style="min-height: 90vh;">
    <!-- Background image with dark overlay -->
    <div class="absolute inset-0">
        <img src="{{ $heroImage }}"
             alt="Zayn's Beauty"
             class="w-full h-full object-cover object-center">
        <div class="absolute inset-0 bg-black/35"></div>
    </div>

    <!-- Content -->
    <div class="relative h-full container mx-auto px-6 lg:px-12 flex items-center" style="min-height: 90vh;">
        <div class="max-w-2xl py-24">

            <!-- Tag line -->
            <p class="text-pink-300 uppercase tracking-[0.25em] text-xs font-medium mb-6 hero-item" style="--delay:0ms">Nairobi's Beauty Destination</p>

            <!-- Headline -->
            <h1 class="text-white font-bold leading-tight mb-6 hero-item" style="font-size: clamp(2.5rem, 6vw, 4.5rem); line-height: 1.1; --delay:120ms">
                {{ $heroTitle }}
            </h1>

            <!-- Subtitle -->
            <p class="text-gray-300 text-lg mb-10 leading-relaxed max-w-lg hero-item" style="--delay:260ms">
                {{ $heroSubtitle }}
            </p>

            <!-- CTAs -->
            <div class="flex flex-col sm:flex-row gap-4 hero-item" style="--delay:380ms">
                <a href="{{ route('products.index') }}"
                   class="inline-block bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold tracking-wide uppercase px-8 py-4 rounded-md transition-colors duration-200">
                    Shop Now
                </a>
                <a href="{{ route('appointments.create') }}"
                   class="inline-block border border-white/60 hover:border-white text-white text-sm font-semibold tracking-wide uppercase px-8 py-4 rounded-md transition-colors duration-200 hover:bg-white/10">
                    Book Makeup Session
                </a>
            </div>

            <!-- Stats -->
            <div class="mt-16 flex gap-10 hero-item" style="--delay:500ms">
                <div>
                    <div class="text-white text-2xl font-bold">{{ $heroStatsCustomers }}</div>
                    <div class="text-gray-400 text-xs uppercase tracking-wider mt-1">Happy Clients</div>
                </div>
                <div class="border-l border-white/20 pl-10">
                    <div class="text-white text-2xl font-bold">{{ $heroStatsProducts }}</div>
                    <div class="text-gray-400 text-xs uppercase tracking-wider mt-1">Products</div>
                </div>
                <div class="border-l border-white/20 pl-10">
                    <div class="flex items-center gap-2 text-white text-2xl font-bold">
                        <span>{{ $heroStatsRating }}</span>
                        <span class="flex items-center gap-1" aria-hidden="true">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.95-.69l1.07-3.292z"></path>
                            </svg>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.539 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.783.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81H7.03a1 1 0 00.95-.69l1.07-3.292z"></path>
                            </svg>
                        </span>
                    </div>
                    <div class="text-gray-400 text-xs uppercase tracking-wider mt-1">Avg. Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
