<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                Featured Products
            </h2>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Discover our most popular beauty products that customers love
            </p>
        </div>
        
        <!-- Product Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $featuredProducts = App\Models\Product::where('is_featured', true)->limit(4)->get();
            @endphp

            @foreach($featuredProducts as $product)
                @include('components.product-card', ['product' => $product])
            @endforeach
        </div>
        
        <!-- View All Button -->
        <div class="text-center mt-12">
            <a href="{{ route('products.index', ['tag' => 'featured']) }}" class="bg-white border-2 border-pink-600 text-pink-600 px-8 py-4 rounded-full font-semibold hover:bg-pink-600 hover:text-white transition-all duration-300">
                View All Products
            </a>
        </div>
    </div>
</section> 