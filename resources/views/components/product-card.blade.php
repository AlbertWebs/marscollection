@php
    // Handle both array and object data
    $productName = is_object($product) ? $product->name : $product['name'];
    $productImage = is_object($product) ? $product->image : $product['image'];
    $productCategory = is_object($product) ? $product->category->name : $product['category'];
    $productPrice = is_object($product) ? $product->formatted_price : $product['price'];
    $productRawPrice = is_object($product) ? (float) $product->price : (float)($product['price'] ?? 0);
    $productOriginalPrice = is_object($product) ? $product->formatted_original_price : ($product['original_price'] ?? null);
    $rawOrig = is_object($product) ? (float)($product->original_price ?? 0) : (float)($product['original_price'] ?? 0);
    $discountPct = ($rawOrig > $productRawPrice && $rawOrig > 0) ? round((($rawOrig - $productRawPrice) / $rawOrig) * 100) : 0;
    $productRating = is_object($product) ? $product->rating : $product['rating'];
    $reviewCount = is_object($product) ? $product->reviews_count : ($product['review_count'] ?? 0);
    $productDescription = is_object($product) ? $product->description : ($product['description'] ?? null);
    
    $numericRating = (float) $productRating;
    $displayRating = ($numericRating == (int)$numericRating) ? (int)$numericRating : rtrim(rtrim(number_format($numericRating, 1), '0'), '.');
    $productBadge = is_object($product) ? $product->badge : ($product['badge'] ?? null);
    $productBadgeColor = is_object($product) ? $product->badge_color : ($product['badge_color'] ?? null);
    $showWishlist = is_object($product) ? true : ($product['show_wishlist'] ?? false);
    $showAddToCart = is_object($product) ? true : ($product['show_add_to_cart'] ?? false);
    $productId = is_object($product) ? $product->id : ($product['id'] ?? null);
    $productSlug = is_object($product) ? $product->slug : ($product['slug'] ?? null);
    $productBrand = is_object($product) ? ($product->brand->name ?? 'Mars Collection') : ($product['brand'] ?? 'Mars Collection');
    $productColors = is_object($product) ? $product->colors : ($product['colors'] ?? null);
    if (!is_array($productColors) && $productColors) {
        $productColors = json_decode($productColors, true);
    }
    
    // Handle image URL using helper
    $imageUrl = \App\Helpers\ImageHelper::getProductImageUrl($productImage);
    
    // Generate SEO-friendly alt text
    $altText = $productName . ' - ' . $productBrand . ' ' . $productCategory . ' | Mars Collection';
@endphp

