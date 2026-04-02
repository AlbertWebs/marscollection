@extends('layouts.app')

@section('title', 'Book Appointment - Zayn\'s Beauty')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">Book Your Makeup Appointment</h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Transform your look with our professional makeup services. Choose your preferred service and time slot.
                </p>
            </div>

            <!-- Progress Steps -->
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-4">
                    <div class="flex items-center">
                        <div id="step-1-indicator" class="w-8 h-8 rounded-full bg-pink-600 text-white flex items-center justify-center font-semibold">1</div>
                        <span class="ml-2 text-sm font-medium text-gray-900">Select Date & Time</span>
                    </div>
                    <div class="w-12 h-1 bg-gray-300"></div>
                    <div class="flex items-center">
                        <div id="step-2-indicator" class="w-8 h-8 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-semibold">2</div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Your Details</span>
                    </div>
                </div>
            </div>

            <div class="max-w-4xl mx-auto">
                <!-- Step 1: Calendar & Time Selection -->
                <div id="step-1">
                    <div class="bg-white rounded-md shadow-sm border border-gray-100 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Step 1: Choose Your Date & Time</h2>
                        
                        <!-- Service Selection -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Choose Your Service *</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($serviceTypes as $type => $label)
                                    <label class="flex items-center p-4 border border-gray-200 rounded-md cursor-pointer hover:border-pink-300 transition-colors">
                                        <input type="radio" name="service_type" value="{{ $type }}" 
                                               class="w-4 h-4 text-pink-600 border-gray-300 focus:ring-pink-500"
                                               required>
                                        <div class="ml-3 flex-1">
                                            <div class="text-sm font-medium text-gray-900">{{ $label }}</div>
                                            <div class="text-xs text-gray-500">{{ $serviceDescriptions[$type] }}</div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('service_type')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Calendar -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Select Date *</label>
                            <div class="bg-gray-50 rounded-md p-4">
                                <div class="flex items-center justify-between mb-4">
                                    <button type="button" id="prev-month" class="p-2 hover:bg-gray-200 rounded-md">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                        </svg>
                                    </button>
                                    <h3 id="current-month" class="text-lg font-semibold text-gray-900"></h3>
                                    <button type="button" id="next-month" class="p-2 hover:bg-gray-200 rounded-md">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Calendar Grid -->
                                <div class="grid grid-cols-7 gap-1">
                                    <div class="text-center text-xs font-medium text-gray-500 py-2">Sun</div>
                                    <div class="text-center text-xs font-medium text-gray-500 py-2">Mon</div>
                                    <div class="text-center text-xs font-medium text-gray-500 py-2">Tue</div>
                                    <div class="text-center text-xs font-medium text-gray-500 py-2">Wed</div>
                                    <div class="text-center text-xs font-medium text-gray-500 py-2">Thu</div>
                                    <div class="text-center text-xs font-medium text-gray-500 py-2">Fri</div>
                                    <div class="text-center text-xs font-medium text-gray-500 py-2">Sat</div>
                                    
                                    <div id="calendar-days" class="col-span-7 grid grid-cols-7 gap-1">
                                        <!-- Calendar days will be populated by JavaScript -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Time Slots -->
                        <div id="time-slots-section" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Select Time *</label>
                            <div id="time-slots" class="grid grid-cols-3 md:grid-cols-4 gap-3">
                                <!-- Time slots will be populated by JavaScript -->
                            </div>
                        </div>

                        <!-- Next Step Button -->
                        <div class="mt-8">
                            <button type="button" id="next-step" 
                                    class="w-full bg-pink-600 text-white py-4 rounded-md font-semibold hover:bg-pink-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                Continue to Step 2
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Customer Details -->
                <div id="step-2" class="hidden">
                    <div class="bg-white rounded-md shadow-sm border border-gray-100 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Step 2: Your Details</h2>
                        
                        <form method="POST" action="{{ route('appointments.store') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" id="selected-service" name="service_type">
                            <input type="hidden" id="selected-date" name="appointment_date">
                            <input type="hidden" id="selected-time" name="appointment_time">
                            
                            <!-- Selected Appointment Summary -->
                            <div class="bg-gray-50 rounded-md p-4 mb-6">
                                <h3 class="font-semibold text-gray-900 mb-2">Appointment Summary</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Service:</span>
                                        <span id="summary-service" class="font-medium"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Date:</span>
                                        <span id="summary-date" class="font-medium"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Time:</span>
                                        <span id="summary-time" class="font-medium"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Price:</span>
                                        <span id="summary-price" class="font-medium text-pink-600"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                                    <input type="text" id="customer_name" name="customer_name" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                           required>
                                    @error('customer_name')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                                    <input type="tel" id="customer_phone" name="customer_phone" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                           required>
                                    @error('customer_phone')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                <input type="email" id="customer_email" name="customer_email" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                                       required>
                                @error('customer_email')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Special Requests -->
                            <div>
                                <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-2">Special Requests</label>
                                <textarea id="special_requests" name="special_requests" rows="4"
                                          placeholder="Any specific requests, allergies, or preferences..."
                                          class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent"></textarea>
                                @error('special_requests')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-4">
                                <button type="button" id="back-step" 
                                        class="flex-1 bg-gray-200 text-gray-700 py-4 px-6 rounded-md font-semibold hover:bg-gray-300 transition-all duration-300">
                                    Back to Step 1
                                </button>
                                <button type="submit" 
                                        class="flex-1 bg-pink-600 text-white py-4 px-6 rounded-md font-semibold hover:bg-pink-700 transition-colors">
                                    Book Appointment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Instagram Reels Marquee -->
