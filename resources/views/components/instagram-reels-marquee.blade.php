@php
    // Get Instagram URL from settings
    $instagramUrl = \App\Models\Setting::get('social_instagram', 'https://instagram.com/zaynsbeauty');
    
    // Sample Instagram reel URLs - In production, you would fetch these from Instagram API
    // For now, using placeholder structure that can be replaced with actual reel URLs
    $reels = [
        ['url' => 'https://www.instagram.com/reel/example1/', 'thumbnail' => 'https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=300&h=400&fit=crop'],
        ['url' => 'https://www.instagram.com/reel/example2/', 'thumbnail' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=300&h=400&fit=crop'],
        ['url' => 'https://www.instagram.com/reel/example3/', 'thumbnail' => 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?w=300&h=400&fit=crop'],
        ['url' => 'https://www.instagram.com/reel/example4/', 'thumbnail' => 'https://images.unsplash.com/photo-1535585209827-a15fcdbc4c2d?w=300&h=400&fit=crop'],
        ['url' => 'https://www.instagram.com/reel/example5/', 'thumbnail' => 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?w=300&h=400&fit=crop'],
        ['url' => 'https://www.instagram.com/reel/example6/', 'thumbnail' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300&h=400&fit=crop'],
        ['url' => 'https://www.instagram.com/reel/example7/', 'thumbnail' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=400&fit=crop'],
        ['url' => 'https://www.instagram.com/reel/example8/', 'thumbnail' => 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=300&h=400&fit=crop'],
    ];
    
    // Duplicate reels for seamless loop
    $reels = array_merge($reels, $reels);
@endphp

<section class="py-12 bg-gradient-to-br from-pink-50 via-purple-50 to-pink-50 overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Follow Us on Instagram</h2>
            <p class="text-gray-600">Check out our latest beauty tips and transformations</p>
            <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" 
               class="inline-flex items-center mt-4 text-pink-600 hover:text-pink-700 font-medium">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                </svg>
                @zaynsbeauty
            </a>
        </div>
    </div>

    <!-- Marquee Container -->
    <div class="relative">
        <div class="overflow-hidden px-4 sm:px-6 lg:px-8">
            <div class="flex animate-marquee space-x-4">
                @foreach($reels as $reel)
                    <a href="{{ $reel['url'] }}" target="_blank" rel="noopener noreferrer" 
                       class="flex-shrink-0 group">
                        <div class="relative w-48 h-64 sm:w-64 sm:h-80 md:w-72 md:h-96 rounded-md overflow-hidden shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <img src="{{ $reel['thumbnail'] }}" 
                                 alt="Instagram Reel" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="absolute bottom-3 left-3 right-3 sm:bottom-4 sm:left-4 sm:right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="flex items-center space-x-2 text-white">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                    <span class="text-xs sm:text-sm font-medium">View on Instagram</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
