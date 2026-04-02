@extends('layouts.app')

@section('title', 'Review Complete - Zayn\'s Beauty')

@section('content')
<div class="bg-white min-h-screen py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Success Icon -->
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <!-- Success Message -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Thank You for Your Review!</h1>
            <p class="text-xl text-gray-600 mb-8">
                Your feedback helps us improve our products and services. We appreciate you taking the time to share your experience.
            </p>

            <!-- Order Details -->
            <div class="bg-gray-50 rounded-md p-6 mb-8">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Order Details</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Order Number</p>
                        <p class="font-medium">{{ $reviewLink->order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Review Link Status</p>
                        <p class="font-medium text-green-600">Completed</p>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-900">What's Next?</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-pink-50 rounded-md p-4">
                        <div class="w-12 h-12 bg-pink-100 rounded-md flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Shop More</h4>
                        <p class="text-sm text-gray-600">Discover our latest products and exclusive offers</p>
                    </div>
                    
                    <div class="bg-pink-50 rounded-sm p-4">
                        <div class="w-12 h-12 bg-pink-100 rounded-sm flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Book Appointment</h4>
                        <p class="text-sm text-gray-600">Schedule a beauty consultation or treatment</p>
                    </div>
                    
                    <div class="bg-yellow-50 rounded-md p-4">
                        <div class="w-12 h-12 bg-yellow-100 rounded-md flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Stay Updated</h4>
                        <p class="text-sm text-gray-600">Get notified about new products and promotions</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mt-8">
                <a href="{{ route('products.index') }}" 
                   class="bg-pink-600 text-white px-8 py-3 rounded-md font-semibold hover:bg-pink-700 transition-colors">
                    Shop Now
                </a>
                <a href="{{ route('appointments.create') }}" 
                   class="bg-white border-2 border-pink-600 text-pink-600 px-8 py-3 rounded-md font-semibold hover:bg-pink-600 hover:text-white transition-colors">
                    Book Appointment
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 