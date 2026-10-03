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

            @if($errors->any())
                <div id="form-errors" role="alert" tabindex="-1" class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                    <p class="font-semibold">We couldn’t save these changes yet.</p>
                    <p class="mt-1">Review the items below. You’ll need to reselect image files after correcting any errors.</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach($errors->all() as $message)<li>{{ $message }}</li>@endforeach
                    </ul>
                </div>
            @endif
            
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
                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Total Stock</label>
                    <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500 sm:text-sm @error('stock_quantity') border-red-500 @enderror">
                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Available Shoe Sizes -->
                @php $selectedProductSizes = array_map('strval', old('sizes', $product->sizes ?? range(19, 48))); @endphp
                <fieldset class="lg:col-span-2 rounded-lg border border-gray-200 p-4">
                    <legend class="px-1 text-sm font-semibold text-gray-900">Available shoe sizes</legend>
                    <p class="mb-3 text-xs text-gray-500">Select every size available for this product. Customers must choose one before adding it to their cart.</p>
                    <div class="grid grid-cols-5 gap-2 sm:grid-cols-8 md:grid-cols-10 lg:grid-cols-12">
                        @foreach(range(19, 48) as $size)
                            <label class="cursor-pointer">
                                <input type="checkbox" name="sizes[]" value="{{ $size }}" class="peer sr-only" @checked(in_array((string) $size, $selectedProductSizes, true))>
                                <span class="flex min-h-10 items-center justify-center rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 transition peer-checked:border-amber-600 peer-checked:bg-amber-50 peer-checked:text-amber-800 peer-focus-visible:ring-2 peer-focus-visible:ring-amber-500">{{ $size }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('sizes')<p class="mt-2 text-sm text-red-700">{{ $message }}</p>@enderror
                    @error('sizes.*')<p class="mt-2 text-sm text-red-700">{{ $message }}</p>@enderror
                </fieldset>

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
            <div class="rounded-xl border border-gray-200 bg-white p-4 sm:p-5">
                <label for="image" class="block text-sm font-semibold text-gray-900">Product image <span class="font-normal text-gray-500">(optional)</span></label>
                <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF or WebP. 2 MB max, at least 200 × 200 px.</p>
                <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif,image/webp" class="sr-only" aria-describedby="image-upload-status">
                <div id="main-drop-zone"
                     role="button" tabindex="0" aria-label="Choose or drop a product image"
                     class="relative mt-3 aspect-square w-full max-w-xs border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center cursor-pointer hover:border-amber-400 hover:bg-amber-50/40 focus:outline-none focus:ring-2 focus:ring-amber-500 transition-colors bg-gray-50"
                     onclick="document.getElementById('image').click()"
                     ondragover="event.preventDefault(); this.classList.add('border-amber-500','bg-amber-50')"
                     ondragleave="this.classList.remove('border-amber-500','bg-amber-50')"
                     ondrop="handleMainDrop(event)">
                    <div id="main-drop-placeholder" class="{{ $product->image ? 'hidden' : '' }} flex flex-col items-center gap-2 py-8 pointer-events-none">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm text-gray-600">Drop an image here or <span class="text-amber-700 font-semibold">browse files</span></p>
                        <p class="text-xs text-gray-500">Square images around 1200 × 1200 px work best.</p>
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
                <p id="image-upload-status" role="status" aria-live="polite" class="mt-2 text-sm text-gray-600">{{ $product->image ? 'Current image is saved. Select a replacement or keep it.' : 'No product image selected.' }}</p>
                @error('image')<p id="image-error" class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
            </div>

            <!-- Extra Images Drop Zone -->
            <div class="rounded-xl border border-gray-200 bg-white p-4 sm:p-5">
                <label for="extra_images" class="block text-sm font-semibold text-gray-900">Gallery images <span class="font-normal text-gray-500">(up to 8 total)</span></label>
                <p class="mt-1 text-xs text-gray-500">JPG, PNG, GIF or WebP. Each image must be 2 MB or smaller; combined new uploads up to 7 MB.</p>
                <input type="file" id="extra_images" name="extra_images[]" accept="image/jpeg,image/png,image/gif,image/webp" multiple class="sr-only" aria-describedby="extra-upload-status">

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
                     role="button" tabindex="0" aria-label="Choose or drop gallery images"
                     class="border-2 border-dashed border-gray-300 rounded-xl p-4 cursor-pointer hover:border-amber-400 hover:bg-amber-50/40 focus:outline-none focus:ring-2 focus:ring-amber-500 transition-colors bg-gray-50"
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
                <p id="extra-upload-status" role="status" aria-live="polite" class="mt-2 text-sm text-gray-600">{{ count($product->extra_images ?? []) }} saved gallery {{ count($product->extra_images ?? []) === 1 ? 'image' : 'images' }}. New images will be added to the gallery.</p>
                @error('extra_images')<p id="extra-images-error" class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
                @error('extra_images.*')<p class="mt-1 text-sm text-red-700">{{ $message }}</p>@enderror
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
                <button type="submit" id="save-product-button"
                        class="bg-amber-600 hover:bg-amber-700 disabled:cursor-wait disabled:opacity-70 text-white px-4 py-2 rounded-md">
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
        hiddenInput.dispatchEvent(new Event('change'));
    }

    function escapeHtml(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    window.removeColor_edit = removeColor;
})();
</script>

