@extends('layouts.admin')

@section('title', 'Edit Footwear Brand')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div><p class="text-xs font-bold uppercase tracking-wider text-amber-700">Footwear catalog</p><h1 class="mt-1 text-xl font-bold text-gray-900">Edit {{ $brand->name }}</h1><p class="mt-1 text-sm text-gray-500">Update the brand details used by shoe listings.</p></div>
        <a href="{{ route('admin.brands.index') }}"
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
            Back to Brands
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Brand details</h3>
        </div>

        <form method="POST" action="{{ route('admin.brands.update', $brand) }}" class="p-6 space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Footwear brand name</label>
                <input type="text" name="name" id="name"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500"
                       value="{{ old('name', $brand->name) }}" required>
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Short brand description</label>
                <textarea name="description" id="description" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-amber-500 focus:border-amber-500">{{ old('description', $brand->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700">Brand mark</label>
                @if($brand->logo)
                    <div class="mt-2 mb-3 flex items-center gap-4">
                        <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($brand->logo) }}" alt="{{ $brand->name }}" class="h-12 w-auto object-contain border border-gray-200 rounded-md p-1">
                        <span class="text-xs text-gray-500">Current logo. Upload a new file to replace it.</span>
                    </div>
                @endif
                <input type="file" name="logo" id="logo" accept="image/*"
                       class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                <p class="mt-1 text-xs text-gray-500">PNG, JPG, WebP or SVG. Max 2MB. Recommended: transparent background PNG.</p>
                @error('logo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-amber-100 bg-amber-50/50 p-4">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $brand->is_active)) class="mt-0.5 h-4 w-4 rounded border-gray-300 text-amber-600 focus:ring-amber-500">
                <span><span class="block text-sm font-semibold text-gray-900">Make this brand available for shoes</span><span class="mt-1 block text-xs text-gray-500">Turn off to archive it and hide it from the storefront.</span></span>
            </label>

            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <a href="{{ route('admin.brands.index') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                    Cancel
                </a>
                <button type="submit"
                        class="bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-md">
                    Update Brand
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
