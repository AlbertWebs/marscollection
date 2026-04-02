@extends('layouts.app')

@section('title', 'Zayn\'s Beauty - Premium Beauty Products & Professional Services | Kenya')
@section('description', 'Discover premium beauty products, professional beauty services, and expert beauty consultations in Kenya. Shop the latest trends in skincare, makeup, and beauty accessories. Book appointments online.')
@section('keywords', 'beauty products Kenya, skincare Nairobi, makeup Kenya, beauty services, beauty salon Nairobi, beauty consultation, premium beauty products, beauty accessories')
@section('canonical', url('/'))

@section('og_type', 'website')
@section('og_image', asset('images/og-image.jpg'))



@section('content')
    @include('components.hero')
    
    @if($trendingProducts->count() > 0)
        <section class="py-16 bg-white">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12 fade-in">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">TRENDING PRODUCTS</h1>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Discover our most popular beauty products that customers love
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
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">FEATURED PRODUCTS</h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Discover our most popular beauty products that customers love
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