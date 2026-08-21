@extends('layouts.app')

@section('title', 'Book a Makeup Session in Nairobi | Zayn\'s Beauty Studio')

@section('description', 'Book a luxury makeup session at Zayn\'s Beauty Studio, Nairobi. Bridal, glam, photoshoot & natural looks. Pick your look, customize add-ons, and choose your date & time online.')

@section('keywords', 'book makeup session Nairobi, makeup artist Nairobi, bridal makeup Nairobi, professional makeup booking, makeup appointment Nairobi, Zayn Beauty studio')

@section('canonical', url('/appointments/create'))

@section('content')
<div class="bg-gray-50 min-h-screen pb-16">

    {{-- Luxury Studio Header --}}
    <div class="bg-gradient-to-b from-pink-50/60 via-white to-gray-50 border-b border-pink-100/60 pt-10 pb-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 bg-pink-100/80 text-pink-700 text-xs font-semibold px-3 py-1 rounded-full mb-3 tracking-wide">
                        <svg class="w-3.5 h-3.5 text-pink-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <span>Zayn's Beauty Studio · Nairobi</span>
                        <span class="text-pink-300">|</span>
                        <span>Rated 5/5 by 350+ Clients</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">Book Your Glam Session</h1>
                    <p class="mt-2 text-gray-600 text-sm sm:text-base max-w-2xl leading-relaxed">
                        Tailored beauty, flawless complexion, and camera-ready looks by certified makeup artists. Select your style, customize optional add-ons, and secure your time slot.
                    </p>
                </div>

                {{-- Direct WhatsApp Consultation Button --}}
                <div class="flex-shrink-0">
                    <a href="https://wa.me/254707641446?text=Hello%20Zayn%27s%20Beauty%2C%20I%20have%20an%20inquiry%20about%20booking%20a%20makeup%20session."
                       target="_blank"
                       rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm font-semibold px-4 py-2.5 rounded-md shadow-sm transition-all hover:shadow">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>Bridal / Group WhatsApp Inquiry</span>
                    </a>
                </div>
            </div>

            {{-- Studio Trust Highlights --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-8 pt-6 border-t border-pink-100/80 text-xs text-gray-700">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center flex-shrink-0 font-bold">✓</span>
                    <span>100% Sanitized & Hypoallergenic</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center flex-shrink-0 font-bold">★</span>
                    <span>MAC, Fenty & Huda Beauty Brands</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center flex-shrink-0 font-bold">⏱</span>
                    <span>Guaranteed On-Time Start</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-pink-100 text-pink-600 flex items-center justify-center flex-shrink-0 font-bold">☕</span>
                    <span>Complimentary Studio Refreshments</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Booking Section --}}
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl py-8">

        {{-- Interactive 3-Step Wizard Navigation --}}
        <div class="bg-white border border-gray-100 rounded-lg p-3 sm:p-4 mb-8 shadow-sm">
            <div class="grid grid-cols-3 gap-2 text-center">
                <div id="step-nav-1" class="step-nav-item py-2 px-2 rounded-md bg-pink-50 text-pink-700 font-semibold text-xs sm:text-sm flex items-center justify-center gap-2 transition-all">
                    <span class="w-5 h-5 rounded-full bg-pink-600 text-white text-xs flex items-center justify-center font-bold">1</span>
                    <span class="hidden sm:inline">Choose</span> Look & Add-ons
                </div>
                <div id="step-nav-2" class="step-nav-item py-2 px-2 rounded-md text-gray-400 font-medium text-xs sm:text-sm flex items-center justify-center gap-2 transition-all">
                    <span class="w-5 h-5 rounded-full bg-gray-200 text-gray-500 text-xs flex items-center justify-center font-bold">2</span>
                    <span class="hidden sm:inline">Pick</span> Date & Time
                </div>
                <div id="step-nav-3" class="step-nav-item py-2 px-2 rounded-md text-gray-400 font-medium text-xs sm:text-sm flex items-center justify-center gap-2 transition-all">
                    <span class="w-5 h-5 rounded-full bg-gray-200 text-gray-500 text-xs flex items-center justify-center font-bold">3</span>
                    <span class="hidden sm:inline">Your</span> Details & Notes
                </div>
            </div>
        </div>

        {{-- Two-Column Layout: Left Steps + Right Sticky Live Summary --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- LEFT COLUMN: Steps Wizard --}}
            <div class="lg:col-span-8 space-y-6">

                {{-- ==================== STEP 1: SERVICE CARDS & ADD-ONS ==================== --}}
                <div id="step-1" class="wizard-step">
                    <div class="bg-white border border-gray-200/80 rounded-xl shadow-sm overflow-hidden p-5 sm:p-6">
                        
                        <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Step 1: Select Your Makeup Style</h2>
                                <p class="text-xs text-gray-500 mt-0.5">Click on a look below to choose your desired makeup service.</p>
                            </div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-pink-600 bg-pink-50 px-2.5 py-1 rounded-full">Required</span>
                        </div>

                        {{-- Service Cards Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="services-container">
                            @php
                                $serviceBadges = [
                                    'bridal-makeup' => ['label' => 'Signature Luxury', 'color' => 'bg-amber-100 text-amber-800 border-amber-200'],
                                    'party-makeup' => ['label' => 'Most Requested', 'color' => 'bg-pink-100 text-pink-800 border-pink-200'],
                                    'photoshoot-makeup' => ['label' => 'HD Camera-Ready', 'color' => 'bg-purple-100 text-purple-800 border-purple-200'],
                                    'everyday-makeup' => ['label' => 'Clean & Natural', 'color' => 'bg-emerald-100 text-emerald-800 border-emerald-200'],
                                    'special-occasion' => ['label' => 'Custom Glam', 'color' => 'bg-rose-100 text-rose-800 border-rose-200'],
                                ];

                                $serviceFeatureMap = [
                                    'bridal-makeup' => ['Full skin prep & hydration', 'Custom 3D mink lash set', 'Waterproof 16hr HD finish', 'Free bridal touch-up kit', 'Complimentary consultation'],
                                    'party-makeup' => ['Flawless longwear complexion', 'Custom eyeshadow (Smokey/Shimmer)', 'Lash application included', 'Hydrating setting spray lock'],
                                    'photoshoot-makeup' => ['Anti-flashback HD formulation', 'Sculpted cheekbones & brow definition', 'Lighting & angle optimized', 'Matte or luminous glow options'],
                                    'everyday-makeup' => ['Radiant sheer/medium base', 'Feathered natural brows', 'Soft tint & lip hydration', 'Fresh glowing daytime finish'],
                                    'special-occasion' => ['Red-carpet tailored look', 'High-definition coverage', 'Statement eye or bold lip', 'All-day durability guarantee'],
                                ];
                            @endphp

                            @foreach($services as $service)
                                @php
                                    $badge = $serviceBadges[$service->slug] ?? ['label' => 'Professional', 'color' => 'bg-gray-100 text-gray-800 border-gray-200'];
                                    $features = $serviceFeatureMap[$service->slug] ?? ['Skin prep & base application', 'Eyes & brows styling', 'Setting spray lock'];
                                @endphp
                                <div class="service-card relative border-2 border-gray-200 rounded-xl p-5 cursor-pointer hover:border-pink-300 hover:shadow-md transition-all group"
                                     data-service-slug="{{ $service->slug }}"
                                     data-service-name="{{ $service->name }}"
                                     data-service-price="{{ $service->price }}"
                                     data-service-formatted-price="{{ $service->formatted_price }}"
                                     data-service-duration="{{ $service->formatted_duration }}"
                                     onclick="selectServiceCard('{{ $service->slug }}')">

                                    {{-- Radio Input & Header --}}
                                    <div class="flex items-start justify-between gap-3 mb-3">
                                        <div class="flex items-center gap-2.5">
                                            <div class="service-radio w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center transition-all group-hover:border-pink-500">
                                                <div class="service-radio-inner w-2.5 h-2.5 rounded-full bg-pink-600 hidden"></div>
                                            </div>
                                            <h3 class="text-base font-bold text-gray-900 group-hover:text-pink-600 transition-colors">
                                                {{ $service->name }}
                                            </h3>
                                        </div>
                                        <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full border {{ $badge['color'] }}">
                                            {{ $badge['label'] }}
                                        </span>
                                    </div>

                                    {{-- Price & Duration Row --}}
                                    <div class="flex items-baseline justify-between mb-3 bg-gray-50/80 px-3 py-2 rounded-lg">
                                        <div class="text-lg font-extrabold text-gray-900">
                                            {{ $service->formatted_price }}
                                        </div>
                                        <div class="text-xs font-medium text-gray-500 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $service->formatted_duration }}
                                        </div>
                                    </div>

                                    {{-- Description snippet --}}
                                    <p class="text-xs text-gray-600 mb-3 leading-relaxed">
                                        {{ Str::limit($service->description, 95) }}
                                    </p>

                                    {{-- What's Included bullets --}}
                                    <ul class="space-y-1.5 pt-2 border-t border-gray-100 text-xs text-gray-600">
                                        @foreach(array_slice($features, 0, 3) as $feat)
                                            <li class="flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-pink-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                <span>{{ $feat }}</span>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="hidden service-full-html">{!! $serviceDescriptions[$service->slug] !!}</div>
                                    <div class="hidden service-title-text">{{ $service->name }}</div>
                                    <div class="hidden service-duration-text">{{ $service->formatted_duration }}</div>
                                    <div class="hidden service-price-text">{{ $service->formatted_price }}</div>
                                </div>
                            @endforeach
                        </div>

                        {{-- ==================== OPTIONAL ADD-ONS SECTION ==================== --}}
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900 flex items-center gap-2">
                                        <span>✨ Enhance Your Glam (Optional Add-ons)</span>
                                    </h3>
                                    <p class="text-xs text-gray-500 mt-0.5">Customize your appointment with extra treatments and perks.</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="addons-container">
                                {{-- Addon 1: Lashes --}}
                                <label class="addon-card flex items-start gap-3 p-3.5 border border-gray-200 rounded-lg cursor-pointer hover:border-pink-300 hover:bg-pink-50/30 transition-all has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50/50">
                                    <input type="checkbox" name="addons[]" value="3d-mink-lashes" data-name="3D Luxury Mink Lashes" data-price="1000" class="addon-checkbox mt-1 w-4 h-4 text-pink-600 rounded border-gray-300 focus:ring-pink-500">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-gray-900">3D Luxury Mink Lashes</span>
                                            <span class="text-xs font-bold text-pink-600">+KES 1,000</span>
                                        </div>
                                        <p class="text-[11px] text-gray-500 mt-0.5">Wispy, lightweight & reusable premium lash upgrade.</p>
                                    </div>
                                </label>

                                {{-- Addon 2: Hair Styling --}}
                                <label class="addon-card flex items-start gap-3 p-3.5 border border-gray-200 rounded-lg cursor-pointer hover:border-pink-300 hover:bg-pink-50/30 transition-all has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50/50">
                                    <input type="checkbox" name="addons[]" value="express-hair" data-name="Express Hair Styling / Curls" data-price="3000" class="addon-checkbox mt-1 w-4 h-4 text-pink-600 rounded border-gray-300 focus:ring-pink-500">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-gray-900">Express Hair Styling / Curls</span>
                                            <span class="text-xs font-bold text-pink-600">+KES 3,000</span>
                                        </div>
                                        <p class="text-[11px] text-gray-500 mt-0.5">Hollywood waves, sleek straight, or soft curls.</p>
                                    </div>
                                </label>

                                {{-- Addon 3: Touch-up Kit --}}
                                <label class="addon-card flex items-start gap-3 p-3.5 border border-gray-200 rounded-lg cursor-pointer hover:border-pink-300 hover:bg-pink-50/30 transition-all has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50/50">
                                    <input type="checkbox" name="addons[]" value="touchup-kit" data-name="Deluxe Touch-up & Glow Kit" data-price="1500" class="addon-checkbox mt-1 w-4 h-4 text-pink-600 rounded border-gray-300 focus:ring-pink-500">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-gray-900">Deluxe Touch-up & Glow Kit</span>
                                            <span class="text-xs font-bold text-pink-600">+KES 1,500</span>
                                        </div>
                                        <p class="text-[11px] text-gray-500 mt-0.5">Lip sample, blotting papers, mini powder puff & setting mist.</p>
                                    </div>
                                </label>

                                {{-- Addon 4: Home Service Callout --}}
                                <label class="addon-card flex items-start gap-3 p-3.5 border border-gray-200 rounded-lg cursor-pointer hover:border-pink-300 hover:bg-pink-50/30 transition-all has-[:checked]:border-pink-500 has-[:checked]:bg-pink-50/50">
                                    <input type="checkbox" name="addons[]" value="home-service" data-name="On-Location / Home Service Callout" data-price="3500" class="addon-checkbox mt-1 w-4 h-4 text-pink-600 rounded border-gray-300 focus:ring-pink-500">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-gray-900">On-Location / Mobile Callout</span>
                                            <span class="text-xs font-bold text-pink-600">+KES 3,500</span>
                                        </div>
                                        <p class="text-[11px] text-gray-500 mt-0.5">We bring the full glam station to your home/hotel in Nairobi.</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Step 1 Next Button --}}
                        <div class="mt-8 pt-5 border-t border-gray-100 flex justify-end">
                            <button type="button" id="btn-to-step-2" onclick="goToStep(2)"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-pink-600 hover:bg-pink-700 text-white px-8 py-3.5 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all disabled:opacity-40 disabled:cursor-not-allowed"
                                    disabled>
                                <span>Continue to Date & Time</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ==================== STEP 2: CALENDAR & TIME SLOTS ==================== --}}
                <div id="step-2" class="wizard-step hidden">
                    <div class="bg-white border border-gray-200/80 rounded-xl shadow-sm overflow-hidden p-5 sm:p-6">
                        
                        <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Step 2: Choose Your Date & Time Slot</h2>
                                <p class="text-xs text-gray-500 mt-0.5">Select a day on the calendar, then pick an available arrival time.</p>
                            </div>
                            <button type="button" onclick="goToStep(1)" class="text-xs text-pink-600 hover:text-pink-700 font-semibold flex items-center gap-1">
                                ← Change Look
                            </button>
                        </div>

                        {{-- Calendar Navigation & Days --}}
                        <div class="bg-gray-50/70 p-4 sm:p-5 rounded-xl border border-gray-200/70 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <button type="button" id="prev-month"
                                        class="p-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-100 transition-colors text-gray-700 hover:text-gray-900 shadow-2xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <span id="current-month" class="text-base font-bold text-gray-900 tracking-tight"></span>
                                <button type="button" id="next-month"
                                        class="p-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-100 transition-colors text-gray-700 hover:text-gray-900 shadow-2xs">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>

                            {{-- Day headers --}}
                            <div class="grid grid-cols-7 mb-2 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">
                                @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $d)
                                    <div class="py-1">{{ $d }}</div>
                                @endforeach
                            </div>

                            {{-- Calendar days grid --}}
                            <div id="calendar-days" class="grid grid-cols-7 gap-1.5 sm:gap-2">
                                {{-- Injected via JS --}}
                            </div>
                        </div>

                        {{-- Time Slots Section --}}
                        <div id="time-slots-section" class="border border-pink-100 rounded-xl p-5 bg-pink-50/30 hidden">
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Available Start Times on <span id="selected-date-display" class="text-pink-600"></span></span>
                                </h3>
                                <span class="text-[11px] text-gray-500 font-medium">Session duration: <strong id="step2-duration-label" class="text-gray-800"></strong></span>
                            </div>

                            <div id="time-slots" class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-5 gap-2.5">
                                {{-- Populated by JS --}}
                            </div>
                        </div>

                        {{-- Step 2 Buttons --}}
                        <div class="mt-8 pt-5 border-t border-gray-100 flex items-center justify-between gap-3">
                            <button type="button" onclick="goToStep(1)"
                                    class="inline-flex items-center gap-2 px-5 py-3 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                                ← Back
                            </button>
                            <button type="button" id="btn-to-step-3" onclick="goToStep(3)"
                                    class="inline-flex items-center justify-center gap-2 bg-pink-600 hover:bg-pink-700 text-white px-8 py-3.5 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all disabled:opacity-40 disabled:cursor-not-allowed"
                                    disabled>
                                <span>Continue to Details</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ==================== STEP 3: DETAILS & INSPIRATION ==================== --}}
                <div id="step-3" class="wizard-step hidden">
                    <div class="bg-white border border-gray-200/80 rounded-xl shadow-sm overflow-hidden p-5 sm:p-6">
                        
                        <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Step 3: Your Details & Inspiration</h2>
                                <p class="text-xs text-gray-500 mt-0.5">Tell us about yourself and any look preferences for your artist.</p>
                            </div>
                            <button type="button" onclick="goToStep(2)" class="text-xs text-pink-600 hover:text-pink-700 font-semibold flex items-center gap-1">
                                ← Change Date/Time
                            </button>
                        </div>

                        <form method="POST" action="{{ route('appointments.store') }}" id="booking-form" class="space-y-5">
                            @csrf
                            <input type="hidden" id="selected-service" name="service_type">
                            <input type="hidden" id="selected-date" name="appointment_date">
                            <input type="hidden" id="selected-time" name="appointment_time">
                            <input type="hidden" id="combined_special_requests" name="special_requests">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="customer_name" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Full Name *</label>
                                    <input type="text" id="customer_name" name="customer_name"
                                           placeholder="e.g. Sarah Mwangi"
                                           class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                                           required>
                                    @error('customer_name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="customer_phone" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Phone Number (M-Pesa / WhatsApp) *</label>
                                    <input type="tel" id="customer_phone" name="customer_phone"
                                           placeholder="e.g. 0712 345 678"
                                           class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                                           required>
                                    @error('customer_phone')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label for="customer_email" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Email Address *</label>
                                <input type="email" id="customer_email" name="customer_email"
                                       placeholder="e.g. sarah@example.com"
                                       class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500"
                                       required>
                                @error('customer_email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            {{-- Occasion Selector --}}
                            <div>
                                <label for="occasion_type" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">Event / Occasion</label>
                                <select id="occasion_type" class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 bg-white">
                                    <option value="Bridal / Wedding">💍 Wedding / Bridal Event</option>
                                    <option value="Birthday Celebration">🎂 Birthday / Anniversary</option>
                                    <option value="Dinner / Gala / Red Carpet">✨ Evening Gala / Dinner Party</option>
                                    <option value="Studio / Commercial Photoshoot">📸 Studio / Brand Photoshoot</option>
                                    <option value="Graduation Ceremony">🎓 Graduation / Prom</option>
                                    <option value="Everyday / Corporate Glam">💼 Corporate / Interview / Everyday</option>
                                    <option value="Other Special Event">🎉 Other Special Occasion</option>
                                </select>
                            </div>

                            {{-- Look Notes / Pinterest Inspiration --}}
                            <div>
                                <label for="user_look_notes" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                    <span>Look Inspiration or Pinterest Link</span>
                                    <span class="text-gray-400 font-normal text-xs lowercase ml-1">(optional)</span>
                                </label>
                                <input type="text" id="user_look_notes"
                                       placeholder="e.g. Bronze smokey eye, nude glossy lip, or paste Instagram/Pinterest URL..."
                                       class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500">
                            </div>

                            {{-- Special Skin Requests / Allergies --}}
                            <div>
                                <label for="user_special_requests" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5">
                                    <span>Skin Sensitivities & Special Preferences</span>
                                    <span class="text-gray-400 font-normal text-xs lowercase ml-1">(optional)</span>
                                </label>
                                <textarea id="user_special_requests" rows="2"
                                          placeholder="e.g. Sensitive skin, prefers matte foundation, bringing own lipstick, etc."
                                          class="w-full px-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500"></textarea>
                            </div>

                            {{-- Cancellation Policy Checkbox --}}
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200/80">
                                <label class="flex items-start gap-2.5 cursor-pointer">
                                    <input type="checkbox" id="policy-agree" required checked
                                           class="mt-1 w-4 h-4 text-pink-600 rounded border-gray-300 focus:ring-pink-500">
                                    <span class="text-xs text-gray-600 leading-relaxed">
                                        I understand that appointments are confirmed via WhatsApp/Email. Please arrive 10 minutes prior with a cleansed face for optimal skin preparation.
                                    </span>
                                </label>
                            </div>

                            {{-- Submit Button & Back --}}
                            <div class="flex items-center gap-3 pt-2">
                                <button type="button" onclick="goToStep(2)"
                                        class="px-5 py-3 border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                                    ← Back
                                </button>
                                <button type="submit" id="submit-booking-btn"
                                        class="flex-1 bg-pink-600 hover:bg-pink-700 text-white py-3.5 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4 text-pink-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Confirm & Reserve Appointment</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN: Sticky Luxury Live Summary --}}
            <div class="lg:col-span-4 lg:sticky lg:top-24 space-y-4">
                <div class="bg-white border-2 border-pink-100 rounded-xl shadow-md p-5 overflow-hidden">
                    
                    {{-- Summary Header --}}
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></span>
                            <h3 class="text-sm font-bold uppercase tracking-wider text-gray-900">Your Booking Summary</h3>
                        </div>
                        <span class="text-[11px] font-semibold text-pink-600 bg-pink-50 px-2 py-0.5 rounded-md">Live Estimate</span>
                    </div>

                    {{-- Selected Service Card --}}
                    <div class="py-4 border-b border-gray-100">
                        <div class="text-xs text-gray-400 uppercase tracking-wider mb-1 font-semibold">Selected Look</div>
                        <div id="sidebar-service-empty" class="text-xs text-gray-400 italic">No makeup style chosen yet</div>
                        <div id="sidebar-service-details" class="hidden">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <h4 id="sidebar-service-name" class="text-sm font-bold text-gray-900"></h4>
                                    <p id="sidebar-service-duration" class="text-xs text-gray-500 mt-0.5 flex items-center gap-1"></p>
                                </div>
                                <span id="sidebar-service-price" class="text-sm font-bold text-gray-900"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Selected Addons --}}
                    <div class="py-4 border-b border-gray-100">
                        <div class="text-xs text-gray-400 uppercase tracking-wider mb-1.5 font-semibold">Add-on Enhancements</div>
                        <div id="sidebar-addons-empty" class="text-xs text-gray-400 italic">None selected</div>
                        <ul id="sidebar-addons-list" class="space-y-1.5 text-xs text-gray-700 hidden">
                            {{-- Populated by JS --}}
                        </ul>
                    </div>

                    {{-- Selected Date & Time --}}
                    <div class="py-4 border-b border-gray-100">
                        <div class="text-xs text-gray-400 uppercase tracking-wider mb-1 font-semibold">Date & Arrival Time</div>
                        <div id="sidebar-datetime-empty" class="text-xs text-gray-400 italic">Pick date & time in Step 2</div>
                        <div id="sidebar-datetime-details" class="hidden space-y-1">
                            <div class="flex items-center gap-2 text-xs text-gray-900 font-semibold">
                                <svg class="w-3.5 h-3.5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span id="sidebar-date"></span>
                            </div>
                            <div class="flex items-center gap-2 text-xs text-pink-600 font-bold">
                                <svg class="w-3.5 h-3.5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span id="sidebar-time"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Total Investment Calculation --}}
                    <div class="pt-4 pb-2">
                        <div class="flex items-center justify-between mb-1 text-xs text-gray-500">
                            <span>Service Base</span>
                            <span id="sidebar-subtotal">KES 0</span>
                        </div>
                        <div class="flex items-center justify-between mb-2 text-xs text-gray-500">
                            <span>Add-ons Total</span>
                            <span id="sidebar-addons-total">KES 0</span>
                        </div>
                        <div class="flex items-baseline justify-between pt-2 border-t border-gray-100">
                            <span class="text-sm font-bold text-gray-900">Total Investment</span>
                            <span id="sidebar-grand-total" class="text-xl font-extrabold text-pink-600">KES 0</span>
                        </div>
                    </div>

                    {{-- Studio Location Badge --}}
                    <div class="mt-4 pt-3 border-t border-gray-100 text-[11px] text-gray-500 flex items-start gap-2">
                        <svg class="w-4 h-4 text-pink-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Zayn's Studio, Nairobi · Free on-site parking & refreshments provided</span>
                    </div>
                </div>

                {{-- Direct WhatsApp Help Card --}}
                <div class="bg-emerald-50/80 border border-emerald-200 rounded-xl p-4 text-xs text-emerald-900 flex items-center justify-between gap-3">
                    <div>
                        <p class="font-bold">Need a Custom Package?</p>
                        <p class="text-[11px] text-emerald-700 mt-0.5">Chat directly with our Lead Artist for bridal parties of 3+.</p>
                    </div>
                    <a href="https://wa.me/254707641446?text=Hello%20Zayn%27s%20Beauty%2C%20I%20would%20like%20to%20inquire%20about%20a%20bridal%20or%20group%20booking."
                       target="_blank"
                       rel="noopener noreferrer"
                       class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-md flex-shrink-0 shadow-2xs">
                        WhatsApp
                    </a>
                </div>
            </div>

        </div>

        {{-- ==================== CLIENT LOOKS INSPIRATION GALLERY ==================== --}}
        <div class="mt-16 bg-white border border-gray-200/80 rounded-2xl p-6 sm:p-8 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <span class="text-xs uppercase tracking-widest text-pink-600 font-bold">Studio Lookbook</span>
                    <h2 class="text-2xl font-bold text-gray-900 mt-1">Real Transformations & Looks</h2>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">Explore our signature beauty looks created for our Nairobi clients.</p>
                </div>
                <div class="flex items-center gap-2 text-xs font-semibold text-pink-600">
                    <span>✨ 100% Client Satisfaction</span>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="group relative rounded-xl overflow-hidden shadow-2xs border border-gray-100 bg-gray-50">
                    <div class="h-44 bg-gradient-to-tr from-rose-200 via-pink-100 to-amber-100 flex items-center justify-center p-4 text-center">
                        <div>
                            <span class="text-2xl mb-1 block">👑</span>
                            <h4 class="text-sm font-bold text-gray-900">Royal Bridal Glam</h4>
                            <p class="text-[11px] text-gray-600 mt-0.5">Classic glow & defined eyes</p>
                        </div>
                    </div>
                    <div class="p-3 bg-white text-center">
                        <button type="button" onclick="selectServiceCard('bridal-makeup')" class="text-xs font-bold text-pink-600 hover:text-pink-700">
                            Book Bridal Glam →
                        </button>
                    </div>
                </div>

                <div class="group relative rounded-xl overflow-hidden shadow-2xs border border-gray-100 bg-gray-50">
                    <div class="h-44 bg-gradient-to-tr from-pink-200 via-purple-100 to-indigo-100 flex items-center justify-center p-4 text-center">
                        <div>
                            <span class="text-2xl mb-1 block">✨</span>
                            <h4 class="text-sm font-bold text-gray-900">Soft Smokey Evening</h4>
                            <p class="text-[11px] text-gray-600 mt-0.5">Shimmer lids & nude lip</p>
                        </div>
                    </div>
                    <div class="p-3 bg-white text-center">
                        <button type="button" onclick="selectServiceCard('party-makeup')" class="text-xs font-bold text-pink-600 hover:text-pink-700">
                            Book Evening Look →
                        </button>
                    </div>
                </div>

                <div class="group relative rounded-xl overflow-hidden shadow-2xs border border-gray-100 bg-gray-50">
                    <div class="h-44 bg-gradient-to-tr from-amber-100 via-orange-100 to-pink-100 flex items-center justify-center p-4 text-center">
                        <div>
                            <span class="text-2xl mb-1 block">📸</span>
                            <h4 class="text-sm font-bold text-gray-900">HD Studio Editorial</h4>
                            <p class="text-[11px] text-gray-600 mt-0.5">Sculpted matte perfection</p>
                        </div>
                    </div>
                    <div class="p-3 bg-white text-center">
                        <button type="button" onclick="selectServiceCard('photoshoot-makeup')" class="text-xs font-bold text-pink-600 hover:text-pink-700">
                            Book Editorial HD →
                        </button>
                    </div>
                </div>

                <div class="group relative rounded-xl overflow-hidden shadow-2xs border border-gray-100 bg-gray-50">
                    <div class="h-44 bg-gradient-to-tr from-emerald-100 via-teal-50 to-pink-100 flex items-center justify-center p-4 text-center">
                        <div>
                            <span class="text-2xl mb-1 block">🌿</span>
                            <h4 class="text-sm font-bold text-gray-900">Sun-Kissed Natural</h4>
                            <p class="text-[11px] text-gray-600 mt-0.5">Dewy glass skin finish</p>
                        </div>
                    </div>
                    <div class="p-3 bg-white text-center">
                        <button type="button" onclick="selectServiceCard('everyday-makeup')" class="text-xs font-bold text-pink-600 hover:text-pink-700">
                            Book Natural Look →
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ==================== STUDIO FAQ ACCORDION ==================== --}}
        <div class="mt-12 bg-white border border-gray-200/80 rounded-2xl p-6 sm:p-8 shadow-sm">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Frequently Asked Questions & Studio Policies</h3>
            <div class="space-y-4 text-xs sm:text-sm text-gray-600">
                <div class="border-b border-gray-100 pb-3">
                    <h4 class="font-bold text-gray-900 mb-1">How should I prepare for my makeup appointment?</h4>
                    <p>Please arrive with a clean, freshly moisturized face free of mascara and heavy oils. Exfoliating the night before helps create an exceptionally smooth, glowing canvas.</p>
                </div>
                <div class="border-b border-gray-100 pb-3">
                    <h4 class="font-bold text-gray-900 mb-1">Do you provide mobile / on-location services across Nairobi?</h4>
                    <p>Yes! Simply select the <strong>On-Location / Mobile Callout</strong> add-on during Step 1, and our makeup artist will bring a complete professional kit, ring light, and beauty station directly to your location.</p>
                </div>
                <div class="border-b border-gray-100 pb-3">
                    <h4 class="font-bold text-gray-900 mb-1">What payment methods do you accept?</h4>
                    <p>We accept M-Pesa (Till / Paybill), Card, and Cash upon arrival at the studio after your session is complete.</p>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-1">Can I bring photos of makeup looks I like?</h4>
                    <p>Absolutely! You can paste inspiration links or describe your look in Step 3, or show photos to your makeup artist upon arrival during the pre-session consultation.</p>
                </div>
            </div>
        </div>

    </div>
