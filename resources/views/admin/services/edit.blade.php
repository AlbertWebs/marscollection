@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Edit Service</h1>
        <a href="{{ route('admin.services.index') }}" 
           class="text-pink-600 hover:text-pink-700">
            ← Back to Services
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-sm p-4 lg:p-6">
        <form method="POST" action="{{ route('admin.services.update', $service) }}" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Service Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (KES) *</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $service->price) }}" min="0" step="0.01" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    @error('price')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Duration (minutes) *</label>
                    <input type="number" id="duration" name="duration" value="{{ old('duration', $service->duration) }}" min="15" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    @error('duration')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $service->sort_order) }}" min="0"
                           class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    @error('sort_order')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea id="description" name="description" rows="4" required
                          placeholder="Describe the service details, what's included, etc."
                          class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">{{ old('description', $service->description) }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}
                           class="rounded-sm border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-700">Active Service</span>
                </label>
                <p class="text-xs text-gray-500 mt-1">Inactive services won't appear in the booking form</p>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.services.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-sm text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-pink-600 text-white rounded-sm hover:bg-pink-700 transition-colors">
                    Update Service
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 