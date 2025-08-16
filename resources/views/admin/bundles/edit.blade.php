@extends('layouts.admin')

@section('title', 'Edit Bundle')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900">Edit Bundle</h1>
        <a href="{{ route('admin.bundles.index') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
            Back to Bundles
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
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
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4"
                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">{{ old('description', $bundle->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Bundle Price (KSh)</label>
                <input type="number" name="price" id="price" step="0.01" min="0"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"
                       value="{{ old('price', $bundle->price) }}" required>
                @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Products in Bundle</label>
                <div class="mt-2 space-y-2 max-h-60 overflow-y-auto border border-gray-300 rounded-md p-4">
                    @php
                        $selectedProducts = $bundle->bundleItems->pluck('product_id')->toArray();
                    @endphp
                    @foreach($products as $product)
                        <label class="flex items-center">
                            <input type="checkbox" name="products[]" value="{{ $product->id }}"
                                   class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                                   {{ in_array($product->id, $selectedProducts) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-900">
                                {{ $product->name }} - KSh {{ number_format($product->price) }}
                                @if($product->brand)
                                    <span class="text-gray-500">({{ $product->brand->name }})</span>
                                @endif
                            </span>
                        </label>
                    @endforeach
                </div>
                @error('products')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1"
                           class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50"
                           {{ old('is_active', $bundle->is_active) ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-900">Active Bundle</span>
                </label>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.bundles.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg">
                    Update Bundle
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 