</div>

@include('components.instagram-reels-marquee')

<script>
document.addEventListener('DOMContentLoaded', function () {
    let currentWizardStep = 1;
    let currentDate = new Date();
    let selectedDate = null;
    let selectedTime = null;
    let selectedService = null;
    let selectedServiceName = '';
    let selectedServicePrice = 0;
    let selectedServiceDuration = '';
    let selectedAddons = [];

    const prices = @json($prices);
    const serviceTypes = @json($serviceTypes);
    const formattedPrices = @json($formattedPrices);
    const formattedDurations = @json($formattedDurations);

    renderCalendar();

    // Month Navigation
    document.getElementById('prev-month').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar();
    });
    document.getElementById('next-month').addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar();
    });

    // Addons change listener
    document.querySelectorAll('.addon-checkbox').forEach(cb => {
        cb.addEventListener('change', updateAddonsSelection);
    });

    // Form submit listener
    const bookingForm = document.getElementById('booking-form');
    bookingForm.addEventListener('submit', function (e) {
        if (!selectedService || !selectedDate || !selectedTime) {
            e.preventDefault();
            alert('Please select a service, date, and time slot before submitting.');
            return;
        }

        // Build combined special requests
        const occasion = document.getElementById('occasion_type').value;
        const lookNotes = document.getElementById('user_look_notes').value.trim();
        const skinNotes = document.getElementById('user_special_requests').value.trim();
        
        let addonSummary = '';
        if (selectedAddons.length > 0) {
            addonSummary = 'Selected Add-ons: ' + selectedAddons.map(a => `${a.name} (+KES ${a.price.toLocaleString()})`).join(', ') + '. ';
        }

        let fullRequests = `[Occasion: ${occasion}] `;
        if (addonSummary) fullRequests += addonSummary;
        if (lookNotes) fullRequests += `[Look Notes: ${lookNotes}] `;
        if (skinNotes) fullRequests += `[Preferences: ${skinNotes}]`;

        document.getElementById('combined_special_requests').value = fullRequests.trim();
    });

    // Card selection function
    window.selectServiceCard = function (slug) {
        selectedService = slug;
        const card = document.querySelector(`.service-card[data-service-slug="${slug}"]`);
        if (!card) return;

        selectedServiceName = card.dataset.serviceName;
        selectedServicePrice = parseFloat(card.dataset.servicePrice) || 0;
        selectedServiceDuration = card.dataset.serviceDuration;

        // Visual selection states
        document.querySelectorAll('.service-card').forEach(c => {
            c.classList.remove('border-pink-600', 'bg-pink-50/40', 'ring-2', 'ring-pink-400');
            c.classList.add('border-gray-200');
            const inner = c.querySelector('.service-radio-inner');
            const radio = c.querySelector('.service-radio');
            if (inner) inner.classList.add('hidden');
            if (radio) radio.classList.remove('border-pink-600');
        });

        card.classList.remove('border-gray-200');
        card.classList.add('border-pink-600', 'bg-pink-50/40', 'ring-2', 'ring-pink-400');
        const activeInner = card.querySelector('.service-radio-inner');
        const activeRadio = card.querySelector('.service-radio');
        if (activeInner) activeInner.classList.remove('hidden');
        if (activeRadio) activeRadio.classList.add('border-pink-600');

        document.getElementById('btn-to-step-2').disabled = false;
        updateLiveSummary();
    };

    function updateAddonsSelection() {
        selectedAddons = [];
        document.querySelectorAll('.addon-checkbox:checked').forEach(cb => {
            selectedAddons.push({
                id: cb.value,
                name: cb.dataset.name,
                price: parseFloat(cb.dataset.price) || 0
            });
        });
        updateLiveSummary();
    }

    function updateLiveSummary() {
        // Service
        const sidebarEmpty = document.getElementById('sidebar-service-empty');
        const sidebarDetails = document.getElementById('sidebar-service-details');
        if (selectedService) {
            sidebarEmpty.classList.add('hidden');
            sidebarDetails.classList.remove('hidden');
            document.getElementById('sidebar-service-name').textContent = selectedServiceName;
            document.getElementById('sidebar-service-duration').textContent = `⏱ ${selectedServiceDuration}`;
            document.getElementById('sidebar-service-price').textContent = `KES ${selectedServicePrice.toLocaleString()}`;
            document.getElementById('sidebar-subtotal').textContent = `KES ${selectedServicePrice.toLocaleString()}`;
            document.getElementById('step2-duration-label').textContent = selectedServiceDuration;
        } else {
            sidebarEmpty.classList.remove('hidden');
            sidebarDetails.classList.add('hidden');
            document.getElementById('sidebar-subtotal').textContent = 'KES 0';
        }

        // Addons
        const addonsEmpty = document.getElementById('sidebar-addons-empty');
        const addonsList = document.getElementById('sidebar-addons-list');
        let addonsTotal = 0;

        if (selectedAddons.length > 0) {
            addonsEmpty.classList.add('hidden');
            addonsList.classList.remove('hidden');
            addonsList.innerHTML = '';
            selectedAddons.forEach(a => {
                addonsTotal += a.price;
                const li = document.createElement('li');
                li.className = 'flex items-center justify-between text-[11px]';
                li.innerHTML = `<span>+ ${a.name}</span> <span class="font-semibold text-gray-900">KES ${a.price.toLocaleString()}</span>`;
                addonsList.appendChild(li);
            });
        } else {
            addonsEmpty.classList.remove('hidden');
            addonsList.classList.add('hidden');
        }

        document.getElementById('sidebar-addons-total').textContent = `KES ${addonsTotal.toLocaleString()}`;

        // Grand Total
        const grandTotal = selectedServicePrice + addonsTotal;
        document.getElementById('sidebar-grand-total').textContent = `KES ${grandTotal.toLocaleString()}`;

        // Date & Time
        const dtEmpty = document.getElementById('sidebar-datetime-empty');
        const dtDetails = document.getElementById('sidebar-datetime-details');
        if (selectedDate && selectedTime) {
            dtEmpty.classList.add('hidden');
            dtDetails.classList.remove('hidden');
            document.getElementById('sidebar-date').textContent = selectedDate.toLocaleDateString('en-KE', { weekday: 'short', month: 'short', day: 'numeric', year: 'numeric' });
            document.getElementById('sidebar-time').textContent = formatTime(selectedTime);
        } else {
            dtEmpty.classList.remove('hidden');
            dtDetails.classList.add('hidden');
        }
    }

    window.goToStep = function (step) {
        if (step === 2 && !selectedService) {
            alert('Please choose a makeup style to continue.');
            return;
        }
        if (step === 3 && (!selectedDate || !selectedTime)) {
            alert('Please select both a date and time slot to continue.');
            return;
        }

        currentWizardStep = step;

        // Hide all steps
        document.querySelectorAll('.wizard-step').forEach(el => el.classList.add('hidden'));
        document.getElementById(`step-${step}`).classList.remove('hidden');

        // Update step navigators
        for (let i = 1; i <= 3; i++) {
            const nav = document.getElementById(`step-nav-${i}`);
            const badge = nav.querySelector('span:first-child');
            if (i === step) {
                nav.className = 'step-nav-item py-2 px-2 rounded-md bg-pink-50 text-pink-700 font-semibold text-xs sm:text-sm flex items-center justify-center gap-2 transition-all';
                badge.className = 'w-5 h-5 rounded-full bg-pink-600 text-white text-xs flex items-center justify-center font-bold';
            } else if (i < step) {
                nav.className = 'step-nav-item py-2 px-2 rounded-md bg-emerald-50 text-emerald-700 font-semibold text-xs sm:text-sm flex items-center justify-center gap-2 transition-all cursor-pointer';
                badge.className = 'w-5 h-5 rounded-full bg-emerald-600 text-white text-xs flex items-center justify-center font-bold';
                badge.innerHTML = '✓';
                nav.onclick = () => goToStep(i);
            } else {
                nav.className = 'step-nav-item py-2 px-2 rounded-md text-gray-400 font-medium text-xs sm:text-sm flex items-center justify-center gap-2 transition-all';
                badge.className = 'w-5 h-5 rounded-full bg-gray-200 text-gray-500 text-xs flex items-center justify-center font-bold';
                badge.innerHTML = i;
                nav.onclick = null;
            }
        }

        if (step === 3) {
            document.getElementById('selected-service').value = selectedService;
            document.getElementById('selected-date').value = `${selectedDate.getFullYear()}-${String(selectedDate.getMonth()+1).padStart(2,'0')}-${String(selectedDate.getDate()).padStart(2,'0')}`;
            document.getElementById('selected-time').value = selectedTime;
        }

        window.scrollTo({ top: document.querySelector('.wizard-step:not(.hidden)').offsetTop - 120, behavior: 'smooth' });
    };

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
        for (let i = 0; i < firstDay; i++) {
            html += '<div class="h-10 sm:h-11"></div>';
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const date = new Date(year, month, day);
            const isPast = date < today;
            const isToday = date.toDateString() === today.toDateString();
            const isSelected = selectedDate && date.toDateString() === selectedDate.toDateString();
            const formatted = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

            let cls = 'h-10 sm:h-11 flex flex-col items-center justify-center text-xs sm:text-sm font-semibold rounded-lg transition-all ';
            if (isPast) {
                cls += 'text-gray-300 cursor-not-allowed bg-gray-50/50';
            } else if (isSelected) {
                cls += 'bg-pink-600 text-white shadow-sm ring-2 ring-pink-400 cursor-pointer';
            } else if (isToday) {
                cls += 'border-2 border-pink-400 text-pink-600 bg-white hover:bg-pink-50 cursor-pointer shadow-2xs';
            } else {
                cls += 'text-gray-800 bg-white border border-gray-100 hover:border-pink-300 hover:bg-pink-50/40 cursor-pointer shadow-2xs';
            }

            html += `<button type="button" class="${cls}" ${!isPast ? `data-date="${formatted}" onclick="selectDate(this)"` : 'disabled'}>
                        <span>${day}</span>
                     </button>`;
        }

        document.getElementById('calendar-days').innerHTML = html;
    }

    window.selectDate = function (el) {
        document.querySelectorAll('[data-date]').forEach(d => {
            d.classList.remove('bg-pink-600', 'text-white', 'ring-2', 'ring-pink-400');
            d.classList.add('bg-white', 'text-gray-800');
        });
        el.classList.remove('bg-white', 'text-gray-800');
        el.classList.add('bg-pink-600', 'text-white', 'ring-2', 'ring-pink-400');

        const dateStr = el.dataset.date;
        selectedDate = new Date(dateStr);
        selectedTime = null;
        document.getElementById('btn-to-step-3').disabled = true;

        document.getElementById('selected-date-display').textContent = selectedDate.toLocaleDateString('en-KE', { weekday: 'short', month: 'short', day: 'numeric' });
        loadTimeSlots(dateStr);
        updateLiveSummary();
    };

    function loadTimeSlots(date) {
        const container = document.getElementById('time-slots');
        container.innerHTML = '<div class="col-span-full py-4 text-center text-xs text-gray-500 flex items-center justify-center gap-2"><svg class="animate-spin w-4 h-4 text-pink-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Checking available studio slots...</div>';
        document.getElementById('time-slots-section').classList.remove('hidden');

        fetch(`/appointments/available-slots?date=${date}`)
            .then(r => r.json())
            .then(data => {
                container.innerHTML = '';
                if (!data.available_slots || data.available_slots.length === 0) {
                    container.innerHTML = '<div class="col-span-full py-3 text-center text-xs text-amber-800 bg-amber-50 rounded-lg border border-amber-200">No open slots available for this date. Please pick another day.</div>';
                } else {
                    data.available_slots.forEach(slot => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'time-slot-btn px-3 py-2.5 text-xs sm:text-sm font-semibold border-2 border-gray-200 rounded-lg text-gray-800 bg-white hover:border-pink-500 hover:text-pink-600 hover:bg-pink-50 transition-all shadow-2xs flex items-center justify-center';
                        btn.textContent = formatTime(slot);
                        btn.dataset.time = slot;
                        btn.onclick = () => selectTime(btn);
                        container.appendChild(btn);
                    });
                }
            })
            .catch(() => {
                container.innerHTML = '<div class="col-span-full py-3 text-center text-xs text-red-600">Failed to load available slots. Please try again.</div>';
            });
    }

    window.selectTime = function (el) {
        document.querySelectorAll('.time-slot-btn').forEach(b => {
            b.classList.remove('bg-pink-600', 'text-white', 'border-pink-600', 'ring-2', 'ring-pink-300');
            b.classList.add('bg-white', 'text-gray-800', 'border-gray-200');
        });
        el.classList.remove('bg-white', 'text-gray-800', 'border-gray-200');
        el.classList.add('bg-pink-600', 'text-white', 'border-pink-600', 'ring-2', 'ring-pink-300');
        selectedTime = el.dataset.time;
        document.getElementById('btn-to-step-3').disabled = false;
        updateLiveSummary();
    };

    function formatTime(time) {
        const [h, m] = time.split(':');
        const hour = parseInt(h);
        return `${hour > 12 ? hour - 12 : hour === 0 ? 12 : hour}:${m} ${hour >= 12 ? 'PM' : 'AM'}`;
    }
});
</script>
@endsection
