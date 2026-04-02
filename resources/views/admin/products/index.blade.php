@extends('layouts.admin')

@section('title', 'Products Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Products</h1>
        <a href="{{ route('admin.products.create') }}" 
           class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-sm flex items-center w-full sm:w-auto justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Product
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white shadow rounded-sm p-4 lg:p-6">
        <form method="GET" action="{{ route('admin.products.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                    <input type="text" name="search" id="search" 
                           class="mt-1 block w-full border-gray-300 rounded-sm shadow-sm focus:ring-pink-500 focus:border-pink-500"
                           value="{{ request('search') }}" placeholder="Search products...">
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" 
                            class="mt-1 block w-full border-gray-300 rounded-sm shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select name="category" id="category" 
                            class="mt-1 block w-full border-gray-300 rounded-sm shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
                    <select name="brand" id="brand" 
                            class="mt-1 block w-full border-gray-300 rounded-sm shadow-sm focus:ring-pink-500 focus:border-pink-500">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
                <button type="submit" 
                        class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-sm w-full sm:w-auto">
                    Search & Filter
                </button>
                
                @if(request('search') || request('status') || request('category') || request('brand'))
                    <a href="{{ route('admin.products.index') }}" 
                       class="text-gray-600 hover:text-gray-900 text-center sm:text-left">
                        Clear Filters
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white shadow rounded-sm overflow-hidden">
        <div class="px-4 lg:px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h3 class="text-base lg:text-lg font-medium text-gray-900">All Products</h3>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 w-full sm:w-auto">
                    <select id="bulk-action" class="border-gray-300 rounded-sm shadow-sm focus:ring-pink-500 focus:border-pink-500 text-sm">
                        <option value="">Bulk Actions</option>
                        <option value="activate">Activate Selected</option>
                        <option value="deactivate">Deactivate Selected</option>
                        <option value="delete">Delete Selected</option>
                    </select>
                    <button id="apply-bulk-action" 
                            class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-sm text-sm">
                        Apply
                    </button>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 hidden sm:table-header-group">
                    <tr>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="select-all" class="rounded-sm border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                        </th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Category</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Brand</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Stock</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 border-b border-gray-200 sm:border-0">
                            <td class="px-2 sm:px-3 lg:px-6 py-3 sm:py-4 hidden sm:table-cell">
                                <input type="checkbox" name="selected_products[]" value="{{ $product->id }}" 
                                       class="product-checkbox rounded-sm border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                            </td>
                            <td class="px-3 lg:px-6 py-3 sm:py-4">
                                <div class="space-y-1">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5 sm:hidden">
                                                <span class="inline-block mr-2">{{ $product->category->name ?? 'No Category' }}</span>
                                                <span class="inline-block">{{ $product->brand->name ?? 'No Brand' }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2 sm:hidden flex-shrink-0">
                                            <input type="checkbox" name="selected_products[]" value="{{ $product->id }}" 
                                                   class="product-checkbox rounded-sm border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 text-xs sm:text-sm sm:hidden">
                                        <span class="font-medium text-gray-900">KSh {{ number_format($product->price) }}</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                            @if($product->is_active) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <div class="text-xs text-gray-500 sm:hidden">
                                        Stock: {{ $product->stock }}
                                    </div>
                                    <div class="text-sm text-gray-500 hidden sm:block md:hidden">{{ Str::limit($product->description, 40) }}</div>
                                    <div class="text-sm text-gray-500 hidden md:block">{{ Str::limit($product->description, 50) }}</div>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <span class="text-sm text-gray-900">{{ $product->category->name ?? 'No Category' }}</span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                <span class="text-sm text-gray-900">{{ $product->brand->name ?? 'No Brand' }}</span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="text-sm font-medium text-gray-900">KSh {{ number_format($product->price) }}</span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="text-sm text-gray-900">{{ $product->stock }}</span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($product->is_active) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2 sm:flex-col sm:items-start sm:gap-1 lg:flex-row lg:gap-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="text-pink-600 hover:text-pink-900 whitespace-nowrap">Edit</a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" 
                                          class="inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 whitespace-nowrap">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                No products found. <a href="{{ route('admin.products.create') }}" class="text-pink-600 hover:text-pink-700">Add your first product</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
            <div class="px-4 lg:px-6 py-4 border-t border-gray-200">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    const bulkAction = document.getElementById('bulk-action');
    const applyBulkAction = document.getElementById('apply-bulk-action');

    // Select all functionality
    selectAll.addEventListener('change', function() {
        productCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Update select all when individual checkboxes change
    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
            selectAll.checked = checkedBoxes.length === productCheckboxes.length;
            selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < productCheckboxes.length;
        });
    });

    // Bulk actions
    applyBulkAction.addEventListener('click', function() {
        const action = bulkAction.value;
        const selectedProducts = document.querySelectorAll('.product-checkbox:checked');
        
        if (!action) {
            alert('Please select an action');
            return;
        }
        
        if (selectedProducts.length === 0) {
            alert('Please select at least one product');
            return;
        }
        
        if (action === 'delete' && !confirm('Are you sure you want to delete the selected products?')) {
            return;
        }
        
        const productIds = Array.from(selectedProducts).map(checkbox => checkbox.value);
        
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.products.bulk-action") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action';
        actionInput.value = action;
        form.appendChild(actionInput);
        
        productIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'product_ids[]';
            input.value = id;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    });
});
</script>
@endsection 