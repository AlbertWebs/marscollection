@extends('layouts.app')

@section('title', 'Appointment Booked - Zayn\'s Beauty')

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
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Appointment Booked!</h1>
            <p class="text-gray-500 text-sm max-w-sm mx-auto">
                Thank you for choosing Zayn's Beauty. We'll be in touch shortly to confirm your appointment.
            </p>
        </div>

        {{-- What's next --}}
        <div class="bg-white border border-gray-100 rounded-sm shadow-sm p-6 mb-5">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-5">What Happens Next</p>
            <div class="space-y-4">
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-pink-50 rounded-sm flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Confirmation email</p>
                        <p class="text-xs text-gray-500 mt-0.5">Check your inbox for your appointment details</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-pink-50 rounded-sm flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">We'll call to confirm</p>
                        <p class="text-xs text-gray-500 mt-0.5">Our team will reach out to confirm your slot</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-pink-50 rounded-sm flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-900">Arrive 10 minutes early</p>
                        <p class="text-xs text-gray-500 mt-0.5">So we can get started on time</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Contact --}}
        @if(\App\Models\Setting::get('contact_phone_primary') || \App\Models\Setting::get('contact_email_primary'))
        <div class="bg-white border border-gray-100 rounded-sm shadow-sm p-5 mb-5 text-center text-sm text-gray-500">
            <p class="mb-2 font-medium text-gray-700">Need to make changes?</p>
            <div class="flex items-center justify-center gap-5">
                @if(\App\Models\Setting::get('contact_phone_primary'))
                <a href="tel:{{ \App\Models\Setting::get('contact_phone_primary') }}" class="hover:text-gray-900 transition-colors">
                    {{ \App\Models\Setting::get('contact_phone_primary') }}
                </a>
                @endif
                @if(\App\Models\Setting::get('contact_email_primary'))
                <a href="mailto:{{ \App\Models\Setting::get('contact_email_primary') }}" class="hover:text-gray-900 transition-colors">
                    {{ \App\Models\Setting::get('contact_email_primary') }}
                </a>
                @endif
            </div>
        </div>
        @endif

        {{-- Actions --}}
        <div class="flex gap-3">
            <a href="{{ route('home') }}"
               class="flex-1 bg-pink-600 hover:bg-pink-700 text-white py-3 rounded-sm text-sm font-semibold transition-colors text-center">
                Back to Home
            </a>
            <a href="{{ route('appointments.create') }}"
               class="flex-1 border border-gray-200 hover:border-gray-300 bg-white text-gray-700 py-3 rounded-sm text-sm font-medium transition-colors text-center">
                Book Another
            </a>
        </div>

    </div>
</div>

@endsection
