@extends('layouts.admin')

@section('title', 'Reviews Management - Admin Panel')

@section('content')
<div class="container mx-auto px-4 lg:px-6 py-4 lg:py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-2xl lg:text-3xl font-bold text-gray-900">Reviews Management</h1>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-md shadow-md p-4 lg:p-6 mb-6">
        <form method="GET" action="{{ route('admin.reviews.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                       placeholder="Search by customer, product, or comment..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                    <option value="">All Reviews</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Approval</option>
                    <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-md hover:bg-pink-700 transition-colors">
                    Filter
                </button>
            </div>
            
            <div class="flex items-end">
                <a href="{{ route('admin.reviews.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                    Clear
                </a>
            </div>
        </form>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white rounded-md shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                Reviews ({{ $reviews->total() }})
            </h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 hidden sm:table-header-group">
                    <tr>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Item</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Comment</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Date</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reviews as $review)
                        <tr class="hover:bg-gray-50 border-b border-gray-200 sm:border-0">
                            <td class="px-3 lg:px-6 py-3 sm:py-4">
                                <div class="space-y-1">
                                    <div class="text-sm font-medium text-gray-900">{{ $review->order->customer_name }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">{{ $review->order->customer_email }}</div>
                                    <div class="flex items-center gap-2 text-xs sm:hidden mt-1">
                                        <span class="text-gray-500">
                                            @if($review->product)
                                                {{ Str::limit($review->product->name, 20) }}
                                            @elseif($review->bundle)
                                                {{ Str::limit($review->bundle->name, 20) }}
                                            @endif
                                        </span>
                                        <span class="text-gray-400">•</span>
                                        <span class="text-gray-500">{{ $review->rating }}/5</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="flex items-center">
                                    @if($review->product)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ \App\Helpers\ImageHelper::getProductImageUrl($review->product->image) }}" 
                                                 alt="{{ $review->product->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $review->product->name }}</div>
                                            <div class="text-sm text-gray-500">Product</div>
                                        </div>
                                    @elseif($review->bundle)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ \App\Helpers\ImageHelper::getProductImageUrl($review->bundle->image) }}" 
                                                 alt="{{ $review->bundle->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $review->bundle->name }}</div>
                                            <div class="text-sm text-gray-500">Bundle</div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="flex items-center">
                                    @if($review->product)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ \App\Helpers\ImageHelper::getProductImageUrl($review->product->image) }}" 
                                                 alt="{{ $review->product->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $review->product->name }}</div>
                                            <div class="text-sm text-gray-500">Product</div>
                                        </div>
                                    @elseif($review->bundle)
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover" 
                                                 src="{{ \App\Helpers\ImageHelper::getProductImageUrl($review->bundle->image) }}" 
                                                 alt="{{ $review->bundle->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $review->bundle->name }}</div>
                                            <div class="text-sm text-gray-500">Bundle</div>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endif
                                    @endfor
                                    <span class="ml-1 sm:ml-2 text-xs sm:text-sm text-gray-900">{{ $review->rating }}/5</span>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 hidden lg:table-cell">
                                <div class="text-sm text-gray-900 max-w-xs truncate">
                                    {{ $review->comment ?: 'No comment' }}
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="space-y-1 sm:space-y-0">
                                    @if($review->is_approved)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 hidden sm:table-cell">
                                {{ $review->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-3 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    @if(!$review->is_approved)
                                        <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-green-600 hover:text-green-900 whitespace-nowrap">
                                                Approve
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 whitespace-nowrap">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No reviews found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-4 lg:px-6 py-4 border-t border-gray-200">
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection 