@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Order #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" 
           class="text-pink-600 hover:text-pink-700 text-sm sm:text-base">
            ← Back to Orders
        </a>
    </div>

    <!-- Order Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
        <!-- Order Details -->
        <div class="bg-white shadow rounded-lg p-4 lg:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Order Information</h3>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Order ID:</span>
                    <span class="text-sm text-gray-900">#{{ $order->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Customer:</span>
                    <span class="text-sm text-gray-900">{{ $order->customer_name ?? $order->user->name ?? 'Guest' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Email:</span>
                    <span class="text-sm text-gray-900">{{ $order->customer_email ?? $order->user->email ?? 'No email' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Phone:</span>
                    <span class="text-sm text-gray-900">{{ $order->customer_phone ?? 'No phone' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Total:</span>
                    <span class="text-sm font-medium text-gray-900">KSh {{ number_format($order->total) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Date:</span>
                    <span class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Status Update -->
        <div class="bg-white shadow rounded-lg p-4 lg:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Status</h3>
            <form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Order Status</label>
                        <select id="status" name="status" 
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-pink-500 focus:border-pink-500 sm:text-sm rounded-md">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" 
                            class="w-full bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-lg">
                        Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 lg:px-6 py-4 border-b border-gray-200">
            <h3 class="text-base lg:text-lg font-medium text-gray-900">Order Items</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Type</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Price</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($order->orderItems as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 lg:px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    @if($item->bundle_id)
                                        <!-- Bundle Image -->
                                        <div class="flex-shrink-0">
                                            @if($item->bundle && $item->bundle->image)
                                                <img src="{{ $item->bundle->image }}" 
                                                     alt="{{ $item->bundle->name }}" 
                                                     class="w-12 h-12 rounded-lg object-cover">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item->bundle_name ?? $item->bundle->name ?? 'Bundle' }}
                                            </div>
                                            <div class="text-sm text-gray-500">Bundle</div>
                                            @if($item->bundle->products->count() > 0)
                                                <div class="text-xs text-gray-400 mt-1">
                                                    <span class="font-medium">Contains:</span>
                                                    <div class="flex flex-col gap-1 mt-1">
                                                        @foreach($item->bundle->products as $product)
                                                            <div class="flex items-center space-x-1">
                                                                @if($product->image)
                                                                    <img src="{{ $product->image }}" 
                                                                         alt="{{ $product->name }}" 
                                                                         class="w-6 h-6 rounded object-cover">
                                                                @else
                                                                    <div class="w-6 h-6 bg-gray-100 rounded flex items-center justify-center">
                                                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                                        </svg>
                                                                    </div>
                                                                @endif
                                                                <span>{{ $product->name }} - KSh {{ number_format($product->price) }}</span>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @php
                                                        $totalIndividualPrice = $item->bundle->products->sum('price');
                                                        $bundlePrice = $item->bundle->price;
                                                        $savings = $totalIndividualPrice - $bundlePrice;
                                                    @endphp
                                                    <div class="mt-1 text-xs">
                                                        @if($savings > 0)
                                                            <span class="text-green-600">Bundle Savings: KSh {{ number_format($savings) }}</span>
                                                        @else
                                                            <span class="text-blue-600">Bundle Value: KSh {{ number_format(abs($savings)) }} extra value</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ $item->product->image }}" 
                                                     alt="{{ $item->product->name }}" 
                                                     class="w-12 h-12 rounded-lg object-cover">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $item->product_name ?? $item->product->name ?? 'Product' }}
                                            </div>
                                            @if($item->product)
                                                <div class="text-sm text-gray-500">{{ $item->product->brand->name ?? 'No Brand' }}</div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($item->bundle_id) bg-purple-100 text-purple-800 @else bg-blue-100 text-blue-800 @endif">
                                    {{ $item->bundle_id ? 'Bundle' : 'Product' }}
                                </span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $item->quantity }}</span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <span class="text-sm text-gray-900">
                                    @if($item->bundle_id)
                                        KSh {{ number_format($item->bundle_price ?? 0) }}
                                    @else
                                        KSh {{ number_format($item->product_price ?? 0) }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">KSh {{ number_format($item->subtotal ?? 0) }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No items found in this order.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 