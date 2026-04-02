@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-md p-8 shadow-sm text-center">
            <!-- Success Icon -->
            <div class="mb-8">
                <div class="bg-green-100 rounded-full w-20 h-20 flex items-center justify-center mx-auto">
                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Success Message -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Placed Successfully!</h1>
            <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                Thank you for your order! We've received your purchase and will begin processing it right away.
            </p>

            <!-- What's Next -->
            <div class="bg-blue-50 rounded-md p-6 mb-8">
                <h2 class="text-lg font-semibold text-blue-900 mb-4">What's Next?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="text-center">
                        <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                            <span class="text-blue-600 font-bold">1</span>
                        </div>
                        <p class="text-blue-800">You'll receive an email confirmation with your order details</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                            <span class="text-blue-600 font-bold">2</span>
                        </div>
                        <p class="text-blue-800">We'll process your order and notify you when it ships</p>
                    </div>
                    <div class="text-center">
                        <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-2">
                            <span class="text-blue-600 font-bold">3</span>
                        </div>
                        <p class="text-blue-800">Track your order status in your account dashboard</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-gray-50 rounded-md p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Need Help?</h3>
                <p class="text-gray-600 mb-4">
                    If you have any questions about your order, please don't hesitate to contact us.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-2 sm:space-y-0 sm:space-x-4 text-sm">
                    <span class="text-gray-700">
                        <strong>Email:</strong> {{ \App\Helpers\SettingsHelper::getEmail('support') }}
                    </span>
                    <span class="text-gray-700">
                        <strong>Phone:</strong> {{ \App\Helpers\SettingsHelper::getPhone('primary') }}
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" 
                   class="bg-pink-600 text-white py-3 px-8 rounded-md hover:bg-pink-700 transition-colors font-semibold">
                    Continue Shopping
                </a>
                <a href="{{ route('contact') }}" 
                   class="bg-gray-600 text-white py-3 px-8 rounded-md hover:bg-gray-700 transition-colors font-semibold">
                    Contact Support
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 