<script>
// ---- Accessible, validated product image uploads ----
const mainInput = document.getElementById('image');
const extraInput = document.getElementById('extra_images');
const mainZone = document.getElementById('main-drop-zone');
const extraZone = document.getElementById('extra-drop-zone');
const mainStatus = document.getElementById('image-upload-status');
const extraStatus = document.getElementById('extra-upload-status');
const clearImageFlag = document.getElementById('clear-image-flag');
const maxFileBytes = 2 * 1024 * 1024;
const maxNewUploadBytes = 7 * 1024 * 1024;
const maxGalleryImages = 8;
const acceptedExtensions = /\.(jpe?g|png|gif|webp)$/i;
let extraFiles = [];
let previewUrls = [];

function setUploadStatus(element, message, isError = false) {
    if (!element) return;
    element.textContent = message;
    element.classList.toggle('text-red-700', isError);
    element.classList.toggle('text-gray-600', !isError);
}

function formatFileSize(bytes) {
    return `${(bytes / (1024 * 1024)).toFixed(2)} MB`;
}

function imageFileError(file) {
    const validMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'].includes(file.type);
    if ((!validMime && file.type !== '') || (!validMime && !acceptedExtensions.test(file.name))) {
        return 'Choose a JPG, PNG, GIF, or WebP image.';
    }
    if (file.size > maxFileBytes) return 'Each image must be 2 MB or smaller.';
    if (file.size === 0) return 'This file is empty. Choose another image.';
    return null;
}

function selectedUploadBytes() {
    return (mainInput.files?.[0]?.size || 0) + extraFiles.reduce((total, file) => total + file.size, 0);
}

function setMainImage(file) {
    const error = imageFileError(file);
    if (error) {
        mainInput.value = '';
        if (clearImageFlag) clearImageFlag.value = '0';
        setUploadStatus(mainStatus, `${file.name}: ${error}`, true);
        return;
    }

    const combinedBytes = file.size + extraFiles.reduce((total, item) => total + item.size, 0);
    if (combinedBytes > maxNewUploadBytes) {
        mainInput.value = '';
        if (clearImageFlag) clearImageFlag.value = '0';
        setUploadStatus(mainStatus, 'New image files must total 7 MB or less. Remove a gallery image and try again.', true);
        return;
    }

    mainInput.classList.remove('border-red-500');
    if (clearImageFlag) clearImageFlag.value = '0';
    document.getElementById('main-preview-img').src = URL.createObjectURL(file);
    document.getElementById('main-drop-placeholder').classList.add('hidden');
    document.getElementById('main-drop-preview').classList.remove('hidden');
    document.getElementById('main-existing-note')?.classList.add('hidden');
    setUploadStatus(mainStatus, `Ready to upload: ${file.name} (${formatFileSize(file.size)}).`);
}

mainInput.addEventListener('change', () => {
    if (mainInput.files?.[0]) setMainImage(mainInput.files[0]);
});

function handleMainDrop(event) {
    event.preventDefault();
    mainZone.classList.remove('border-amber-500', 'bg-amber-50');
    const file = event.dataTransfer.files?.[0];
    if (!file) return;
    const transfer = new DataTransfer();
    transfer.items.add(file);
    mainInput.files = transfer.files;
    setMainImage(file);
}

function clearMainImage() {
    mainInput.value = '';
    document.getElementById('main-drop-placeholder').classList.remove('hidden');
    document.getElementById('main-drop-preview').classList.add('hidden');
    if (clearImageFlag) {
        document.getElementById('clear-image-flag').value = '1';
        setUploadStatus(mainStatus, 'The current product image will be removed when you save.');
    } else {
        setUploadStatus(mainStatus, 'Product image cleared.');
    }
}

