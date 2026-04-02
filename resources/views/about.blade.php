@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">About Zayn's Beauty</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Your trusted destination for premium beauty products and expert beauty advice. 
                    We're passionate about helping you discover your unique beauty and confidence.
                </p>
            </div>
        </div>
    </div>

    <!-- Our Story Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Story</h2>
                <p class="text-gray-600 mb-6">
                    Founded with a vision to make premium beauty accessible to everyone, Zayn's Beauty 
                    began as a small local store with big dreams. Today, we've grown into a trusted 
                    beauty destination, serving customers across Kenya with carefully curated products 
                    from the world's leading beauty brands.
                </p>
                <p class="text-gray-600 mb-6">
                    Our journey started with a simple belief: everyone deserves to feel beautiful and 
                    confident. This philosophy drives everything we do, from the products we select to 
                    the service we provide.
                </p>
                <p class="text-gray-600">
                    We're not just selling beauty products - we're building a community of confident, 
                    empowered individuals who embrace their unique beauty.
                </p>
            </div>
            <div class="relative">
                <div class="bg-gradient-to-br from-pink-400 to-purple-500 rounded-2xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-4">Our Mission</h3>
                    <p class="text-lg">
                        To empower individuals with premium beauty products and expert guidance, 
                        helping them discover and enhance their natural beauty while building confidence 
                        and self-expression.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Our Values</h2>
                <p class="text-xl text-gray-600">The principles that guide everything we do</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-pink-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Quality First</h3>
                    <p class="text-gray-600">
                        We carefully select only the highest quality products from trusted brands, 
                        ensuring you get the best for your beauty routine.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="bg-purple-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Customer Focus</h3>
                    <p class="text-gray-600">
                        Your satisfaction is our priority. We provide personalized service and expert 
                        advice to help you make the best beauty choices.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="bg-pink-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Innovation</h3>
                    <p class="text-gray-600">
                        We stay ahead of beauty trends and continuously update our product range 
                        to bring you the latest innovations in beauty care.
                    </p>
                </div>
            </div>
        </div>
    </div>



    <!-- Stats Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold text-pink-600 mb-2">5000+</div>
                    <div class="text-gray-600">Happy Customers</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-purple-600 mb-2">1000+</div>
                    <div class="text-gray-600">Products</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-pink-600 mb-2">50+</div>
                    <div class="text-gray-600">Brands</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-purple-600 mb-2">5+</div>
                    <div class="text-gray-600">Years Experience</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
