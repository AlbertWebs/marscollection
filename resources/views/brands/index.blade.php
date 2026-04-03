@extends('layouts.app')

@section('title', 'Brands - Zayn\'s Beauty')

@section('content')

<div class="bg-white border-b border-gray-100 py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-xs uppercase tracking-widest text-pink-600 font-medium mb-2">Shop By</p>
        <h1 class="text-3xl font-bold text-gray-900">All Brands</h1>
        <p class="mt-2 text-gray-500 text-sm">Explore products from the brands we carry.</p>
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">

        @if($brands->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach($brands as $brand)
                <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" class="group">
                    <div class="bg-white border border-gray-100 rounded-sm shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                        <div class="h-40 bg-gray-50 flex items-center justify-center p-5 border-b border-gray-100">
                            @if($brand->logo)
                                <img src="{{ str_starts_with($brand->logo, 'http') ? $brand->logo : Storage::disk('s3')->url($brand->logo) }}" alt="{{ $brand->name }}"
                                     class="max-w-full max-h-full object-contain group-hover:scale-105 transition-transform duration-300">
                            @else
                                <span class="text-lg font-bold text-gray-300 uppercase tracking-wide">{{ Str::limit($brand->name, 12) }}</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-pink-600 transition-colors">
                                {{ $brand->name }}
                            </h3>
                            @if($brand->description)
                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $brand->description }}</p>
                            @endif
                            <div class="mt-3 flex items-center justify-between">
                                <span class="text-xs text-gray-400">{{ $brand->products->count() }} products</span>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                <p class="text-sm">No brands available at the moment.</p>
            </div>
        @endif

    </div>
</div>

@endsection