<article class="relative bg-white rounded-md overflow-hidden group cursor-pointer fade-in" itemscope itemtype="https://schema.org/Product">

    {{-- Wishlist button sits OUTSIDE the <a> so it never triggers navigation --}}
    @if($showWishlist)
        <div class="absolute top-2 right-2 z-20">
            <button onclick="event.stopPropagation()"
                    class="bg-white p-1.5 rounded-full shadow-md hover:bg-amber-50 transition-colors"
                    aria-label="Add {{ $productName }} to wishlist">
                <svg class="w-4 h-4 text-gray-500 hover:text-amber-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
            </button>
        </div>
    @endif

    <a href="{{ route('products.show', $product) }}" class="block" aria-label="View details for {{ $productName }}">
        <div class="relative overflow-hidden">
            <img src="{{ $imageUrl }}" 
                 alt="{{ $altText }}" 
                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                 loading="lazy"
                 itemprop="image">
            
            <!-- Hover Overlay with Add to Cart Button -->
            <div class="absolute inset-0 bg-gray-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                <button onclick="event.preventDefault(); handleCardAddToCart(this, {{ $productId }})" 
                        class="card-add-btn bg-white text-gray-900 px-6 py-3 rounded-md font-semibold hover:bg-amber-600 hover:text-white transition-colors duration-200 flex items-center space-x-2 shadow-lg"
                        data-selected-color=""
                        aria-label="Add {{ $productName }} to cart">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span>Add to Cart</span>
                </button>
            </div>
            
            {{-- Badges & Percentage Offer overlay on top of image (top-left, opposite heart button) --}}
            <div class="absolute top-2 left-2 z-10 flex flex-col gap-1 items-start pointer-events-none">
                @if($discountPct > 0)
                    <span class="bg-red-600 text-white text-[11px] font-bold px-2 py-0.5 rounded shadow-sm">
                        -{{ $discountPct }}%
                    </span>
                @endif
                @if($productBadge)
                    <span class="bg-{{ $productBadgeColor ?? 'pink' }}-500 text-white px-2.5 py-0.5 rounded-full text-xs font-semibold shadow-sm" aria-label="Product badge: {{ $productBadge }}">{{ $productBadge }}</span>
                @endif
            </div>
        </div>
        <div class="p-3">
            {{-- Category: very muted, purely contextual --}}
            <div class="text-[10px] font-medium text-gray-400 uppercase tracking-wider mb-0.5" itemprop="category">{{ $productCategory }}</div>

            {{-- Name: readable but not dominant, with price as the hero --}}
            <h3 class="text-sm font-medium text-gray-600 leading-snug mb-2 line-clamp-2" itemprop="name">{{ $productName }}</h3>

            {{-- Price and Review in one line --}}
            <div class="flex items-center justify-between gap-1.5 mb-2">
                {{-- Price & Original Price --}}
                <div class="flex items-baseline gap-1.5 flex-wrap min-w-0">
                    <span class="text-base font-bold text-gray-900" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                        <meta itemprop="priceCurrency" content="KES">
                        @php
                            $stockAvailability = (is_object($product) && isset($product->stock_quantity))
                                ? ($product->stock_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock')
                                : 'https://schema.org/InStock';
                        @endphp
                        <meta itemprop="availability" content="{{ $stockAvailability }}">
                        <meta itemprop="price" content="{{ $productRawPrice }}">
                        <meta itemprop="priceValidUntil" content="{{ now()->addYear()->format('Y-m-d') }}">
                        <meta itemprop="validFrom" content="{{ now()->format('Y-m-d') }}">
                        <div itemprop="hasMerchantReturnPolicy" itemscope itemtype="https://schema.org/MerchantReturnPolicy" class="hidden" aria-hidden="true">
                            <meta itemprop="applicableCountry" content="KE">
                            <meta itemprop="returnPolicyCategory" content="https://schema.org/MerchantReturnFiniteReturnWindow">
                            <meta itemprop="merchantReturnDays" content="7">
                            <meta itemprop="returnMethod" content="https://schema.org/ReturnByMail">
                            <meta itemprop="returnFees" content="https://schema.org/FreeReturn">
                        </div>
                        <div itemprop="shippingDetails" itemscope itemtype="https://schema.org/OfferShippingDetails" class="hidden" aria-hidden="true">
                            <div itemprop="shippingRate" itemscope itemtype="https://schema.org/MonetaryAmount">
                                <meta itemprop="value" content="0">
                                <meta itemprop="currency" content="KES">
                            </div>
                            <div itemprop="shippingDestination" itemscope itemtype="https://schema.org/DefinedRegion">
                                <meta itemprop="addressCountry" content="KE">
                            </div>
                            <div itemprop="deliveryTime" itemscope itemtype="https://schema.org/ShippingDeliveryTime">
                                <div itemprop="handlingTime" itemscope itemtype="https://schema.org/QuantitativeValue">
                                    <meta itemprop="minValue" content="0">
                                    <meta itemprop="maxValue" content="1">
                                    <meta itemprop="unitCode" content="DAY">
                                </div>
                                <div itemprop="transitTime" itemscope itemtype="https://schema.org/QuantitativeValue">
                                    <meta itemprop="minValue" content="1">
                                    <meta itemprop="maxValue" content="3">
                                    <meta itemprop="unitCode" content="DAY">
                                </div>
                            </div>
                        </div>
                        {{ $productPrice }}
                    </span>

                    @if($productOriginalPrice)
                        <span class="text-xs text-gray-400 line-through">{{ $productOriginalPrice }}</span>
                    @endif
                </div>

                {{-- Stars & Rating in the same row --}}
                @if($reviewCount > 0 && $productRating > 0)
                <div class="flex items-center gap-1 shrink-0">
                    <div class="flex text-amber-400" aria-label="Rating: {{ $displayRating }} out of 5 stars">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-2.5 h-2.5" fill="{{ $i <= $displayRating ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-[10px] text-gray-400" itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
                        <meta itemprop="ratingValue" content="{{ $displayRating }}">
                        <meta itemprop="bestRating" content="5">
                        <meta itemprop="ratingCount" content="1">
                        {{ $displayRating }}/5
                    </span>
                </div>
                @else
                    <span class="shrink-0 text-[10px] font-medium uppercase tracking-wide text-gray-400">New</span>
                @endif
            </div>

            @if($productColors && count($productColors) > 0)
                <div class="flex flex-wrap gap-1 mb-1 color-swatches-container">
                    @foreach($productColors as $colorOption)
                        @php
                            $parts = explode(':', $colorOption);
                            $cName = trim($parts[0]);
                            $cVal  = isset($parts[1]) ? trim($parts[1]) : $cName;
                        @endphp
                        <div class="w-3 h-3 rounded-full border border-gray-200 shadow-sm swatch-dot transition-all cursor-pointer hover:scale-110"
                             style="background-color: {{ $cVal }};"
                             title="{{ $cName }}"
                             onclick="event.preventDefault(); event.stopPropagation(); selectCardColor(this, '{{ $cName }}')">
                        </div>
                    @endforeach
                    <span class="text-[10px] text-gray-400 ml-0.5 italic selected-color-text"></span>
                </div>
            @endif
        </div>
    </a>
    
    <!-- Hidden structured data -->
    <div class="product-schema">
        <meta itemprop="brand" content="{{ $productBrand }}">
        <meta itemprop="description" content="{{ $productDescription ?? $productName . ' from ' . $productBrand }}">
        <meta itemprop="url" content="{{ route('products.show', $product) }}">
    </div>
</article>
