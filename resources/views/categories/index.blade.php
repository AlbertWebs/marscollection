@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">All Categories</h1>
            <p class="text-gray-600">Browse products by category</p>
        </div>
        
        <!-- Categories Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($activeCategories as $category)
                <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="group">
                    <div class="bg-white rounded-sm shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300 overflow-hidden">
                        <!-- Category Image -->
                        <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                            @if($category->image)
                                <img src="{{ $category->image }}" alt="{{ $category->name }}" 
                                     class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-pink-100 to-pink-200 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Category Info -->
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-pink-600 transition-colors">
                                {{ $category->name }}
                            </h3>
                            @if($category->description)
                                <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                                    {{ $category->description }}
                                </p>
                            @endif
                            
                            <!-- Product Count -->
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-sm text-gray-500">
                                    {{ $category->products->count() }} products
                                </span>
                                <span class="text-pink-600 group-hover:text-pink-700 transition-colors">
                                    View Products →
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        
        @if($activeCategories->count() == 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No categories found</h3>
                <p class="mt-1 text-sm text-gray-500">There are no categories available at the moment.</p>
            </div>
        @endif
    </div>
</div>
@endsection 