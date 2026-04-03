@extends('layouts.app')

@section('title', 'Book Appointment - Zayn\'s Beauty')

@section('content')
<div class="bg-gray-50 min-h-screen">

    {{-- Page header --}}
    <div class="bg-white border-b border-gray-100 py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl">
            <p class="text-xs uppercase tracking-widest text-pink-600 font-medium mb-2">Zayn's Beauty Studio</p>
            <h1 class="text-3xl font-bold text-gray-900">Book an Appointment</h1>
            <p class="mt-2 text-gray-500 text-sm">Professional makeup services in Nairobi — pick a time that works for you.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-4xl py-10">

        {{-- Step indicator --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="flex items-center gap-2">
                <span id="step-1-indicator" class="w-7 h-7 rounded-full bg-pink-600 text-white text-xs flex items-center justify-center font-semibold">1</span>
                <span id="step-1-label" class="text-sm font-medium text-gray-900">Date & Time</span>
            </div>
            <div class="flex-1 h-px bg-gray-200 max-w-[60px]"></div>
            <div class="flex items-center gap-2">
                <span id="step-2-indicator" class="w-7 h-7 rounded-full bg-gray-200 text-gray-500 text-xs flex items-center justify-center font-semibold">2</span>
                <span id="step-2-label" class="text-sm font-medium text-gray-400">Your Details</span>
            </div>
        </div>

        {{-- STEP 1 --}}
        <div id="step-1">
            <div class="bg-white border border-gray-100 rounded-sm shadow-sm overflow-hidden">

                {{-- Service selection --}}
                <div class="px-6 pt-6 pb-5 border-b border-gray-100">
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-4">Choose a Service</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($serviceTypes as $type => $label)
                            <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-sm cursor-pointer hover:border-pink-300 hover:bg-pink-50/40 transition-colors has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50">
                                <input type="radio" name="service_type" value="{{ $type }}"
                                       class="mt-0.5 w-4 h-4 text-pink-600 border-gray-300 focus:ring-pink-500 flex-shrink-0"
                                       required>
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-gray-900">{{ $label }}</p>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <p class="text-xs font-semibold text-pink-600">{{ $formattedPrices[$type] }}</p>
                                        <span class="text-gray-300">•</span>
                                        <p class="text-[10px] uppercase tracking-wider text-gray-500">{{ $formattedDurations[$type] }}</p>
                                    </div>
                                    @if(!empty($serviceDescriptions[$type]))
                                        <div class="service-desc-wrap mt-2">
                                            <div class="service-desc text-xs text-gray-500 line-clamp-2 overflow-hidden transition-all duration-300 prose prose-sm prose-pink max-w-none">
                                                {!! $serviceDescriptions[$type] !!}
                                            </div>
                                            <div class="hidden service-full-html">{!! $serviceDescriptions[$type] !!}</div>
                                            <div class="hidden service-title-text">{{ $label }}</div>
                                            <div class="hidden service-duration-text text-gray-500">{{ $formattedDurations[$type] }}</div>
                                            <div class="hidden service-price-text text-pink-600 font-bold font-medium">{{ $formattedPrices[$type] }}</div>
                                            <button type="button" onclick="event.preventDefault(); openServiceDialog(this)"
                                                    class="text-xs text-pink-500 hover:text-pink-700 mt-0.5 flex items-center gap-0.5 font-medium">
                                                <span class="btn-label">Read more</span>
                                                <svg class="btn-icon w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                    @error('service_type')
                        <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Calendar --}}
                <div class="px-6 pt-5 pb-4 border-b border-gray-100">
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-4">Select a Date</p>

                    {{-- Month nav --}}
                    <div class="flex items-center justify-between mb-4">
                        <button type="button" id="prev-month"
                                class="p-1.5 rounded-sm hover:bg-gray-100 transition-colors text-gray-500 hover:text-gray-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <span id="current-month" class="text-sm font-semibold text-gray-900"></span>
                        <button type="button" id="next-month"
                                class="p-1.5 rounded-sm hover:bg-gray-100 transition-colors text-gray-500 hover:text-gray-900">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Day headers --}}
                    <div class="grid grid-cols-7 mb-1">
                        @foreach(['Su','Mo','Tu','We','Th','Fr','Sa'] as $d)
                            <div class="text-center text-xs font-medium text-gray-400 py-1">{{ $d }}</div>
                        @endforeach
                    </div>

                    {{-- Calendar days --}}
                    <div id="calendar-days" class="grid grid-cols-7 gap-0.5">
                        {{-- Populated by JS --}}
                    </div>
                </div>

                {{-- Time slots --}}
                <div id="time-slots-section" class="px-6 pt-5 pb-4 border-b border-gray-100 hidden">
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-4">Select a Time</p>
                    <div id="time-slots" class="flex flex-wrap gap-2">
                        {{-- Populated by JS --}}
                    </div>
                </div>

                {{-- CTA --}}
                <div class="px-6 py-5">
                    <button type="button" id="next-step"
                            class="w-full bg-pink-600 hover:bg-pink-700 text-white py-3 rounded-sm text-sm font-semibold transition-colors disabled:opacity-40 disabled:cursor-not-allowed"
                            disabled>
                        Continue to Your Details →
                    </button>
                </div>
            </div>
        </div>

        {{-- STEP 2 --}}
        <div id="step-2" class="hidden">
            <div class="bg-white border border-gray-100 rounded-sm shadow-sm overflow-hidden">

                {{-- Summary bar --}}
                <div class="px-6 py-4 bg-pink-50 border-b border-pink-100">
                    <p class="text-xs uppercase tracking-widest text-pink-600 font-medium mb-2">Appointment Summary</p>
                    <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm">
                        <span class="text-gray-600">Service: <span id="summary-service" class="font-semibold text-gray-900"></span></span>
                        <span class="text-gray-600">Date: <span id="summary-date" class="font-semibold text-gray-900"></span></span>
                        <span class="text-gray-600">Time: <span id="summary-time" class="font-semibold text-gray-900"></span></span>
                        <span class="text-gray-600">Price: <span id="summary-price" class="font-semibold text-pink-600"></span></span>
                    </div>
                </div>

                <form method="POST" action="{{ route('appointments.store') }}" class="p-6 space-y-5">
                    @csrf
                    <input type="hidden" id="selected-service" name="service_type">
                    <input type="hidden" id="selected-date" name="appointment_date">
                    <input type="hidden" id="selected-time" name="appointment_time">

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" id="customer_name" name="customer_name"
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-sm text-sm focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-pink-500"
                                   required>
                            @error('customer_name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number *</label>
                            <input type="tel" id="customer_phone" name="customer_phone"
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-sm text-sm focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-pink-500"
                                   required>
                            @error('customer_phone')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                        <input type="email" id="customer_email" name="customer_email"
                               class="w-full px-3 py-2.5 border border-gray-300 rounded-sm text-sm focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-pink-500"
                               required>
                        @error('customer_email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-1">Special Requests</label>
                        <textarea id="special_requests" name="special_requests" rows="3"
                                  placeholder="Any specific requests, allergies, or preferences..."
                                  class="w-full px-3 py-2.5 border border-gray-300 rounded-sm text-sm focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-pink-500"></textarea>
                        @error('special_requests')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" id="back-step"
                                class="flex-none px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-sm transition-colors">
                            ← Back
                        </button>
                        <button type="submit"
                                class="flex-1 bg-pink-600 hover:bg-pink-700 text-white py-2.5 rounded-sm text-sm font-semibold transition-colors">
                            Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

@include('components.instagram-reels-marquee')

{{-- Sidebar Dialog for Service Description --}}
<div id="service-dialog" class="fixed inset-0 z-50 hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity opacity-0" id="service-dialog-backdrop" onclick="closeServiceDialog()"></div>
    <div class="fixed inset-y-0 right-0 z-10 flex max-w-full pl-10 sm:pl-16">
        <div class="w-screen max-w-md transform transition ease-in-out duration-300 translate-x-full" id="service-dialog-panel">
            <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                <div class="px-4 py-6 sm:px-6 border-b border-gray-100 flex items-start justify-between">
                    <h2 class="text-base font-semibold leading-6 text-gray-900" id="service-dialog-title">Service Details</h2>
                    <div class="ml-3 flex h-7 items-center">
                        <button type="button" onclick="closeServiceDialog()" class="relative rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2">
                            <span class="absolute -inset-2.5"></span>
                            <span class="sr-only">Close panel</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="px-4 py-2 bg-gray-50 border-b border-gray-100 flex items-center justify-between text-xs sm:text-sm">
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400 font-medium uppercase tracking-wider">Price:</span>
                        <span id="service-dialog-price" class="font-bold text-pink-600"></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-gray-400 font-medium uppercase tracking-wider">Duration:</span>
                        <span id="service-dialog-duration" class="font-semibold text-gray-700"></span>
                    </div>
                </div>
                <div class="relative mt-6 flex-1 px-4 sm:px-6">
                    <div id="service-dialog-content" class="prose prose-sm prose-pink max-w-none text-gray-600">
                        <!-- Content goes here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openServiceDialog(btn) {
    const wrap = btn.closest('.service-desc-wrap');
    const htmlContent = wrap.querySelector('.service-full-html').innerHTML;
    const titleText = wrap.querySelector('.service-title-text').textContent;
    const durationText = wrap.querySelector('.service-duration-text').textContent;
    const priceText = wrap.querySelector('.service-price-text').textContent;
    
    document.getElementById('service-dialog-title').textContent = titleText;
    document.getElementById('service-dialog-duration').textContent = durationText;
    document.getElementById('service-dialog-price').textContent = priceText;
    document.getElementById('service-dialog-content').innerHTML = htmlContent;
    
    const dialog = document.getElementById('service-dialog');
    const backdrop = document.getElementById('service-dialog-backdrop');
    const panel = document.getElementById('service-dialog-panel');
    
    dialog.classList.remove('hidden');
    // slight delay for transition
    setTimeout(() => {
        backdrop.classList.remove('opacity-0');
        backdrop.classList.add('opacity-100');
        panel.classList.remove('translate-x-full');
        panel.classList.add('translate-x-0');
    }, 10);
    
    document.body.style.overflow = 'hidden';
}

function closeServiceDialog() {
    const backdrop = document.getElementById('service-dialog-backdrop');
    const panel = document.getElementById('service-dialog-panel');
    
    backdrop.classList.remove('opacity-100');
    backdrop.classList.add('opacity-0');
    panel.classList.remove('translate-x-0');
    panel.classList.add('translate-x-full');
    
    setTimeout(() => {
        document.getElementById('service-dialog').classList.add('hidden');
        document.body.style.overflow = '';
    }, 300);
}

document.addEventListener('DOMContentLoaded', function () {
    let currentDate = new Date();
    let selectedDate = null;
    let selectedTime = null;
    let selectedService = null;

    const prices = @json($prices);
    const serviceTypes = @json($serviceTypes);

    renderCalendar();

    document.getElementById('prev-month').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });
    document.getElementById('next-month').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    document.querySelectorAll('input[name="service_type"]').forEach(radio => {
        radio.addEventListener('change', function () {
            selectedService = this.value;
            updateNextButton();
        });
    });

    document.getElementById('next-step').addEventListener('click', () => {
        if (selectedService && selectedDate && selectedTime) showStep2();
    });
    document.getElementById('back-step').addEventListener('click', () => showStep1());

    function renderCalendar() {
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const monthNames = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        document.getElementById('current-month').textContent = `${monthNames[month]} ${year}`;

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        let html = '';
        for (let i = 0; i < firstDay; i++) html += '<div></div>';

        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const isPast = date < today;
            const isToday = date.toDateString() === today.toDateString();
            const isSelected = selectedDate && date.toDateString() === selectedDate.toDateString();
            const formatted = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

            let cls = 'h-9 flex items-center justify-center text-sm rounded-sm transition-colors ';
            if (isPast) {
                cls += 'text-gray-300 cursor-not-allowed';
            } else if (isSelected) {
                cls += 'bg-pink-600 text-white font-semibold cursor-pointer';
            } else if (isToday) {
                cls += 'border border-pink-400 text-pink-600 font-semibold cursor-pointer hover:bg-pink-50';
            } else {
                cls += 'text-gray-700 cursor-pointer hover:bg-gray-100';
            }

            html += `<div class="${cls}" ${!isPast ? `data-date="${formatted}" onclick="selectDate(this)"` : ''}>${day}</div>`;
        }

        document.getElementById('calendar-days').innerHTML = html;
    }

    window.selectDate = function (el) {
        document.querySelectorAll('[data-date]').forEach(d => {
            d.classList.remove('bg-pink-600', 'text-white', 'font-semibold');
            if (!d.classList.contains('border')) d.classList.add('text-gray-700', 'hover:bg-gray-100');
        });
        el.classList.remove('text-gray-700', 'hover:bg-gray-100');
        el.classList.add('bg-pink-600', 'text-white', 'font-semibold');

        const dateStr = el.dataset.date;
        selectedDate = new Date(dateStr);
        selectedTime = null;
        loadTimeSlots(dateStr);
        updateNextButton();
    };

    function loadTimeSlots(date) {
        fetch(`/appointments/available-slots?date=${date}`)
            .then(r => r.json())
            .then(data => {
                const container = document.getElementById('time-slots');
                container.innerHTML = '';

                if (!data.available_slots.length) {
                    container.innerHTML = '<p class="text-sm text-gray-500">No available slots for this date.</p>';
                } else {
                    data.available_slots.forEach(slot => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'px-4 py-2 text-sm border border-gray-200 rounded-sm text-gray-700 hover:border-pink-400 hover:text-pink-600 hover:bg-pink-50 transition-colors';
                        btn.textContent = formatTime(slot);
                        btn.dataset.time = slot;
                        btn.onclick = () => selectTime(btn);
                        container.appendChild(btn);
                    });
                }
                document.getElementById('time-slots-section').classList.remove('hidden');
            });
    }

    window.selectTime = function (el) {
        document.querySelectorAll('[data-time]').forEach(b => {
            b.classList.remove('bg-pink-600', 'text-white', 'border-pink-600');
            b.classList.add('border-gray-200', 'text-gray-700');
        });
        el.classList.remove('border-gray-200', 'text-gray-700');
        el.classList.add('bg-pink-600', 'text-white', 'border-pink-600');
        selectedTime = el.dataset.time;
        updateNextButton();
    };

    function formatTime(time) {
        const [h, m] = time.split(':');
        const hour = parseInt(h);
        return `${hour > 12 ? hour - 12 : hour === 0 ? 12 : hour}:${m} ${hour >= 12 ? 'PM' : 'AM'}`;
    }

    function updateNextButton() {
        document.getElementById('next-step').disabled = !(selectedService && selectedDate && selectedTime);
    }

    function showStep2() {
        document.getElementById('step-1').classList.add('hidden');
        document.getElementById('step-2').classList.remove('hidden');
        document.getElementById('step-1-indicator').className = 'w-7 h-7 rounded-full bg-gray-200 text-gray-500 text-xs flex items-center justify-center font-semibold';
        document.getElementById('step-1-label').className = 'text-sm font-medium text-gray-400';
        document.getElementById('step-2-indicator').className = 'w-7 h-7 rounded-full bg-pink-600 text-white text-xs flex items-center justify-center font-semibold';
        document.getElementById('step-2-label').className = 'text-sm font-medium text-gray-900';

        document.getElementById('selected-service').value = selectedService;
        document.getElementById('selected-date').value = `${selectedDate.getFullYear()}-${String(selectedDate.getMonth()+1).padStart(2,'0')}-${String(selectedDate.getDate()).padStart(2,'0')}`;
        document.getElementById('selected-time').value = selectedTime;

        document.getElementById('summary-service').textContent = serviceTypes[selectedService];
        document.getElementById('summary-date').textContent = selectedDate.toLocaleDateString('en-KE', { weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' });
        document.getElementById('summary-time').textContent = formatTime(selectedTime);
        document.getElementById('summary-price').textContent = `KES ${prices[selectedService].toLocaleString()}`;
    }

    function showStep1() {
        document.getElementById('step-2').classList.add('hidden');
        document.getElementById('step-1').classList.remove('hidden');
        document.getElementById('step-2-indicator').className = 'w-7 h-7 rounded-full bg-gray-200 text-gray-500 text-xs flex items-center justify-center font-semibold';
        document.getElementById('step-2-label').className = 'text-sm font-medium text-gray-400';
        document.getElementById('step-1-indicator').className = 'w-7 h-7 rounded-full bg-pink-600 text-white text-xs flex items-center justify-center font-semibold';
        document.getElementById('step-1-label').className = 'text-sm font-medium text-gray-900';
    }
});
</script>
@endsection
