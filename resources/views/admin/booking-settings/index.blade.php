@extends('layouts.admin')

@section('title', 'Booking Settings')

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
               class="border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                Appointments
            </a>
            <a href="{{ route('admin.booking-settings.index') }}" 
               class="border-b-2 border-amber-500 py-2 px-1 text-sm font-medium text-amber-600">
                Booking Settings
            </a>
        </nav>
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h2 class="text-lg lg:text-xl font-semibold text-gray-900">Booking Settings</h2>
        <p class="text-sm text-gray-600">Configure business hours, breaks, and disabled time slots for each day</p>
    </div>

    <!-- Settings Form -->
    <div class="bg-white shadow rounded-md">
        <form method="POST" action="{{ route('admin.booking-settings.update') }}" class="p-4 lg:p-6">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                @foreach($bookingSettings as $setting)
                    <div class="border border-gray-200 rounded-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $days[$setting->day_of_week] }}</h3>
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="disabled_{{ $setting->day_of_week }}" 
                                       name="settings[{{ $setting->day_of_week }}][is_disabled]" 
                                       value="1"
                                       {{ $setting->is_disabled ? 'checked' : '' }}
                                       class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded-md">
                                <label for="disabled_{{ $setting->day_of_week }}" class="ml-2 text-sm text-gray-700">
                                    Disable this day
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <!-- Business Hours -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Business Hours Start</label>
                                <input type="time" 
                                       name="settings[{{ $setting->day_of_week }}][business_hours_start]"
                                       value="{{ $setting->business_hours_start ? $setting->business_hours_start->format('H:i') : '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Business Hours End</label>
                                <input type="time" 
                                       name="settings[{{ $setting->day_of_week }}][business_hours_end]"
                                       value="{{ $setting->business_hours_end ? $setting->business_hours_end->format('H:i') : '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Slot Duration (minutes)</label>
                                <input type="number" 
                                       name="settings[{{ $setting->day_of_week }}][slot_duration]"
                                       value="{{ $setting->slot_duration }}"
                                       min="15" max="240" step="15"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                        </div>

                        <!-- Break Time -->
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Break Time</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Break Start</label>
                                    <input type="time" 
                                           name="settings[{{ $setting->day_of_week }}][break_start]"
                                           value="{{ $setting->break_start ? $setting->break_start->format('H:i') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Break End</label>
                                    <input type="time" 
                                           name="settings[{{ $setting->day_of_week }}][break_end]"
                                           value="{{ $setting->break_end ? $setting->break_end->format('H:i') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                                </div>
                            </div>
                        </div>

                        <!-- Disabled Hours -->
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Disabled Time Slots</h4>
                            <div class="space-y-2" id="disabled-hours-{{ $setting->day_of_week }}">
                                @if($setting->disabled_hours)
                                    @foreach($setting->disabled_hours as $index => $hour)
                                        <div class="flex items-center space-x-2">
                                            <input type="time" 
                                                   name="settings[{{ $setting->day_of_week }}][disabled_hours][]"
                                                   value="{{ $hour }}"
                                                   class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                                            <button type="button" 
                                                    onclick="removeDisabledHour(this)"
                                                    class="text-red-600 hover:text-red-800">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" 
                                    onclick="addDisabledHour({{ $setting->day_of_week }})"
                                    class="mt-2 text-sm text-amber-600 hover:text-amber-800">
                                + Add Disabled Time Slot
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <div class="mt-6 flex justify-end">
                <button type="submit" 
                        class="bg-amber-600 text-white px-6 py-2 rounded-md hover:bg-amber-700 transition-colors">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function addDisabledHour(dayOfWeek) {
    const container = document.getElementById(`disabled-hours-${dayOfWeek}`);
    const div = document.createElement('div');
    div.className = 'flex items-center space-x-2';
    div.innerHTML = `
        <input type="time" 
               name="settings[${dayOfWeek}][disabled_hours][]"
               class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
        <button type="button" 
                onclick="removeDisabledHour(this)"
                class="text-red-600 hover:text-red-800">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    `;
    container.appendChild(div);
}

function removeDisabledHour(button) {
    button.parentElement.remove();
}
</script>
@endsection 