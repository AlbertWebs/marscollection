@php
    $heroEnabled = \App\Models\Setting::get('hero_enabled', '1');
    $heroTitle = \App\Models\Setting::get('hero_title', 'Beauty, Curated For You');
    $heroSubtitle = \App\Models\Setting::get('hero_subtitle', 'Skincare, makeup & salon services — all in one place. Real products, real results.');
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
            <p class="text-pink-300 uppercase tracking-[0.25em] text-xs font-medium mb-6">Nairobi's Beauty Destination</p>

            <!-- Headline -->
            <h1 class="text-white font-bold leading-tight mb-6" style="font-size: clamp(2.5rem, 6vw, 4.5rem); line-height: 1.1;">
                {{ $heroTitle }}
            </h1>

            <!-- Subtitle -->
            <p class="text-gray-300 text-lg mb-10 leading-relaxed max-w-lg">
                {{ $heroSubtitle }}
            </p>

            <!-- CTAs -->
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('products.index') }}"
                   class="inline-block bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold tracking-wide uppercase px-8 py-4 rounded-lg transition-colors duration-200">
                    Shop Now
                </a>
                <a href="{{ route('appointments.create') }}"
                   class="inline-block border border-white/60 hover:border-white text-white text-sm font-semibold tracking-wide uppercase px-8 py-4 rounded-lg transition-colors duration-200 hover:bg-white/10">
                    Book Appointment
                </a>
            </div>

            <!-- Stats -->
            <div class="mt-16 flex gap-10">
                <div>
                    <div class="text-white text-2xl font-bold">{{ $heroStatsCustomers }}</div>
                    <div class="text-gray-400 text-xs uppercase tracking-wider mt-1">Happy Clients</div>
                </div>
                <div class="border-l border-white/20 pl-10">
                    <div class="text-white text-2xl font-bold">{{ $heroStatsProducts }}</div>
                    <div class="text-gray-400 text-xs uppercase tracking-wider mt-1">Products</div>
                </div>
                <div class="border-l border-white/20 pl-10">
                    <div class="text-white text-2xl font-bold">{{ $heroStatsRating }}★</div>
                    <div class="text-gray-400 text-xs uppercase tracking-wider mt-1">Avg. Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