@include('components.instagram-reels-marquee')

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentDate = new Date();
    let selectedDate = null;
    let selectedTime = null;
    let selectedService = null;
    
    const prices = @json($prices);
    const serviceTypes = @json($serviceTypes);
    
    // Initialize calendar
    renderCalendar();
    
    // Event listeners
    document.getElementById('prev-month').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });
    
    document.getElementById('next-month').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });
    
    // Service selection
    document.querySelectorAll('input[name="service_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            selectedService = this.value;
            updateNextButton();
        });
    });
    
    // Next step button
    document.getElementById('next-step').addEventListener('click', () => {
        if (selectedService && selectedDate && selectedTime) {
            showStep2();
        }
    });
    
    // Back step button
    document.getElementById('back-step').addEventListener('click', () => {
        showStep1();
    });
    
    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        
        // Update month display
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June',
                           'July', 'August', 'September', 'October', 'November', 'December'];
        document.getElementById('current-month').textContent = `${monthNames[month]} ${year}`;
        
        // Get first day of month and number of days
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        
        // Generate calendar HTML
        let calendarHTML = '';
        
        // Add empty cells for days before first day of month
        for (let i = 0; i < firstDay; i++) {
            calendarHTML += '<div class="h-10"></div>';
        }
        
        // Add days of month
        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const isToday = date.toDateString() === new Date().toDateString();
            const isPast = date < new Date();
            const isSelected = selectedDate && date.toDateString() === selectedDate.toDateString();
            
            // Format date as YYYY-MM-DD without timezone issues
            const formattedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            
            let classes = 'h-10 flex items-center justify-center text-sm font-medium rounded-md cursor-pointer transition-colors';
            
            if (isPast) {
                classes += ' text-gray-400 cursor-not-allowed';
            } else if (isSelected) {
                classes += ' bg-pink-600 text-white';
            } else if (isToday) {
                classes += ' bg-pink-100 text-pink-600';
            } else {
                classes += ' text-gray-900 hover:bg-gray-100';
            }
            
            calendarHTML += `<div class="${classes}" data-date="${formattedDate}" ${!isPast ? 'onclick="selectDate(this)"' : ''}>${day}</div>`;
        }
        
        document.getElementById('calendar-days').innerHTML = calendarHTML;
    }
    
    window.selectDate = function(element) {
        // Remove previous selection
        document.querySelectorAll('[data-date]').forEach(el => {
            el.classList.remove('bg-pink-600', 'text-white');
            el.classList.add('text-gray-900', 'hover:bg-gray-100');
        });
        
        // Add selection to clicked element
        element.classList.remove('text-gray-900', 'hover:bg-gray-100');
        element.classList.add('bg-pink-600', 'text-white');
        
        const selectedDateStr = element.dataset.date;
        selectedDate = new Date(selectedDateStr);
        console.log('Selected date:', selectedDateStr);
        loadTimeSlots(selectedDateStr);
        updateNextButton();
    };
    
    function loadTimeSlots(date) {
        console.log('Loading time slots for date:', date);
        console.log('Date type:', typeof date);
        console.log('Date value:', date);
        
        fetch(`/appointments/available-slots?date=${date}`)
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('API Response:', data);
                const timeSlotsContainer = document.getElementById('time-slots');
                timeSlotsContainer.innerHTML = '';
                
                if (data.available_slots.length === 0) {
                    console.log('No available slots found');
                    timeSlotsContainer.innerHTML = '<div class="col-span-full text-center text-gray-500 py-4">No available time slots for this date</div>';
                } else {
                    console.log('Available slots:', data.available_slots);
                    data.available_slots.forEach(slot => {
                        const button = document.createElement('button');
                        button.type = 'button';
                        button.className = 'p-3 border border-gray-300 rounded-md text-sm font-medium hover:border-pink-300 hover:bg-pink-50 transition-colors';
                        button.textContent = formatTime(slot);
                        button.dataset.time = slot;
                        button.onclick = () => selectTime(button);
                        timeSlotsContainer.appendChild(button);
                    });
                }
                
                document.getElementById('time-slots-section').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error loading time slots:', error);
            });
    }
    
    window.selectTime = function(element) {
        // Remove previous selection
        document.querySelectorAll('[data-time]').forEach(el => {
            el.classList.remove('border-pink-500', 'bg-pink-100');
            el.classList.add('border-gray-300');
        });
        
        // Add selection to clicked element
        element.classList.remove('border-gray-300');
        element.classList.add('border-pink-500', 'bg-pink-100');
        
        selectedTime = element.dataset.time;
        updateNextButton();
    };
    
    function formatTime(time) {
        const [hours, minutes] = time.split(':');
        const hour = parseInt(hours);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const displayHour = hour > 12 ? hour - 12 : hour === 0 ? 12 : hour;
        return `${displayHour}:${minutes} ${ampm}`;
    }
    
    function updateNextButton() {
        const nextButton = document.getElementById('next-step');
        if (selectedService && selectedDate && selectedTime) {
            nextButton.disabled = false;
        } else {
            nextButton.disabled = true;
        }
    }
    
    function showStep2() {
        document.getElementById('step-1').classList.add('hidden');
        document.getElementById('step-2').classList.remove('hidden');
        document.getElementById('step-1-indicator').classList.remove('bg-pink-600');
        document.getElementById('step-1-indicator').classList.add('bg-gray-300', 'text-gray-600');
        document.getElementById('step-2-indicator').classList.remove('bg-gray-300', 'text-gray-600');
        document.getElementById('step-2-indicator').classList.add('bg-pink-600', 'text-white');
        
        // Update form fields
        document.getElementById('selected-service').value = selectedService;
        document.getElementById('selected-date').value = selectedDate.toISOString().split('T')[0];
        document.getElementById('selected-time').value = selectedTime;
        
        // Update summary
        document.getElementById('summary-service').textContent = serviceTypes[selectedService];
        document.getElementById('summary-date').textContent = selectedDate.toLocaleDateString('en-US', { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        });
        document.getElementById('summary-time').textContent = formatTime(selectedTime);
        document.getElementById('summary-price').textContent = `KES ${prices[selectedService].toLocaleString()}`;
    }
    
    function showStep1() {
        document.getElementById('step-2').classList.add('hidden');
        document.getElementById('step-1').classList.remove('hidden');
        document.getElementById('step-2-indicator').classList.remove('bg-pink-600', 'text-white');
        document.getElementById('step-2-indicator').classList.add('bg-gray-300', 'text-gray-600');
        document.getElementById('step-1-indicator').classList.remove('bg-gray-300', 'text-gray-600');
        document.getElementById('step-1-indicator').classList.add('bg-pink-600', 'text-white');
    }
});
</script>
@endsection 