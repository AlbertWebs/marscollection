@extends('layouts.admin')

@section('title', 'Appointments Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Appointments Management</h1>
    </div>

    <!-- Tabs -->
    <div class="border-b border-gray-200 overflow-x-auto">
        <nav class="-mb-px flex space-x-4 sm:space-x-8 min-w-max sm:min-w-0">
            <a href="{{ route('admin.appointments.index') }}" 
               class="border-b-2 border-pink-500 py-2 px-1 text-sm font-medium text-pink-600">
                Appointments
            </a>
            <a href="{{ route('admin.booking-settings.index') }}" 
               class="border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Booking Settings
            </a>
        </nav>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-sm p-4 lg:p-6">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                       placeholder="Search by name, email, phone..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div>
                <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">From Date</label>
                <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-sm focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>
            <div class="flex items-end">
                <button type="submit" 
                        class="w-full bg-gray-600 text-white px-4 py-2 rounded-sm hover:bg-gray-700 transition-colors">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Appointments Table -->
    <div class="bg-white shadow rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 hidden sm:table-header-group">
                    <tr>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Service</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Price</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-gray-50 border-b border-gray-200 sm:border-0">
                            <td class="px-3 lg:px-6 py-3 sm:py-4">
                                <div class="space-y-1">
                                    <div class="text-sm font-medium text-gray-900">{{ $appointment->customer_name }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">{{ $appointment->customer_email }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">{{ $appointment->customer_phone }}</div>
                                    <div class="flex items-center gap-2 text-xs sm:hidden mt-1">
                                        <span class="text-gray-500">{{ $appointment->service_type_label }}</span>
                                        <span class="text-gray-400">•</span>
                                        <span class="text-gray-500">{{ $appointment->formatted_price }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 hidden md:table-cell">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $appointment->service_type_label }}</div>
                                    <div class="text-sm text-gray-500">{{ $appointment->formatted_duration }}</div>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-3 sm:py-4">
                                <div class="space-y-0.5">
                                    <div class="text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">{{ $appointment->appointment_time->format('g:i A') }}</div>
                                    <div class="sm:hidden mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                            bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="text-sm font-medium text-gray-900">{{ $appointment->formatted_price }}</span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    bg-{{ $appointment->status_color }}-100 text-{{ $appointment->status_color }}-800">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td class="px-3 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.appointments.show', $appointment) }}" 
                                   class="text-pink-600 hover:text-pink-900 whitespace-nowrap">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No appointments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($appointments->hasPages())
            <div class="px-4 lg:px-6 py-4 border-t border-gray-200">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 