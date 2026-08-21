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
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
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
        "priceValidUntil": "{{ now()->addYear()->format('Y-m-d') }}",
        "validFrom": "{{ now()->format('Y-m-d') }}",
        "availability": "{{ $product->stock_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "url": "{{ route('products.show', $product) }}",
        "seller": {
            "@@type": "Organization",
            "name": "Zayn's Beauty"
        },
        "hasMerchantReturnPolicy": {
            "@@type": "MerchantReturnPolicy",
            "applicableCountry": "KE",
            "returnPolicyCategory": "https://schema.org/MerchantReturnFiniteReturnWindow",
            "merchantReturnDays": 7,
            "returnMethod": "https://schema.org/ReturnByMail",
            "returnFees": "https://schema.org/FreeReturn"
        },
        "shippingDetails": {
            "@@type": "OfferShippingDetails",
            "shippingRate": {
                "@@type": "MonetaryAmount",
                "value": "0",
                "currency": "KES"
            },
            "shippingDestination": {
                "@@type": "DefinedRegion",
                "addressCountry": "KE"
            },
            "deliveryTime": {
                "@@type": "ShippingDeliveryTime",
                "handlingTime": {
                    "@@type": "QuantitativeValue",
                    "minValue": 0,
                    "maxValue": 1,
                    "unitCode": "DAY"
                },
                "transitTime": {
                    "@@type": "QuantitativeValue",
                    "minValue": 1,
                    "maxValue": 3,
                    "unitCode": "DAY"
                }
            }
        }
    }
    @php
        $productReviews = $product->reviews()->latest()->take(3)->get();
        $hasRealReviews = $product->reviews_count > 0 && $productReviews->count() > 0;
    @endphp
    ,"aggregateRating": {
        "@@type": "AggregateRating",
        "ratingValue": "{{ $hasRealReviews ? number_format($product->average_rating, 1) : '5.0' }}",
        "reviewCount": "{{ $hasRealReviews ? $product->reviews_count : 1 }}",
        "bestRating": "5",
        "worstRating": "1"
    }
    @if($hasRealReviews)
    ,"review": [
        @foreach($productReviews as $review)
        {
            "@@type": "Review",
            "author": {
                "@@type": "Person",
                "name": "{{ addslashes($review->order->customer_name ?? 'Customer') }}"
            },
            "reviewRating": {
                "@@type": "Rating",
                "ratingValue": "{{ $review->rating }}",
                "bestRating": "5"
            },
            "reviewBody": "{{ addslashes($review->comment ?? 'Great product!') }}",
            "datePublished": "{{ $review->created_at->format('Y-m-d') }}"
        }@if(!$loop->last),@endif
        @endforeach
    ]
    @endif
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
                @php
                    $productImgUrl = \App\Helpers\ImageHelper::getProductImageUrl($product->image);
                    $allImages = array_merge(
                        [$product->image],
                        $product->extra_images ?? []
                    );
                @endphp
                <div class="relative">
                    <!-- Main image container -->
                    <div id="zoom-container"
                         class="bg-gray-50 rounded-md overflow-hidden flex items-center justify-center cursor-zoom-in select-none"
                         style="height: 380px; position: relative;">
                        <img id="zoom-img"
                             src="{{ $productImgUrl }}"
                             alt="{{ $product->name }} - {{ $product->brand->name ?? 'Zayn\'s Beauty' }} {{ $product->category->name ?? 'Beauty Product' }}"
                             class="max-w-full max-h-full object-contain p-3"
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

                @if(count($allImages) > 1)
                <!-- Thumbnail strip -->
                <div class="flex gap-2 overflow-x-auto pb-1">
                    @foreach($allImages as $i => $imgPath)
                    @php $thumbUrl = \App\Helpers\ImageHelper::getProductImageUrl($imgPath); @endphp
                    <button type="button"
                            onclick="switchMainImage('{{ $thumbUrl }}', this)"
                            class="thumb-btn flex-shrink-0 w-16 h-16 rounded-md overflow-hidden border-2 transition-all duration-150 focus:outline-none {{ $i === 0 ? 'border-pink-500' : 'border-gray-200 hover:border-pink-300' }}"
                            aria-label="View image {{ $i + 1 }}">
                        <img src="{{ $thumbUrl }}"
                             alt="{{ $product->name }} image {{ $i + 1 }}"
                             class="w-full h-full object-cover"
                             loading="lazy">
                    </button>
                    @endforeach
                </div>
                @endif

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

            <!-- Gallery Lightbox Modal -->
            @php
                $galleryImages = array_merge(
                    $product->image ? [$product->image] : [],
                    $product->extra_images ?? []
                );
            @endphp
            <div id="lightbox" class="fixed inset-0 z-[999] hidden items-center justify-center bg-black/95" role="dialog" aria-modal="true" aria-label="Product image gallery">
                <!-- Close -->
                <button id="lightbox-close" class="absolute top-4 right-4 text-white hover:text-pink-400 transition-colors z-10" aria-label="Close gallery">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <!-- Counter -->
                <div class="absolute top-4 left-4 text-white text-sm font-medium z-10">
                    <span id="lb-counter-current">1</span> / <span id="lb-counter-total">{{ count($galleryImages) }}</span>
                </div>

                <!-- Prev arrow -->
                @if(count($galleryImages) > 1)
                <button id="lb-prev" class="absolute left-3 top-1/2 -translate-y-1/2 z-10 bg-black/40 hover:bg-pink-600 text-white rounded-full p-2 transition-colors" aria-label="Previous image">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </button>
                @endif

                <!-- Main lightbox image -->
                <img id="lightbox-img" src="" alt="{{ $product->name }}"
                     class="max-w-[80vw] max-h-[75vh] object-contain rounded-md shadow-2xl select-none transition-opacity duration-200">

                <!-- Next arrow -->
                @if(count($galleryImages) > 1)
                <button id="lb-next" class="absolute right-3 top-1/2 -translate-y-1/2 z-10 bg-black/40 hover:bg-pink-600 text-white rounded-full p-2 transition-colors" aria-label="Next image">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
                @endif

                @if(count($galleryImages) > 1)
                <!-- Thumbnail strip -->
                <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 px-4 overflow-x-auto">
                    @foreach($galleryImages as $i => $imgPath)
                    @php $tUrl = \App\Helpers\ImageHelper::getProductImageUrl($imgPath); @endphp
                    <button type="button"
                            onclick="lbGoTo({{ $i }})"
                            data-lb-index="{{ $i }}"
                            class="lb-thumb flex-shrink-0 w-12 h-12 rounded-md overflow-hidden border-2 transition-all {{ $i === 0 ? 'border-pink-500' : 'border-white/30 hover:border-white/70' }}"
                            aria-label="Go to image {{ $i + 1 }}">
                        <img src="{{ $tUrl }}" alt="" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif
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
                        <span class="text-sm text-gray-600 ml-2">@php
                            $rVal = (float)($product->rating > 0 ? $product->rating : 5);
                            $rDisplay = ($rVal == (int)$rVal) ? (int)$rVal : rtrim(rtrim(number_format($rVal, 1), '0'), '.');
                        @endphp
                        {{ $rDisplay }}/5</span>
                    </div>
                    

                </div>

                <!-- Price -->
                <div class="space-y-2">
                    <div class="flex items-center space-x-3">
                        <span id="product-price" class="text-3xl font-bold text-gray-900">{{ $product->formatted_price }}</span>
                        <span id="product-original-price" class="text-lg text-gray-500 line-through {{ ($product->original_price && $product->original_price > $product->price) ? '' : 'hidden' }}">
                            {{ $product->formatted_original_price }}
                        </span>
                        <span id="product-discount-badge" class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-600 rounded-md {{ ($product->original_price && $product->original_price > $product->price) ? '' : 'hidden' }}">
                            {{ ($product->original_price && $product->original_price > $product->price) ? round((($product->original_price - $product->price) / $product->original_price) * 100) . '% OFF' : '' }}
                        </span>
                    </div>
                </div>

                <!-- Category and Brand -->
                <div class="flex items-center space-x-4 text-sm text-gray-600">
                    @if($product->category)
                        <div class="flex items-center space-x-1">
                            <span class="text-gray-500">Category:</span>
                            <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" 
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
                <div class="space-y-4">
                    @if($product->stock_quantity > 0)

                        @if($product->variants && count($product->variants) > 0)
                        @php
                            // Sort variants: those with a price first (ascending), then base-price ones
                            $sortedVariants = collect($product->variants)->sortBy(function($v) {
                                return isset($v['price']) && $v['price'] !== null ? (float)$v['price'] : PHP_INT_MAX;
                            })->values()->all();
                        @endphp
                        <!-- Variant Selector -->
                        <div class="border-t border-gray-100 pt-4 space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-semibold text-gray-900 uppercase tracking-widest">Select Option</label>
                                <span id="variant-label" class="text-sm font-bold text-pink-600"></span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($sortedVariants as $i => $variant)
                                <button type="button"
                                        onclick="handleVariantChange(this)"
                                        data-label="{{ $variant['label'] }}"
                                        data-price="{{ $variant['price'] ?? '' }}"
                                        data-original-price="{{ $variant['original_price'] ?? '' }}"
                                        class="variant-btn px-4 py-2 rounded-md border-2 text-sm font-medium transition-all duration-150 whitespace-nowrap
                                               {{ $i === 0 ? 'border-pink-500 text-pink-600 bg-pink-50' : 'border-gray-200 text-gray-700 hover:border-pink-400 hover:text-pink-600' }}">
                                    {{ $variant['label'] }}
                                    @if(!empty($variant['price']))
                                        <span class="text-xs {{ $i === 0 ? 'text-pink-400' : 'text-gray-400' }} ml-1">KES&nbsp;{{ number_format($variant['price'], 0) }}</span>
                                    @endif
                                </button>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="flex items-center space-x-2 text-green-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">In Stock ({{ $product->stock_quantity }} available)</span>
                        </div>

                        <!-- Color Selection -->
                        @if($product->colors && count($product->colors) > 0)
                            <div class="pt-4 border-t border-gray-100 space-y-3">
                                <div class="flex justify-between items-center">
                                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-widest">Select Color</h3>
                                    <span id="color-label" class="text-sm font-bold text-pink-600"></span>
                                </div>
                                <div class="flex flex-wrap gap-4">
                                    @foreach($product->colors as $index => $colorOption)
                                        @php
                                            $parts = explode(':', $colorOption);
                                            $cName = trim($parts[0]);
                                            $cVal  = isset($parts[1]) ? trim($parts[1]) : $cName;
                                        @endphp
                                        <button type="button" 
                                                class="color-option-btn group relative"
                                                onclick="handleColorSelect('{{ $cName }}', this)"
                                                title="{{ $cName }}">
                                            <div class="w-10 h-10 rounded-full border-2 border-gray-200 transition-all duration-200 group-hover:scale-110 flex items-center justify-center p-0.5"
                                                 style="background-color: {{ $cVal }};">
                                                <div class="hidden selected-check">
                                                    <svg class="w-5 h-5 text-white drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <span class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] whitespace-nowrap opacity-0 group-hover:opacity-100 font-medium text-gray-500 transition-opacity">
                                                {{ $cName }}
                                            </span>
                                        </button>
                                    @endforeach
                                </div>
                                <input type="hidden" id="selected-color-input" value="">
                            </div>
                        @endif
                    @else
                        <div class="flex items-center space-x-2 text-red-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Out of Stock</span>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons (Add to Cart & WhatsApp Inquiry) -->
                @php
                    $rawPhone = \App\Models\Setting::get('contact_phone_primary', '254707614446');
                    $cleanPhone = preg_replace('/\D/', '', $rawPhone);
                    $inquiryMsg = "Hi, I would like to inquire about: " . $product->name . " (" . $product->formatted_price . ") - " . route('products.show', $product);
                    $waUrl = "https://wa.me/" . $cleanPhone . "?text=" . urlencode($inquiryMsg);
                @endphp

                <div class="space-y-4">
                    @if($product->stock_quantity > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <button type="button"
                                    onclick="handleAddWithColor({{ $product->id }})" 
                                    style="background-color: #db2777; color: #ffffff;"
                                    class="w-full py-3.5 px-5 rounded-lg font-semibold hover:opacity-95 active:scale-[0.98] transition-all duration-200 flex items-center justify-center space-x-2 shadow-md cursor-pointer"
                                    aria-label="Add {{ $product->name }} to cart">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <span>Add to Cart</span>
                            </button>

                            <a href="{{ $waUrl }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               style="background-color: #059669; color: #ffffff;"
                               class="w-full py-3.5 px-5 rounded-lg font-semibold hover:opacity-95 active:scale-[0.98] transition-all duration-200 flex items-center justify-center space-x-2 shadow-md cursor-pointer"
                               aria-label="Inquire about {{ $product->name }} on WhatsApp">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M17.472 14.382c-.301-.15-1.781-.878-2.057-.978-.277-.1-.478-.15-.68.15-.201.3-.777.978-.953 1.179-.175.2-.351.225-.652.075-.301-.15-1.272-.469-2.423-1.496-.895-.798-1.5-1.784-1.675-2.085-.176-.301-.019-.464.132-.614.136-.135.301-.351.452-.527.15-.175.201-.3.301-.501.1-.2.05-.376-.025-.526-.075-.15-.68-1.639-.932-2.247-.246-.593-.497-.513-.68-.522-.176-.009-.377-.01-.578-.01-.201 0-.527.075-.803.376s-1.054 1.03-1.054 2.512c0 1.482 1.079 2.914 1.23 3.115.15.2 2.124 3.243 5.145 4.547.719.311 1.28.497 1.718.637.722.23 1.379.197 1.898.12.578-.087 1.781-.728 2.032-1.432.251-.704.251-1.307.176-1.432-.075-.126-.276-.201-.577-.351zm-5.467 7.618a9.947 9.947 0 0 1-5.074-1.391l-.364-.216-3.771.989 1.006-3.677-.237-.377A9.948 9.948 0 0 1 2.05 12c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10zm0-22C5.373 0 0 5.373 0 12c0 2.116.554 4.103 1.523 5.836L0 24l6.326-1.66A11.95 11.95 0 0 0 12.005 24C18.627 24 24 18.627 24 12S18.627 0 12.005 0z"/>
                                </svg>
                                <span>Inquire</span>
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <button disabled 
                                    style="background-color: #e5e7eb; color: #6b7280;"
                                    class="w-full py-3.5 px-5 rounded-lg font-semibold cursor-not-allowed">
                                Out of Stock
                            </button>
                            <a href="{{ $waUrl }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               style="background-color: #059669; color: #ffffff;"
                               class="w-full py-3.5 px-5 rounded-lg font-semibold hover:opacity-95 active:scale-[0.98] transition-all duration-200 flex items-center justify-center space-x-2 shadow-md cursor-pointer"
                               aria-label="Inquire about restock on WhatsApp">
                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M17.472 14.382c-.301-.15-1.781-.878-2.057-.978-.277-.1-.478-.15-.68.15-.201.3-.777.978-.953 1.179-.175.2-.351.225-.652.075-.301-.15-1.272-.469-2.423-1.496-.895-.798-1.5-1.784-1.675-2.085-.176-.301-.019-.464.132-.614.136-.135.301-.351.452-.527.15-.175.201-.3.301-.501.1-.2.05-.376-.025-.526-.075-.15-.68-1.639-.932-2.247-.246-.593-.497-.513-.68-.522-.176-.009-.377-.01-.578-.01-.201 0-.527.075-.803.376s-1.054 1.03-1.054 2.512c0 1.482 1.079 2.914 1.23 3.115.15.2 2.124 3.243 5.145 4.547.719.311 1.28.497 1.718.637.722.23 1.379.197 1.898.12.578-.087 1.781-.728 2.032-1.432.251-.704.251-1.307.176-1.432-.075-.126-.276-.201-.577-.351zm-5.467 7.618a9.947 9.947 0 0 1-5.074-1.391l-.364-.216-3.771.989 1.006-3.677-.237-.377A9.948 9.948 0 0 1 2.05 12c0-5.514 4.486-10 10-10s10 4.486 10 10-4.486 10-10 10zm0-22C5.373 0 0 5.373 0 12c0 2.116.554 4.103 1.523 5.836L0 24l6.326-1.66A11.95 11.95 0 0 0 12.005 24C18.627 24 24 18.627 24 12S18.627 0 12.005 0z"/>
                                </svg>
                                <span>Inquire Restock</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- You May Also Like -->
        @if($similarProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">You May Also Like</h2>
                <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 xl:gap-4">
                    @foreach($similarProducts as $similarProduct)
                        @include('components.product-card', ['product' => $similarProduct])
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
                        <span class="text-sm text-gray-600 ml-2">@php
                            $avgVal = (float)($product->reviews_count > 0 ? $product->average_rating : 5);
                            $avgDisplay = ($avgVal == (int)$avgVal) ? (int)$avgVal : rtrim(rtrim(number_format($avgVal, 1), '0'), '.');
                        @endphp
                        {{ $avgDisplay }}/5</span>
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
        // Basic setup on enter
        const rect = container.getBoundingClientRect();
        panel.style.display   = 'none'; // Will show only when over image
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

        // Check if mouse is over the actual image area
        const x = e.clientX;
        const y = e.clientY;
        const isOverImage = (x >= imgRect.left && x <= imgRect.right && y >= imgRect.top && y <= imgRect.bottom);

        if (!isOverImage) {
            lens.classList.add('hidden');
            panel.style.display = 'none';
            return;
        }

        // Show them if over image
        lens.classList.remove('hidden');
        panel.style.display = 'block';

        const lensW     = lens.offsetWidth;
        const lensH     = lens.offsetHeight;
        const panelW    = panel.offsetWidth;
        const panelH    = panel.offsetHeight;

        // Cursor position relative to container
        let cx = x - rect.left;
        let cy = y - rect.top;

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
        // Open at the currently active thumbnail index
        const activeThumb = document.querySelector('.thumb-btn.border-pink-500');
        const idx = activeThumb ? parseInt(activeThumb.dataset.thumbIndex ?? 0) : 0;
        lbOpen(idx);
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
        if (e.key === 'ArrowRight') lbNext();
        if (e.key === 'ArrowLeft')  lbPrev();
    });

    // Prev/Next buttons
    const lbPrevBtn = document.getElementById('lb-prev');
    const lbNextBtn = document.getElementById('lb-next');
    lbPrevBtn && lbPrevBtn.addEventListener('click', function(e) { e.stopPropagation(); lbPrev(); });
    lbNextBtn && lbNextBtn.addEventListener('click', function(e) { e.stopPropagation(); lbNext(); });
});

