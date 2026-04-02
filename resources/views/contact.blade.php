@extends('layouts.app')

@section('title', 'Contact Us - Zayn\'s Beauty')

@section('content')

{{-- Page header --}}
<div class="bg-white border-b border-gray-100 py-10">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <p class="text-xs uppercase tracking-widest text-pink-600 font-medium mb-2">Get in Touch</p>
        <h1 class="text-3xl font-bold text-gray-900">Contact Us</h1>
        <p class="mt-2 text-gray-500 text-sm max-w-xl">Questions about an order, product advice, or just want to say hi — we're here.</p>
    </div>
</div>

<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl py-12">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

            {{-- Contact form (wider column) --}}
            <div class="lg:col-span-3">
                <div class="bg-white border border-gray-100 rounded-sm shadow-sm p-8">

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-sm text-sm text-green-800">
                            {{ session('success') }}
                        </div>
                    @endif

                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Send a Message</h2>

                    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-5">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                                <input type="text" id="first_name" name="first_name" required
                                       value="{{ old('first_name') }}"
                                       class="w-full px-3 py-2.5 border border-gray-300 rounded-sm text-sm focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-pink-500">
                                @error('first_name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                <input type="text" id="last_name" name="last_name" required
                                       value="{{ old('last_name') }}"
                                       class="w-full px-3 py-2.5 border border-gray-300 rounded-sm text-sm focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-pink-500">
                                @error('last_name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address *</label>
                            <input type="email" id="email" name="email" required
                                   value="{{ old('email') }}"
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-sm text-sm focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-pink-500">
                            @error('email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                   value="{{ old('phone') }}"
                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-sm text-sm focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-pink-500">
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject *</label>
                            <select id="subject" name="subject" required
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-sm text-sm focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-pink-500 bg-white">
                                <option value="">Select a subject</option>
                                <option value="general" @selected(old('subject')=='general')>General Inquiry</option>
                                <option value="product" @selected(old('subject')=='product')>Product Information</option>
                                <option value="order" @selected(old('subject')=='order')>Order Status</option>
                                <option value="return" @selected(old('subject')=='return')>Returns & Refunds</option>
                                <option value="beauty-advice" @selected(old('subject')=='beauty-advice')>Beauty Advice</option>
                                <option value="feedback" @selected(old('subject')=='feedback')>Feedback</option>
                                <option value="other" @selected(old('subject')=='other')>Other</option>
                            </select>
                            @error('subject')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                            <textarea id="message" name="message" rows="5" required
                                      placeholder="Tell us how we can help you..."
                                      class="w-full px-3 py-2.5 border border-gray-300 rounded-sm text-sm focus:outline-none focus:ring-1 focus:ring-pink-500 focus:border-pink-500 resize-none">{{ old('message') }}</textarea>
                            @error('message')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Honeypot --}}
                        <div class="hidden">
                            <input type="text" name="website" tabindex="-1" autocomplete="off">
                            <input type="text" name="company" tabindex="-1" autocomplete="off">
                        </div>

                        <button type="submit"
                                class="w-full bg-pink-600 hover:bg-pink-700 text-white font-semibold py-3 px-6 rounded-sm text-sm transition-colors">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            {{-- Info sidebar --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Contact details --}}
                <div class="bg-white border border-gray-100 rounded-sm shadow-sm p-6">
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-4">Contact Details</p>
                    <ul class="space-y-4 text-sm">
                        @php
                            $phone   = \App\Models\Setting::get('contact_phone_primary', '');
                            $phone2  = \App\Models\Setting::get('contact_phone_secondary', '');
                            $email   = \App\Models\Setting::get('contact_email_primary', '');
                            $address = \App\Models\Setting::get('contact_address_full', \App\Models\Setting::get('contact_address_city', 'Nairobi, Kenya'));
                        @endphp
                        @if($phone || $phone2)
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <div class="text-gray-600 leading-relaxed">
                                @if($phone)<a href="tel:{{ $phone }}" class="hover:text-gray-900 transition-colors block">{{ $phone }}</a>@endif
                                @if($phone2)<a href="tel:{{ $phone2 }}" class="hover:text-gray-900 transition-colors block">{{ $phone2 }}</a>@endif
                            </div>
                        </li>
                        @endif
                        @if($email)
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <a href="mailto:{{ $email }}" class="text-gray-600 hover:text-gray-900 transition-colors">{{ $email }}</a>
                        </li>
                        @endif
                        @if($address)
                        <li class="flex items-start gap-3">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="text-gray-600 leading-relaxed">{!! nl2br(e($address)) !!}</span>
                        </li>
                        @endif
                    </ul>
                </div>

                {{-- Business hours --}}
                <div class="bg-white border border-gray-100 rounded-sm shadow-sm p-6">
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-4">Business Hours</p>
                    <ul class="space-y-2 text-sm">
                        <li class="flex justify-between">
                            <span class="text-gray-500">Mon – Fri</span>
                            <span class="font-medium text-gray-900">{{ \App\Helpers\SettingsHelper::getBusinessHours('monday_friday') ?: '9:00 AM – 6:00 PM' }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-500">Saturday</span>
                            <span class="font-medium text-gray-900">{{ \App\Helpers\SettingsHelper::getBusinessHours('saturday') ?: '10:00 AM – 5:00 PM' }}</span>
                        </li>
                        <li class="flex justify-between">
                            <span class="text-gray-500">Sunday</span>
                            <span class="font-medium text-gray-900">{{ \App\Helpers\SettingsHelper::getBusinessHours('sunday') ?: 'Closed' }}</span>
                        </li>
                    </ul>
                    <p class="mt-4 text-xs text-gray-400">Closed on public holidays. Orders processed 24/7.</p>
                </div>

                {{-- Social --}}
                @php
                    $instagram = \App\Models\Setting::get('social_instagram', '');
                    $facebook  = \App\Models\Setting::get('social_facebook', '');
                    $twitter   = \App\Models\Setting::get('social_twitter', '');
                @endphp
                @if($instagram || $facebook || $twitter)
                <div class="bg-white border border-gray-100 rounded-sm shadow-sm p-6">
                    <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-4">Follow Us</p>
                    <div class="flex gap-3">
                        @if($instagram)
                        <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"
                           class="w-9 h-9 flex items-center justify-center border border-gray-200 rounded-sm text-gray-500 hover:text-pink-600 hover:border-pink-300 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                        @endif
                        @if($facebook)
                        <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"
                           class="w-9 h-9 flex items-center justify-center border border-gray-200 rounded-sm text-gray-500 hover:text-pink-600 hover:border-pink-300 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 01-1.93.07 4.28 4.28 0 004 2.98 8.521 8.521 0 01-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        @endif
                        @if($twitter)
                        <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer" aria-label="Twitter/X"
                           class="w-9 h-9 flex items-center justify-center border border-gray-200 rounded-sm text-gray-500 hover:text-pink-600 hover:border-pink-300 transition-colors">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- FAQs --}}
        @if(!empty($faqs))
        <div class="mt-12">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-6">Frequently Asked Questions</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($faqs as $faq)
                <div class="bg-white border border-gray-100 rounded-sm shadow-sm p-5">
                    <p class="text-sm font-semibold text-gray-900 mb-2">{{ $faq['question'] }}</p>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $faq['answer'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@endsection
