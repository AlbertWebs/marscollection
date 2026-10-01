@extends('layouts.app')

@section('robots', 'noindex, nofollow')
@section('canonical', route('cart.index'))

@section('content')
<div class="bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6 md:mb-8">Shopping Cart</h1>

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 md:gap-8">
                <!-- Cart Items -->
                <div class="xl:col-span-2">
                    <div class="bg-white rounded-md shadow-sm border border-gray-200">
                        <div class="p-4 md:p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Cart Items ({{ $cartItems->count() }})</h2>

                            @foreach($cartItems as $item)
                                <div class="py-4 border-b border-gray-200 last:border-b-0">
                                    <!-- Mobile Layout: Stacked -->
                                    <div class="block md:hidden">
                                        <div class="flex items-start space-x-3 mb-3">
                                            @if($item->bundle_id)
                                                <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($item->bundle->image) }}"
                                                     alt="{{ $item->bundle->name }}"
                                                     class="w-16 h-16 object-cover rounded-md flex-shrink-0">

                                                <div class="flex-1 min-w-0">
                                                    <h3 class="text-sm font-semibold text-gray-900 line-clamp-2">{{ $item->bundle->name }}</h3>
                                                    <p class="text-xs text-gray-600">{{ $item->bundle->category }}</p>
                                                    <p class="text-sm font-bold text-amber-600">{{ $item->bundle->formatted_price }}</p>
                                                    <p class="text-xs text-gray-500">Bundle</p>
                                                </div>
                                            @else
                                                <a href="{{ route('products.show', $item->product) }}" class="flex-shrink-0">
                                                    <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($item->product->image) }}"
                                                         alt="{{ $item->product->name }}"
                                                         class="w-16 h-16 object-cover rounded-md hover:opacity-90 transition-opacity">
                                                </a>

                                                <div class="flex-1 min-w-0">
                                                    <a href="{{ route('products.show', $item->product) }}" class="hover:text-amber-600 transition-colors">
                                                        <h3 class="text-sm font-semibold text-gray-900 line-clamp-2">{{ $item->product->name }}</h3>
                                                    </a>
                                                    @if($item->product->category)
                                                        <p class="text-xs text-gray-600">{{ $item->product->category->name }}</p>
                                                    @endif
                                                    <p class="text-sm font-bold text-amber-600">{{ $item->product->formatted_price }}</p>
                                                    @if($item->selected_color)
                                                        <p class="text-[10px] mt-0.5 font-medium text-amber-600">Color: {{ $item->selected_color }}</p>
                                                    @endif
                                                    @if($item->selected_size)
                                                        <p class="text-[10px] mt-0.5 font-medium text-gray-600">Size: {{ $item->selected_size }}</p>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        <div class="flex items-center justify-between">
                                            <!-- Quantity Controls -->
                                            <div class="flex items-center border border-gray-300 rounded-md">
                                                <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                        class="px-4 py-2 text-gray-600 hover:text-gray-900 {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                    </svg>
                                                </button>
                                                <span class="px-4 py-2 border-x border-gray-300 font-medium">{{ $item->quantity }}</span>
                                                <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                        class="px-4 py-2 text-gray-600 hover:text-gray-900">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Remove Button -->
                                            <button onclick="removeFromCart({{ $item->id }})"
                                                    class="text-red-600 hover:text-red-800 p-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Desktop Layout: Side by Side -->
                                    <div class="hidden md:flex items-center">
                                    @if($item->bundle_id)
                                        <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($item->bundle->image) }}"
                                             alt="{{ $item->bundle->name }}"
                                             class="w-20 h-20 object-cover rounded-md">

                                        <div class="ml-4 flex-1">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $item->bundle->name }}</h3>
                                            <p class="text-sm text-gray-600">{{ $item->bundle->category }}</p>
                                            <p class="text-lg font-bold text-amber-600">{{ $item->bundle->formatted_price }}</p>
                                            <p class="text-xs text-gray-500">Bundle</p>
                                        </div>
                                    @else
                                        <a href="{{ route('products.show', $item->product) }}" class="flex-shrink-0">
                                            <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($item->product->image) }}"
                                                 alt="{{ $item->product->name }}"
                                                 class="w-20 h-20 object-cover rounded-md hover:opacity-90 transition-opacity">
                                        </a>

                                        <div class="ml-4 flex-1">
                                            <a href="{{ route('products.show', $item->product) }}" class="hover:text-amber-600 transition-colors">
                                                <h3 class="text-base font-semibold text-gray-900">{{ $item->product->name }}</h3>
                                            </a>
                                            @if($item->product->category)
                                                <p class="text-sm text-gray-600">{{ $item->product->category->name }}</p>
                                            @endif
                                            <p class="text-lg font-bold text-amber-600">{{ $item->product->formatted_price }}</p>
                                            @if($item->selected_color)
                                                <p class="text-xs mt-1 font-medium text-amber-600">Color: {{ $item->selected_color }}</p>
                                            @endif
                                            @if($item->selected_size)
                                                <p class="text-xs mt-1 font-medium text-gray-600">Size: {{ $item->selected_size }}</p>
                                            @endif
                                        </div>
                                    @endif

                                    <div class="flex items-center space-x-4">
                                        <!-- Quantity Controls -->
                                        <div class="flex items-center border border-gray-300 rounded-md">
                                            <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                    class="px-3 py-1 text-gray-600 hover:text-gray-900 {{ $item->quantity <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                                                -
                                            </button>
                                            <span class="px-3 py-1 border-x border-gray-300">{{ $item->quantity }}</span>
                                            <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                    class="px-3 py-1 text-gray-600 hover:text-gray-900">
                                                +
                                            </button>
                                        </div>

                                        <!-- Remove Button -->
                                        <button onclick="removeFromCart({{ $item->id }})"
                                                class="text-red-600 hover:text-red-800">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary & Delivery Form -->
                <div class="xl:col-span-1">
                    <div class="bg-white rounded-md shadow-sm border border-gray-200 p-4 md:p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>

                        {{-- Free Delivery Progress Meter --}}
                        @php
                            $freeDeliveryGoal = 5000;
                            $amountRemaining = max(0, $freeDeliveryGoal - $total);
                            $progressPct = min(100, round(($total / $freeDeliveryGoal) * 100));
                        @endphp
                        <div class="mb-5 p-3.5 bg-gradient-to-r {{ $amountRemaining > 0 ? 'from-amber-50 to-rose-50 border-amber-200' : 'from-emerald-50 to-teal-50 border-emerald-200' }} border rounded-lg">
                            <div class="flex items-center justify-between text-xs font-semibold mb-1.5">
                                @if($amountRemaining > 0)
                                    <span class="text-amber-900 flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                                        </svg>
                                        <span>Add <strong class="text-amber-600">KES {{ number_format($amountRemaining) }}</strong> for <strong class="text-gray-900">FREE Nairobi Delivery</strong></span>
                                    </span>
                                    <span class="text-amber-600 font-bold">{{ $progressPct }}%</span>
                                @else
                                    <span class="text-emerald-900 font-bold flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span>You've unlocked <strong class="text-emerald-700">FREE Delivery</strong> across Nairobi!</span>
                                    </span>
                                    <span class="text-emerald-700 font-bold">100%</span>
                                @endif
                            </div>
                            <div class="w-full bg-gray-200/80 rounded-full h-2 overflow-hidden">
                                <div class="h-2 rounded-full transition-all duration-500 {{ $amountRemaining > 0 ? 'bg-amber-600' : 'bg-emerald-500' }}" style="width: {{ $progressPct }}%"></div>
                            </div>
                        </div>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">KES {{ number_format($total) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold text-emerald-600" id="shipping-cost">{{ $total >= 5000 ? 'FREE (KES 0)' : 'KES 0' }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-semibold">Total</span>
                                    <span class="text-lg font-bold text-amber-600" id="total-cost">KES {{ number_format($total) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Simple Delivery Form -->
                        <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="border-t border-gray-200 pt-4">
                                <h3 class="text-md font-semibold text-gray-900 mb-3">Delivery Details</h3>

                                <div class="space-y-3">
                                    <div>
                                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                                        <input type="text" id="customer_name" name="customer_name" required
                                               class="w-full px-3 py-3 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm">
                                    </div>

                                    <div>
                                        <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                        <input type="email" id="customer_email" name="customer_email" required
                                               class="w-full px-3 py-3 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm">
                                    </div>

                                    <div>
                                        <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number (M-Pesa) *</label>
                                        <input type="tel" id="customer_phone" name="customer_phone" required
                                               placeholder="0712 345 678"
                                               class="w-full px-3 py-3 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm">
                                    </div>

                                    <div>
                                        <label for="customer_city" class="block text-sm font-medium text-gray-700 mb-1">City / Town *</label>
                                        <input type="text" id="customer_city" name="customer_city" required
                                               placeholder="e.g. Nairobi, Westlands, Kilimani, Mombasa..."
                                               class="w-full px-3 py-3 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm"
                                               oninput="calculateShipping()">
                                        <p class="text-xs text-gray-500 mt-1">Free delivery in Nairobi & local towns on orders over KES 5,000</p>
                                    </div>

                                    <div>
                                        <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-1">Delivery Address *</label>
                                        <textarea id="delivery_address" name="delivery_address" rows="2" required
                                                  placeholder="Building, street, apartment or estate name"
                                                  class="w-full px-3 py-3 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm"></textarea>
                                    </div>

                                    <div>
                                        <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method *</label>
                                        <select id="payment_method" name="payment_method" required
                                                class="w-full px-3 py-3 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm bg-white">
                                            <option value="mpesa" selected>Lipa Na M-Pesa (Till / STK Push / Paybill)</option>
                                            <option value="cash_on_delivery">Cash / Card on Delivery (Nairobi)</option>
                                            <option value="credit_card">Credit / Debit Card (Visa / Mastercard)</option>
                                            <option value="bank_transfer">Bank Transfer / Airtel Money</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes</label>
                                        <textarea id="notes" name="notes" rows="2"
                                                  placeholder="Any special instructions..."
                                                  class="w-full px-3 py-3 md:py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500 text-sm"></textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full bg-amber-600 hover:bg-amber-700 text-white py-4 md:py-3 rounded-sm font-semibold transition-colors">
                                Place Order
                            </button>
                        </form>

                        <div class="mt-4 text-center">
                            <a href="{{ route('products.index') }}" class="text-amber-600 hover:text-amber-700 text-sm">
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Your cart is empty</h3>
                <p class="mt-1 text-sm text-gray-500">Start shopping to add items to your cart.</p>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" class="bg-amber-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-amber-700 transition-colors">
                        Start Shopping
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2 max-w-sm"></div>

<script>
const subtotal = {{ $total }};
const tax = subtotal * 0.15;

// Toast notification function
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');

    // Set background color based on type
    const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';

    toast.className = `${bgColor} text-white px-6 py-3 rounded-md shadow-lg transform translate-x-full transition-all duration-300 flex items-center space-x-2 opacity-90 hover:opacity-100`;
    toast.innerHTML = `
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            ${type === 'success' ?
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
            }
        </svg>
        <span>${message}</span>
    `;

    container.appendChild(toast);

    // Animate in from right
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);

    // Auto-remove after 4 seconds (unless hovered)
    let autoRemoveTimeout = setTimeout(() => {
        if (!toast.matches(':hover')) {
            removeToast(toast);
        }
    }, 4000);

    // Pause auto-remove on hover
    toast.addEventListener('mouseenter', () => {
        clearTimeout(autoRemoveTimeout);
    });

    // Resume auto-remove when mouse leaves
    toast.addEventListener('mouseleave', () => {
        autoRemoveTimeout = setTimeout(() => {
            removeToast(toast);
        }, 2000);
    });
}

function removeToast(toast) {
    toast.classList.add('translate-x-full');
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 300);
}

