@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Product Bundles</h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Discover footwear styles selected by Mars Collection
            </p>
        </div>

        <!-- Bundles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($bundles as $bundle)
                @include('components.bundle-card', [
                    'bundle' => [
                        'id' => $bundle->id,
                        'name' => $bundle->name,
                        'category' => $bundle->category,
                        'price' => $bundle->formatted_price,
                        'original_price' => $bundle->formatted_original_price,
                        'rating' => $bundle->rating,
                        'image' => $bundle->image,
                        'description' => $bundle->description,
                        'badge' => $bundle->badge,
                        'badge_color' => $bundle->badge_color,
                        'review_count' => $bundle->review_count
                    ]
                ])
            @endforeach
        </div>

        <!-- Pagination -->
        @if($bundles->hasPages())
            <div class="mt-12">
                {{ $bundles->links() }}
            </div>
        @endif

        <!-- Empty State -->
        @if($bundles->count() == 0)
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No bundles available</h3>
                <p class="mt-1 text-sm text-gray-500">Check back later for new bundle offers.</p>
            </div>
        @endif
    </div>
</div>
@endsection
