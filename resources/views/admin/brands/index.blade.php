@extends('layouts.admin')

@section('title', 'Brands Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Brands</h1>
        <a href="{{ route('admin.brands.create') }}" 
           class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-sm flex items-center w-full sm:w-auto justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Brand
        </a>
    </div>

    <!-- Brands Table -->
    <div class="bg-white shadow rounded-sm overflow-hidden">
        <div class="px-4 lg:px-6 py-4 border-b border-gray-200">
            <h3 class="text-base lg:text-lg font-medium text-gray-900">All Brands</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 hidden sm:table-header-group">
                    <tr>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Description</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Created</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($brands as $brand)
                        <tr class="hover:bg-gray-50 border-b border-gray-200 sm:border-0">
                            <td class="px-3 lg:px-6 py-3 sm:py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="text-sm font-medium text-gray-900">{{ $brand->name }}</div>
                                        <div class="sm:hidden">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $brand->products_count }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 md:hidden">{{ Str::limit($brand->description ?? 'No description', 50) }}</div>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 hidden md:table-cell">
                                <div class="text-sm text-gray-900">{{ $brand->description ?? 'No description' }}</div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $brand->products_count }} products
                                </span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                <div class="text-sm text-gray-900">{{ $brand->created_at->format('M d, Y') }}</div>
                            </td>
                            <td class="px-3 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.brands.edit', $brand) }}" 
                                       class="text-pink-600 hover:text-pink-900 whitespace-nowrap">Edit</a>
                                    <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" 
                                          class="inline" onsubmit="return confirm('Are you sure you want to delete this brand?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 whitespace-nowrap">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No brands found. <a href="{{ route('admin.brands.create') }}" class="text-pink-600 hover:text-pink-700">Add your first brand</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($brands->hasPages())
            <div class="px-4 lg:px-6 py-4 border-t border-gray-200">
                {{ $brands->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 