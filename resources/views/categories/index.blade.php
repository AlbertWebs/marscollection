@extends('layouts.app')

@section('title', $homeContent->get('home.categories.page.title', 'Shop Shoe Categories | Mars Collection'))
@section('description', $homeContent->get('home.categories.page.description', 'Explore sneakers, formal shoes, loafers, flats, sandals and boots at Mars Collection.'))
@section('keywords', 'shoe categories Kenya, sneakers, formal shoes, loafers, flats, sandals, boots')
@section('canonical', route('categories.index'))
@section('og_type', 'website')
@section('og_image', asset('images/mars-footwear-hero.png'))
@if($categories->isEmpty()) @section('robots', 'noindex, follow') @endif
@php
    $categoryCollectionSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'CollectionPage',
        'name' => $homeContent->get('home.categories.page.title', 'Shoe Categories in Kenya | Mars Collection'),
        'description' => $homeContent->get('home.categories.page.description', 'Explore sneakers, formal shoes, loafers, flats, sandals and boots at Mars Collection Kenya.'),
        'url' => route('categories.index'),
        'mainEntity' => [
            '@type' => 'ItemList',
            'itemListElement' => $categories->values()->map(fn ($category, $index) => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $category->name,
                'url' => route('categories.show', $category),
            ])->all(),
        ],
    ];
@endphp
@section('structured_data')
<script type="application/ld+json">@json($categoryCollectionSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
@endsection

@section('content')
<main class="min-h-screen bg-[#f7f6f3]">
    <section class="border-b border-stone-200 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 sm:py-20 lg:px-8">
            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-700">{{ $homeContent->get('home.categories.page.eyebrow', 'Find your pair') }}</p>
            <div class="mt-4 flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                <div>
                    <h1 class="max-w-2xl text-4xl font-bold tracking-tight text-stone-950 sm:text-5xl">{{ $homeContent->get('home.categories.page.title', 'Shop by category') }}</h1>
                    <p class="mt-4 max-w-xl text-base leading-7 text-stone-600">{{ $homeContent->get('home.categories.page.description', 'Explore shoes by style at Mars Collection.') }}</p>
                </div>
                <a href="{{ route('products.index') }}" class="inline-flex w-fit items-center rounded-full border border-stone-300 px-5 py-3 text-sm font-semibold text-stone-900 transition hover:border-amber-500 hover:text-amber-700">
                    {{ $homeContent->get('home.categories.page.button', 'View all footwear') }} <span aria-hidden="true" class="ml-2">→</span>
                </a>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 sm:py-14 lg:px-8">
        @if($categories->isNotEmpty())
            <div class="grid grid-cols-2 gap-4 sm:gap-6 md:grid-cols-3 lg:grid-cols-4">
                @foreach($categories as $category)
                    <a href="{{ route('categories.show', $category) }}" class="group">
                        <article class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-black/5 transition duration-300 group-hover:-translate-y-1 group-hover:shadow-lg">
                            <div class="relative aspect-[4/5] overflow-hidden bg-stone-200">
                                @if($category->image)
                                    <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($category->image) }}" alt="{{ $category->name }} footwear" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy" decoding="async">
                                @else
                                    <x-category-placeholder />
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/5 to-transparent"></div>
                                <div class="absolute inset-x-0 bottom-0 p-4 sm:p-5">
                                    <h2 class="text-lg font-bold text-white sm:text-xl">{{ $category->name }}</h2>
                                    <p class="mt-1 text-xs font-medium text-white/80">{{ $category->products_count }} {{ \Illuminate\Support\Str::plural('style', $category->products_count) }}</p>
                                </div>
                            </div>
                            <div class="flex min-h-16 items-center justify-between gap-2 px-4 py-3 sm:px-5">
                                <p class="line-clamp-2 text-xs leading-5 text-stone-600 sm:text-sm">{{ $category->description }}</p>
                                <span aria-hidden="true" class="shrink-0 text-lg text-amber-700 transition-transform group-hover:translate-x-1">→</span>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl bg-white px-6 py-16 text-center shadow-sm ring-1 ring-black/5">
                <h2 class="text-xl font-semibold text-stone-900">New styles are on the way</h2>
                <p class="mt-2 text-sm text-stone-600">Browse all available footwear while we update our categories.</p>
                <a href="{{ route('products.index') }}" class="mt-6 inline-flex rounded-full bg-stone-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-amber-600">Shop footwear</a>
            </div>
        @endif
    </section>
</main>
@endsection
