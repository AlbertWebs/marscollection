@extends('layouts.admin')

@section('title', 'Appointment Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Appointment #{{ $appointment->id }}</h1>
        <a href="{{ route('admin.appointments.index') }}" 
           class="text-pink-600 hover:text-pink-700 text-sm sm:text-base">
            ← Back to Appointments
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
        <!-- Appointment Information -->
        <div class="bg-white shadow rounded-md p-4 lg:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Appointment Information</h3>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Appointment ID:</span>
                    <span class="text-sm text-gray-900">#{{ $appointment->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Service:</span>
                    <span class="text-sm text-gray-900">{{ $appointment->service_type_label }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Date:</span>
                    <span class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Time:</span>
                    <span class="text-sm text-gray-900">{{ $appointment->appointment_time->format('g:i A') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Duration:</span>
                    <span class="text-sm text-gray-900">{{ $appointment->formatted_duration }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Price:</span>
                    <span class="text-sm font-medium text-gray-900">{{ $appointment->formatted_price }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Status:</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white shadow rounded-md p-4 lg:p-6">
            <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Name:</span>
                    <span class="text-sm text-gray-900">{{ $appointment->customer_name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Email:</span>
                    <span class="text-sm text-gray-900">{{ $appointment->customer_email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500">Phone:</span>
                    <span class="text-sm text-gray-900">{{ $appointment->customer_phone }}</span>
                </div>
                @if($appointment->special_requests)
                    <div class="border-t border-gray-200 pt-4">
                        <span class="text-sm font-medium text-gray-500">Special Requests:</span>
                        <p class="text-sm text-gray-900 mt-1">{{ $appointment->special_requests }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Update -->
    <div class="bg-white shadow rounded-md p-4 lg:p-6">
        <h3 class="text-base lg:text-lg font-semibold text-gray-900 mb-4">Update Status</h3>
        <form method="POST" action="{{ route('admin.appointments.update-status', $appointment) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Appointment Status</label>
                    <select id="status" name="status" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
                        <option value="pending" {{ $appointment->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ $appointment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ $appointment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $appointment->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                    <textarea id="notes" name="notes" rows="3"
                              placeholder="Add any notes about this appointment..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">{{ old('notes', $appointment->notes) }}</textarea>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" 
                        class="bg-pink-600 text-white px-4 py-2 rounded-md hover:bg-pink-700 transition-colors">
                    Update Status
                </button>
            </div>
        </form>
    </div>

    <!-- Service Details -->
    @if($appointment->service)
    <div class="bg-white shadow rounded-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Service Details</h3>
        <div class="space-y-4">
            <div class="flex justify-between">
                <span class="text-sm font-medium text-gray-500">Service Name:</span>
                <span class="text-sm text-gray-900">{{ $appointment->service->name }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm font-medium text-gray-500">Service Price:</span>
                <span class="text-sm text-gray-900">{{ $appointment->service->formatted_price }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm font-medium text-gray-500">Service Duration:</span>
                <span class="text-sm text-gray-900">{{ $appointment->service->formatted_duration }}</span>
            </div>
            <div class="border-t border-gray-200 pt-4">
                <span class="text-sm font-medium text-gray-500">Service Description:</span>
                <p class="text-sm text-gray-900 mt-1">{{ $appointment->service->description }}</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 