@extends('layouts.app')

@section('title', 'Review Your Order - Zayn\'s Beauty')

@section('content')
<div class="bg-white min-h-screen py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Review Your Order</h1>
                <p class="text-gray-600">Order #{{ $order->order_number }} - {{ $order->created_at->format('M d, Y') }}</p>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 rounded-lg p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Customer</p>
                        <p class="font-medium">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total</p>
                        <p class="font-medium">{{ $order->formatted_total }}</p>
                    </div>
                </div>
            </div>

            <!-- Reviewable Items -->
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-900">Review Your Items</h2>
                
                @foreach($reviewableItems as $item)
                    <div class="border border-gray-200 rounded-lg p-6" id="review-item-{{ $item['type'] }}-{{ $item['id'] }}">
                        <div class="flex items-start space-x-4">
                            <!-- Item Image -->
                            <div class="flex-shrink-0">
                                @if($item['image'])
                                    <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($item['image']) }}" 
                                         alt="{{ $item['name'] }}" 
                                         class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Item Details -->
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $item['name'] }}</h3>
                                <p class="text-sm text-gray-600">Quantity: {{ $item['quantity'] }}</p>
                                <p class="text-sm text-gray-600 capitalize">{{ $item['type'] }}</p>
                                
                                @if($item['already_reviewed'])
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Already Reviewed
                                        </span>
                                    </div>
                                @else
                                    <!-- Review Form -->
                                    <div class="mt-4 space-y-4">
                                        <!-- Rating -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                            <div class="flex items-center space-x-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <button type="button" 
                                                            class="rating-star text-2xl text-gray-300 hover:text-yellow-400 transition-colors"
                                                            data-rating="{{ $i }}"
                                                            data-item-type="{{ $item['type'] }}"
                                                            data-item-id="{{ $item['id'] }}">
                                                        ★
                                                    </button>
                                                @endfor
                                            </div>
                                        </div>

                                        <!-- Comment -->
                                        <div>
                                            <label for="comment-{{ $item['type'] }}-{{ $item['id'] }}" class="block text-sm font-medium text-gray-700 mb-2">Comment (Optional)</label>
                                            <textarea id="comment-{{ $item['type'] }}-{{ $item['id'] }}"
                                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                                                      rows="3"
                                                      placeholder="Share your experience with this product..."></textarea>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="button" 
                                                class="submit-review bg-pink-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-pink-700 transition-colors"
                                                data-item-type="{{ $item['type'] }}"
                                                data-item-id="{{ $item['id'] }}">
                                            Submit Review
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Complete Review Link -->
            <div class="mt-8 text-center">
                <a href="{{ route('reviews.complete', $reviewLink->unique_token) }}" 
                   class="bg-gray-600 text-white px-8 py-3 rounded-lg font-medium hover:bg-gray-700 transition-colors">
                    Complete Review Process
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Rating functionality
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratings = {};

    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.dataset.rating;
            const itemType = this.dataset.itemType;
            const itemId = this.dataset.itemId;
            const key = `${itemType}-${itemId}`;
            
            // Store rating
            ratings[key] = rating;
            
            // Update star display
            const stars = this.parentElement.querySelectorAll('.rating-star');
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });

    // Submit review functionality
    const submitButtons = document.querySelectorAll('.submit-review');
    
    submitButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemType = this.dataset.itemType;
            const itemId = this.dataset.itemId;
            const key = `${itemType}-${itemId}`;
            
            if (!ratings[key]) {
                alert('Please select a rating before submitting.');
                return;
            }
            
            const comment = document.getElementById(`comment-${itemType}-${itemId}`).value;
            
            // Disable button and show loading
            this.disabled = true;
            this.textContent = 'Submitting...';
            
            // Submit review
            fetch('{{ route("reviews.store", $reviewLink->unique_token) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    reviewable_type: itemType,
                    reviewable_id: itemId,
                    rating: ratings[key],
                    comment: comment
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    this.textContent = 'Review Submitted!';
                    this.classList.remove('bg-pink-600', 'hover:bg-pink-700');
                    this.classList.add('bg-green-600');
                    
                    // Disable the entire review form
                    const reviewItem = document.getElementById(`review-item-${itemType}-${itemId}`);
                    const reviewForm = reviewItem.querySelector('.mt-4');
                    reviewForm.innerHTML = `
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Review Submitted Successfully!
                            </span>
                        </div>
                    `;
                } else {
                    alert(data.message || 'Error submitting review. Please try again.');
                    this.disabled = false;
                    this.textContent = 'Submit Review';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error submitting review. Please try again.');
                this.disabled = false;
                this.textContent = 'Submit Review';
            });
        });
    });
});
</script>
@endsection 