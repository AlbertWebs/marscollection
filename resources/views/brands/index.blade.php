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
@endphp
@section('structured_data')
<script type="application/ld+json">@json($brandCollectionSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endsection

@section('content')

<div class="bg-white border-b border-gray-100 py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs uppercase tracking-widest text-amber-600 font-medium mb-2">Shop By</p>
        <h1 class="text-3xl font-bold text-gray-900">All Brands</h1>
        <p class="mt-2 text-gray-500 text-sm">Explore products from the brands we carry.</p>
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        @if($brands->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            @foreach($brands as $brand)
            @php
                $logoUrl = $brand->logo ? \App\Helpers\ImageHelper::getProductImageUrl($brand->logo) : null;
            @endphp
            <a href="{{ route('brands.show', $brand) }}"
               class="group relative rounded-lg overflow-hidden block"
               style="height: 120px;">
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $brand->name }}"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy" decoding="async">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400 font-bold text-lg uppercase">{{ Str::limit($brand->name, 2) }}</span>
                    </div>
                @endif
                <div class="absolute inset-0 bg-black/45 group-hover:bg-black/60 transition-colors duration-200 flex items-center justify-center p-3">
                    <span class="text-white text-base font-bold text-center leading-tight drop-shadow-md">{{ $brand->name }}</span>
                </div>
            </a>
            @endforeach
        </div>
        @else
            <div class="text-center py-16 text-gray-400">
                <svg class="mx-auto h-10 w-10 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <p class="text-sm">No brands available at the moment.</p>
            </div>
        @endif

    </div>
</div>

@endsection
