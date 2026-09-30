@php
    // Handle both array and object data
    $bundleName = is_object($bundle) ? $bundle->name : $bundle['name'];
    $bundleImage = is_object($bundle) ? $bundle->image : $bundle['image'];
    $bundleCategory = is_object($bundle) ? $bundle->category : $bundle['category'];
    $bundlePrice = is_object($bundle) ? $bundle->formatted_price : $bundle['price'];
    $bundleOriginalPrice = is_object($bundle) ? $bundle->formatted_original_price : ($bundle['original_price'] ?? null);
    $bundleRating = is_object($bundle) ? $bundle->rating : $bundle['rating'];
    $bundleDescription = is_object($bundle) ? $bundle->description : ($bundle['description'] ?? null);
    $bundleBadge = is_object($bundle) ? $bundle->badge : ($bundle['badge'] ?? null);
    $bundleBadgeColor = is_object($bundle) ? $bundle->badge_color : ($bundle['badge_color'] ?? null);
    $bundleReviewCount = is_object($bundle) ? $bundle->review_count : ($bundle['review_count'] ?? 0);
    $bundleId = is_object($bundle) ? $bundle->id : ($bundle['id'] ?? null);
    
    // Show 5/5 stars when no reviews, formatting whole numbers without decimal points
    $numericRating = (float)($bundleRating > 0 ? $bundleRating : 5);
    $displayRating = ($numericRating == (int)$numericRating) ? (int)$numericRating : rtrim(rtrim(number_format($numericRating, 1), '0'), '.');
@endphp

<div class="bg-white rounded-md overflow-hidden group shadow-sm hover:shadow-lg transition-shadow duration-300">
    <div class="relative overflow-hidden">
        <img src="{{ $bundleImage }}" 
             alt="{{ $bundleName }}" 
             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
        
        <!-- Hover Overlay with Add to Cart Button -->
        <div class="absolute inset-0 bg-gray-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
            <button onclick="addBundleToCart({{ $bundleId }})" class="bg-white text-gray-900 px-6 py-3 rounded-md font-semibold hover:bg-amber-600 hover:text-white transition-all duration-300 transform hover:scale-105 flex items-center space-x-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span>Add Bundle to Cart</span>
            </button>
        </div>
        
        @if($bundleBadge)
            <div class="absolute top-2 left-2 z-10">
                <span class="bg-{{ $bundleBadgeColor ?? 'pink' }}-500 text-white px-3 py-0.5 rounded-full text-sm font-semibold">{{ $bundleBadge }}</span>
            </div>
        @endif
    </div>
    <div class="p-4">
        <div class="text-xs text-gray-400 uppercase tracking-wide mb-1">{{ $bundleCategory }}</div>
        <h3 class="text-md font-semibold text-gray-900 mb-2">{{ $bundleName }}</h3>
        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $bundleDescription }}</p>
        <div class="flex flex-col mb-4">
            <div class="flex items-center space-x-2">
                <span class="text-xl font-bold text-gray-900">{{ $bundlePrice }}</span>
                @if($bundleOriginalPrice)
                    <span class="text-gray-400 line-through">{{ $bundleOriginalPrice }}</span>
                @endif
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <div class="flex text-amber-400 mr-2">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                    @endfor
                </div>
                <span>({{ $displayRating }}/5)</span>
                <span class="mx-1">|</span>
                @if($bundleReviewCount > 0)
                    <span>({{ $bundleReviewCount }} reviews)</span>
                @else
                    <span>(No reviews yet)</span>
                @endif
            </div>
        </div>
        
        <!-- Quick Add to Cart Button -->
        <button onclick="addBundleToCart({{ $bundleId }})" class="w-full bg-amber-600 text-white py-2 px-4 rounded-md font-semibold hover:bg-amber-700 transition-colors duration-200 flex items-center justify-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <span>Add to Cart</span>
        </button>
    </div>
</div> 