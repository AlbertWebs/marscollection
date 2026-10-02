@extends('layouts.admin')

@section('title', 'Add Shoe Category')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div><p class="text-xs font-bold uppercase tracking-wider text-amber-700">Footwear catalog</p><h1 class="mt-1 text-xl font-bold text-gray-900">Add a shoe category</h1><p class="mt-1 text-sm text-gray-500">Examples: sneakers, formal shoes, loafers, flats, sandals or boots.</p></div>
        <a href="{{ route('admin.categories.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
            Back to Categories
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Category details</h3>
        </div>

        <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Shoe category name</label>
                <input type="text" name="name" id="name"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                       value="{{ old('name') }}" placeholder="For example, Running Sneakers" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Shopper-facing description</label>
                <textarea name="description" id="description" rows="4"
                          placeholder="Describe the types of shoes in this category."
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-gray-700" for="category-image">Category photo</label>
                <input id="category-image" name="image" type="file" accept="image/jpeg,image/png,image/gif,image/webp" class="sr-only">
                <button type="button" id="category-image-dropzone" class="relative flex min-h-56 w-full items-center justify-center overflow-hidden rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 text-left transition hover:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500" aria-label="Choose or drop a category photo">
                    <img id="category-image-preview" alt="Selected category photo preview" class="hidden absolute inset-0 h-full w-full object-cover">
                    <span id="category-image-prompt" class="pointer-events-none flex flex-col items-center gap-2 p-6 text-center">
                        <svg class="h-8 w-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16.5 8.5 12l3 3L16 10l4 5M5 20h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1Z"/><path stroke-linecap="round" stroke-width="1.8" d="M12 4v5m-2-2 2 2 2-2"/></svg>
                        <span class="text-sm text-gray-600">Drop a photo here or <span class="font-semibold text-amber-700">click to browse</span></span>
                    </span>
                    <span id="category-image-replace" class="hidden absolute inset-x-0 bottom-0 bg-black/60 px-4 py-3 text-center text-sm font-medium text-white">Photo selected · drop or click to replace</span>
                </button>
                <div class="mt-2 rounded-lg border border-amber-100 bg-amber-50 px-3 py-2">
                    <p class="text-sm text-gray-800"><span class="font-semibold">Recommended image size:</span> <span class="font-bold text-amber-800">1200 × 1500 px</span> <span class="text-xs text-gray-600">(4:5 portrait)</span></p>
                    <p class="mt-0.5 text-xs text-gray-500">JPG, PNG, GIF or WebP, up to 4 MB.</p>
                </div>
                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700">Storefront order</label>
                    <input type="number" min="0" name="sort_order" id="sort_order" value="{{ old('sort_order') }}" placeholder="Added to the end"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500">
                    <p class="mt-1 text-xs text-gray-500">Smaller numbers appear earlier.</p>
                    @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-amber-100 bg-amber-50/50 p-4">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="mt-0.5 h-4 w-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                    <span><span class="block text-sm font-semibold text-gray-900">Show in the shoe store</span><span class="mt-1 block text-xs leading-5 text-gray-500">Active categories can be browsed by customers.</span></span>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.categories.index') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-md">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>
<script>
(() => {
    const input = document.getElementById('category-image');
    const zone = document.getElementById('category-image-dropzone');
    const preview = document.getElementById('category-image-preview');
    const prompt = document.getElementById('category-image-prompt');
    const replace = document.getElementById('category-image-replace');
    zone.addEventListener('click', () => input.click());
    const showFile = file => {
        if (!file || !file.type.startsWith('image/')) return;
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden'); prompt.classList.add('hidden'); replace.classList.remove('hidden');
    };
    input.addEventListener('change', () => showFile(input.files[0]));
    ['dragenter', 'dragover'].forEach(event => zone.addEventListener(event, e => { e.preventDefault(); zone.classList.add('border-amber-500', 'bg-amber-50'); }));
    ['dragleave', 'drop'].forEach(event => zone.addEventListener(event, e => { e.preventDefault(); zone.classList.remove('border-amber-500', 'bg-amber-50'); }));
    zone.addEventListener('drop', e => { const file = e.dataTransfer.files[0]; if (!file) return; const transfer = new DataTransfer(); transfer.items.add(file); input.files = transfer.files; showFile(file); });
})();
</script>
@endsection
