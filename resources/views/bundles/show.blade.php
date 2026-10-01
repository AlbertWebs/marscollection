@extends('layouts.app')

@php
    $bundleDescription = \Illuminate\Support\Str::limit(trim(strip_tags($bundle->description ?: ($bundle->name . ' footwear bundle from Mars Collection Kenya.'))), 155);
    $bundleImage = \App\Helpers\ImageHelper::getProductImageUrl($bundle->image);
    $bundleUrl = route('bundles.show', $bundle);
    $bundleIsInStock = $bundle->products->isNotEmpty()
        && $bundle->products->every(fn ($product) => $product->stock_quantity > 0);
    $bundleSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Product',
        'name' => $bundle->name,
        'description' => $bundleDescription,
        'image' => $bundleImage,
        'url' => $bundleUrl,
        'category' => $bundle->category ?: 'Footwear bundle',
        'brand' => ['@type' => 'Brand', 'name' => 'Mars Collection'],
    ];
    if (is_numeric($bundle->price) && (float) $bundle->price > 0) {
        $bundleSchema['offers'] = [
            '@type' => 'Offer',
            'price' => (float) $bundle->price,
            'priceCurrency' => 'KES',
            'availability' => $bundleIsInStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'url' => $bundleUrl,
            'seller' => ['@type' => 'Organization', 'name' => 'Mars Collection'],
        ];
    }
    if (!$bundleSchema['image']) unset($bundleSchema['image']);
    if ($bundle->review_count > 0 && $bundle->rating >= 1 && $bundle->rating <= 5) {
        $bundleSchema['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => (string) $bundle->rating,
            'reviewCount' => (string) $bundle->review_count,
            'bestRating' => '5',
            'worstRating' => '1',
        ];
    }
    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('home')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Shoe bundles', 'item' => route('bundles.index')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $bundle->name, 'item' => $bundleUrl],
        ],
    ];
@endphp

@section('title', \Illuminate\Support\Str::limit($bundle->name . ' | Shoe Bundle in Kenya | Mars Collection', 65, ''))
@section('description', $bundleDescription)
@section('keywords', strtolower($bundle->name) . ' Kenya, footwear bundle, shoe set, Mars Collection')
@section('canonical', $bundleUrl)
@section('og_type', 'product')
@section('og_image', $bundleImage ?: asset('images/mars-footwear-hero.png'))
@section('structured_data')
@if(isset($bundleSchema['offers']) || isset($bundleSchema['aggregateRating']))<script type="application/ld+json">@json($bundleSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>@endif
<script type="application/ld+json">@json($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endsection

@section('content')
<main class="min-h-screen bg-stone-50 py-10 sm:py-14">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <nav aria-label="Breadcrumb" class="mb-8 text-sm text-stone-500">
            <a href="{{ route('home') }}" class="hover:text-amber-700">Home</a><span class="mx-2">/</span>
            <a href="{{ route('bundles.index') }}" class="hover:text-amber-700">Shoe bundles</a><span class="mx-2">/</span>
            <span aria-current="page" class="font-medium text-stone-900">{{ $bundle->name }}</span>
        </nav>
        <article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5">
            <div class="grid md:grid-cols-2">
                <div class="bg-stone-100">
                    @if($bundleImage)
                        <img src="{{ $bundleImage }}" alt="{{ $bundle->name }} footwear bundle" class="aspect-square h-full w-full object-cover" fetchpriority="high">
                    @else
                        <div class="flex aspect-square items-center justify-center text-stone-400">Footwear bundle</div>
                    @endif
                </div>
                <div class="flex flex-col justify-center p-6 sm:p-10 lg:p-14">
                    <p class="text-xs font-bold uppercase tracking-[.2em] text-amber-700">{{ $bundle->category ?: 'Curated footwear' }}</p>
                    <h1 class="mt-3 text-3xl font-black tracking-tight text-stone-950 sm:text-4xl">{{ $bundle->name }}</h1>
                    <p class="mt-5 leading-7 text-stone-600">{{ $bundle->description ?: 'Explore this curated footwear set from Mars Collection Kenya. Review the included pairs below, then order the bundle online for delivery across Kenya.' }}</p>
                    <p class="mt-6 text-3xl font-bold text-stone-950">{{ $bundle->formatted_price }}</p>
                    @if($bundle->formatted_original_price)<p class="mt-1 text-sm text-stone-400 line-through">{{ $bundle->formatted_original_price }}</p>@endif
                    <button type="button" onclick="addBundleToCart({{ $bundle->id }})" class="mt-7 inline-flex w-fit items-center rounded-full bg-stone-950 px-7 py-3.5 text-sm font-bold text-white transition hover:bg-amber-600">Add bundle to cart</button>
                </div>
            </div>
            @if($bundle->products->isNotEmpty())
                <section class="border-t border-stone-200 p-6 sm:p-10" aria-labelledby="bundle-includes-heading">
                    <h2 id="bundle-includes-heading" class="text-2xl font-bold text-stone-950">What’s included</h2>
                    <ul class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($bundle->products as $product)
                            <li class="flex items-center gap-3 rounded-xl border border-stone-200 p-3">
                                <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($product->image) }}" alt="{{ $product->name }}" class="h-16 w-16 rounded-lg object-cover" loading="lazy">
                                <div class="min-w-0">
                                    <a href="{{ route('products.show', $product) }}" class="font-semibold text-stone-900 hover:text-amber-700">{{ $product->name }}</a>
                                    <p class="mt-1 text-sm text-stone-500">{{ $product->formatted_price }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </article>
    </div>
</main>
@endsection