// ---------- Color Selection Helpers ----------
function handleColorSelect(name, btn) {
    // Update hidden input
    document.getElementById('selected-color-input').value = name;
    
    // Update label
    document.getElementById('color-label').textContent = name;
    
    // Reset all buttons
    document.querySelectorAll('.color-option-btn .rounded-full').forEach(el => {
        el.classList.remove('border-pink-600', 'ring-2', 'ring-pink-200');
        el.classList.add('border-gray-200');
        el.querySelector('.selected-check').classList.add('hidden');
    });
    
    // Highlight selected
    const circle = btn.querySelector('.rounded-full');
    circle.classList.remove('border-gray-200');
    circle.classList.add('border-pink-600', 'ring-2', 'ring-pink-200');
    circle.querySelector('.selected-check').classList.remove('hidden');
}

function handleAddWithColor(productId) {
    const colorInput = document.getElementById('selected-color-input');
    const color = colorInput ? colorInput.value : null;
    
    // If colors exist but none selected, alert user
    if (colorInput && !color) {
        showToast('Please select a color first', 'error');
        
        // Pulse the color section to draw attention
        const colorSection = colorInput.parentElement;
        colorSection.classList.add('animate-pulse');
        setTimeout(() => colorSection.classList.remove('animate-pulse'), 1000);
        return;
    }
    
    addToCart(productId, 1, color);
}

