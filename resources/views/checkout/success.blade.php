@extends('layouts.app')

@section('title', 'Order Placed - Zayn\'s Beauty')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-2xl">

        {{-- Success card --}}
        <div class="bg-white border border-gray-100 rounded-sm shadow-sm p-10 text-center mb-5">
            <div class="w-14 h-14 bg-green-50 rounded-sm flex items-center justify-center mx-auto mb-6">
                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Order Placed Successfully!</h1>
            <p class="text-gray-500 text-sm max-w-sm mx-auto">
                Thank you for your order. We've received it and will begin processing right away.
            </p>
        </div>

        {{-- What's next --}}
        <div class="bg-white border border-gray-100 rounded-sm shadow-sm p-6 mb-5">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-5">What Happens Next</p>
            <div class="space-y-4">
                <div class="flex items-start gap-4">
                    <span class="w-6 h-6 rounded-sm bg-pink-50 text-pink-600 text-xs font-bold flex items-center justify-center shrink-0">1</span>
                    <p class="text-sm text-gray-600">You'll receive an email confirmation with your order details</p>
                </div>
                <div class="flex items-start gap-4">
                    <span class="w-6 h-6 rounded-sm bg-pink-50 text-pink-600 text-xs font-bold flex items-center justify-center shrink-0">2</span>
                    <p class="text-sm text-gray-600">We'll process your order and notify you when it ships</p>
                </div>
                <div class="flex items-start gap-4">
                    <span class="w-6 h-6 rounded-sm bg-pink-50 text-pink-600 text-xs font-bold flex items-center justify-center shrink-0">3</span>
                    <p class="text-sm text-gray-600">Track your order status in your account dashboard</p>
                </div>
            </div>
        </div>

        {{-- Need help --}}
        <div class="bg-white border border-gray-100 rounded-sm shadow-sm p-5 mb-5 text-center text-sm text-gray-500">
            <p class="mb-1 font-medium text-gray-700">Need help with your order?</p>
            <div class="flex flex-wrap items-center justify-center gap-4 mt-2">
                @if(\App\Helpers\SettingsHelper::getEmail('support'))
                <span><strong class="text-gray-700">Email:</strong> {{ \App\Helpers\SettingsHelper::getEmail('support') }}</span>
                @endif
                @if(\App\Helpers\SettingsHelper::getPhone('primary'))
                <span><strong class="text-gray-700">Phone:</strong> {{ \App\Helpers\SettingsHelper::getPhone('primary') }}</span>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex gap-3">
            <a href="{{ route('home') }}"
               class="flex-1 bg-pink-600 hover:bg-pink-700 text-white py-3 rounded-sm text-sm font-semibold transition-colors text-center">
                Continue Shopping
            </a>
            <a href="{{ route('contact') }}"
               class="flex-1 border border-gray-200 hover:border-gray-300 bg-white text-gray-700 py-3 rounded-sm text-sm font-medium transition-colors text-center">
                Contact Support
            </a>
        </div>

    </div>
</div>
@endsection
