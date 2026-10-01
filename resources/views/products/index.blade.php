@extends('layouts.app')

@php
    $pageCategory = $selectedCategory ?? null;
    $pageBrand = $selectedBrand ?? null;
    $listingTitle = $pageCategory
        ? $pageCategory->name . ' in Kenya | Mars Collection'
        : ($pageBrand
            ? $pageBrand->name . ' Shoes in Kenya | Mars Collection'
            : 'Shop Shoes & Sneakers in Kenya | Mars Collection');
    $listingDescription = $pageCategory
        ? \Illuminate\Support\Str::limit(trim(($pageCategory->description ? $pageCategory->description . ' ' : '') . 'Shop ' . strtolower($pageCategory->name) . ' in Kenya at Mars Collection. Browse available styles, compare prices and order online with delivery across Kenya.'), 155, '')
        : ($pageBrand
            ? \Illuminate\Support\Str::limit(trim(($pageBrand->description ? $pageBrand->description . ' ' : '') . 'Shop ' . $pageBrand->name . ' footwear in Kenya at Mars Collection. Compare available styles and order online.'), 155, '')
            : 'Shop shoes and sneakers at Mars Collection Kenya. Browse formal shoes, sneakers, loafers, flats, sandals and boots, then order online.');
    $listingKeywords = $pageCategory
        ? strtolower($pageCategory->name) . ' Kenya, buy ' . strtolower($pageCategory->name) . ' online, ' . strtolower($pageCategory->name) . ' Nairobi, Mars Collection'
        : ($pageBrand
            ? strtolower($pageBrand->name) . ' shoes Kenya, buy ' . strtolower($pageBrand->name) . ' online, ' . strtolower($pageBrand->name) . ' Nairobi'
            : 'shoes Kenya, sneakers Nairobi, footwear online Kenya, Mars Collection');
    $listingCanonical = $pageCategory
        ? route('categories.show', $pageCategory)
        : ($pageBrand
            ? route('brands.show', $pageBrand)
            : route('products.index'));
    if (request()->filled('page') && (int) request('page') > 1) {
        $listingCanonical .= '?page=' . (int) request('page');
    }
    $hasExtraFilters = request()->hasAny(['search', 'min_price', 'max_price', 'sort', 'tag'])
        || ($pageCategory && $pageBrand)
        || (!$pageCategory && request()->filled('category'))
        || (!$pageBrand && request()->filled('brand'))
        || $products->total() === 0;
    $breadcrumbItems = [
        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Shoes', 'item' => route('products.index')],
    ];
    if ($pageCategory || $pageBrand) {
        $breadcrumbItems[] = [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => $pageCategory?->name ?? $pageBrand->name,
            'item' => $listingCanonical,
        ];
    }
@endphp
@section('title', $listingTitle)
@section('description', $listingDescription)
@section('keywords', $listingKeywords)
@section('canonical', $listingCanonical)
@if($hasExtraFilters) @section('robots', 'noindex, follow') @endif

@section('og_type', 'website')
@section('og_image', asset('images/mars-footwear-hero.png'))

@section('structured_data')
@php
    $collectionSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $pageCategory ? $pageCategory->name . ' | Mars Collection' : ($pageBrand ? $pageBrand->name . ' Shoes | Mars Collection' : 'Shoes & Footwear | Mars Collection'),
        'description' => $listingDescription,
        'url' => $listingCanonical,
        'mainEntity' => [
            '@type' => 'ItemList',
            'numberOfItems' => $products->count(),
            'itemListElement' => $products->values()->map(fn ($product, $index) => [
                '@type' => 'ListItem',
                'position' => ($products->firstItem() ?? 1) + $index,
                'name' => $product->name,
                'url' => route('products.show', $product),
            ])->all(),
        ],
    ];
