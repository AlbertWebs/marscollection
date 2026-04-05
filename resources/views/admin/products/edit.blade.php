@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Edit Product</h1>
        <a href="{{ route('admin.products.index') }}" 
           class="text-pink-600 hover:text-pink-700 text-sm sm:text-base">
            ← Back to Products
        </a>
    </div>

    <!-- Product Form -->
    <div class="bg-white shadow rounded-md p-4 lg:p-6">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price (KSh)</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('price') border-red-500 @enderror">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Original Price -->
                <div>
                    <label for="original_price" class="block text-sm font-medium text-gray-700">Original Price (KSh) <span class="text-gray-400 font-normal">- for showing discounts</span></label>
                    <input type="number" id="original_price" name="original_price" value="{{ old('original_price', $product->original_price) }}" step="0.01" min="0"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('original_price') border-red-500 @enderror">
                    @error('original_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select id="category_id" name="category_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('category_id') border-red-500 @enderror">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Brand -->
                <div>
                    <label for="brand_id" class="block text-sm font-medium text-gray-700">Brand</label>
                    <select id="brand_id" name="brand_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('brand_id') border-red-500 @enderror">
                        <option value="">Select a brand</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stock -->
                <div>
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                    <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('stock_quantity') border-red-500 @enderror">
                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('sku') border-red-500 @enderror">
                    @error('sku')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Badge -->
                <div>
                    <label for="badge" class="block text-sm font-medium text-gray-700">Badge <span class="text-gray-400 font-normal">- label shown on product card</span></label>
                    <input type="text" id="badge" name="badge" value="{{ old('badge', $product->badge) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm"
                           placeholder="e.g. NEW, SALE, HOT">
                </div>

                <!-- Badge Color -->
                <div>
                    <label for="badge_color" class="block text-sm font-medium text-gray-700">Badge Color</label>
                    <select id="badge_color" name="badge_color"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                        <option value="">None</option>
                        <option value="pink" {{ old('badge_color', $product->badge_color) === 'pink' ? 'selected' : '' }}>Pink</option>
                        <option value="red" {{ old('badge_color', $product->badge_color) === 'red' ? 'selected' : '' }}>Red</option>
                        <option value="green" {{ old('badge_color', $product->badge_color) === 'green' ? 'selected' : '' }}>Green</option>
                        <option value="blue" {{ old('badge_color', $product->badge_color) === 'blue' ? 'selected' : '' }}>Blue</option>
                        <option value="yellow" {{ old('badge_color', $product->badge_color) === 'yellow' ? 'selected' : '' }}>Yellow</option>
                        <option value="gray" {{ old('badge_color', $product->badge_color) === 'gray' ? 'selected' : '' }}>Gray</option>
                    </select>
                </div>

                <!-- Colors Tag Builder -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Available Colors
                        <span class="text-gray-400 font-normal">- optional, customers select one when adding to cart</span>
                    </label>

                    {{-- Hidden input submitted with form --}}
                    <input type="hidden" id="edit-colors" name="colors"
                           value="{{ old('colors', is_array($product->colors) ? implode(',', $product->colors) : '') }}">

                    {{-- Chips display --}}
                    <div id="edit-color-tags" class="flex flex-wrap gap-2 mb-3 min-h-[36px]"></div>

                    {{-- Add row --}}
                    <div class="flex items-center gap-2">
                        <input type="color" id="edit-color-picker" value="#ec4899"
                               class="h-9 w-12 cursor-pointer border border-gray-300 rounded-md p-0.5">
                        <input type="text" id="edit-color-name-input" placeholder="Color name (e.g. Rose Pink)"
                               class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm"
                               onkeydown="if(event.key==='Enter'){event.preventDefault();editAddColor();}">
                        <button type="button" onclick="editAddColor()"
                                class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap">
                            + Add Color
                        </button>
                    </div>
                    @error('colors')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Flags -->
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded-md">
                        <span class="ml-2 text-sm text-gray-700">Active Product</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                               class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded-md">
                        <span class="ml-2 text-sm text-gray-700">Featured (shown on homepage)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" id="is_trending" name="is_trending" value="1" {{ old('is_trending', $product->is_trending) ? 'checked' : '' }}
                               class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded-md">
                        <span class="ml-2 text-sm text-gray-700">Trending (shown on homepage)</span>
                    </label>
                </div>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                
                <!-- Current Image Preview -->
                @if($product->image)
                    <div class="mt-2 mb-4">
                        <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                        <div class="flex items-center space-x-4">
                            <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($product->image) }}" alt="{{ $product->name }}"
                                 class="w-24 h-24 object-cover rounded-md border border-gray-200">
                            <div>
                                <p class="text-sm text-gray-500">{{ basename($product->image) }}</p>
                                <p class="text-xs text-gray-400">Click "Choose File" to replace this image</p>
                            </div>
                        </div>
                    </div>
                @endif
                
                <div class="mt-1 flex items-center">
                    <input type="file" id="image" name="image" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 @error('image') border-red-500 @enderror">
                </div>
                <p class="mt-1 text-sm text-gray-500">Upload a new product image (JPG, PNG, GIF). Max size: 2MB. Leave empty to keep current image.</p>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <div id="description-editor" class="bg-white border border-gray-300 rounded-md @error('description') border-red-500 @enderror" style="min-height: 200px;"></div>
                <textarea id="description" name="description" class="hidden">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-center">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-md">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
// ---- Color Tag Builder (Edit Form) ----
(function () {
    const tagsContainer = document.getElementById('edit-color-tags');
    const hiddenInput   = document.getElementById('edit-colors');
    const picker        = document.getElementById('edit-color-picker');
    const nameInput     = document.getElementById('edit-color-name-input');

    if (!tagsContainer || !hiddenInput) return;

    let colors = [];

    // Parse existing product colors from PHP
    @php
        $editColorsJson = '[]';
        if ($product->colors && count($product->colors) > 0) {
            $mapped = array_map(function($c) {
                $parts = explode(':', $c);
                $name = trim($parts[0]);
                $hex  = isset($parts[1]) ? trim($parts[1]) : '#cccccc';
                return ['name' => $name, 'hex' => $hex];
            }, $product->colors);
            $editColorsJson = json_encode(array_values($mapped));
        }
    @endphp
    colors = {!! $editColorsJson !!};

    renderTags();
    sync();

    window.editAddColor = function () {
        const name = nameInput.value.trim();
        const hex  = picker.value || '#cccccc';
        if (!name) { nameInput.focus(); return; }
        colors.push({ name, hex });
        nameInput.value = '';
        renderTags();
        sync();
    };

    function removeColor(idx) {
        colors.splice(idx, 1);
        renderTags();
        sync();
    }

    function renderTags() {
        tagsContainer.innerHTML = '';
        colors.forEach((c, i) => {
            const chip = document.createElement('span');
            chip.className = 'inline-flex items-center gap-1.5 bg-gray-100 border border-gray-200 rounded-full px-3 py-1 text-sm font-medium text-gray-800';
            chip.innerHTML = `
                <span class="inline-block w-4 h-4 rounded-full border border-gray-300 flex-shrink-0" style="background:${c.hex}"></span>
                ${escapeHtml(c.name)}
                <button type="button" onclick="removeColor_edit(${i})" class="ml-1 text-gray-400 hover:text-red-500 leading-none">&times;</button>
            `;
            tagsContainer.appendChild(chip);
        });
    }

    function sync() {
        hiddenInput.value = colors.map(c => `${c.name}:${c.hex}`).join(',');
    }

    function escapeHtml(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    window.removeColor_edit = removeColor;
})();
</script>
@endsection