// ---------- Variant selector ----------
const basePrice         = {{ (float) $product->price }};
const basePriceFormatted = 'KES {{ number_format($product->price, 0) }}';
const baseOriginalPrice  = {{ $product->original_price ? (float)$product->original_price : 'null' }};

function handleVariantChange(btn) {
    // Active pill state
    document.querySelectorAll('.variant-btn').forEach(b => {
        b.classList.remove('border-pink-500', 'text-pink-600', 'bg-pink-50');
        b.classList.add('border-gray-200', 'text-gray-700');
        const sub = b.querySelector('span');
        if (sub) sub.classList.replace('text-pink-400', 'text-gray-400');
    });
    btn.classList.add('border-pink-500', 'text-pink-600', 'bg-pink-50');
    btn.classList.remove('border-gray-200', 'text-gray-700');
    const sub = btn.querySelector('span');
    if (sub) sub.classList.replace('text-gray-400', 'text-pink-400');

    // Label
    const labelEl = document.getElementById('variant-label');
    if (labelEl) labelEl.textContent = btn.dataset.label;

    // Resolve prices
    const rawPrice    = btn.dataset.price;
    const rawOriginal = btn.dataset.originalPrice;
    const price    = rawPrice    && rawPrice    !== '' ? parseFloat(rawPrice)    : basePrice;
    const original = rawOriginal && rawOriginal !== '' ? parseFloat(rawOriginal) : null;

    // Update main price
    const priceEl = document.getElementById('product-price');
    if (priceEl) priceEl.textContent = 'KES ' + price.toLocaleString('en-KE', { maximumFractionDigits: 0 });

    // Update strikethrough + badge
    const origEl  = document.getElementById('product-original-price');
    const badgeEl = document.getElementById('product-discount-badge');

    if (original && original > price) {
        if (origEl)  { origEl.textContent  = 'KES ' + original.toLocaleString('en-KE', { maximumFractionDigits: 0 }); origEl.classList.remove('hidden'); }
        if (badgeEl) { badgeEl.textContent = Math.round(((original - price) / original) * 100) + '% OFF'; badgeEl.classList.remove('hidden'); }
    } else {
        if (origEl)  origEl.classList.add('hidden');
        if (badgeEl) badgeEl.classList.add('hidden');
    }
}

