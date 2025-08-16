@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">All Brands</h1>
            <p class="text-gray-600">Discover products from your favorite brands</p>
        </div>
        
        <!-- Brands Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($brands as $brand)
                <a href="{{ route('products.index', ['brand_id' => $brand->id]) }}" class="group">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300 overflow-hidden">
                        <!-- Brand Logo Section -->
                        <div class="h-48 bg-gray-50 flex items-center justify-center p-6 border-b border-gray-100 overflow-hidden">
                            @if($brand->logo)
                                <img src="{{ $brand->logo }}" alt="{{ $brand->name }}" 
                                     class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-pink-100 to-pink-200 flex items-center justify-center rounded-lg">
                                    <svg class="w-16 h-16 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Brand Details Section -->
                        <div class="p-6 bg-white">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-pink-600 transition-colors mb-2">
                                {{ $brand->name }}
                            </h3>
                            @if($brand->description)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                    {{ $brand->description }}
                                </p>
                            @endif
                            
                            <!-- Product Count -->
                            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                <span class="text-sm text-gray-500">
                                    {{ $brand->products->count() }} products
                                </span>
                                <span class="text-pink-600 group-hover:text-pink-700 transition-colors text-sm font-medium">
                                    View Products →
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        @if($brands->count() == 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No brands found</h3>
                <p class="mt-1 text-sm text-gray-500">There are no brands available at the moment.</p>
            </div>
        @endif
    </div>
</div>
@endsection 