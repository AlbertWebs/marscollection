@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Shipping Information</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Learn about our shipping options, delivery times, and policies.
                </p>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-2xl p-8 shadow-sm">
            <div class="prose prose-lg max-w-none">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Shipping Options</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-pink-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Standard Shipping</h3>
                        <p class="text-gray-600 mb-3">3-5 business days</p>
                        <p class="text-2xl font-bold text-pink-600">KES 500</p>
                        <p class="text-sm text-gray-500 mt-2">Free on orders over KES 5,000</p>
                    </div>
                    <div class="bg-purple-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Express Shipping</h3>
                        <p class="text-gray-600 mb-3">1-2 business days</p>
                        <p class="text-2xl font-bold text-purple-600">KES 1,200</p>
                        <p class="text-sm text-gray-500 mt-2">Available for most locations</p>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Delivery Areas</h2>
                <p class="text-gray-600 mb-6">
                    We currently ship to the following areas in Kenya:
                </p>
                <ul class="list-disc pl-6 text-gray-600 mb-6">
                    <li>Nairobi (All areas)</li>
                    <li>Mombasa</li>
                    <li>Kisumu</li>
                    <li>Nakuru</li>
                    <li>Eldoret</li>
                    <li>Thika</li>
                    <li>Other major towns (contact us for availability)</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Processing</h2>
                <p class="text-gray-600 mb-6">
                    Orders are typically processed within 24 hours of placement. You will receive an email 
                    confirmation with tracking information once your order ships.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Tracking Your Order</h2>
                <p class="text-gray-600 mb-6">
                    Once your order ships, you'll receive a tracking number via email. You can also track 
                    your order status in your account dashboard.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Delivery Times</h2>
                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Estimated Delivery Times</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-medium text-gray-900">Nairobi</h4>
                            <p class="text-gray-600">Standard: 1-2 days | Express: Same day</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-900">Other Major Cities</h4>
                            <p class="text-gray-600">Standard: 3-5 days | Express: 1-2 days</p>
                        </div>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Shipping Restrictions</h2>
                <p class="text-gray-600 mb-6">
                    Some items may have shipping restrictions due to their nature or size:
                </p>
                <ul class="list-disc pl-6 text-gray-600 mb-6">
                    <li>Fragile items may require special handling</li>
                    <li>Large items may have additional shipping fees</li>
                    <li>Some beauty products may have temperature restrictions</li>
                    <li>International shipping is not currently available</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h2>
                <p class="text-gray-600 mb-6">
                    For shipping-related questions, please contact us:
                </p>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">
                        <strong>Email:</strong> {{ \App\Helpers\SettingsHelper::getEmailByType('shipping') }}<br>
                        <strong>Phone:</strong> {{ \App\Helpers\SettingsHelper::getPhone('primary') }}<br>
                        <strong>Hours:</strong> Monday - Friday, {{ \App\Helpers\SettingsHelper::getBusinessHours('monday_friday') }}
                    </p>
                </div>

                <div class="mt-8 p-4 bg-green-50 rounded-lg">
                    <p class="text-sm text-green-800">
                        <strong>Note:</strong> Delivery times may be affected by holidays, weather conditions, 
                        or other factors beyond our control. We'll keep you updated on any delays.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 