@extends('layouts.app')

@php
    $aboutTitle = 'Mars Collection Kenya | Our Story, Shoes & Footwear Categories';
    $aboutDescription = 'Get to know Mars Collection, a Kenyan footwear store for sneakers, formal shoes, loafers, flats, sandals and boots. Explore the story and shop by category.';
    $sameAs = array_values(array_filter([
        $brandDetails['facebook'] ?? null,
        $brandDetails['instagram'] ?? null,
        $brandDetails['twitter'] ?? null,
    ]));
    $aboutSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'AboutPage',
        'name' => 'About Mars Collection Kenya',
        'description' => $aboutDescription,
        'url' => route('about'),
        'mainEntity' => [
            '@type' => 'OnlineStore',
            '@id' => url('/#store'),
            'name' => 'Mars Collection',
            'url' => url('/'),
            'description' => 'A footwear store in Kenya offering sneakers, formal shoes, loafers, flats, sandals and boots.',
            'logo' => asset('mars-collections-logo.png'),
            'areaServed' => ['@type' => 'Country', 'name' => 'Kenya'],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'telephone' => $brandDetails['phone'] ?? '0726243706',
                'email' => $brandDetails['email'] ?? 'info@marscollection.co.ke',
            ],
        ],
    ];
    if ($sameAs) $aboutSchema['mainEntity']['sameAs'] = $sameAs;
@endphp

@section('title', $aboutTitle)
@section('description', $aboutDescription)
@section('keywords', 'Mars Collection, Mars Collection Kenya, Mars Collection shoes, shoes Kenya, footwear Kenya, sneakers Kenya, formal shoes Kenya')
@section('canonical', route('about'))
@section('og_type', 'website')
@section('og_image', asset('images/mars-footwear-hero.png'))

