@extends('layouts.admin')

@section('title', 'Add New Product')


@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Add New Product</h1>
        <a href="{{ route('admin.products.index') }}" 
           class="text-pink-600 hover:text-pink-700 text-sm sm:text-base">
            ← Back to Products
        </a>
    </div>

    <!-- Product Form -->
    <div class="bg-white shadow rounded-md p-4 lg:p-6">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price (KSh)</label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('price') border-red-500 @enderror">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Original Price -->
                <div>
                    <label for="original_price" class="block text-sm font-medium text-gray-700">Original Price (KSh) <span class="text-gray-400 font-normal">- for showing discounts</span></label>
                    <input type="number" id="original_price" name="original_price" value="{{ old('original_price') }}" step="0.01" min="0"
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
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                    <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('stock_quantity') border-red-500 @enderror">
                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700">SKU <span class="text-gray-400 font-normal">- leave blank to auto-generate</span></label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm @error('sku') border-red-500 @enderror"
                           placeholder="e.g. ZB-001">
                    @error('sku')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Badge -->
                <div>
                    <label for="badge" class="block text-sm font-medium text-gray-700">Badge <span class="text-gray-400 font-normal">- label shown on product card</span></label>
                    <input type="text" id="badge" name="badge" value="{{ old('badge') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm"
                           placeholder="e.g. NEW, SALE, HOT">
                </div>

                <!-- Badge Color -->
                <div>
                    <label for="badge_color" class="block text-sm font-medium text-gray-700">Badge Color</label>
                    <select id="badge_color" name="badge_color"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                        <option value="">None</option>
                        <option value="pink" {{ old('badge_color') === 'pink' ? 'selected' : '' }}>Pink</option>
                        <option value="red" {{ old('badge_color') === 'red' ? 'selected' : '' }}>Red</option>
                        <option value="green" {{ old('badge_color') === 'green' ? 'selected' : '' }}>Green</option>
                        <option value="blue" {{ old('badge_color') === 'blue' ? 'selected' : '' }}>Blue</option>
                        <option value="yellow" {{ old('badge_color') === 'yellow' ? 'selected' : '' }}>Yellow</option>
                        <option value="gray" {{ old('badge_color') === 'gray' ? 'selected' : '' }}>Gray</option>
                    </select>
                </div>

                <!-- Colors Tag Builder -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Available Colors
                        <span class="text-gray-400 font-normal">- optional, customers select one when adding to cart</span>
                    </label>

                    {{-- Hidden input that gets submitted --}}
                    <input type="hidden" id="colors" name="colors" value="{{ old('colors') }}">

                    {{-- Color chips display --}}
                    <div id="color-tags" class="flex flex-wrap gap-2 mb-3 min-h-[36px]"></div>

                    {{-- Add color row --}}
                    <div class="flex items-center gap-2">
                        <input type="color" id="color-picker" value="#ec4899"
                               class="h-9 w-12 cursor-pointer border border-gray-300 rounded-md p-0.5">
                        <input type="text" id="color-name-input" placeholder="Color name (e.g. Rose Pink)"
                               class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm"
                               onkeydown="if(event.key==='Enter'){event.preventDefault();createAddColor();}">
                        <button type="button" onclick="createAddColor()"
                                class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap">
                            + Add Color
                        </button>
                    </div>
                    @error('colors')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Variants (Size / Type) Builder -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Variants <span class="text-gray-400 font-normal">— Size, Type, Scent, etc. (optional). Each can have its own price or inherit the base price.</span>
                    </label>
                    <input type="hidden" id="variants" name="variants" value="{{ old('variants') }}">
                    <div id="variant-tags" class="flex flex-wrap gap-2 mb-3 min-h-[36px]"></div>
                    <div class="flex items-center gap-2">
                        <input type="text" id="variant-label-input" placeholder="Label (e.g. Small, Coconut, 50ml)"
                               class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm"
                               onkeydown="if(event.key==='Enter'){event.preventDefault();createAddVariant();}">
                        <input type="number" id="variant-price-input" placeholder="Price (optional)"
                               min="0" step="1"
                               class="w-36 border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                        <button type="button" onclick="createAddVariant()"
                                class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-md text-sm font-medium whitespace-nowrap">
                            + Add
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Leave price blank to use the product's base price for that variant.</p>
                    @error('variants')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <!-- Flags -->
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}
                               class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded-md">
                        <span class="ml-2 text-sm text-gray-700">Active Product</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                               class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded-md">
                        <span class="ml-2 text-sm text-gray-700">Featured (shown on homepage)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" id="is_trending" name="is_trending" value="1" {{ old('is_trending') ? 'checked' : '' }}
                               class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded-md">
                        <span class="ml-2 text-sm text-gray-700">Trending (shown on homepage)</span>
                    </label>
                </div>
            </div>

            <!-- Main Image Drop Zone -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                <input type="file" id="image" name="image" accept="image/*" class="sr-only">
                <div id="main-drop-zone"
                     class="relative border-2 border-dashed border-gray-300 rounded-lg flex flex-col items-center justify-center cursor-pointer hover:border-pink-400 transition-colors bg-gray-50"
                     style="width: 200px; height: 200px;"
                     onclick="document.getElementById('image').click()"
                     ondragover="event.preventDefault(); this.classList.add('border-pink-500','bg-pink-50')"
                     ondragleave="this.classList.remove('border-pink-500','bg-pink-50')"
                     ondrop="handleMainDrop(event)">
                    <div id="main-drop-placeholder" class="flex flex-col items-center gap-2 py-8 pointer-events-none">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm text-gray-500">Drop image here or <span class="text-pink-600 font-medium">click to browse</span></p>
                        <p class="text-xs text-gray-400">JPG, PNG, WebP — max 2MB</p>
                    </div>
                    <div id="main-drop-preview" class="hidden w-full h-full relative">
                        <img id="main-preview-img" src="" alt="Preview" class="w-full h-full object-cover rounded-lg">
                        <button type="button" id="main-preview-clear"
                                onclick="event.stopPropagation(); clearMainImage()"
                                class="absolute top-2 right-2 bg-red-600 hover:bg-red-700 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <!-- Extra Images Drop Zone -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Extra Images <span class="text-gray-400 font-normal">(optional, up to 8)</span></label>
                <input type="file" id="extra_images" name="extra_images[]" accept="image/*" multiple class="sr-only">
                <div id="extra-drop-zone"
                     class="border-2 border-dashed border-gray-300 rounded-lg p-4 cursor-pointer hover:border-pink-400 transition-colors bg-gray-50"
                     onclick="document.getElementById('extra_images').click()"
                     ondragover="event.preventDefault(); this.classList.add('border-pink-500','bg-pink-50')"
                     ondragleave="this.classList.remove('border-pink-500','bg-pink-50')"
                     ondrop="handleExtraDrop(event)">
                    <div id="extra-drop-placeholder" class="flex flex-col items-center gap-2 py-4 pointer-events-none">
                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                        <p class="text-sm text-gray-500">Drop multiple images or <span class="text-pink-600 font-medium">click to browse</span></p>
                        <p class="text-xs text-gray-400">Up to 8 images — they appear as a gallery on the product page</p>
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
                <textarea id="description" name="description" class="hidden">{{ old('description') }}</textarea>
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
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
// ---- Color Tag Builder (Create Form) ----
(function () {
    const tagsContainer = document.getElementById('color-tags');
    const hiddenInput   = document.getElementById('colors');
    const picker        = document.getElementById('color-picker');
    const nameInput     = document.getElementById('color-name-input');

    if (!tagsContainer || !hiddenInput) return;

    let colors = [];

    // Load pre-existing value (from old() on validation failure)
    const initial = hiddenInput.value.trim();
    if (initial) {
        colors = initial.split(',').map(s => {
            s = s.trim();
            const idx = s.lastIndexOf(':');
            if (idx > 0 && s[idx+1] === '#') {
                return { name: s.slice(0, idx).trim(), hex: s.slice(idx+1).trim() };
            }
            return { name: s, hex: '#cccccc' };
        }).filter(c => c.name);
        renderTags();
    }

    window.createAddColor = function () {
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
                <button type="button" onclick="removeColor_create(${i})" class="ml-1 text-gray-400 hover:text-red-500 leading-none">&times;</button>
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

    // Expose remove globally so inline onclick works
    window.removeColor_create = removeColor;
})();
</script>

<script>
// ---- Variant Builder (Create Form) ----
(function () {
    const tagsContainer = document.getElementById('variant-tags');
    const hiddenInput   = document.getElementById('variants');
    const labelInput    = document.getElementById('variant-label-input');
    const priceInput    = document.getElementById('variant-price-input');

    if (!tagsContainer || !hiddenInput) return;

    let variants = [];

    // Restore from old() on validation failure
    const initial = hiddenInput.value.trim();
    if (initial) {
        try { variants = JSON.parse(initial); } catch(e) {}
        renderTags();
    }

    window.createAddVariant = function () {
        const label = labelInput.value.trim();
        if (!label) { labelInput.focus(); return; }
        const price = priceInput.value.trim() !== '' ? parseFloat(priceInput.value) : null;
        variants.push({ label, price });
        labelInput.value = '';
        priceInput.value = '';
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
            chip.className = 'inline-flex items-center gap-1.5 bg-pink-50 border border-pink-200 rounded-full px-3 py-1 text-sm font-medium text-gray-800';
            const priceText = v.price != null ? ` — KES ${Number(v.price).toLocaleString()}` : ' — base price';
            chip.innerHTML = `${escapeHtmlV(v.label)}<span class="text-gray-400 text-xs">${priceText}</span><button type="button" onclick="removeVariant_create(${i})" class="ml-1 text-gray-400 hover:text-red-500 leading-none">&times;</button>`;
            tagsContainer.appendChild(chip);
        });
    }

    function sync() {
        hiddenInput.value = JSON.stringify(variants);
    }

    function escapeHtmlV(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    window.removeVariant_create = removeVariant;
})();

