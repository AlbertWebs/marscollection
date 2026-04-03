@extends('layouts.app')

@section('title', $product->name . ' | ' . ($product->brand->name ?? 'Zayn\'s Beauty') . ' - Nairobi, Kenya')
@section('description', ($product->description ? Str::limit($product->description, 140) : $product->name . ' available at Zayn\'s Beauty in Nairobi, Kenya. Authentic product, fast delivery. Order online today.'))
@section('keywords', $product->name . ' Nairobi, buy ' . $product->name . ' Kenya, ' . ($product->category->name ?? 'beauty products') . ' Nairobi, ' . ($product->brand->name ?? 'Zayn\'s Beauty') . ', makeup products Nairobi, beauty shop Kenya')
@section('canonical', route('products.show', $product))

@section('og_type', 'product')
@section('og_image', \App\Helpers\ImageHelper::getProductImageUrl($product->image))

@section('breadcrumbs')
    <a href="{{ route('home') }}">Home</a>
    <span>/</span>
    <a href="{{ route('products.index') }}">Products</a>
    <span>/</span>
    @if($product->category)
        <a href="{{ route('categories.show', $product->category) }}">{{ $product->category->name }}</a>
        <span>/</span>
    @endif
    <span class="text-gray-500">{{ $product->name }}</span>
