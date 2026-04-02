@extends('layouts.app')

@section('title', 'Appointment Booked Successfully - Zayn\'s Beauty')

@section('content')
<div class="bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Success Header -->
            <div class="text-center mb-12">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Appointment Booked Successfully!</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Thank you for choosing Zayn's Beauty. We've received your booking and will contact you shortly to confirm your appointment.
                </p>
            </div>

            <!-- What Happens Next -->
            <div class="bg-white rounded-sm shadow-xl p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">What Happens Next?</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Email Confirmation -->
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-sm flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email Confirmation</p>
                            <p class="font-semibold text-gray-900">Check your email</p>
                        </div>
                    </div>

                    <!-- Phone Call -->
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-green-100 rounded-sm flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Phone Confirmation</p>
                            <p class="font-semibold text-gray-900">We'll call you soon</p>
                        </div>
                    </div>

                    <!-- Calendar -->
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-sm flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Calendar</p>
                            <p class="font-semibold text-gray-900">Add to your calendar</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-white rounded-sm shadow-xl p-8 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">What's Next?</h3>
                <div class="space-y-4">
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-pink-600">1</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Confirmation Email</p>
                            <p class="text-sm text-gray-600">You'll receive a detailed confirmation email with your appointment details</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-pink-600">2</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Phone Confirmation</p>
                            <p class="text-sm text-gray-600">We'll call you to confirm your appointment and answer any questions</p>
                        </div>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-6 h-6 bg-pink-100 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-pink-600">3</span>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Arrive Early</p>
                            <p class="text-sm text-gray-600">Please arrive 10 minutes before your appointment time</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('home') }}" 
                   class="flex-1 bg-gradient-to-r from-pink-600 to-purple-600 text-white py-4 px-6 rounded-sm font-semibold hover:from-pink-700 hover:to-purple-700 transition-all duration-300 text-center">
                    Back to Home
                </a>
                <a href="{{ route('appointments.create') }}" 
                   class="flex-1 bg-white border-2 border-pink-600 text-pink-600 py-4 px-6 rounded-sm font-semibold hover:bg-pink-600 hover:text-white transition-all duration-300 text-center">
                    Book Another Appointment
                </a>
            </div>

            <!-- Contact Information -->
            <div class="mt-8 text-center">
                <p class="text-gray-600 mb-2">Need to make changes?</p>
                <div class="flex items-center justify-center space-x-6 text-sm text-gray-500">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>{{ \App\Models\Setting::get('contact_phone_primary') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \App\Models\Setting::get('contact_email_primary') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 