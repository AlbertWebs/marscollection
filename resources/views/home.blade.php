@extends('layouts.app')

@section('title', 'Zayn\'s Beauty | Makeup Products & Beauty Shop in Nairobi, Kenya')
@section('description', 'Shop authentic makeup products, skincare & beauty supplies in Nairobi, Kenya. Same-day delivery within CBD. Book professional makeup appointments online. Genuine products guaranteed.')
@section('keywords', 'makeup products Nairobi, beauty shop Nairobi, makeup Nairobi Kenya, skincare Nairobi, buy makeup online Kenya, beauty products Kenya, makeup store Nairobi, authentic makeup Kenya, professional makeup Nairobi')
@section('canonical', url('/'))

@section('og_type', 'website')
@section('og_image', asset('images/og-image.jpg'))



@section('content')
    @include('components.hero')

    @if(isset($pickedProducts) && $pickedProducts->count() > 0)
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 fade-in">
                    <p class="text-xs uppercase tracking-widest text-pink-500 font-medium mb-2">Personalised For You</p>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Picked For You</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">Based on what you've been browsing</p>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach($pickedProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if($trendingProducts->count() > 0)
        <section class="py-16 {{ isset($pickedProducts) && $pickedProducts->count() > 0 ? 'bg-gray-50' : 'bg-white' }}">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 fade-in">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Trending Products</h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Our most popular makeup and beauty products in Nairobi
                    </p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach($trendingProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('components.bundle')
    
    @if($featuredProducts->count() > 0)
        <section class="py-16 bg-gray-50">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 fade-in">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Featured Products</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Hand-picked beauty products available in Nairobi — delivered to your door
                    </p>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach($featuredProducts as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>
                
                <div class="text-center mt-12">
                    <a href="{{ route('products.index', ['tag' => 'featured']) }}" class="bg-white border-2 border-pink-600 text-pink-600 px-8 py-4 rounded-full font-semibold hover:bg-pink-600 hover:text-white transition-all duration-300">
                        View All Featured Products
                    </a>
                </div>
            </div>
        </section>
    @endif

    @include('components.brand-logos')
    @include('components.video-section')
    @include('components.faq-section')
    @include('components.newsletter-signup')
    @include('components.call-to-action')
@endsection