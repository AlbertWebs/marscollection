@extends('layouts.app')

@section('title', 'Categories - Zayn\'s Beauty')

@section('content')

<div class="bg-white border-b border-gray-100 py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs uppercase tracking-widest text-pink-600 font-medium mb-2">Shop By</p>
        <h1 class="text-3xl font-bold text-gray-900">All Categories</h1>
        <p class="mt-2 text-gray-500 text-sm">Browse our full range of beauty products by category.</p>
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        @if($activeCategories->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($activeCategories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="group">
                    <div class="bg-white border border-gray-100 rounded-sm shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                        @if($category->image)
                            <img src="{{ $category->image }}" alt="{{ $category->name }}"
                                 class="w-full h-44 object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-44 bg-gray-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-pink-600 transition-colors">
                                {{ $category->name }}
                            </h3>
                            @if($category->description)
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $category->description }}</p>
                            @endif
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xs text-gray-400">{{ $category->products->count() }} products</span>
                                <span class="text-xs text-pink-600 font-medium group-hover:underline">Browse →</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        @else
            <div class="text-center py-16 text-gray-400">
                <svg class="mx-auto h-10 w-10 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <p class="text-sm">No categories available at the moment.</p>
            </div>
        @endif

    </div>
</div>

@endsection
