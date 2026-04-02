@php
    // Handle both array and object data
    $productName = is_object($product) ? $product->name : $product['name'];
    $productImage = is_object($product) ? $product->image : $product['image'];
    $productCategory = is_object($product) ? $product->category->name : $product['category'];
    $productPrice = is_object($product) ? $product->formatted_price : $product['price'];
    $productOriginalPrice = is_object($product) ? $product->formatted_original_price : ($product['original_price'] ?? null);
    $productRating = is_object($product) ? $product->rating : $product['rating'];
    $productDescription = is_object($product) ? $product->description : ($product['description'] ?? null);
    
    // Show 5/5 stars when no reviews
    $displayRating = $productRating > 0 ? $productRating : 5;
    $productBadge = is_object($product) ? $product->badge : ($product['badge'] ?? null);
    $productBadgeColor = is_object($product) ? $product->badge_color : ($product['badge_color'] ?? null);
    $showWishlist = is_object($product) ? true : ($product['show_wishlist'] ?? false);
    $showAddToCart = is_object($product) ? true : ($product['show_add_to_cart'] ?? false);
    $productId = is_object($product) ? $product->id : ($product['id'] ?? null);
    $productSlug = is_object($product) ? $product->slug : ($product['slug'] ?? null);
    $productBrand = is_object($product) ? ($product->brand->name ?? 'Zayn\'s Beauty') : ($product['brand'] ?? 'Zayn\'s Beauty');
    
    // Handle image URL using helper
    $imageUrl = \App\Helpers\ImageHelper::getProductImageUrl($productImage);
    
    // Generate SEO-friendly alt text
    $altText = $productName . ' - ' . $productBrand . ' ' . $productCategory . ' | Zayn\'s Beauty';
@endphp

<article class="bg-white rounded-md overflow-hidden group cursor-pointer fade-in" itemscope itemtype="https://schema.org/Product">
    <a href="{{ route('products.show', $product) }}" class="block" aria-label="View details for {{ $productName }}">
        <div class="relative overflow-hidden">
            <img src="{{ $imageUrl }}" 
                 alt="{{ $altText }}" 
                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                 loading="lazy"
                 itemprop="image">
            
            <!-- Hover Overlay with Add to Cart Button -->
            <div class="absolute inset-0 bg-gray-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                <button onclick="event.preventDefault(); addToCart({{ $productId }})" 
                        class="bg-white text-gray-900 px-6 py-3 rounded-md font-semibold hover:bg-pink-600 hover:text-white transition-colors duration-200 flex items-center space-x-2 shadow-lg"
                        aria-label="Add {{ $productName }} to cart">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span>Add to Cart</span>
                </button>
            </div>
            
            @if($productBadge)
                <div class="absolute top-2 left-2 z-10">
                    <span class="bg-{{ $productBadgeColor ?? 'pink' }}-500 text-white px-3 py-0.5 rounded-full text-sm font-semibold" aria-label="Product badge: {{ $productBadge }}">{{ $productBadge }}</span>
                </div>
            @endif
            
            @if($showWishlist)
                <div class="absolute top-4 right-4 z-10">
                    <button class="bg-white p-2 rounded-full shadow-md hover:bg-pink-50 transition-colors" aria-label="Add {{ $productName }} to wishlist">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
        <div class="p-4">
            <div class="text-xs text-gray-400 uppercase tracking-wide mb-1" itemprop="category">{{ $productCategory }}</div>
            <h3 class="text-md font-semibold text-gray-900 mb-2" itemprop="name">{{ $productName }}</h3>
            <div class="flex flex-col mb-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 space-y-1 sm:space-y-0">
                    <span class="text-lg sm:text-xl font-bold text-gray-900" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                        <meta itemprop="priceCurrency" content="KES">
                        <meta itemprop="availability" content="https://schema.org/InStock">
                        <span itemprop="price">{{ $productPrice }}</span>
                    </span>
                    @if($productOriginalPrice)
                        <span class="text-sm sm:text-base text-gray-400 line-through">{{ $productOriginalPrice }}</span>
                    @endif
                </div>
                <div class="flex items-center text-xs sm:text-sm text-gray-500">
                    <div class="flex text-pink-400 mr-2" aria-label="Rating: {{ $displayRating }} out of 5 stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $displayRating)
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @else
                                <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <span itemprop="aggregateRating" itemscope itemtype="https://schema.org/AggregateRating">
                        <meta itemprop="ratingValue" content="{{ $displayRating }}">
                        <meta itemprop="bestRating" content="5">
                        <meta itemprop="ratingCount" content="1">
                        <span>({{ $displayRating }}/5)</span>
                    </span>
                </div>
            </div>
        </div>
    </a>
    
    <!-- Hidden structured data -->
    <div class="product-schema">
        <meta itemprop="brand" content="{{ $productBrand }}">
        <meta itemprop="description" content="{{ $productDescription ?? $productName . ' - Premium beauty product from ' . $productBrand }}">
        <meta itemprop="url" content="{{ route('products.show', $product) }}">
    </div>
</article>