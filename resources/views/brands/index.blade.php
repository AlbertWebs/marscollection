@extends('layouts.app')

@section('title', 'Shoe Brands in Kenya | Mars Collection')
@section('description', 'Shop footwear by brand at Mars Collection Kenya. Browse available shoe labels, compare styles and find your next pair.')
@section('keywords', 'shoe brands Kenya, footwear brands Nairobi, buy branded shoes Kenya, Mars Collection')
@section('canonical', route('brands.index'))
@section('og_type', 'website')
@section('og_image', asset('images/mars-footwear-hero.png'))
@if($brands->isEmpty()) @section('robots', 'noindex, follow') @endif
@php
    $brandCollectionSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => 'Shoe Brands in Kenya | Mars Collection',
        'description' => 'Browse footwear brands and shop available styles at Mars Collection Kenya.',
        'url' => route('brands.index'),
        'mainEntity' => [
            '@type' => 'ItemList',
            'itemListElement' => $brands->values()->map(fn ($brand, $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $brand->name,
                'url' => route('brands.show', $brand),
            ])->all(),
        ],
    ];
    $brandLetters = $brands->map(fn ($brand) => mb_strtoupper(mb_substr($brand->name, 0, 1)))->unique()->sort()->values();
@endphp
@section('structured_data')
<script type="application/ld+json">@json($brandCollectionSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endsection

@section('content')
<section class="relative isolate overflow-hidden bg-gray-950 text-white">
    <div class="absolute inset-0 -z-10 bg-cover bg-center opacity-30" style="background-image: url('{{ asset('images/mars-footwear-hero.png') }}')"></div>
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-gray-950 via-gray-950/90 to-gray-950/45"></div>
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-20 lg:px-8 lg:py-24">
        <nav aria-label="Breadcrumb" class="mb-8 flex items-center gap-2 text-xs font-medium text-gray-300"><a href="{{ route('home') }}" class="transition hover:text-white">Home</a><span class="text-amber-400">/</span><span class="text-white">Brands</span></nav>
        <div class="max-w-2xl">
            <p class="inline-flex items-center gap-2 rounded-full border border-amber-300/30 bg-amber-300/10 px-3 py-1.5 text-[10px] font-extrabold uppercase tracking-[0.2em] text-amber-300"><span class="h-1.5 w-1.5 rounded-full bg-amber-300"></span>Find your kind of shoe</p>
            <h1 class="mt-5 text-4xl font-black tracking-tight sm:text-5xl lg:text-6xl">Good shoes.<br><span class="text-amber-300">Great names.</span></h1>
            <p class="mt-5 max-w-xl text-sm leading-7 text-gray-300 sm:text-base">Explore the labels we love, then head straight to the styles available in your size.</p>
            <div class="mt-8 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-300"><span><strong class="text-white">{{ $brands->count() }}</strong> {{ Str::plural('brand', $brands->count()) }}</span><span class="h-1 w-1 rounded-full bg-amber-300" aria-hidden="true"></span><span>Curated footwear, all in one place</span></div>
        </div>
    </div>
    <div class="absolute bottom-0 right-0 -z-10 hidden h-72 w-72 translate-x-1/4 translate-y-1/3 rounded-full border border-white/10 lg:block"></div>
</section>

<section class="bg-[#f7f6f3] py-10 sm:py-14">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @if($brands->isNotEmpty())
            <div class="mb-7 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div><p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-800">The brand directory</p><h2 class="mt-1 text-2xl font-black tracking-tight text-gray-950 sm:text-3xl">Shop by brand</h2><p class="mt-2 text-sm text-gray-500">Choose a brand to browse its available shoes.</p></div>
                <div class="w-full lg:max-w-sm">
                    <label for="brand-search" class="sr-only">Search brands</label>
                    <div class="relative">
                        <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="m16 16 5 5"/></svg>
                        <input id="brand-search" type="search" autocomplete="off" placeholder="Search {{ $brands->count() }} brands…" class="w-full rounded-2xl border border-gray-200 bg-white py-3.5 pl-12 pr-4 text-sm shadow-sm outline-none transition placeholder:text-gray-400 focus:border-amber-400 focus:ring-4 focus:ring-amber-100">
                    </div>
                </div>
            </div>

            @if($brandLetters->count() > 1)
                <div class="mb-8 flex items-center gap-2 overflow-x-auto pb-2 scrollbar-hide" aria-label="Jump to brand letter">
                    <span class="mr-1 shrink-0 text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Jump to</span>
                    @foreach($brandLetters as $letter)
                        <button type="button" data-brand-letter="{{ $letter }}" class="brand-letter-button flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-gray-200 bg-white text-xs font-bold text-gray-600 transition hover:border-gray-950 hover:bg-gray-950 hover:text-white focus:outline-none focus:ring-4 focus:ring-amber-100">{{ $letter }}</button>
                    @endforeach
                    <button type="button" id="brand-clear-filter" class="ml-auto shrink-0 px-2 py-2 text-xs font-bold text-amber-800 underline decoration-amber-300 underline-offset-4 transition hover:text-amber-950">Show all</button>
                </div>
            @endif

            <div class="mb-4 flex items-center justify-between gap-3"><p id="brand-results" class="text-xs font-semibold text-gray-500">Showing {{ $brands->count() }} {{ Str::plural('brand', $brands->count()) }}</p><span class="hidden text-[10px] font-bold uppercase tracking-widest text-gray-400 sm:inline">Mars Collection · Kenya</span></div>
            <div id="brand-grid" class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-5 lg:grid-cols-4 xl:grid-cols-5">
                @foreach($brands as $brand)
                    @php $logoUrl = $brand->logo ? \App\Helpers\ImageHelper::getProductImageUrl($brand->logo) : null; @endphp
                    <a href="{{ route('brands.show', $brand) }}" data-brand-name="{{ mb_strtolower($brand->name) }}" data-brand-letter="{{ mb_strtoupper(mb_substr($brand->name, 0, 1)) }}" class="brand-card group overflow-hidden rounded-2xl border border-gray-200/80 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-amber-300 hover:shadow-xl hover:shadow-gray-900/10 focus:outline-none focus:ring-4 focus:ring-amber-100">
                        <div class="relative flex aspect-[1.2/1] items-center justify-center overflow-hidden bg-gradient-to-br from-gray-50 via-white to-amber-50/70 p-5 sm:p-7">
                            <div class="absolute inset-0 opacity-[0.035]" style="background-image: radial-gradient(#111827 0.7px, transparent 0.7px); background-size: 12px 12px"></div>
                            @if($logoUrl)
                                <img src="{{ $logoUrl }}" alt="{{ $brand->name }} logo" class="relative z-10 max-h-full max-w-full object-contain transition duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                            @else
                                <span class="relative z-10 flex h-20 w-20 items-center justify-center rounded-3xl bg-gray-950 text-2xl font-black uppercase tracking-tight text-amber-300 shadow-lg shadow-gray-900/15">{{ mb_strtoupper(mb_substr($brand->name, 0, 2)) }}</span>
                            @endif
                            <span class="absolute right-3 top-3 rounded-full border border-white/80 bg-white/90 px-2.5 py-1 text-[10px] font-bold text-gray-500 shadow-sm">{{ $brand->products_count }} {{ \Illuminate\Support\Str::plural('style', $brand->products_count) }}</span>
                        </div>
                        <div class="flex items-center justify-between gap-2 border-t border-gray-100 px-4 py-4 sm:px-5">
                            <div class="min-w-0"><h3 class="truncate text-sm font-extrabold text-gray-950 sm:text-base">{{ $brand->name }}</h3><p class="mt-0.5 text-[11px] font-medium text-gray-500">Explore the collection</p></div>
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition group-hover:bg-amber-400 group-hover:text-gray-950" aria-hidden="true"><svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 12h14m-6-6 6 6-6 6"/></svg></span>
                        </div>
                    </a>
                @endforeach
            </div>
            <div id="brand-no-results" class="hidden rounded-3xl border border-dashed border-gray-300 bg-white px-6 py-14 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 text-amber-800"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="10.8" cy="10.8" r="6.8" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="m16 16 5 5M8 11h6"/></svg></span>
                <h3 class="mt-4 text-lg font-extrabold text-gray-950">No brands found</h3><p class="mt-1 text-sm text-gray-500">Try another name or clear your search.</p><button type="button" id="brand-empty-reset" class="mt-5 rounded-full bg-gray-950 px-5 py-2.5 text-xs font-bold text-white transition hover:bg-amber-600 hover:text-gray-950">Show all brands</button>
            </div>
        @else
            <div class="rounded-3xl border border-gray-200 bg-white px-6 py-16 text-center shadow-sm"><span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 text-amber-800"><svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg></span><h2 class="mt-4 text-lg font-extrabold text-gray-950">New labels are on the way</h2><p class="mt-1 text-sm text-gray-500">There are no active brands to show right now. Check back soon.</p><a href="{{ route('products.index') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-amber-800 hover:text-amber-950">Browse all shoes <span aria-hidden="true">→</span></a></div>
        @endif
    </div>
</section>
@endsection

@section('scripts')
<script>
(() => {
    const search = document.getElementById('brand-search');
    const cards = Array.from(document.querySelectorAll('.brand-card'));
    if (!search || cards.length === 0) return;

    const grid = document.getElementById('brand-grid');
    const result = document.getElementById('brand-results');
    const empty = document.getElementById('brand-no-results');
    const letters = document.querySelectorAll('.brand-letter-button');
    let activeLetter = '';
    const clear = () => {
        search.value = '';
        activeLetter = '';
        letters.forEach(button => button.classList.remove('border-gray-950', 'bg-gray-950', 'text-white'));
        update();
        search.focus();
    };
    function update() {
        const query = search.value.trim().toLocaleLowerCase();
        let visible = 0;
        cards.forEach(card => {
            const matches = card.dataset.brandName.includes(query) && (!activeLetter || card.dataset.brandLetter === activeLetter);
            card.classList.toggle('hidden', !matches);
            if (matches) visible++;
        });
        grid.classList.toggle('hidden', visible === 0);
        empty.classList.toggle('hidden', visible !== 0);
        result.textContent = `Showing ${visible} ${visible === 1 ? 'brand' : 'brands'}`;
    }

    search.addEventListener('input', update);
    letters.forEach(button => button.addEventListener('click', () => {
        const selected = activeLetter === button.dataset.brandLetter ? '' : button.dataset.brandLetter;
        activeLetter = selected;
        letters.forEach(item => item.classList.toggle('border-gray-950', item.dataset.brandLetter === selected));
        letters.forEach(item => item.classList.toggle('bg-gray-950', item.dataset.brandLetter === selected));
        letters.forEach(item => item.classList.toggle('text-white', item.dataset.brandLetter === selected));
        update();
    }));
    document.getElementById('brand-clear-filter')?.addEventListener('click', clear);
    document.getElementById('brand-empty-reset')?.addEventListener('click', clear);
})();
</script>
@endsection
