<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Zayn's Beauty - Premium Beauty Products</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
            /* Tailwind CSS styles will be included here */
            @import 'tailwindcss/base';
            @import 'tailwindcss/components';
            @import 'tailwindcss/utilities';
            </style>
        @endif
    </head>
<body class="bg-white text-gray-900">
    <!-- Header -->
    @include('components.header')
    
    <!-- Hero Section -->
    @include('components.hero')
    
    <!-- Feature Icons -->
    @include('components.feature-icons')
    
    <!-- Promotional Banners -->
    @include('components.promotional-banners')
    
    <!-- Trending Products -->
    @include('components.trending-products')
    
    <!-- Video Section -->
    @include('components.video-section')
    
    <!-- Must Have Products -->
    @include('components.must-have-products')
    
    <!-- Product Categories -->
    @include('components.product-categories')
    
    <!-- Call to Action -->
    @include('components.call-to-action')
    
    <!-- Brand Logos -->
    @include('components.brand-logos')
    
    <!-- FAQ Section -->
    @include('components.faq-section')
    
    <!-- Newsletter Signup -->
    @include('components.newsletter-signup')
    
    <!-- Footer -->
    @include('components.footer')
    </body>
</html>