// Auto-select first (cheapest) variant on load
document.addEventListener('DOMContentLoaded', function () {
    const firstVariant = document.querySelector('.variant-btn');
    if (firstVariant) handleVariantChange(firstVariant);
});

// ---------- Gallery lightbox state ----------
const lbImages = @json(array_map(fn($p) => \App\Helpers\ImageHelper::getProductImageUrl($p), $galleryImages));
let lbIndex = 0;

function lbOpen(index) {
    lbIndex = index;
    lbRender();
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.remove('hidden');
    lightbox.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function lbGoTo(index) {
    lbIndex = index;
    lbRender();
}

function lbNext() {
    lbIndex = (lbIndex + 1) % lbImages.length;
    lbRender();
}

function lbPrev() {
    lbIndex = (lbIndex - 1 + lbImages.length) % lbImages.length;
    lbRender();
}

function lbRender() {
    const img  = document.getElementById('lightbox-img');
    const curr = document.getElementById('lb-counter-current');

    if (img) {
        img.style.opacity = '0';
        setTimeout(() => {
            img.src = lbImages[lbIndex];
            img.style.opacity = '1';
        }, 150);
    }
    if (curr) curr.textContent = lbIndex + 1;

    // Update thumbnail active state
    document.querySelectorAll('.lb-thumb').forEach(btn => {
        const i = parseInt(btn.dataset.lbIndex);
        btn.classList.toggle('border-pink-500', i === lbIndex);
        btn.classList.toggle('border-white/30', i !== lbIndex);
    });
}

// ---------- Extra image thumbnail switcher ----------
function switchMainImage(url, thumbBtn) {
    const mainImg = document.getElementById('zoom-img');
    const panel   = document.getElementById('zoom-panel');

    if (mainImg) {
        mainImg.src = url;
        if (panel) panel.style.backgroundImage = `url('${url}')`;
    }

    // Update active thumbnail border + track index for lightbox
    document.querySelectorAll('.thumb-btn').forEach((btn, i) => {
        const isActive = btn === thumbBtn;
        btn.classList.toggle('border-pink-500', isActive);
        btn.classList.toggle('border-gray-200', !isActive);
        if (isActive) lbIndex = i;
    });
}
</script>
@endsection
