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

        <form method="POST" action="{{ route('admin.categories.store') }}" class="p-6 space-y-6">
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
@endsection
