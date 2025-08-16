@extends('layouts.app')

@section('title', 'Appointments Calendar - Zayn\'s Beauty')

@section('content')
<div class="bg-gradient-to-br from-pink-50 to-purple-50 min-h-screen py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Appointments Calendar</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    View all appointments in a calendar format
                </p>
            </div>

            <!-- Navigation -->
            <div class="flex justify-between items-center mb-8">
                <a href="{{ route('appointments.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
                <a href="{{ route('appointments.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Book Appointment
                </a>
            </div>

            <!-- Calendar -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($appointments as $date => $dayAppointments)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">
                                {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                                <span class="text-sm font-normal text-gray-500">
                                    ({{ \Carbon\Carbon::parse($date)->format('l') }})
                                </span>
                            </h3>
                            
                            <div class="space-y-2">
                                @foreach($dayAppointments as $appointment)
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $appointment->appointment_time->format('g:i A') }}
                                                </div>
                                                <div class="text-xs text-gray-600 mt-1">
                                                    {{ $appointment->service_type_label }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ $appointment->customer_name }}
                                                </div>
                                            </div>
                                            <div class="ml-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                    bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                                                    {{ ucfirst($appointment->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($appointments->count() === 0)
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No appointments</h3>
                        <p class="mt-1 text-sm text-gray-500">No appointments found in the calendar.</p>
                        <div class="mt-6">
                            <a href="{{ route('appointments.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Book Appointment
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 