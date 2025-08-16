@extends('layouts.app')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Checkout</h1>
            <p class="text-gray-600">Complete your order</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('checkout.store') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <!-- Customer Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Customer Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('customer_name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('customer_email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="tel" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('customer_phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping Address</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="shipping_street" class="block text-sm font-medium text-gray-700 mb-2">Street Address *</label>
                                <input type="text" id="shipping_street" name="shipping_address[street]" value="{{ old('shipping_address.street') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('shipping_address.street')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" id="shipping_city" name="shipping_address[city]" value="{{ old('shipping_address.city') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('shipping_address.city')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="shipping_state" class="block text-sm font-medium text-gray-700 mb-2">State/Province *</label>
                                <input type="text" id="shipping_state" name="shipping_address[state]" value="{{ old('shipping_address.state') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('shipping_address.state')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="shipping_zip" class="block text-sm font-medium text-gray-700 mb-2">ZIP/Postal Code *</label>
                                <input type="text" id="shipping_zip" name="shipping_address[zip_code]" value="{{ old('shipping_address.zip_code') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('shipping_address.zip_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="shipping_country" class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                <input type="text" id="shipping_country" name="shipping_address[country]" value="{{ old('shipping_address.country', 'United States') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('shipping_address.country')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Billing Address</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="billing_street" class="block text-sm font-medium text-gray-700 mb-2">Street Address *</label>
                                <input type="text" id="billing_street" name="billing_address[street]" value="{{ old('billing_address.street') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('billing_address.street')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="billing_city" class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" id="billing_city" name="billing_address[city]" value="{{ old('billing_address.city') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('billing_address.city')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="billing_state" class="block text-sm font-medium text-gray-700 mb-2">State/Province *</label>
                                <input type="text" id="billing_state" name="billing_address[state]" value="{{ old('billing_address.state') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('billing_address.state')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="billing_zip" class="block text-sm font-medium text-gray-700 mb-2">ZIP/Postal Code *</label>
                                <input type="text" id="billing_zip" name="billing_address[zip_code]" value="{{ old('billing_address.zip_code') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('billing_address.zip_code')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="billing_country" class="block text-sm font-medium text-gray-700 mb-2">Country *</label>
                                <input type="text" id="billing_country" name="billing_address[country]" value="{{ old('billing_address.country', 'United States') }}" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                                @error('billing_address.country')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Method</h2>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="cash_on_delivery" checked
                                       class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300">
                                <span class="ml-3 text-sm text-gray-700">Cash on Delivery</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="credit_card"
                                       class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300">
                                <span class="ml-3 text-sm text-gray-700">Credit Card</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="bank_transfer"
                                       class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300">
                                <span class="ml-3 text-sm text-gray-700">Bank Transfer</span>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order Notes -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Notes</h2>
                        <textarea name="notes" rows="3" placeholder="Any special instructions or notes for your order..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-24">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                            <div class="flex items-center space-x-3">
                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" 
                                     class="w-12 h-12 object-cover rounded">
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-sm font-medium text-gray-900">
                                    ${{ number_format($item->product->price * $item->quantity, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Totals -->
                    <div class="border-t border-gray-200 pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900">${{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Tax (15%)</span>
                            <span class="text-gray-900">${{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="text-gray-900">${{ number_format($shipping, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-lg font-semibold border-t border-gray-200 pt-2">
                            <span class="text-gray-900">Total</span>
                            <span class="text-gray-900">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" form="checkout-form" 
                            class="w-full bg-pink-600 text-white py-3 px-4 rounded-md hover:bg-pink-700 transition-colors font-semibold mt-6">
                        Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Add form ID to the form
document.querySelector('form').id = 'checkout-form';
</script>
@endsection 