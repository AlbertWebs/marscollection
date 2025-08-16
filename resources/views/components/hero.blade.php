@php
    $heroEnabled = \App\Models\Setting::get('hero_enabled', '1');
    $heroTitle = \App\Models\Setting::get('hero_title', 'Discover Your Natural Beauty');
    $heroSubtitle = \App\Models\Setting::get('hero_subtitle', 'Premium beauty products that enhance your natural radiance. From skincare essentials to makeup must-haves, we bring you the finest quality products for your beauty journey.');
    $heroImage = \App\Models\Setting::get('hero_image', 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80');
    $heroStatsCustomers = \App\Models\Setting::get('hero_stats_customers', '500+');
    $heroStatsProducts = \App\Models\Setting::get('hero_stats_products', '100+');
    $heroStatsRating = \App\Models\Setting::get('hero_stats_rating', '5★');
@endphp

@if($heroEnabled)
<section class="relative bg-gradient-to-br from-pink-50 via-white to-purple-50 overflow-hidden">
    <!-- Background decorative elements -->
    <div class="absolute inset-0">
        <div class="absolute top-0 left-0 w-72 h-72 bg-pink-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-0 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>
    
    <div class="relative container mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Content -->
            <div class="text-center lg:text-left">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Discover Your
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-600 to-purple-600">{{ $heroTitle }}</span>
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    {{ $heroSubtitle }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('products.index') }}" class="bg-gradient-to-r from-pink-600 to-purple-600 text-white px-8 py-2 rounded-full font-semibold hover:from-pink-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-lg text-center">
                        Shop Now
                    </a>
                    <a href="{{ route('appointments.create') }}" class="border-2 border-pink-600 text-pink-600 px-8 py-2 rounded-full font-semibold hover:bg-pink-600 hover:text-white transition-all duration-300 text-center">
                        Book Appointment
                    </a>
                </div>
                
                <!-- Stats -->
                <div class="mt-12 grid grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-pink-600">{{ $heroStatsCustomers }}</div>
                        <div class="text-sm text-gray-600">Happy Customers</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $heroStatsProducts }}</div>
                        <div class="text-sm text-gray-600">Premium Products</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $heroStatsRating }}</div>
                        <div class="text-sm text-gray-600">Average Rating</div>
                    </div>
                </div>
            </div>
            
            <!-- Hero Image -->
            <div class="relative">
                <div class="relative z-10">
                    <img src="{{ $heroImage }}" 
                         alt="Beauty Products" 
                         class="w-full h-96 object-cover rounded-2xl shadow-2xl">
                </div>
                
                <!-- Floating elements -->
                <div class="absolute -top-4 -right-4 bg-white p-4 rounded-xl shadow-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-sm font-medium text-gray-700">Premium Quality</span>
                    </div>
                </div>
                
                <div class="absolute -bottom-4 -left-4 bg-white p-4 rounded-xl shadow-lg">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">4.9/5 Rating</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes blob {
    0% { transform: translate(0px, 0px) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
    100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob {
    animation: blob 7s infinite;
}
.animation-delay-2000 {
    animation-delay: 2s;
}
.animation-delay-4000 {
    animation-delay: 4s;
}
</style>
@endif 