<div class="bg-gray-50 rounded-md p-6 lg:sticky lg:top-28">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Filters</h2>
    
    <form method="GET" action="{{ route('products.index') }}" class="space-y-6">
        <!-- Search -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"
                   placeholder="Search products...">
        </div>
        
        <!-- Price Range Inputs -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">Price Range</label>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Min Price</label>
                    <input type="number" 
                           name="min_price" 
                           value="{{ request('min_price', '') }}"
                           placeholder="1000"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Max Price</label>
                    <input type="number" 
                           name="max_price" 
                           value="{{ request('max_price', '') }}"
                           placeholder="50000"
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm">
                </div>
            </div>
        </div>
        
        <!-- Filter Button -->
        <button type="submit" class="w-full bg-pink-600 text-white px-6 py-3 rounded-md hover:bg-pink-700 transition-colors font-semibold">
            Apply Filters
        </button>
        
        <!-- Clear Filters -->
        @if(request('search') || request('min_price') || request('max_price'))
            <a href="{{ route('products.index') }}" class="block w-full text-center text-gray-600 hover:text-gray-800 py-2 text-sm">
                Clear All Filters
            </a>
        @endif
    </form>
    
    <!-- Categories -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <h3 class="text-sm font-medium text-gray-900 mb-3">Categories</h3>
        <div class="space-y-2">
            <a href="{{ route('products.index', array_merge(request()->except(['category_id', 'brand_id']), ['category_id' => ''])) }}" 
               class="block text-sm {{ !request('category_id') ? 'text-pink-600 font-medium' : 'text-gray-600 hover:text-pink-600' }}">
                All Categories
            </a>
            @foreach($activeCategories as $category)
                <a href="{{ route('products.index', array_merge(request()->except(['category_id', 'brand_id']), ['category_id' => $category->id])) }}" 
                   class="block text-sm {{ request('category_id') == $category->id ? 'text-pink-600 font-medium' : 'text-gray-600 hover:text-pink-600' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
    
    <!-- Brands -->
    <div class="mt-6">
        <h3 class="text-sm font-medium text-gray-900 mb-3">Brands</h3>
        <div class="space-y-2">
            <a href="{{ route('products.index', array_merge(request()->except(['category_id', 'brand_id']), ['brand_id' => ''])) }}" 
               class="block text-sm {{ !request('brand_id') ? 'text-pink-600 font-medium' : 'text-gray-600 hover:text-pink-600' }}">
                All Brands
            </a>
            @foreach($brands as $brand)
                <a href="{{ route('products.index', array_merge(request()->except(['category_id', 'brand_id']), ['brand_id' => $brand->id])) }}" 
                   class="block text-sm {{ request('brand_id') == $brand->id ? 'text-pink-600 font-medium' : 'text-gray-600 hover:text-pink-600' }}">
                    {{ $brand->name }}
                </a>
            @endforeach
        </div>
    </div>
    
    <!-- Active Filters Display -->
    @if(request('search') || request('category_id') || request('brand_id') || request('min_price') || request('max_price'))
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-sm font-medium text-gray-900 mb-3">Active Filters:</h3>
            <div class="space-y-2">
                @if(request('search'))
                    <div class="flex items-center justify-between bg-white rounded-md px-3 py-2">
                        <span class="text-sm text-gray-600">Search: "{{ request('search') }}"</span>
                        <a href="{{ route('products.index', array_merge(request()->except('search'), ['search' => ''])) }}" class="text-pink-600 hover:text-pink-800 text-xs">×</a>
                    </div>
                @endif
                @if(request('category_id'))
                    @php $selectedCategory = $activeCategories->find(request('category_id')) @endphp
                    @if($selectedCategory)
                        <div class="flex items-center justify-between bg-white rounded-md px-3 py-2">
                            <span class="text-sm text-gray-600">Category: {{ $selectedCategory->name }}</span>
                            <a href="{{ route('products.index', array_merge(request()->except('category_id'), ['category_id' => ''])) }}" class="text-pink-600 hover:text-pink-800 text-xs">×</a>
                        </div>
                    @endif
                @endif
                @if(request('brand_id'))
                    @php $selectedBrand = $brands->find(request('brand_id')) @endphp
                    @if($selectedBrand)
                        <div class="flex items-center justify-between bg-white rounded-md px-3 py-2">
                            <span class="text-sm text-gray-600">Brand: {{ $selectedBrand->name }}</span>
                            <a href="{{ route('products.index', array_merge(request()->except('brand_id'), ['brand_id' => ''])) }}" class="text-pink-600 hover:text-pink-800 text-xs">×</a>
                        </div>
                    @endif
                @endif
                @if(request('min_price') || request('max_price'))
                    <div class="flex items-center justify-between bg-white rounded-md px-3 py-2">
                        <span class="text-sm text-gray-600">
                            Price: 
                            @if(request('min_price'))${{ request('min_price') }}@endif
                            @if(request('min_price') && request('max_price')) - @endif
                            @if(request('max_price'))${{ request('max_price') }}@endif
                        </span>
                        <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price']), ['min_price' => '', 'max_price' => ''])) }}" class="text-pink-600 hover:text-pink-800 text-xs">×</a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div> 