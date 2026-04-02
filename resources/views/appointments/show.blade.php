@extends('layouts.app')

@section('title', 'Appointment Details - Zayn\'s Beauty')

@section('content')
<div class="bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Appointment Details</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    View your appointment information
                </p>
            </div>

            <!-- Navigation -->
            <div class="flex justify-between items-center mb-8">
                <a href="{{ route('appointments.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Appointments
                </a>
                <a href="{{ route('appointments.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-sm text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Book Another Appointment
                </a>
            </div>

            <!-- Appointment Details -->
            <div class="bg-white rounded-sm shadow-xl p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Appointment Information</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Service</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $appointment->service_type_label }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $appointment->appointment_date->format('l, F d, Y') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Time</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $appointment->appointment_time->format('g:i A') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Duration</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $appointment->formatted_duration }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Price</label>
                                <p class="mt-1 text-lg font-semibold text-pink-600">{{ $appointment->formatted_price }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Your Details</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $appointment->customer_name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $appointment->customer_email }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $appointment->customer_phone }}</p>
                            </div>

                            @if($appointment->special_requests)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Special Requests</label>
                                    <p class="mt-1 text-lg text-gray-900">{{ $appointment->special_requests }}</p>
                                </div>
                            @endif

                            @if($appointment->notes)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Admin Notes</label>
                                    <p class="mt-1 text-lg text-gray-900">{{ $appointment->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Service Description -->
                @if($appointment->service_description)
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Service Description</h3>
                        <p class="text-gray-700">{{ $appointment->service_description }}</p>
                    </div>
                @endif

                <!-- Important Information -->
                <div class="mt-8 p-6 bg-blue-50 rounded-sm">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">Important Information</h3>
                    <ul class="space-y-2 text-blue-800">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Please arrive 10 minutes before your appointment time
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Bring any reference photos if you have a specific look in mind
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mention any skin sensitivities or allergies to your makeup artist
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Contact us if you need to reschedule or cancel
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 