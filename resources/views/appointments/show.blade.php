@extends('layouts.app')

@section('title', 'Appointment Details - Zayn\'s Beauty')

@section('content')

<div class="bg-white border-b border-gray-100 py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
        <div class="flex items-center gap-4">
            <a href="{{ route('appointments.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <p class="text-xs uppercase tracking-widest text-pink-600 font-medium mb-1">Zayn's Beauty Studio</p>
                <h1 class="text-3xl font-bold text-gray-900">Appointment Details</h1>
            </div>
        </div>
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl space-y-5">

        <div class="bg-white border border-gray-100 rounded-sm shadow-sm p-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-4">Appointment</p>
                    <dl class="space-y-3 text-sm">
                        <div><dt class="text-gray-500">Service</dt><dd class="font-medium text-gray-900 mt-0.5">{{ $appointment->service_type_label }}</dd></div>
                        <div><dt class="text-gray-500">Date</dt><dd class="font-medium text-gray-900 mt-0.5">{{ $appointment->appointment_date->format('l, F d, Y') }}</dd></div>
                        <div><dt class="text-gray-500">Time</dt><dd class="font-medium text-gray-900 mt-0.5">{{ $appointment->appointment_time->format('g:i A') }}</dd></div>
                        <div><dt class="text-gray-500">Duration</dt><dd class="font-medium text-gray-900 mt-0.5">{{ $appointment->formatted_duration }}</dd></div>
                        <div><dt class="text-gray-500">Price</dt><dd class="font-semibold text-pink-600 mt-0.5">{{ $appointment->formatted_price }}</dd></div>
                        <div>
                            <dt class="text-gray-500">Status</dt>
                            <dd class="mt-0.5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium
                                    bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-4">Your Details</p>
                    <dl class="space-y-3 text-sm">
                        <div><dt class="text-gray-500">Name</dt><dd class="font-medium text-gray-900 mt-0.5">{{ $appointment->customer_name }}</dd></div>
                        <div><dt class="text-gray-500">Email</dt><dd class="font-medium text-gray-900 mt-0.5">{{ $appointment->customer_email }}</dd></div>
                        <div><dt class="text-gray-500">Phone</dt><dd class="font-medium text-gray-900 mt-0.5">{{ $appointment->customer_phone }}</dd></div>
                        @if($appointment->special_requests)
                        <div><dt class="text-gray-500">Special Requests</dt><dd class="text-gray-700 mt-0.5">{{ $appointment->special_requests }}</dd></div>
                        @endif
                        @if($appointment->notes)
                        <div><dt class="text-gray-500">Notes</dt><dd class="text-gray-700 mt-0.5">{{ $appointment->notes }}</dd></div>
                        @endif
                    </dl>
                </div>
            </div>

            @if($appointment->service_description)
            <div class="mt-8 pt-6 border-t border-gray-100">
                <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-2">Service Description</p>
                <p class="text-sm text-gray-600">{{ $appointment->service_description }}</p>
            </div>
            @endif
        </div>

        {{-- Info box --}}
        <div class="bg-white border border-gray-100 rounded-sm shadow-sm p-6">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-4">Before Your Appointment</p>
            <ul class="space-y-2 text-sm text-gray-600">
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 mt-0.5 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Please arrive 10 minutes before your appointment time
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 mt-0.5 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Bring any reference photos if you have a specific look in mind
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 mt-0.5 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Mention any skin sensitivities or allergies to your makeup artist
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-4 h-4 mt-0.5 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Contact us if you need to reschedule or cancel
                </li>
            </ul>
        </div>

        <div class="flex gap-3">
            <a href="{{ route('appointments.index') }}"
               class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-sm transition-colors">
                ← All Appointments
            </a>
            <a href="{{ route('appointments.create') }}"
               class="px-5 py-2.5 bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold rounded-sm transition-colors">
                Book Another
            </a>
        </div>

    </div>
</div>

@endsection
