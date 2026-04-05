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
        "price": {{ (float) $product->price }},
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
                @if($product->image)
                @php $productImgUrl = \App\Helpers\ImageHelper::getProductImageUrl($product->image); @endphp
                <div class="relative">
                    <!-- Image container -->
                    <div id="zoom-container"
                         class="bg-gray-50 rounded-md overflow-hidden flex items-center justify-center cursor-zoom-in select-none"
                         style="height: 380px; position: relative;">
                        <img id="zoom-img"
                             src="{{ $productImgUrl }}"
                             alt="{{ $product->name }} - {{ $product->brand->name ?? 'Zayn\'s Beauty' }} {{ $product->category->name ?? 'Beauty Product' }}"
                             class="w-full h-full object-contain p-3"
                             loading="eager"
                             draggable="false">
                        <!-- Lens overlay -->
                        <div id="zoom-lens"
                             class="hidden absolute border-2 border-pink-400 bg-pink-50/20 rounded pointer-events-none"
                             style="width: 120px; height: 120px; z-index: 10;"></div>
                    </div>
                    <!-- Zoomed panel (desktop only, positioned by JS) -->
                    <div id="zoom-panel"
                         class="bg-white border border-gray-200 rounded-md shadow-xl overflow-hidden pointer-events-none"
                         style="display:none; position:fixed; width: 380px; height: 380px; z-index: 50;"></div>
                    <!-- Click hint badge -->
                    <div class="absolute bottom-3 right-3 bg-black/50 text-white text-xs px-2 py-1 rounded-full flex items-center gap-1 pointer-events-none">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                        Click to zoom
                    </div>
                </div>
                @else
                <div class="bg-gray-50 rounded-md overflow-hidden flex items-center justify-center" style="height: 380px;">
                    <div class="flex items-center justify-center">
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                @endif
            </div>

            <!-- Lightbox Modal -->
            <div id="lightbox" class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/90" role="dialog" aria-modal="true" aria-label="Product image zoom">
                <button id="lightbox-close" class="absolute top-4 right-4 text-white hover:text-pink-400 transition-colors" aria-label="Close zoom">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
                <img id="lightbox-img" src="" alt="{{ $product->name }}" class="max-w-[90vw] max-h-[90vh] object-contain rounded-md shadow-2xl">
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
                    <div class="border-t border-gray-100 pt-5">
                        <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-widest mb-3">Description</h3>
                        <div class="prose max-w-none">
                            {!! $product->description !!}
                        </div>
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
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('zoom-container');
    const img       = document.getElementById('zoom-img');
    const lens      = document.getElementById('zoom-lens');
    const panel     = document.getElementById('zoom-panel');

    const lightbox  = document.getElementById('lightbox');
    const lbImg     = document.getElementById('lightbox-img');
    const lbClose   = document.getElementById('lightbox-close');

    if (!container || !img) return;

    const imgSrc = img.src;
    const isDesktop = () => window.innerWidth >= 1024;

    // ---------- Hover zoom (desktop only) ----------
    container.addEventListener('mouseenter', function () {
        if (!isDesktop()) return;
        lens.classList.remove('hidden');
        // Position panel fixed to the right of the container
        const rect = container.getBoundingClientRect();
        panel.style.display   = 'block';
        panel.style.top       = rect.top + 'px';
        panel.style.left      = (rect.right + 12) + 'px';
        
        // Make both square
        const panelSize = 380; 
        panel.style.width     = panelSize + 'px';
        panel.style.height    = panelSize + 'px';

        const lensSize = 120;
        lens.style.width  = lensSize + 'px';
        lens.style.height = lensSize + 'px';

        panel.style.backgroundImage  = `url('${imgSrc}')`;
        panel.style.backgroundRepeat = 'no-repeat';
    });

    container.addEventListener('mouseleave', function () {
        lens.classList.add('hidden');
        panel.style.display = 'none';
    });

    container.addEventListener('mousemove', function (e) {
        if (!isDesktop()) return;

        const rect      = container.getBoundingClientRect();
        const imgRect   = img.getBoundingClientRect();
        const lensW     = lens.offsetWidth;
        const lensH     = lens.offsetHeight;
        const panelW    = panel.offsetWidth;
        const panelH    = panel.offsetHeight;

        // Cursor position relative to container
        let cx = e.clientX - rect.left;
        let cy = e.clientY - rect.top;

        // Clamp lens within image bounds
        let lx = cx - lensW / 2;
        let ly = cy - lensH / 2;
        lx = Math.max(imgRect.left - rect.left, Math.min(lx, imgRect.right  - rect.left - lensW));
        ly = Math.max(imgRect.top  - rect.top,  Math.min(ly, imgRect.bottom - rect.top  - lensH));

        lens.style.left = lx + 'px';
        lens.style.top  = ly + 'px';

        // Zoom ratio: panel size / lens size
        const ratioX = panelW / lensW;
        const ratioY = panelH / lensH;

        // Background size = image rendered size * zoom ratio
        const bgW = imgRect.width  * ratioX;
        const bgH = imgRect.height * ratioY;

        // Background position: offset from image top-left
        const offsetX = (lx - (imgRect.left - rect.left)) * ratioX;
        const offsetY = (ly - (imgRect.top  - rect.top))  * ratioY;

        panel.style.backgroundSize     = `${bgW}px ${bgH}px`;
        panel.style.backgroundPosition = `-${offsetX}px -${offsetY}px`;
    });

    // ---------- Click to lightbox ----------
    container.addEventListener('click', function () {
        lbImg.src = imgSrc;
        lightbox.classList.remove('hidden');
        lightbox.classList.add('flex');
        document.body.style.overflow = 'hidden';
    });

    function closeLightbox() {
        lightbox.classList.add('hidden');
        lightbox.classList.remove('flex');
        document.body.style.overflow = '';
    }

    lbClose && lbClose.addEventListener('click', closeLightbox);
    lightbox && lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) closeLightbox();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeLightbox();
    });
});
</script>
@endsection