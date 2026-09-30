@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Edit Product</h1>
        <a href="{{ route('admin.products.index') }}" 
           class="text-amber-600 hover:text-amber-700 text-sm sm:text-base">
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
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price (KSh)</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm @error('price') border-red-500 @enderror">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Original Price -->
                <div>
                    <label for="original_price" class="block text-sm font-medium text-gray-700">Original Price (KSh) <span class="text-gray-400 font-normal">- for showing discounts</span></label>
                    <input type="number" id="original_price" name="original_price" value="{{ old('original_price', $product->original_price) }}" step="0.01" min="0"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm @error('original_price') border-red-500 @enderror">
                    @error('original_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                    <select id="category_id" name="category_id" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm @error('category_id') border-red-500 @enderror">
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
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm @error('brand_id') border-red-500 @enderror">
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
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm @error('stock_quantity') border-red-500 @enderror">
                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm @error('sku') border-red-500 @enderror">
                    @error('sku')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Badge -->
                <div>
                    <label for="badge" class="block text-sm font-medium text-gray-700">Badge <span class="text-gray-400 font-normal">- label shown on product card</span></label>
                    <input type="text" id="badge" name="badge" value="{{ old('badge', $product->badge) }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                           placeholder="e.g. NEW, SALE, HOT">
                </div>

                <!-- Badge Color -->
                <div>
                    <label for="badge_color" class="block text-sm font-medium text-gray-700">Badge Color</label>
                    <select id="badge_color" name="badge_color"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
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
                        <input type="color" id="edit-color-picker" value="#c49a31"
                               class="h-9 w-12 cursor-pointer border border-gray-300 rounded-md p-0.5">
                        <input type="text" id="edit-color-name-input" placeholder="Color name (e.g. Black)"
                               class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                               onkeydown="if(event.key==='Enter'){event.preventDefault();editAddColor();}">
                        <button type="button" onclick="editAddColor()"
                                class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap">
                            + Add Color
                        </button>
                    </div>
                    @error('colors')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Variants (Size / Type) Builder -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Sizes and options <span class="text-gray-400 font-normal">Add shoe sizes or other product options. Each can use its own price or inherit the base price.</span>
                    </label>
                    @php
                        $existingVariants = old('variants', $product->variants ? json_encode($product->variants) : '');
                    @endphp
                    <input type="hidden" id="edit-variants" name="variants" value="{{ $existingVariants }}">
                    <div id="edit-variant-tags" class="flex flex-wrap gap-2 mb-3 min-h-[36px]"></div>
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                        <input type="text" id="edit-variant-label-input" placeholder="Label (e.g. Small, XL, Coconut)"
                               class="sm:col-span-2 border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm"
                               onkeydown="if(event.key==='Enter'){event.preventDefault();editAddVariant();}">
                        <input type="number" id="edit-variant-price-input" placeholder="Price (optional)"
                               min="0" step="1"
                               class="border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                        <input type="number" id="edit-variant-original-price-input" placeholder="Was / Original price"
                               min="0" step="1"
                               class="border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                    </div>
                    <div class="mt-2">
                        <button type="button" onclick="editAddVariant()"
                                class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            + Add Variant
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Leave price blank to use the product's base price. Set "Was" price to show a strikethrough discount on the product page.</p>
                    @error('variants')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Images by shoe option -->
                <div class="lg:col-span-2 rounded-lg border border-gray-200 p-4">
                    <h3 class="text-sm font-semibold text-gray-900">Images by color, size or option</h3>
                    <p class="mt-1 text-xs text-gray-500">Add a photo for a specific color or size. When a shopper selects it, that image becomes the main product photo.</p>
                    <div id="option-image-rows" class="mt-3 space-y-3">
                        @foreach($product->variant_images ?? [] as $imageKey => $imagePath)
                            <div class="flex flex-wrap items-center gap-3 rounded-md bg-gray-50 p-3" data-option-image-key="{{ $imageKey }}" data-existing-image="1">
                                <span class="min-w-32 text-sm font-medium text-gray-700">{{ \Illuminate\Support\Str::headline(str_replace(':', ' ', $imageKey)) }}</span>
                                <input type="file" name="variant_images[{{ $imageKey }}]" accept="image/*" class="min-w-0 flex-1 text-sm" onchange="previewOptionImage(this, this.parentElement.querySelector('img'))">
                                <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($imagePath) }}" alt="{{ $imageKey }} option" class="h-14 w-14 rounded object-cover">
                                <button type="button" data-image-key="{{ $imageKey }}" onclick="removeOptionImageRow(this)" class="text-sm font-medium text-red-600 hover:text-red-800">Remove</button>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3 grid gap-2 sm:grid-cols-[130px_1fr_auto]">
                        <select id="option-image-type" class="rounded-md border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                            <option value="color">Color</option><option value="size">Size</option><option value="option">Other option</option><option value="color_size">Color + size</option>
                        </select>
                        <input id="option-image-label" type="text" placeholder="Option value, e.g. Black or 40" class="rounded-md border-gray-300 text-sm focus:border-amber-500 focus:ring-amber-500">
                        <button type="button" onclick="addOptionImageRow()" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">Add image slot</button>
                    </div>
                    @error('variant_images.*')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Flags -->
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded-md">
                        <span class="ml-2 text-sm text-gray-700">Active Product</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                               class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded-md">
                        <span class="ml-2 text-sm text-gray-700">Featured (shown on homepage)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" id="is_trending" name="is_trending" value="1" {{ old('is_trending', $product->is_trending) ? 'checked' : '' }}
                               class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded-md">
                        <span class="ml-2 text-sm text-gray-700">Trending (shown on homepage)</span>
                    </label>
                </div>
            </div>

            <!-- Main Image Drop Zone -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                <input type="file" id="image" name="image" accept="image/*" class="sr-only">
                <div id="main-drop-zone"
                     class="relative border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center cursor-pointer hover:border-amber-400 transition-colors bg-gray-50"
                     style="width: 200px; height: 200px;"
                     onclick="document.getElementById('image').click()"
                     ondragover="event.preventDefault(); this.classList.add('border-amber-500','bg-amber-50')"
                     ondragleave="this.classList.remove('border-amber-500','bg-amber-50')"
                     ondrop="handleMainDrop(event)">
                    <div id="main-drop-placeholder" class="{{ $product->image ? 'hidden' : '' }} flex flex-col items-center gap-2 py-8 pointer-events-none">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm text-gray-500">Drop image here or <span class="text-amber-600 font-medium">click to browse</span></p>
                        <p class="text-xs text-gray-400">JPG, PNG, WebP. Max 2 MB.</p>
                    </div>
                    <div id="main-drop-preview" class="{{ $product->image ? '' : 'hidden' }} w-full relative">
                        <img id="main-preview-img"
                             src="{{ $product->image ? \App\Helpers\ImageHelper::getProductImageUrl($product->image) : '' }}"
                             alt="Preview" class="w-full h-full object-cover rounded-lg">
                        <button type="button" id="main-preview-clear"
                                onclick="event.stopPropagation(); clearMainImage()"
                                class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                        <p id="main-existing-note" class="{{ $product->image ? '' : 'hidden' }} absolute bottom-2 left-2 bg-black/50 text-white text-xs px-2 py-1 rounded pointer-events-none">Current image. Drop or click to replace.</p>
                    </div>
                </div>
                {{-- Hidden flag to clear image server-side if user removes it --}}
                <input type="hidden" name="clear_image" id="clear-image-flag" value="0">
                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Extra Images Drop Zone -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Extra Images <span class="text-gray-400 font-normal">(up to 8 total)</span></label>
                <input type="file" id="extra_images" name="extra_images[]" accept="image/*" multiple class="sr-only">

                {{-- Existing saved extra images --}}
                @if($product->extra_images && count($product->extra_images) > 0)
                <div id="existing-extras" class="flex flex-wrap gap-2 mb-3">
                    @foreach($product->extra_images as $extraImg)
                    <div class="relative group w-20 h-20 flex-shrink-0" id="existing-{{ md5($extraImg) }}">
                        <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($extraImg) }}"
                             alt="Extra image" class="w-full h-full object-cover rounded-md border border-gray-200">
                        <button type="button"
                                onclick="event.stopPropagation(); deleteExistingExtra('{{ $extraImg }}', '{{ md5($extraImg) }}')"
                                class="absolute -top-1.5 -right-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full w-5 h-5 hidden group-hover:flex items-center justify-center shadow text-xs leading-none">×</button>
                        <input type="hidden" name="keep_extra_images[]" value="{{ $extraImg }}" id="keep-{{ md5($extraImg) }}">
                    </div>
                    @endforeach
                </div>
                @endif

                <div id="extra-drop-zone"
                     class="border-2 border-dashed border-gray-300 rounded-lg p-4 cursor-pointer hover:border-amber-400 transition-colors bg-gray-50"
                     onclick="document.getElementById('extra_images').click()"
                     ondragover="event.preventDefault(); this.classList.add('border-amber-500','bg-amber-50')"
                     ondragleave="this.classList.remove('border-amber-500','bg-amber-50')"
                     ondrop="handleExtraDrop(event)">
                    <div id="extra-drop-placeholder" class="flex flex-col items-center gap-2 py-3 pointer-events-none">
                        <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                        <p class="text-sm text-gray-500">Drop new images or <span class="text-amber-600 font-medium">click to browse</span></p>
                    </div>
                    <div id="extra-images-preview" class="flex flex-wrap gap-2"></div>
                </div>
                @error('extra_images')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                @error('extra_images.*')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
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

            <div>
                <label for="meta_description" class="block text-sm font-medium text-gray-700">Search description (SEO)</label>
                <textarea id="meta_description" name="meta_description" rows="3" maxlength="320" placeholder="Summarize this product for search results in one or two clear sentences."
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">{{ old('meta_description', $product->meta_description) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Used for search engines and social previews. Keep it specific to this product.</p>
                @error('meta_description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-center">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-md">
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
function addOptionImageRow() {
    const typeInput = document.getElementById('option-image-type');
    const labelInput = document.getElementById('option-image-label');
    const type = typeInput.value;
    const label = labelInput.value.trim();
    const normalized = label.toLowerCase().replace(/[^a-z0-9 _|/-]/g, '').trim();
    if (!normalized) { labelInput.focus(); return; }
    const key = `${type}:${normalized}`;
    if ([...document.querySelectorAll('[data-option-image-key]')].some(row => row.dataset.optionImageKey === key)) return;

    const row = document.createElement('div');
    row.className = 'flex flex-wrap items-center gap-3 rounded-md bg-gray-50 p-3';
    row.dataset.optionImageKey = key;
    row.innerHTML = `<span class="min-w-32 text-sm font-medium text-gray-700"></span><input type="file" accept="image/*" class="min-w-0 flex-1 text-sm"><img class="hidden h-14 w-14 rounded object-cover"><button type="button" class="text-sm font-medium text-red-600 hover:text-red-800">Remove</button>`;
    row.querySelector('span').textContent = `${typeInput.options[typeInput.selectedIndex].text}: ${label}`;
    const fileInput = row.querySelector('input[type=file]');
    fileInput.name = `variant_images[${key}]`;
    fileInput.addEventListener('change', () => previewOptionImage(fileInput, row.querySelector('img')));
    row.querySelector('button').addEventListener('click', () => row.remove());
    document.getElementById('option-image-rows').appendChild(row);
    labelInput.value = '';
}

function removeOptionImageRow(button) {
    const row = button.closest('[data-option-image-key]');
    const removed = document.createElement('input');
    removed.type = 'hidden';
    removed.name = 'remove_variant_images[]';
    removed.value = button.dataset.imageKey;
    document.querySelector('form').appendChild(removed);
    row.remove();
}

function previewOptionImage(input, preview) {
    const file = input.files?.[0];
    if (!file) return;
    preview.src = URL.createObjectURL(file);
    preview.classList.remove('hidden');
}
</script>
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

<script>
// ---- Variant Builder (Edit Form) ----
(function () {
    const tagsContainer  = document.getElementById('edit-variant-tags');
    const hiddenInput    = document.getElementById('edit-variants');
    const labelInput     = document.getElementById('edit-variant-label-input');
    const priceInput     = document.getElementById('edit-variant-price-input');
    const origPriceInput = document.getElementById('edit-variant-original-price-input');

    if (!tagsContainer || !hiddenInput) return;

    let variants = [];

    const initial = hiddenInput.value.trim();
    if (initial) {
        try { variants = JSON.parse(initial); } catch(e) {}
        renderTags();
    }

    window.editAddVariant = function () {
        const label = labelInput.value.trim();
        if (!label) { labelInput.focus(); return; }
        const price = priceInput.value.trim() !== '' ? parseFloat(priceInput.value) : null;
        const originalPrice = origPriceInput.value.trim() !== '' ? parseFloat(origPriceInput.value) : null;
        variants.push({ label, price, original_price: originalPrice });
        labelInput.value = '';
        priceInput.value = '';
        origPriceInput.value = '';
        renderTags();
        sync();
    };

    function removeVariant(idx) {
        variants.splice(idx, 1);
        renderTags();
        sync();
    }

    function renderTags() {
        tagsContainer.innerHTML = '';
        variants.forEach((v, i) => {
            const chip = document.createElement('span');
            chip.className = 'inline-flex items-center gap-1.5 bg-amber-50 border border-amber-200 rounded-full px-3 py-1 text-sm font-medium text-gray-800';
            let priceText = v.price != null ? `KES ${Number(v.price).toLocaleString()}` : 'base price';
            if (v.original_price != null) priceText += ` <span class="line-through text-gray-400">KES ${Number(v.original_price).toLocaleString()}</span>`;
            chip.innerHTML = `${escV(v.label)} <span class="text-gray-400 text-xs">${priceText}</span><button type="button" onclick="removeVariant_edit(${i})" class="ml-1 text-gray-400 hover:text-red-500 leading-none">&times;</button>`;
            tagsContainer.appendChild(chip);
        });
    }

    function sync() { hiddenInput.value = JSON.stringify(variants); }

    function escV(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    window.removeVariant_edit = removeVariant;
})();

// ---- Main image drop zone (edit) ----
const mainInput = document.getElementById('image');
mainInput.addEventListener('change', () => showMainPreview(mainInput.files[0]));

function handleMainDrop(e) {
    e.preventDefault();
    document.getElementById('main-drop-zone').classList.remove('border-amber-500','bg-amber-50');
    const file = e.dataTransfer.files[0];
    if (!file || !file.type.startsWith('image/')) return;
    const dt = new DataTransfer(); dt.items.add(file); mainInput.files = dt.files;
    showMainPreview(file);
}

function showMainPreview(file) {
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
        document.getElementById('main-preview-img').src = ev.target.result;
        document.getElementById('main-drop-placeholder').classList.add('hidden');
        document.getElementById('main-drop-preview').classList.remove('hidden');
        document.getElementById('main-existing-note').classList.add('hidden');
        document.getElementById('clear-image-flag').value = '0';
    };
    reader.readAsDataURL(file);
}

function clearMainImage() {
    mainInput.value = '';
    document.getElementById('clear-image-flag').value = '1';
    document.getElementById('main-drop-placeholder').classList.remove('hidden');
    document.getElementById('main-drop-preview').classList.add('hidden');
}

// ---- Extra images drop zone (edit) ----
let extraFiles = [];
const extraInput = document.getElementById('extra_images');
extraInput.addEventListener('change', () => addExtraFiles(extraInput.files));

function handleExtraDrop(e) {
    e.preventDefault();
    document.getElementById('extra-drop-zone').classList.remove('border-amber-500','bg-amber-50');
    addExtraFiles(e.dataTransfer.files);
}

function addExtraFiles(fileList) {
    Array.from(fileList).forEach(file => {
        if (!file.type.startsWith('image/')) return;
        if (extraFiles.length >= 8) return;
        extraFiles.push(file);
    });
    syncExtraInput();
    renderExtraPreviews();
}

function removeExtraFile(idx) {
    extraFiles.splice(idx, 1);
    syncExtraInput();
    renderExtraPreviews();
}

function syncExtraInput() {
    const dt = new DataTransfer();
    extraFiles.forEach(f => dt.items.add(f));
    extraInput.files = dt.files;
}

function renderExtraPreviews() {
    const container = document.getElementById('extra-images-preview');
    const placeholder = document.getElementById('extra-drop-placeholder');
    container.innerHTML = '';
    if (extraFiles.length === 0) {
        placeholder.classList.remove('hidden');
        return;
    }
    placeholder.classList.add('hidden');
    extraFiles.forEach((file, idx) => {
        const reader = new FileReader();
        reader.onload = ev => {
            const div = document.createElement('div');
            div.className = 'relative w-20 h-20 flex-shrink-0';
            div.innerHTML = `
                <img src="${ev.target.result}" class="w-full h-full object-cover rounded-md border border-gray-200">
                <button type="button" onclick="event.stopPropagation(); removeExtraFile(${idx})"
                        class="absolute -top-1.5 -right-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full w-5 h-5 flex items-center justify-center shadow text-xs leading-none">×</button>`;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

// ---- Delete an existing saved extra image ----
function deleteExistingExtra(path, hash) {
    const wrapper = document.getElementById('existing-' + hash);
    const keepInput = document.getElementById('keep-' + hash);
    if (wrapper) wrapper.remove();
    if (keepInput) keepInput.remove();
}
</script>
@endsection