@section('structured_data')
    <script type="application/ld+json">@json($aboutSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endsection

@section('content')
<div class="bg-[#f8f7f4] text-gray-950">
    <section class="relative isolate overflow-hidden bg-gray-950 text-white">
        <div class="absolute inset-0 -z-10" aria-hidden="true">
            <img src="{{ asset('images/mars-footwear-hero.png') }}" alt="" class="h-full w-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-950 via-gray-950/90 to-gray-950/55"></div>
        </div>
        <div class="mx-auto max-w-7xl px-4 pb-16 pt-8 sm:px-6 md:pb-24 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-12">
                <ol class="flex items-center gap-2 text-xs font-medium text-gray-400">
                    <li><a href="{{ route('home') }}" class="transition hover:text-amber-300">Home</a></li>
                    <li aria-hidden="true" class="text-gray-600">/</li>
                    <li aria-current="page" class="text-amber-200">About Mars Collection</li>
                </ol>
            </nav>
            <div class="max-w-3xl">
                <p class="inline-flex items-center gap-2 rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1.5 text-[11px] font-bold uppercase tracking-[0.2em] text-amber-200">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-300"></span> Mars Collection · Kenya
                </p>
                <h1 class="mt-6 text-4xl font-black leading-[1.05] tracking-tight sm:text-5xl md:text-6xl">Mars Collection: footwear for wherever you’re headed.</h1>
                <p class="mt-6 max-w-2xl text-base leading-7 text-gray-300 sm:text-lg sm:leading-8">We bring shoes for different days and different ways of dressing together in one place. Explore sneakers, formal shoes, loafers, flats, sandals and boots from Mars Collection Kenya.</p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="#shop-categories" class="inline-flex items-center justify-center gap-2 rounded-full bg-amber-400 px-6 py-3 text-sm font-bold text-gray-950 shadow-lg shadow-amber-950/20 transition hover:bg-amber-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-300">
                        Explore shoe categories <span aria-hidden="true">↓</span>
                    </a>
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 px-6 py-3 text-sm font-semibold text-white transition hover:border-white/50 hover:bg-white/5">Talk to our team</a>
                </div>
            </div>
            <div class="mt-12 grid max-w-3xl grid-cols-3 border-t border-white/15 pt-5 text-xs text-gray-300 sm:mt-16 sm:pt-6 sm:text-sm">
                <div><span class="block text-lg font-bold text-white sm:text-xl">{{ $categories->count() }}</span> footwear categories</div>
                <div class="border-l border-white/15 pl-4 sm:pl-6"><span class="block text-lg font-bold text-white sm:text-xl">Kenya</span> local store</div>
                <div class="border-l border-white/15 pl-4 sm:pl-6"><span class="block text-lg font-bold text-white sm:text-xl">Your pace</span> your pair</div>
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 md:grid-cols-[0.8fr_1.2fr] md:gap-16 md:py-24 lg:px-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-700">The Mars Collection story</p>
            <h2 class="mt-4 text-3xl font-black leading-tight tracking-tight sm:text-4xl">A good pair belongs in your everyday.</h2>
        </div>
        <div class="space-y-5 text-base leading-8 text-gray-600">
            <p><strong class="font-semibold text-gray-950">Mars Collection is a footwear store in Kenya</strong>, bringing a range of styles together so it’s easier to find a pair that suits the occasion, your wardrobe and your day.</p>
            <p>Some days call for sneakers. Others need a sharper formal shoe, an easy loafer or a comfortable flat. Our collection also includes sandals and boots, giving you different options to browse from one place.</p>
            <p>We keep the shopping journey straightforward: explore by category, open a product to check its available options, and reach out if you need help with a product or your order. That’s the Mars Collection approach: useful footwear, clearly presented, for life on the move.</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 font-semibold text-amber-800 underline decoration-amber-300 underline-offset-4 transition hover:text-amber-950">Contact Mars Collection <span aria-hidden="true">→</span></a>
        </div>
    </section>

    <section id="shop-categories" class="border-y border-gray-200 bg-white py-16 sm:py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-9 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
                <div class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-700">Shop Mars Collection</p>
                    <h2 class="mt-3 text-3xl font-black tracking-tight sm:text-4xl">Find your style, category by category.</h2>
                    <p class="mt-3 leading-7 text-gray-600">Browse the Mars Collection footwear range and go straight to the styles you’re looking for.</p>
                </div>
                <a href="{{ route('products.index') }}" class="inline-flex shrink-0 items-center gap-2 text-sm font-bold text-gray-900 transition hover:text-amber-700">View all shoes <span aria-hidden="true">→</span></a>
            </div>

            <div class="grid grid-cols-2 gap-3 sm:gap-4 md:grid-cols-3">
                @forelse($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group relative isolate min-h-52 overflow-hidden rounded-2xl bg-gray-950 sm:min-h-64">
                        <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($category->image) }}" alt="{{ $category->name }} at Mars Collection Kenya" loading="lazy" class="absolute inset-0 -z-20 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-950 via-gray-950/30 to-transparent transition group-hover:from-gray-950/95"></div>
                        <div class="absolute inset-x-0 bottom-0 p-4 sm:p-5">
                            <div class="flex items-end justify-between gap-2">
                                <div>
                                    <h3 class="text-lg font-bold text-white sm:text-xl">{{ $category->name }}</h3>
                                    <p class="mt-1 text-xs text-gray-300">{{ number_format($category->products_count) }} {{ \Illuminate\Support\Str::plural('style', $category->products_count) }} to explore</p>
                                </div>
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-white/30 bg-white/10 text-white backdrop-blur-sm transition group-hover:border-amber-300 group-hover:bg-amber-400 group-hover:text-gray-950" aria-hidden="true">→</span>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full rounded-2xl border border-dashed border-gray-300 bg-gray-50 p-8 text-center text-gray-600">New footwear categories are on the way. Browse all available shoes in the meantime.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-8 px-4 py-16 sm:px-6 md:grid-cols-3 lg:px-8">
        <article class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-7">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 12h16M4 12l5-5m-5 5 5 5m11-5-5-5m5 5-5 5"/></svg></span>
            <h3 class="mt-5 text-lg font-bold">A range for real days</h3>
            <p class="mt-2 text-sm leading-6 text-gray-600">Move from everyday sneakers to occasion-ready shoes and relaxed slip-ons with categories that make browsing simpler.</p>
        </article>
        <article class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-7">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3 4 7v5c0 5 3.4 8 8 9 4.6-1 8-4 8-9V7l-8-4Z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m9 12 2 2 4-4"/></svg></span>
            <h3 class="mt-5 text-lg font-bold">Clear product details</h3>
            <p class="mt-2 text-sm leading-6 text-gray-600">Check product information and available options on each listing, then contact us if you need a hand before ordering.</p>
        </article>
        <article class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-7">
            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5h18v14H3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m3 7 9 6 9-6"/></svg></span>
            <h3 class="mt-5 text-lg font-bold">Here when you need us</h3>
            <p class="mt-2 text-sm leading-6 text-gray-600">Have a question about Mars Collection or a product? Our team is available by phone and email.</p>
            <div class="mt-4 space-y-1 text-sm font-semibold text-gray-900">
                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $brandDetails['phone'] ?? '0726243706') }}" class="block hover:text-amber-800">{{ $brandDetails['phone'] ?? '0726243706' }}</a>
                <a href="mailto:{{ $brandDetails['email'] ?? 'info@marscollection.co.ke' }}" class="block break-all hover:text-amber-800">{{ $brandDetails['email'] ?? 'info@marscollection.co.ke' }}</a>
            </div>
        </article>
    </section>

    <section class="bg-gray-950 px-4 py-14 text-center text-white sm:px-6 sm:py-16">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-300">Mars Collection · Kenya</p>
        <h2 class="mx-auto mt-3 max-w-2xl text-3xl font-black tracking-tight sm:text-4xl">Your next pair is waiting to be found.</h2>
        <p class="mx-auto mt-4 max-w-xl text-sm leading-6 text-gray-400">Explore the collection or get in touch with the Mars Collection team.</p>
        <div class="mt-7 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('products.index') }}" class="rounded-full bg-amber-400 px-6 py-3 text-sm font-bold text-gray-950 transition hover:bg-amber-300">Shop all footwear</a>
            <a href="{{ route('contact') }}" class="rounded-full border border-white/20 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/5">Contact us</a>
        </div>
    </section>
</div>
@endsection
