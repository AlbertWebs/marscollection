@extends('layouts.admin')

@section('title', 'Edit Bundle')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Edit Bundle</h1>
        <a href="{{ route('admin.bundles.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
            Back to Bundles
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Bundle Information</h3>
        </div>
        
        <form method="POST" action="{{ route('admin.bundles.update', $bundle) }}" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Bundle Name</label>
                <input type="text" name="name" id="name" 
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"
                       value="{{ old('name', $bundle->name) }}" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <div id="description-editor" class="bg-white border border-gray-300 rounded-md @error('description') border-red-500 @enderror" style="min-height: 200px;"></div>
                <textarea id="description" name="description" class="hidden">{{ old('description', $bundle->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">
                    Bundle Price (KSh)
                    <span id="savings-display" class="text-sm font-normal text-gray-500 ml-2"></span>
                </label>
                <input type="number" name="price" id="price" step="0.01" min="0"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"
                       value="{{ old('price', $bundle->price) }}" required>
                <div id="price-breakdown" class="mt-2 text-sm text-gray-600 hidden">
                    <div>Individual Products Total: <span id="individual-total" class="font-medium">KSh 0</span></div>
                    <div>Bundle Price: <span id="bundle-price-display" class="font-medium">KSh 0</span></div>
                    <div class="text-green-600 font-medium">You Save: <span id="savings-amount">KSh 0</span></div>
                </div>
                @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Products in Bundle</label>
                
                <!-- Search Input -->
                <div class="mt-2 mb-4">
                    <input type="text" id="product-search" placeholder="Search products by name, brand, or category..."
                           class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                
                <!-- Search Results -->
                <div id="search-results" class="border border-gray-300 rounded-md p-4 max-h-80 overflow-y-auto mb-4">
                    <div class="text-center text-gray-500 py-8">
                        <p>Start typing to search for products...</p>
                    </div>
                </div>
                
                <!-- Selected Products Display -->
                <div id="selected-products" class="p-4 bg-gray-50 rounded-md border border-gray-200">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Selected Products (<span id="selected-count">0</span>)</h4>
                    <div id="selected-list" class="space-y-2">
                        @php
                            $selectedProducts = $bundle->bundleItems->pluck('product_id')->toArray();
                        @endphp
                        @if(count($selectedProducts) > 0)
                            @foreach($bundle->bundleItems as $bundleItem)
                                <div id="selected-{{ $bundleItem->product->id }}" class="flex items-center justify-between p-2 bg-white rounded-md border border-gray-200">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-900">{{ $bundleItem->product->name }}</div>
                                        <div class="ml-2 text-sm text-gray-500">
                                            KSh {{ number_format($bundleItem->product->price) }}
                                            @if($bundleItem->product->brand)
                                                • {{ $bundleItem->product->brand->name }}
                                            @endif
                                        </div>
                                    </div>
                                    <button type="button" class="remove-product text-red-600 hover:text-red-800" data-product-id="{{ $bundleItem->product->id }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-gray-500 italic">No products selected yet. Use the search above to find and add products.</p>
                        @endif
                    </div>
                </div>
                
                <!-- Hidden inputs for selected products -->
                <div id="hidden-inputs">
                    @foreach($selectedProducts as $productId)
                        <input type="hidden" name="products[]" value="{{ $productId }}">
                    @endforeach
                </div>
                
                @error('products')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1"
                           class="rounded-md border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                           {{ old('is_active', $bundle->is_active) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-900">Active Bundle</span>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.bundles.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-md">
                    Update Bundle
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('product-search');
    const searchResults = document.getElementById('search-results');
    const selectedList = document.getElementById('selected-list');
    const selectedCount = document.getElementById('selected-count');
    const hiddenInputs = document.getElementById('hidden-inputs');
    const priceInput = document.getElementById('price');
    const savingsDisplay = document.getElementById('savings-display');
    const priceBreakdown = document.getElementById('price-breakdown');
    const individualTotal = document.getElementById('individual-total');
    const bundlePriceDisplay = document.getElementById('bundle-price-display');
    const savingsAmount = document.getElementById('savings-amount');
    
    // Initialize with existing selected products
    let selectedProducts = new Set();
    let selectedProductsData = new Map(); // Store product data for calculations
    
    @foreach($bundle->bundleItems as $bundleItem)
        selectedProducts.add({{ $bundleItem->product->id }});
        selectedProductsData.set({{ $bundleItem->product->id }}, {
            id: {{ $bundleItem->product->id }},
            name: '{{ $bundleItem->product->name }}',
            price: {{ $bundleItem->product->price }},
            brand: '{{ $bundleItem->product->brand ? $bundleItem->product->brand->name : '' }}',
            category: '{{ $bundleItem->product->category ? $bundleItem->product->category->name : '' }}'
        });
    @endforeach
    
    let searchTimeout;
    let currentPage = 1;
    let isLoading = false;
    
    // Update initial count and price calculation
    updateSelectedCount();
    updatePriceCalculation();
    
    // Search functionality
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            if (query.length >= 2) {
                searchProducts(query, 1);
            } else if (query.length === 0) {
                showInitialMessage();
            }
        }, 300);
    });
    
    function searchProducts(query, page = 1) {
        if (isLoading) return;
        
        isLoading = true;
        showLoading();
        
        fetch(`{{ route('admin.search-products') }}?q=${encodeURIComponent(query)}&page=${page}`)
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data.products, data.pagination);
                currentPage = page;
                isLoading = false;
            })
            .catch(error => {
                console.error('Search error:', error);
                showError('Error searching products. Please try again.');
                isLoading = false;
            });
    }
    
    function displaySearchResults(products, pagination) {
        if (products.length === 0) {
            searchResults.innerHTML = '<div class="text-center text-gray-500 py-8"><p>No products found matching your search.</p></div>';
            return;
        }
        
        let html = '<div class="space-y-2">';
        
        products.forEach(product => {
            const isSelected = selectedProducts.has(product.id);
            const brandName = product.brand ? product.brand.name : '';
            const categoryName = product.category ? product.category.name : '';
            
            html += `
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-md hover:bg-gray-50">
                    <div class="flex items-center">
                        <input type="checkbox" 
                               class="product-checkbox rounded-md border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                               data-product-id="${product.id}"
                               data-product-name="${product.name}"
                               data-product-price="${product.price}"
                               data-product-brand="${brandName}"
                               data-product-category="${categoryName}"
                               ${isSelected ? 'checked' : ''}>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">${product.name}</div>
                            <div class="text-sm text-gray-500">
                                KSh ${Number(product.price).toLocaleString()}
                                ${brandName ? ` • ${brandName}` : ''}
                                ${categoryName ? ` • ${categoryName}` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        
        // Add pagination if there are more pages
        if (pagination.has_more) {
            html += `
                <div class="mt-4 text-center">
                    <button type="button" id="load-more" 
                            class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-md text-sm">
                        Load More Products
                    </button>
                </div>
            `;
        }
        
        searchResults.innerHTML = html;
        
        // Add event listeners to checkboxes
        document.querySelectorAll('.product-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', handleProductSelection);
        });
        
        // Add load more functionality
        const loadMoreBtn = document.getElementById('load-more');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', () => {
                searchProducts(searchInput.value.trim(), currentPage + 1);
            });
        }
    }
    
    function handleProductSelection(event) {
        const checkbox = event.target;
        const productId = parseInt(checkbox.dataset.productId);
        const productData = {
            id: productId,
            name: checkbox.dataset.productName,
            price: parseFloat(checkbox.dataset.productPrice),
            brand: checkbox.dataset.productBrand,
            category: checkbox.dataset.productCategory
        };
        
        if (checkbox.checked) {
            selectedProducts.add(productId);
            selectedProductsData.set(productId, productData);
            addSelectedProduct(productData);
        } else {
            selectedProducts.delete(productId);
            selectedProductsData.delete(productId);
            removeSelectedProduct(productId);
        }
        
        updateHiddenInputs();
        updateSelectedCount();
        updatePriceCalculation();
    }
    
    function addSelectedProduct(product) {
        const productElement = document.createElement('div');
        productElement.id = `selected-${product.id}`;
        productElement.className = 'flex items-center justify-between p-2 bg-white rounded-md border border-gray-200';
        productElement.innerHTML = `
            <div class="flex items-center">
                <div class="text-sm font-medium text-gray-900">${product.name}</div>
                <div class="ml-2 text-sm text-gray-500">
                    KSh ${Number(product.price).toLocaleString()}
                    ${product.brand ? ` • ${product.brand}` : ''}
                </div>
            </div>
            <button type="button" class="remove-product text-red-600 hover:text-red-800" data-product-id="${product.id}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        `;
        
        // Remove the "no products" message if it exists
        const noProductsMsg = selectedList.querySelector('.text-gray-500.italic');
        if (noProductsMsg) {
            noProductsMsg.remove();
        }
        
        selectedList.appendChild(productElement);
        
        // Add remove functionality
        productElement.querySelector('.remove-product').addEventListener('click', () => {
            removeSelectedProduct(product.id);
            selectedProductsData.delete(product.id);
            // Uncheck the checkbox in search results
            const searchCheckbox = document.querySelector(`[data-product-id="${product.id}"]`);
            if (searchCheckbox) {
                searchCheckbox.checked = false;
            }
            updatePriceCalculation();
        });
    }
    
    function removeSelectedProduct(productId) {
        const productElement = document.getElementById(`selected-${productId}`);
        if (productElement) {
            productElement.remove();
        }
        
        // Show "no products" message if no products are selected
        if (selectedProducts.size === 0) {
            selectedList.innerHTML = '<p class="text-sm text-gray-500 italic">No products selected yet. Use the search above to find and add products.</p>';
        }
    }
    
    function updateHiddenInputs() {
        hiddenInputs.innerHTML = '';
        selectedProducts.forEach(productId => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'products[]';
            input.value = productId;
            hiddenInputs.appendChild(input);
        });
    }
    
    function updateSelectedCount() {
        selectedCount.textContent = selectedProducts.size;
    }
    
    function showLoading() {
        searchResults.innerHTML = '<div class="text-center text-gray-500 py-8"><p>Searching products...</p></div>';
    }
    
    function showError(message) {
        searchResults.innerHTML = `<div class="text-center text-red-500 py-8"><p>${message}</p></div>`;
    }
    
    function showInitialMessage() {
        searchResults.innerHTML = '<div class="text-center text-gray-500 py-8"><p>Start typing to search for products...</p></div>';
    }
    
    // Add event listeners to existing remove buttons
    document.querySelectorAll('.remove-product').forEach(button => {
        button.addEventListener('click', function() {
            const productId = parseInt(this.dataset.productId);
            removeSelectedProduct(productId);
            selectedProducts.delete(productId);
            selectedProductsData.delete(productId);
            updateHiddenInputs();
            updateSelectedCount();
            updatePriceCalculation();
        });
    });
    
    function updatePriceCalculation() {
        const bundlePrice = parseFloat(priceInput.value) || 0;
        const individualTotalPrice = Array.from(selectedProductsData.values())
            .reduce((sum, product) => sum + product.price, 0);
        
        const savings = individualTotalPrice - bundlePrice;
        const savingsPercentage = individualTotalPrice > 0 ? (savings / individualTotalPrice * 100) : 0;
        
        // Update display elements
        individualTotal.textContent = `KSh ${individualTotalPrice.toLocaleString()}`;
        bundlePriceDisplay.textContent = `KSh ${bundlePrice.toLocaleString()}`;
        savingsAmount.textContent = `KSh ${savings.toLocaleString()}`;
        
        // Update savings display in label
        if (selectedProducts.size > 0 && bundlePrice > 0) {
            if (savings > 0) {
                savingsDisplay.textContent = `(Save KSh ${savings.toLocaleString()} - ${savingsPercentage.toFixed(1)}% off)`;
                savingsDisplay.className = 'text-sm font-normal text-green-600 ml-2';
                priceBreakdown.classList.remove('hidden');
            } else if (savings < 0) {
                savingsDisplay.textContent = `(KSh ${Math.abs(savings).toLocaleString()} more than individual)`;
                savingsDisplay.className = 'text-sm font-normal text-red-600 ml-2';
                priceBreakdown.classList.remove('hidden');
            } else {
                savingsDisplay.textContent = '(Same as individual prices)';
                savingsDisplay.className = 'text-sm font-normal text-gray-500 ml-2';
                priceBreakdown.classList.remove('hidden');
            }
        } else {
            savingsDisplay.textContent = '';
            priceBreakdown.classList.add('hidden');
        }
    }
    
    // Add event listener to price input
    priceInput.addEventListener('input', updatePriceCalculation);
});
</script>
@endsection 