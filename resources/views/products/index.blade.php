@extends('layouts.app')

@section('title', 'Beauty Products - Premium Skincare, Makeup & Beauty Accessories | Zayn\'s Beauty')
@section('description', 'Shop premium beauty products including skincare, makeup, and beauty accessories. Discover trending and featured products from top beauty brands. Free shipping on orders over KES 5,000.')
@section('keywords', 'beauty products, skincare, makeup, beauty accessories, premium beauty, beauty brands, trending products, featured products')
@section('canonical', request()->url())

@section('og_type', 'website')
@section('og_image', asset('images/og-image.jpg'))

@section('breadcrumbs')
    <a href="{{ route('home') }}">Home</a>
    <span>/</span>
    <span class="text-gray-500">Products</span>
@endsection

@section('structured_data')
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@@type": "CollectionPage",
    "name": "Beauty Products",
    "description": "Premium beauty products including skincare, makeup, and beauty accessories",
    "url": "{{ request()->url() }}",
    "mainEntity": {
        "@@type": "ItemList",
        "numberOfItems": {{ $products->count() }},
        "itemListElement": [
            @php
                $items = [];
                $validFrom = now()->format('Y-m-d');
                $priceValidUntil = now()->addYear()->format('Y-m-d');
                foreach($products as $index => $product) {
                    $item = [
                        '@type' => 'ListItem',
                        'position' => $index + 1,
                        'item' => [
                            '@type' => 'Product',
                            'name' => $product->name,
                            'description' => $product->description ?? 'Premium beauty product',
                            'url' => route('products.show', $product),
                            'image' => \App\Helpers\ImageHelper::getProductImageUrl($product->image),
                            'brand' => [
                                '@type' => 'Brand',
                                'name' => $product->brand->name ?? 'Zayn\'s Beauty'
                            ],
                            'category' => $product->category->name ?? 'Beauty Products',
                            'offers' => [
                                '@type' => 'Offer',
                                'price' => $product->price,
                                'priceCurrency' => 'KES',
                                'priceValidUntil' => $priceValidUntil,
                                'validFrom' => $validFrom,
                                'availability' => $product->stock_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                                'url' => route('products.show', $product),
                                'hasMerchantReturnPolicy' => [
                                    '@type' => 'MerchantReturnPolicy',
                                    'applicableCountry' => 'KE',
                                    'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
                                    'merchantReturnDays' => 7,
                                    'returnMethod' => 'https://schema.org/ReturnByMail',
                                    'returnFees' => 'https://schema.org/FreeReturn'
                                ],
                                'shippingDetails' => [
                                    '@type' => 'OfferShippingDetails',
                                    'shippingRate' => [
                                        '@type' => 'MonetaryAmount',
                                        'value' => '0',
                                        'currency' => 'KES'
                                    ],
                                    'shippingDestination' => [
                                        '@type' => 'DefinedRegion',
                                        'addressCountry' => 'KE'
                                    ],
                                    'deliveryTime' => [
                                        '@type' => 'ShippingDeliveryTime',
                                        'handlingTime' => [
                                            '@type' => 'QuantitativeValue',
                                            'minValue' => 0,
                                            'maxValue' => 1,
                                            'unitCode' => 'DAY'
                                        ],
                                        'transitTime' => [
                                            '@type' => 'QuantitativeValue',
                                            'minValue' => 1,
                                            'maxValue' => 3,
                                            'unitCode' => 'DAY'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ];
                    // Always include aggregateRating; fall back to 5 stars when no reviews yet
                    $item['item']['aggregateRating'] = [
                        '@type' => 'AggregateRating',
                        'ratingValue' => $product->reviews_count > 0 ? number_format($product->average_rating, 1) : '5.0',
                        'reviewCount' => $product->reviews_count > 0 ? (string) $product->reviews_count : '1',
                        'bestRating' => '5',
                        'worstRating' => '1'
                    ];
                    $items[] = json_encode($item);
                }
                echo implode(",\n            ", $items);
            @endphp
        ]
    }
}
</script>
@endsection

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            @if(request('tag') === 'featured')
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Featured Products</h1>
                <p class="text-gray-600">Discover our handpicked selection of premium beauty products</p>
            @elseif(request('tag') === 'trending')
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Trending Products</h1>
                <p class="text-gray-600">Most popular products loved by our customers</p>
            @else
                <h1 class="text-3xl font-bold text-gray-900 mb-4">All Products</h1>
                <p class="text-gray-600">Discover our complete collection of premium beauty products</p>
            @endif
        </div>
        
        <!-- Mobile Filter Toggle -->
        <div class="lg:hidden mb-6">
            <button id="mobile-filter-toggle" class="w-full bg-pink-600 text-white px-4 py-3 rounded-md hover:bg-pink-700 transition-colors font-semibold flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filters
                <svg id="filter-arrow" class="w-5 h-5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Filters -->
            <div class="lg:col-span-1">
                <div id="mobile-filters" class="hidden lg:block">
                    @include('components.product-filters')
                </div>
            </div>
            
            <div class="lg:col-span-3">
                @if($products->count() > 0)
                    <div class="mb-6">
                        <p class="text-gray-600">Showing {{ $products->count() }} of {{ $products->total() }} products</p>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 xl:gap-4">
                        @foreach($products as $product)
                            @include('components.product-card', ['product' => $product])
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
    const mobileFilters = document.getElementById('mobile-filters');
    const filterArrow = document.getElementById('filter-arrow');
    
    if (mobileFilterToggle && mobileFilters && filterArrow) {
        mobileFilterToggle.addEventListener('click', function() {
            const isHidden = mobileFilters.classList.contains('hidden');
            
            if (isHidden) {
                // Show filters
                mobileFilters.classList.remove('hidden');
                filterArrow.style.transform = 'rotate(180deg)';
            } else {
                // Hide filters
                mobileFilters.classList.add('hidden');
                filterArrow.style.transform = 'rotate(0deg)';
            }
        });
    }
});
</script>
@endsection 