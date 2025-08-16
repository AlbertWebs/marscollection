@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Returns Policy</h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    We want you to be completely satisfied with your purchase. Learn about our return process.
                </p>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="bg-white rounded-2xl p-8 shadow-sm">
            <div class="prose prose-lg max-w-none">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Return Policy Overview</h2>
                <p class="text-gray-600 mb-6">
                    We accept returns within 30 days of purchase for most items. All returned items must be 
                    unused, unopened, and in their original packaging.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">What Can Be Returned</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-green-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">✅ Acceptable Returns</h3>
                        <ul class="text-gray-600 text-sm space-y-2">
                            <li>• Unopened products in original packaging</li>
                            <li>• Products with manufacturing defects</li>
                            <li>• Wrong items received</li>
                            <li>• Damaged items during shipping</li>
                        </ul>
                    </div>
                    <div class="bg-red-50 p-6 rounded-lg">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">❌ Non-Returnable Items</h3>
                        <ul class="text-gray-600 text-sm space-y-2">
                            <li>• Opened or used products</li>
                            <li>• Personal care items (for hygiene reasons)</li>
                            <li>• Sale or clearance items</li>
                            <li>• Gift cards</li>
                        </ul>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Return Process</h2>
                <div class="bg-gray-50 p-6 rounded-lg mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Step-by-Step Return Process</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4">
                            <div class="bg-pink-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold flex-shrink-0">1</div>
                            <div>
                                <h4 class="font-medium text-gray-900">Contact Customer Service</h4>
                                <p class="text-gray-600">Email us at {{ \App\Helpers\SettingsHelper::getEmailByType('returns') }} or call {{ \App\Helpers\SettingsHelper::getPhone('primary') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="bg-pink-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold flex-shrink-0">2</div>
                            <div>
                                <h4 class="font-medium text-gray-900">Get Return Authorization</h4>
                                <p class="text-gray-600">We'll provide you with a return authorization number</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="bg-pink-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold flex-shrink-0">3</div>
                            <div>
                                <h4 class="font-medium text-gray-900">Package Your Return</h4>
                                <p class="text-gray-600">Include the return authorization number and original receipt</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="bg-pink-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-sm font-bold flex-shrink-0">4</div>
                            <div>
                                <h4 class="font-medium text-gray-900">Ship Your Return</h4>
                                <p class="text-gray-600">Use a trackable shipping method and keep your receipt</p>
                            </div>
                        </div>
                    </div>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Refund Information</h2>
                <p class="text-gray-600 mb-6">
                    Once we receive and inspect your return, we'll process your refund within 5-7 business days.
                </p>
                <ul class="list-disc pl-6 text-gray-600 mb-6">
                    <li>Refunds will be issued to the original payment method</li>
                    <li>Shipping costs are non-refundable unless the item was defective or wrong</li>
                    <li>You'll receive an email confirmation when your refund is processed</li>
                </ul>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Return Shipping</h2>
                <p class="text-gray-600 mb-6">
                    Customers are responsible for return shipping costs unless the item was defective, 
                    damaged during shipping, or the wrong item was sent.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Exchanges</h2>
                <p class="text-gray-600 mb-6">
                    We offer exchanges for different sizes, colors, or similar products. Exchanges follow 
                    the same process as returns. If the new item costs more, you'll need to pay the difference.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Damaged or Defective Items</h2>
                <p class="text-gray-600 mb-6">
                    If you receive a damaged or defective item, please contact us immediately. We'll provide 
                    a prepaid return label and expedite your replacement or refund.
                </p>

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Information</h2>
                <p class="text-gray-600 mb-6">
                    For return-related questions, please contact us:
                </p>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-gray-700">
                        <strong>Email:</strong> {{ \App\Helpers\SettingsHelper::getEmailByType('returns') }}<br>
                        <strong>Phone:</strong> {{ \App\Helpers\SettingsHelper::getPhone('primary') }}<br>
                        <strong>Hours:</strong> Monday - Friday, {{ \App\Helpers\SettingsHelper::getBusinessHours('monday_friday') }}<br>
                        <strong>Address:</strong> {{ \App\Helpers\SettingsHelper::getAddress('full') }}
                    </p>
                </div>

                <div class="mt-8 p-4 bg-blue-50 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <strong>Note:</strong> This returns policy is subject to change. Please check back 
                        periodically for updates. For questions about specific items, please contact our 
                        customer service team.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 