@endsection

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "Product",
    "name": "{{ $product->name }}",
    "description": "{{ $product->description ?? $product->name . ' - Premium beauty product' }}",
    "image": "{{ \App\Helpers\ImageHelper::getProductImageUrl($product->image) }}",
    "url": "{{ route('products.show', $product) }}",
    "sku": "{{ $product->id }}",
    "mpn": "{{ $product->id }}",
    "brand": {
        "@@type": "Brand",
        "name": "{{ $product->brand->name ?? 'Zayn\'s Beauty' }}"
    },
    "category": "{{ $product->category->name ?? 'Beauty Products' }}",
    "offers": {
        "@@type": "Offer",
        "price": "{{ $product->price }}",
        "priceCurrency": "KES",
        "priceValidUntil": "{{ now()->addYear()->toISOString() }}",
        "availability": "{{ $product->stock_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "url": "{{ route('products.show', $product) }}",
        "seller": {
            "@@type": "Organization",
            "name": "Zayn's Beauty"
        }
    },
    "aggregateRating": {
        "@@type": "AggregateRating",
        "ratingValue": "{{ $product->reviews_count > 0 ? $product->average_rating : 5 }}",
        "reviewCount": "{{ $product->reviews_count > 0 ? $product->reviews_count : 1 }}",
        "bestRating": "5",
        "worstRating": "1"
    },
    "review": [
        @foreach($product->reviews()->latest()->take(3)->get() as $review)
        {
            "@@type": "Review",
            "author": {
                "@@type": "Person",
                "name": "{{ $review->order->customer_name }}"
            },
            "reviewRating": {
                "@@type": "Rating",
                "ratingValue": "{{ $review->rating }}",
                "bestRating": "5"
            },
            "reviewBody": "{{ $review->comment ?? 'Great product!' }}",
            "datePublished": "{{ $review->created_at->toISOString() }}"
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script>
@endsection

@section('content')
<div class="bg-white min-h-screen py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-pink-600 transition-colors">Home</a></li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ route('products.index') }}" class="hover:text-pink-600 transition-colors">Products</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-4 h-4 mx-2" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-900 font-medium">{{ $product->name }}</span>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="space-y-4">
                <div class="bg-gray-50 rounded-md overflow-hidden">
                    @if($product->image)
                        <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($product->image) }}" 
                             alt="{{ $product->name }} - {{ $product->brand->name ?? 'Zayn\'s Beauty' }} {{ $product->category->name ?? 'Beauty Product' }}" 
                             class="w-full h-96 object-cover"
                             loading="eager">
                    @else
                        <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="space-y-6">
                <!-- Badge -->
                @if($product->badge)
                    <div class="inline-block">
                        <span class="px-3 py-1 text-xs font-semibold rounded-full text-white" 
                              style="background-color: {{ $product->badge_color ?? '#ec4899' }}"
                              aria-label="Product badge: {{ $product->badge }}">
                            {{ $product->badge }}
                        </span>
                    </div>
                @endif

                <!-- Product Name -->
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $product->name }}</h1>

                <!-- Rating and Sold Count -->
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-1">
                        <div class="flex items-center" aria-label="Rating: {{ $product->rating > 0 ? $product->rating : 5 }} out of 5 stars">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= ($product->rating > 0 ? $product->rating : 5))
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-sm text-gray-600 ml-2">{{ $product->rating > 0 ? $product->rating : 5 }}/5</span>
                    </div>
                    

                </div>

                <!-- Price -->
                <div class="space-y-2">
                    <div class="flex items-center space-x-3">
                        <span class="text-3xl font-bold text-gray-900">{{ $product->formatted_price }}</span>
                        @if($product->original_price && $product->original_price > $product->price)
                            <span class="text-lg text-gray-500 line-through">{{ $product->formatted_original_price }}</span>
                            <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-600 rounded-md">
                                {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}% OFF
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Category and Brand -->
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    @if($product->category)
                        <div class="flex items-center space-x-1">
                            <span class="text-gray-500">Category:</span>
                            <a href="{{ route('categories.show', $product->category) }}" 
                               class="text-pink-600 hover:text-pink-700 font-medium">
                                {{ $product->category->name }}
                            </a>
                        </div>
                    @endif
                    
                    @if($product->brand)
                        <div class="flex items-center space-x-1">
                            <span class="text-gray-500">Brand:</span>
                            <a href="{{ route('brands.show', $product->brand) }}" 
                               class="text-pink-600 hover:text-pink-700 font-medium">
                                {{ $product->brand->name }}
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                @if($product->description)
                    <div class="space-y-2">
                        <h3 class="text-lg font-semibold text-gray-900">Description</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                <!-- Stock Status -->
                <div class="space-y-2">
                    @if($product->stock_quantity > 0)
                        <div class="flex items-center space-x-2 text-green-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">In Stock ({{ $product->stock_quantity }} available)</span>
                        </div>
                    @else
                        <div class="flex items-center space-x-2 text-red-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Out of Stock</span>
                        </div>
                    @endif
                </div>

                <!-- Add to Cart Button -->
                <div class="space-y-4">
                    @if($product->stock_quantity > 0)
                        <button onclick="addToCart({{ $product->id }})" 
                                class="w-full bg-pink-600 text-white py-4 px-6 rounded-md font-semibold hover:bg-pink-700 transition-all duration-300 flex items-center justify-center space-x-2"
                                aria-label="Add {{ $product->name }} to cart">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Add to Cart</span>
                        </button>
                    @else
                        <button disabled 
                                class="w-full bg-gray-300 text-gray-500 py-4 px-6 rounded-md font-semibold cursor-not-allowed">
                            Out of Stock
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        @include('components.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Reviews Section -->
        <div class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900">Customer Reviews</h2>
                <div class="flex items-center space-x-2">
                    <div class="flex items-center space-x-1" aria-label="Average rating: {{ $product->reviews_count > 0 ? number_format($product->average_rating, 1) : '5' }} out of 5 stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= ($product->reviews_count > 0 ? $product->average_rating : 5))
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endif
                        @endfor
                        <span class="text-sm text-gray-600 ml-2">{{ $product->reviews_count > 0 ? number_format($product->average_rating, 1) : '5' }}/5</span>
                    </div>
                    @if($product->reviews_count > 0)
                        <span class="text-sm text-gray-500">({{ $product->reviews_count }} reviews)</span>
                    @else
                        <span class="text-sm text-gray-500">(No reviews yet)</span>
                    @endif
                </div>
            </div>

            @if($product->reviews_count > 0)
                <div class="space-y-6">
                    @foreach($product->reviews()->latest()->take(5)->get() as $review)
                        <div class="border border-gray-200 rounded-md p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center">
                                        <span class="text-pink-600 font-semibold">
                                            {{ strtoupper(substr($review->order->customer_name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">
                                            {{ $review->order->customer_name }}
                                        </p>
                                        <p class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-1" aria-label="Rating: {{ $review->rating }} out of 5 stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            @if($review->comment)
                                <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No reviews yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Be the first to review this product!</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 