function calculateShipping() {
    const city = document.getElementById('customer_city').value.toLowerCase().trim();
    let shippingCost = 2500; // Default shipping cost in KES

    // Free shipping threshold
    if (subtotal >= 5000) {
        shippingCost = 0;
    } else {
        // Local cities (free shipping)
        const localCities = ['nairobi', 'mombasa', 'kisumu', 'nakuru', 'eldoret', 'thika', 'kakamega', 'kericho', ''];

        // Nearby cities (low shipping cost)
        const nearbyCities = ['naivasha', 'kerugoya', 'nyeri', 'muranga', 'kiambu', 'machakos', 'kitui', 'embu', 'meru'];

        if (localCities.includes(city) || city.includes('nairobi') || city.includes('westlands') || city.includes('kilimani') || city.includes('cbd')) {
            shippingCost = 0;
        } else if (nearbyCities.includes(city)) {
            shippingCost = 1500;
        }
    }

    // Update shipping cost display
    document.getElementById('shipping-cost').textContent = shippingCost === 0 ? 'FREE (KES 0)' : `KES ${shippingCost.toLocaleString()}`;

    // Calculate and update total
    const total = subtotal + shippingCost;
    document.getElementById('total-cost').textContent = `KES ${total.toLocaleString()}`;
}

function updateQuantity(cartItemId, newQuantity) {
    if (newQuantity < 1) return;

    fetch(`/cart/${cartItemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Cart updated successfully!', 'success');
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showToast(data.message || 'Error updating cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error updating cart:', error);
        showToast('Error updating cart. Please try again.', 'error');
    });
}

function removeFromCart(cartItemId) {
    // Create a custom confirmation dialog
    const confirmDialog = document.createElement('div');
    confirmDialog.className = 'fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50';
    confirmDialog.innerHTML = `
        <div class="bg-white rounded-md p-6 max-w-sm mx-4">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Remove Item</h3>
            <p class="text-gray-600 mb-6">Are you sure you want to remove this item from your cart?</p>
            <div class="flex space-x-3">
                <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                    Cancel
                </button>
                <button onclick="confirmRemoveFromCart(${cartItemId})" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                    Remove
                </button>
            </div>
        </div>
    `;
    document.body.appendChild(confirmDialog);
}

function confirmRemoveFromCart(cartItemId) {
    // Remove the confirmation dialog
    document.querySelector('.fixed').remove();

    fetch(`/cart/${cartItemId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('Item removed from cart!', 'success');
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showToast(data.message || 'Error removing item', 'error');
        }
    })
    .catch(error => {
        console.error('Error removing from cart:', error);
        showToast('Error removing item. Please try again.', 'error');
    });
}
</script>
@endsection