function existingGalleryCount() {
    return document.querySelectorAll('input[name="keep_extra_images[]"]').length;
}

function addExtraFiles(fileList) {
    const rejected = [];
    Array.from(fileList).forEach(file => {
        const error = imageFileError(file);
        if (error) {
            rejected.push(`${file.name}: ${error}`);
            return;
        }
        if (existingGalleryCount() + extraFiles.length >= maxGalleryImages) {
            rejected.push(`${file.name}: a product can have up to 8 gallery images total.`);
            return;
        }
        if (selectedUploadBytes() + file.size > maxNewUploadBytes) {
            rejected.push(`${file.name}: new image files must total 7 MB or less.`);
            return;
        }
        extraFiles.push(file);
    });

    syncExtraInput();
    renderExtraPreviews();
    const count = extraFiles.length;
    const ready = count ? `${count} new ${count === 1 ? 'image' : 'images'} ready to upload (${formatFileSize(extraFiles.reduce((sum, file) => sum + file.size, 0))}).` : 'No new gallery images selected.';
    setUploadStatus(extraStatus, rejected.length ? `${ready} ${rejected.join(' ')}` : ready, rejected.length > 0);
}

function handleExtraDrop(event) {
    event.preventDefault();
    extraZone.classList.remove('border-amber-500', 'bg-amber-50');
    addExtraFiles(event.dataTransfer.files);
}

extraInput.addEventListener('change', () => addExtraFiles(extraInput.files));

function removeExtraFile(index) {
    extraFiles.splice(index, 1);
    syncExtraInput();
    renderExtraPreviews();
    const count = extraFiles.length;
    setUploadStatus(extraStatus, count ? `${count} new ${count === 1 ? 'image' : 'images'} ready to upload (${formatFileSize(extraFiles.reduce((sum, file) => sum + file.size, 0))}).` : 'No new gallery images selected.');
}

function syncExtraInput() {
    const transfer = new DataTransfer();
    extraFiles.forEach(file => transfer.items.add(file));
    extraInput.files = transfer.files;
}

function renderExtraPreviews() {
    const container = document.getElementById('extra-images-preview');
    previewUrls.forEach(url => URL.revokeObjectURL(url));
    previewUrls = [];
    container.innerHTML = '';

    extraFiles.forEach((file, index) => {
        const url = URL.createObjectURL(file);
        previewUrls.push(url);
        const card = document.createElement('div');
        card.className = 'relative h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg border border-gray-200 bg-white';
        const image = document.createElement('img');
        image.src = url;
        image.alt = file.name;
        image.className = 'h-full w-full object-cover';
        const remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'absolute right-1 top-1 flex h-6 w-6 items-center justify-center rounded-full bg-black/70 text-sm text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-white';
        remove.setAttribute('aria-label', `Remove ${file.name}`);
        remove.textContent = '×';
        remove.addEventListener('click', event => {
            event.stopPropagation();
            removeExtraFile(index);
        });
        card.append(image, remove);
        container.appendChild(card);
    });
}

function bindUploadKeyboard(zone, input) {
    zone.addEventListener('keydown', event => {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            input.click();
        }
    });
}

bindUploadKeyboard(mainZone, mainInput);
bindUploadKeyboard(extraZone, extraInput);

document.querySelector('form').addEventListener('submit', event => {
    const totalBytes = selectedUploadBytes();
    if (totalBytes > maxNewUploadBytes) {
        event.preventDefault();
        setUploadStatus(extraStatus, 'New image files must total 7 MB or less. Remove an image before saving.', true);
        extraZone.focus();
        return;
    }
    const button = document.getElementById('save-product-button');
    button.disabled = true;
    button.textContent = 'Saving product…';
    setUploadStatus(extraStatus, 'Uploading images and saving your changes…');
});

function deleteExistingExtra(path, hash) {
    const wrapper = document.getElementById('existing-' + hash);
    const keepInput = document.getElementById('keep-' + hash);
    if (wrapper) wrapper.remove();
    if (keepInput) keepInput.remove();
    const count = existingGalleryCount() + extraFiles.length;
    setUploadStatus(extraStatus, `${count} gallery ${count === 1 ? 'image' : 'images'} will remain after saving.`);
}

const formErrors = document.getElementById('form-errors');
if (formErrors) formErrors.focus();
</script>
@endsection