// ---- Main image drop zone (create) ----
const mainInput = document.getElementById('image');
mainInput.addEventListener('change', () => showMainPreview(mainInput.files[0]));

function handleMainDrop(e) {
    e.preventDefault();
    document.getElementById('main-drop-zone').classList.remove('border-pink-500','bg-pink-50');
    const file = e.dataTransfer.files[0];
    if (!file || !file.type.startsWith('image/')) return;
    const dt = new DataTransfer(); dt.items.add(file); mainInput.files = dt.files;
    showMainPreview(file);
}

function showMainPreview(file) {
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('main-preview-img').src = e.target.result;
        document.getElementById('main-drop-placeholder').classList.add('hidden');
        document.getElementById('main-drop-preview').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function clearMainImage() {
    mainInput.value = '';
    document.getElementById('main-drop-placeholder').classList.remove('hidden');
    document.getElementById('main-drop-preview').classList.add('hidden');
}

// ---- Extra images drop zone (create) ----
let extraFiles = [];
const extraInput = document.getElementById('extra_images');
extraInput.addEventListener('change', () => addExtraFiles(extraInput.files));

function handleExtraDrop(e) {
    e.preventDefault();
    document.getElementById('extra-drop-zone').classList.remove('border-pink-500','bg-pink-50');
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
        reader.onload = e => {
            const div = document.createElement('div');
            div.className = 'relative w-20 h-20 flex-shrink-0';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover rounded-md border border-gray-200">
                <button type="button" onclick="removeExtraFile(${idx})"
                        class="absolute -top-1.5 -right-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full w-5 h-5 flex items-center justify-center shadow text-xs leading-none">×</button>`;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
