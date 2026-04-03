<div class="bg-gray-50 rounded-md p-6 lg:sticky lg:top-28">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Filters</h2>

    <form method="GET" action="{{ route('products.index') }}" class="space-y-6">
        <!-- Preserve category/brand slugs through form submit -->
        @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
        @if(request('brand'))<input type="hidden" name="brand" value="{{ request('brand') }}">@endif

        <!-- Search -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500"
                   placeholder="Search products...">
        </div>

        <!-- Price Range -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">Price Range</label>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Min Price</label>
                    <input type="number" name="min_price" value="{{ request('min_price', '') }}"
                           placeholder="1000" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Max Price</label>
                    <input type="number" name="max_price" value="{{ request('max_price', '') }}"
                           placeholder="50000" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500 text-sm">
                </div>
            </div>
        </div>

        <button type="submit" class="w-full bg-pink-600 text-white px-6 py-3 rounded-md hover:bg-pink-700 transition-colors font-semibold">
            Apply Filters
        </button>

        @if(request('search') || request('min_price') || request('max_price'))
            <a href="{{ route('products.index', array_merge(request()->except(['search', 'min_price', 'max_price']))) }}"
               class="block w-full text-center text-gray-600 hover:text-gray-800 py-2 text-sm">
                Clear All Filters
            </a>
        @endif
    </form>

    <!-- Categories -->
    <div class="mt-8 pt-6 border-t border-gray-200">
        <h3 class="text-sm font-medium text-gray-900 mb-3">Categories</h3>
        <div class="space-y-2">
            <a href="{{ route('products.index', array_merge(request()->except('category'), ['page' => 1])) }}"
               class="block text-sm {{ !request('category') ? 'text-pink-600 font-medium' : 'text-gray-600 hover:text-pink-600' }}">
                All Categories
            </a>
            @foreach($activeCategories as $cat)
                <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                   class="block text-sm {{ request('category') === $cat->slug ? 'text-pink-600 font-medium' : 'text-gray-600 hover:text-pink-600' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Brands -->
    <div class="mt-6">
        <h3 class="text-sm font-medium text-gray-900 mb-3">Brands</h3>
        <div class="space-y-2">
            <a href="{{ route('products.index', array_merge(request()->except('brand'), ['page' => 1])) }}"
               class="block text-sm {{ !request('brand') ? 'text-pink-600 font-medium' : 'text-gray-600 hover:text-pink-600' }}">
                All Brands
            </a>
            @foreach($brands as $br)
                <a href="{{ route('products.index', array_merge(request()->except(['brand', 'page']), ['brand' => $br->slug])) }}"
                   class="block text-sm {{ request('brand') === $br->slug ? 'text-pink-600 font-medium' : 'text-gray-600 hover:text-pink-600' }}">
                    {{ $br->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Active Filters -->
    @if(request('search') || request('category') || request('brand') || request('min_price') || request('max_price'))
        <div class="mt-6 pt-6 border-t border-gray-200">
            <h3 class="text-sm font-medium text-gray-900 mb-3">Active Filters:</h3>
            <div class="space-y-2">
                @if(request('search'))
                    <div class="flex items-center justify-between bg-white rounded-md px-3 py-2">
                        <span class="text-sm text-gray-600">Search: "{{ request('search') }}"</span>
                        <a href="{{ route('products.index', array_merge(request()->except('search'))) }}" class="text-pink-600 hover:text-pink-800 text-xs">×</a>
                    </div>
                @endif
                @if(request('category'))
                    @php $selectedCategory = $activeCategories->firstWhere('slug', request('category')) @endphp
                    @if($selectedCategory)
                        <div class="flex items-center justify-between bg-white rounded-md px-3 py-2">
                            <span class="text-sm text-gray-600">Category: {{ $selectedCategory->name }}</span>
                            <a href="{{ route('products.index', array_merge(request()->except('category'))) }}" class="text-pink-600 hover:text-pink-800 text-xs">×</a>
                        </div>
                    @endif
                @endif
                @if(request('brand'))
                    @php $selectedBrand = $brands->firstWhere('slug', request('brand')) @endphp
                    @if($selectedBrand)
                        <div class="flex items-center justify-between bg-white rounded-md px-3 py-2">
                            <span class="text-sm text-gray-600">Brand: {{ $selectedBrand->name }}</span>
                            <a href="{{ route('products.index', array_merge(request()->except('brand'))) }}" class="text-pink-600 hover:text-pink-800 text-xs">×</a>
                        </div>
                    @endif
                @endif
                @if(request('min_price') || request('max_price'))
                    <div class="flex items-center justify-between bg-white rounded-md px-3 py-2">
                        <span class="text-sm text-gray-600">
                            Price:
                            @if(request('min_price'))KES {{ number_format(request('min_price')) }}@endif
                            @if(request('min_price') && request('max_price')) – @endif
                            @if(request('max_price'))KES {{ number_format(request('max_price')) }}@endif
                        </span>
                        <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price']))) }}" class="text-pink-600 hover:text-pink-800 text-xs">×</a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
