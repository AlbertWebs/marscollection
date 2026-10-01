@extends('layouts.app')

@section('title', $homeContent->get('home.title', 'Mars Collection | Sneakers & Shoes in Kenya'))
@section('description', $homeContent->get('home.description', 'Shop sneakers, casual shoes, formal footwear and everyday favourites at Mars Collection. Find your fit and order online in Kenya.'))
@section('keywords', $homeContent->get('home.keywords', 'shoes Kenya, sneakers Nairobi, buy shoes online Kenya, Mars Collection footwear'))
@section('canonical', route('home'))
@section('og_type', 'website')
@section('og_image', asset(ltrim($homeContent->get('home.hero.image', '/images/mars-footwear-hero.png'), '/')))
@section('og_image_alt', $homeContent->get('home.hero.image_alt', 'Shop sneakers and footwear at Mars Collection Kenya'))

@section('content')
    @include('components.hero')

    @if($categories->isNotEmpty())
        <section class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-9 flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-amber-700">{{ $homeContent->get('home.categories.eyebrow', 'Find your pair') }}</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-gray-950 sm:text-4xl">{{ $homeContent->get('home.categories.title', 'Shop by category') }}</h2>
                    </div>
                    <a href="{{ route('categories.index') }}" class="hidden text-sm font-semibold text-gray-800 hover:text-amber-700 sm:inline-flex">{{ $homeContent->get('home.categories.link', 'All categories') }} <span aria-hidden="true" class="ml-2">→</span></a>
                </div>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
                    @foreach($categories as $category)
                        <a href="{{ route('categories.show', $category) }}" class="group relative overflow-hidden rounded-xl bg-gray-100">
                            <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($category->image) }}" alt="{{ $category->name }}" class="aspect-[4/5] w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                            <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent px-3 pb-4 pt-10 text-sm font-semibold text-white sm:text-base">{{ $category->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($trendingProducts->isNotEmpty())
        <section class="bg-[#f7f6f3] py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-9 flex items-end justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-amber-700">{{ $homeContent->get('home.trending.eyebrow', 'The pairs everyone wants') }}</p>
                        <h2 class="mt-2 text-3xl font-bold tracking-tight text-gray-950 sm:text-4xl">{{ $homeContent->get('home.trending.title', 'Trending now') }}</h2>
                    </div>
                    <a href="{{ route('products.index', ['tag' => 'trending']) }}" class="text-sm font-semibold text-gray-800 hover:text-amber-700">{{ $homeContent->get('home.trending.link', 'Shop all') }} <span aria-hidden="true" class="ml-2">→</span></a>
                </div>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-5">
                    @foreach($trendingProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($featuredProducts->isNotEmpty())
        <section class="bg-white py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-9 text-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-amber-700">{{ $homeContent->get('home.featured.eyebrow', 'Made for your everyday') }}</p>
                    <h2 class="mt-2 text-3xl font-bold tracking-tight text-gray-950 sm:text-4xl">{{ $homeContent->get('home.featured.title', 'The Mars edit') }}</h2>
                    <p class="mx-auto mt-3 max-w-xl text-sm leading-6 text-gray-600">{{ $homeContent->get('home.featured.description', 'Fresh sneakers, smart classics and comfortable pairs for wherever the day takes you.') }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-5">
                    @foreach($featuredProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
                <div class="mt-10 text-center">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center rounded-full bg-gray-950 px-7 py-3 text-sm font-semibold text-white transition hover:bg-amber-600">{{ $homeContent->get('home.featured.button', 'Explore all footwear') }} <span aria-hidden="true" class="ml-2">→</span></a>
                </div>
            </div>
        </section>
    @endif

    <section class="border-y border-gray-200 bg-[#f7f6f3] py-10">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 text-center sm:grid-cols-3 sm:px-6 lg:px-8">
            <div><p class="font-semibold text-gray-950">{{ $homeContent->get('home.benefit.size.title', 'A size for your stride') }}</p><p class="mt-1 text-sm text-gray-600">{{ $homeContent->get('home.benefit.size.description', 'Clear size options on every pair') }}</p></div>
            <div><p class="font-semibold text-gray-950">{{ $homeContent->get('home.benefit.delivery.title', 'Delivery across Kenya') }}</p><p class="mt-1 text-sm text-gray-600">{{ $homeContent->get('home.benefit.delivery.description', 'Convenient dispatch to your door') }}</p></div>
            <div><p class="font-semibold text-gray-950">{{ $homeContent->get('home.benefit.fit.title', 'Help choosing your fit') }}</p><p class="mt-1 text-sm text-gray-600">{{ $homeContent->get('home.benefit.fit.description', 'Message us with your shoe questions') }}</p></div>
        </div>
    </section>

    @include('components.newsletter-signup')
@endsection