@endphp
<script type="application/ld+json">@json($collectionSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
<script type="application/ld+json">@json(['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $breadcrumbItems], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endsection

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <nav aria-label="Breadcrumb" class="mb-6">
            <ol class="flex flex-wrap items-center gap-2 text-sm">
                <li><a href="{{ route('home') }}" class="font-medium text-gray-500 transition-colors hover:text-amber-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-amber-600 rounded-sm">Home</a></li>
                <li aria-hidden="true" class="text-gray-300"><svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 0 1 .02-1.06L10.94 10 7.23 6.29a.75.75 0 1 1 1.06-1.06l4.24 4.24a.75.75 0 0 1 0 1.06l-4.24 4.24a.75.75 0 0 1-1.08 0Z" clip-rule="evenodd"/></svg></li>
                <li><a href="{{ route('products.index') }}" class="font-medium text-gray-500 transition-colors hover:text-amber-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-amber-600 rounded-sm">Shoes</a></li>
                @if($pageCategory)
                    <li aria-hidden="true" class="text-gray-300"><svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 0 1 .02-1.06L10.94 10 7.23 6.29a.75.75 0 1 1 1.06-1.06l4.24 4.24a.75.75 0 0 1 0 1.06l-4.24 4.24a.75.75 0 0 1-1.08 0Z" clip-rule="evenodd"/></svg></li>
                    <li aria-current="page"><span class="inline-flex items-center rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-900">{{ $pageCategory->name }}</span></li>
                @elseif($pageBrand)
                    <li aria-hidden="true" class="text-gray-300"><span>/</span></li>
                    <li aria-current="page"><span class="inline-flex items-center rounded-full border border-amber-200 bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-900">{{ $pageBrand->name }}</span></li>
                @else
                    <li aria-current="page"><span class="font-semibold text-gray-900">All products</span></li>
                @endif
            </ol>
        </nav>
        <!-- Page Header -->
        <div class="mb-8">
            @if(request('tag') === 'featured')
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Featured Products</h1>
                <p class="text-gray-600">Discover footwear selected for everyday style and comfort</p>
            @elseif(request('tag') === 'trending')
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Trending Products</h1>
                <p class="text-gray-600">Most popular products loved by our customers</p>
            @elseif($pageCategory)
                <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $pageCategory->name }} in Kenya</h1>
                <p class="max-w-2xl text-gray-600">{{ $listingDescription }}</p>
            @elseif($pageBrand)
                <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $pageBrand->name }} Shoes in Kenya</h1>
                <p class="max-w-2xl text-gray-600">{{ $listingDescription }}</p>
            @else
                <h1 class="text-3xl font-bold text-gray-900 mb-4">All Products</h1>
                <p class="text-gray-600">Browse sneakers, smart classics and everyday footwear</p>
            @endif
        </div>

        <!-- Mobile Filter Toggle -->
        <div class="lg:hidden mb-6">
            <button id="mobile-filter-toggle" class="w-full bg-amber-600 text-white px-4 py-3 rounded-md hover:bg-amber-700 transition-colors font-semibold flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filters
                <svg id="filter-arrow" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
            <!-- Sidebar Filters -->
            <div class="lg:col-span-1">
                <div id="mobile-filters" class="hidden lg:block">
                    @include('components.product-filters')
                </div>
            </div>

            <div class="lg:col-span-3">
                @if($products->count() > 0)
                    <div class="mb-6">
                        <p class="text-gray-600">Showing {{ $products->count() }} of {{ $products->total() }} products</p>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 xl:gap-4">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
    const mobileFilters = document.getElementById('mobile-filters');
    const filterArrow = document.getElementById('filter-arrow');

    if (mobileFilterToggle && mobileFilters && filterArrow) {
        mobileFilterToggle.addEventListener('click', function() {
            const isHidden = mobileFilters.classList.contains('hidden');

            if (isHidden) {
                // Show filters
                mobileFilters.classList.remove('hidden');
                filterArrow.style.transform = 'rotate(180deg)';
            } else {
                // Hide filters
                mobileFilters.classList.add('hidden');
                filterArrow.style.transform = 'rotate(0deg)';
            }
        });
    }
});
</script>
@endsection
