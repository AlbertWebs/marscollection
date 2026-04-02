@extends('layouts.app')

@section('title', 'My Appointments - Zayn\'s Beauty')

@section('content')

<div class="bg-white border-b border-gray-100 py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
        <div class="flex items-end justify-between">
            <div>
                <p class="text-xs uppercase tracking-widest text-pink-600 font-medium mb-2">Zayn's Beauty Studio</p>
                <h1 class="text-3xl font-bold text-gray-900">My Appointments</h1>
            </div>
            <a href="{{ route('appointments.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold rounded-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Book Appointment
            </a>
        </div>
    </div>
</div>

<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">

        <div class="bg-white border border-gray-100 rounded-sm shadow-sm overflow-hidden">
            @if($appointments->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($appointments as $appointment)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-medium text-gray-900">{{ $appointment->service_type_label }}</p>
                                        @if($appointment->special_requests)
                                            <p class="text-xs text-gray-400 mt-0.5">{{ Str::limit($appointment->special_requests, 50) }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <p class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</p>
                                        <p class="text-xs text-gray-400">{{ $appointment->appointment_time->format('g:i A') }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $appointment->formatted_duration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $appointment->formatted_price }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-sm text-xs font-medium
                                            bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('appointments.show', $appointment) }}"
                                           class="text-pink-600 hover:text-pink-800 font-medium">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-16">
                    <svg class="mx-auto h-10 w-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm font-medium text-gray-900 mb-1">No appointments yet</p>
                    <p class="text-xs text-gray-400 mb-6">Book your first makeup appointment with us.</p>
                    <a href="{{ route('appointments.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold rounded-sm transition-colors">
                        Book Appointment
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>

@endsection
