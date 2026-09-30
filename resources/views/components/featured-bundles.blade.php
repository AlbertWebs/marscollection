<section class="py-16 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">FEATURED BUNDLES</h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Explore footwear combinations selected for everyday style
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $featuredBundles = App\Models\Bundle::where('is_featured', true)->limit(4)->get();
            @endphp

            @foreach($featuredBundles as $bundle)
                @include('components.bundle-card', [
                    'bundle' => [
                        'id' => $bundle->id,
                        'name' => $bundle->name,
                        'category' => $bundle->category,
                        'price' => $bundle->formatted_price,
                        'original_price' => $bundle->formatted_original_price,
                        'rating' => $bundle->rating,
                        'image' => $bundle->image,
                        'description' => $bundle->description,
                        'badge' => $bundle->badge,
                        'badge_color' => $bundle->badge_color,
                        'review_count' => $bundle->review_count
                    ]
                ])
            @endforeach
        </div>
    </div>
</section>
