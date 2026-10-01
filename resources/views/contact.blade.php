@extends('layouts.app')

@php
    $contactPhone = \App\Models\Setting::get('contact_phone_primary', '0726243706');
    $contactPhone2 = \App\Models\Setting::get('contact_phone_secondary', '');
    $contactEmail = \App\Models\Setting::get('contact_email_primary', 'info@marscollection.co.ke');
    $contactAddress = \App\Models\Setting::get('contact_address_full', \App\Models\Setting::get('contact_address_city', 'Kenya'));
    $waPhone = preg_replace('/\D/', '', $contactPhone);
    if (str_starts_with($waPhone, '0')) $waPhone = '254' . substr($waPhone, 1);
    $instagram = \App\Models\Setting::get('social_instagram', '');
    $facebook = \App\Models\Setting::get('social_facebook', '');
    $twitter = \App\Models\Setting::get('social_twitter', '');
@endphp

@section('title', 'Contact Mars Collection Kenya | Product & Order Support')
@section('description', 'Contact Mars Collection in Kenya for help with shoes, sizing, orders and delivery. Call ' . $contactPhone . ' or email ' . $contactEmail . '.')
@section('keywords', 'contact Mars Collection, Mars Collection Kenya contact, shoe store customer support Kenya, order help Mars Collection')
@section('canonical', route('contact'))
@section('og_type', 'website')
@section('og_image', asset('images/mars-footwear-hero.png'))

@section('content')
<div class="min-h-screen bg-[#f7f6f3]">
    <section class="relative overflow-hidden bg-gray-950 text-white">
        <div class="absolute -right-24 -top-40 h-96 w-96 rounded-full border-[48px] border-amber-400/5" aria-hidden="true"></div>
        <div class="relative mx-auto max-w-7xl px-4 pb-12 pt-7 sm:px-6 sm:pb-16 lg:px-8">
            <nav aria-label="Breadcrumb" class="mb-9">
                <ol class="flex items-center gap-2 text-xs font-medium text-gray-400">
                    <li><a href="{{ route('home') }}" class="transition hover:text-amber-300">Home</a></li>
                    <li aria-hidden="true" class="text-gray-600">/</li>
                    <li aria-current="page" class="text-amber-200">Contact Mars Collection</li>
                </ol>
            </nav>
            <div class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-[0.22em] text-amber-300">We’re here to help</p>
                <h1 class="mt-3 text-4xl font-black tracking-tight sm:text-5xl">How can we help you?</h1>
                <p class="mt-4 max-w-xl text-sm leading-7 text-gray-300 sm:text-base">Questions about a pair, your size or an order? Choose the contact option that works for you, or send our team a message.</p>
            </div>
            <div class="mt-8 grid max-w-3xl gap-3 sm:grid-cols-2">
                @if($contactPhone)
                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone) }}" class="group flex min-w-0 items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.06] p-4 transition hover:border-amber-300/50 hover:bg-white/10">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-400 text-gray-950"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 5a2 2 0 0 1 2-2h3l2 5-2 1.5a15 15 0 0 0 6.5 6.5L16 14l5 2v3a2 2 0 0 1-2 2C10.16 21 3 13.84 3 5Z"/></svg></span>
                        <span class="min-w-0"><span class="block text-[11px] font-semibold uppercase tracking-wider text-gray-400">Call Mars Collection</span><span class="mt-1 block truncate text-sm font-bold text-white group-hover:text-amber-200">{{ $contactPhone }}</span></span>
                        <span class="ml-auto text-gray-500 transition group-hover:translate-x-0.5 group-hover:text-amber-300" aria-hidden="true">→</span>
                    </a>
                @endif
                @if($contactEmail)
                    <a href="mailto:{{ $contactEmail }}" class="group flex min-w-0 items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.06] p-4 transition hover:border-amber-300/50 hover:bg-white/10">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-400 text-gray-950"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 6h18v12H3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m3 7 9 6 9-6"/></svg></span>
                        <span class="min-w-0"><span class="block text-[11px] font-semibold uppercase tracking-wider text-gray-400">Email our team</span><span class="mt-1 block truncate text-sm font-bold text-white group-hover:text-amber-200">{{ $contactEmail }}</span></span>
                        <span class="ml-auto text-gray-500 transition group-hover:translate-x-0.5 group-hover:text-amber-300" aria-hidden="true">→</span>
                    </a>
                @endif
            </div>
        </div>
    </section>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 sm:py-12 lg:px-8">
        <div class="grid items-start gap-6 lg:grid-cols-[minmax(0,1.55fr)_minmax(18rem,0.85fr)] lg:gap-8">
            <section id="contact-form" class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-8" aria-labelledby="contact-form-title">
                @if(session('success'))
                    <div role="status" class="mb-6 flex gap-3 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-700" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m5 12 4 4L19 6"/></svg>
                        <div><p class="font-bold">Message sent</p><p class="mt-1">{{ session('success') }}</p></div>
                    </div>
                @endif
                @if($errors->any())
                    <div role="alert" class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                        <p class="font-bold">Please check the highlighted fields.</p>
                        <p class="mt-1">{{ $errors->first() }}</p>
                    </div>
                @endif

                <div class="mb-7 flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-amber-700">Send us a message</p>
                        <h2 id="contact-form-title" class="mt-2 text-2xl font-black tracking-tight text-gray-950">Tell us what you need.</h2>
                        <p class="mt-2 text-sm leading-6 text-gray-500">We’ll use your details to respond to this enquiry.</p>
                    </div>
                    <span class="hidden h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-700 sm:flex"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h8M8 14h5m-8 7 2.5-3H19a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v16Z"/></svg></span>
                </div>

                <form method="POST" action="{{ route('contact.submit') }}" class="space-y-5">
                    @csrf
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="first_name" class="mb-1.5 block text-sm font-semibold text-gray-800">First name <span class="text-amber-700">*</span></label>
                            <input type="text" id="first_name" name="first_name" autocomplete="given-name" required value="{{ old('first_name') }}" @if($errors->has('first_name')) aria-invalid="true" aria-describedby="first_name-error" @endif
                                   class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-3 text-sm text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10 @error('first_name') border-red-400 @enderror" placeholder="Your first name">
                            @error('first_name')<p id="first_name-error" class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="last_name" class="mb-1.5 block text-sm font-semibold text-gray-800">Last name <span class="text-amber-700">*</span></label>
                            <input type="text" id="last_name" name="last_name" autocomplete="family-name" required value="{{ old('last_name') }}" @if($errors->has('last_name')) aria-invalid="true" aria-describedby="last_name-error" @endif
                                   class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-3 text-sm text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10 @error('last_name') border-red-400 @enderror" placeholder="Your last name">
                            @error('last_name')<p id="last_name-error" class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-semibold text-gray-800">Email address <span class="text-amber-700">*</span></label>
                            <input type="email" id="email" name="email" autocomplete="email" required value="{{ old('email') }}" @if($errors->has('email')) aria-invalid="true" aria-describedby="email-error" @endif
                                   class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-3 text-sm text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10 @error('email') border-red-400 @enderror" placeholder="you@example.com">
                            @error('email')<p id="email-error" class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="phone" class="mb-1.5 block text-sm font-semibold text-gray-800">Phone number <span class="font-normal text-gray-400">(optional)</span></label>
                            <input type="tel" id="phone" name="phone" autocomplete="tel" inputmode="tel" value="{{ old('phone') }}" @if($errors->has('phone')) aria-invalid="true" aria-describedby="phone-error" @endif
                                   class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-3 text-sm text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10 @error('phone') border-red-400 @enderror" placeholder="e.g. 07xx xxx xxx">
                            @error('phone')<p id="phone-error" class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="mb-1.5 block text-sm font-semibold text-gray-800">What can we help with? <span class="text-amber-700">*</span></label>
                        <select id="subject" name="subject" required @if($errors->has('subject')) aria-invalid="true" aria-describedby="subject-error" @endif
                                class="w-full appearance-none rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-3 text-sm text-gray-900 transition hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10 @error('subject') border-red-400 @enderror">
                            <option value="">Choose a topic</option>
                            <option value="general" @selected(old('subject') === 'general')>General question</option>
                            <option value="product" @selected(old('subject') === 'product')>Product information</option>
                            <option value="order" @selected(old('subject') === 'order')>Order status</option>
                            <option value="return" @selected(old('subject') === 'return')>Returns and refunds</option>
                            <option value="shoe-sizing" @selected(old('subject') === 'shoe-sizing')>Shoe sizing</option>
                            <option value="feedback" @selected(old('subject') === 'feedback')>Feedback</option>
                            <option value="other" @selected(old('subject') === 'other')>Something else</option>
                        </select>
                        @error('subject')<p id="subject-error" class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <div class="mb-1.5 flex items-center justify-between gap-3">
                            <label for="message" class="block text-sm font-semibold text-gray-800">Your message <span class="text-amber-700">*</span></label>
                            <span class="text-[11px] text-gray-400">Up to 1,000 characters</span>
                        </div>
                        <textarea id="message" name="message" rows="5" maxlength="1000" required placeholder="Share a few details so we can help you better..." @if($errors->has('message')) aria-invalid="true" aria-describedby="message-error" @endif
                                  class="w-full resize-y rounded-xl border border-gray-200 bg-gray-50 px-3.5 py-3 text-sm leading-6 text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10 @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                        @error('message')<p id="message-error" class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>@enderror
                    </div>

                    <div class="hidden" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"><input type="text" name="company" tabindex="-1" autocomplete="off"></div>
                    <div class="flex flex-col gap-3 border-t border-gray-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-xs leading-5 text-gray-500">Fields marked <span class="font-bold text-amber-700">*</span> are required.</p>
                        <button type="submit" class="group inline-flex items-center justify-center gap-2 rounded-xl bg-amber-500 px-6 py-3 text-sm font-bold text-gray-950 shadow-sm transition hover:bg-amber-400 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600">
                            Send message <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                        </button>
                    </div>
                </form>
            </section>

            <aside class="space-y-5">
                <section class="overflow-hidden rounded-2xl bg-gray-950 text-white shadow-sm" aria-labelledby="reach-us-title">
                    <div class="p-6 sm:p-7">
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-amber-300">Mars Collection support</p>
                        <h2 id="reach-us-title" class="mt-2 text-xl font-black">Reach us directly</h2>
                        <p class="mt-2 text-sm leading-6 text-gray-400">Pick the channel that’s easiest for you.</p>
                        @if($contactPhone)
                            <a href="https://wa.me/{{ $waPhone }}" target="_blank" rel="noopener noreferrer" class="mt-5 flex items-center justify-center gap-2 rounded-xl bg-emerald-500 px-4 py-3 text-sm font-bold text-white transition hover:bg-emerald-400">
                                <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24" aria-hidden="true"><path d="M20.52 3.48A11.78 11.78 0 0 0 12.13 0C5.54 0 .18 5.36.18 11.96c0 2.1.55 4.16 1.6 5.98L.08 24l6.22-1.63a11.96 11.96 0 0 0 5.82 1.48h.01c6.6 0 11.96-5.36 11.96-11.96 0-3.2-1.25-6.2-3.57-8.41ZM12.13 21.8a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.69.97.98-3.6-.24-.37a9.88 9.88 0 0 1-1.52-5.25c0-5.46 4.45-9.91 9.92-9.91 2.65 0 5.14 1.03 7.01 2.9a9.86 9.86 0 0 1 2.9 7.02c0 5.47-4.45 9.92-9.92 9.92Zm5.44-7.43c-.3-.15-1.77-.87-2.04-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.64.07-.3-.15-1.26-.46-2.4-1.47-.89-.79-1.49-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.14-.14.3-.35.45-.52.15-.18.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.49 0 1.47 1.06 2.88 1.21 3.08.15.2 2.1 3.21 5.1 4.5.71.31 1.27.49 1.7.63.72.23 1.37.2 1.89.12.57-.08 1.76-.72 2.01-1.41.25-.7.25-1.3.17-1.42-.07-.13-.27-.2-.57-.35Z"/></svg>
                                Chat with us on WhatsApp
                            </a>
                        @endif
                        <div class="mt-6 space-y-4 border-t border-white/10 pt-5">
                            @if($contactPhone)
                                <div><p class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Phone</p><a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone) }}" class="mt-1 block text-sm font-semibold text-white hover:text-amber-200">{{ $contactPhone }}</a>@if($contactPhone2)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $contactPhone2) }}" class="mt-1 block text-sm font-semibold text-white hover:text-amber-200">{{ $contactPhone2 }}</a>@endif</div>
                            @endif
                            @if($contactEmail)<div><p class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Email</p><a href="mailto:{{ $contactEmail }}" class="mt-1 block break-all text-sm font-semibold text-white hover:text-amber-200">{{ $contactEmail }}</a></div>@endif
                            @if($contactAddress)<div><p class="text-[11px] font-semibold uppercase tracking-wider text-gray-500">Location</p><p class="mt-1 text-sm leading-6 text-gray-300">{!! nl2br(e($contactAddress)) !!}</p></div>@endif
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-7" aria-labelledby="hours-title">
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="M12 7v5l3 2"/></svg></span>
                        <div><h2 id="hours-title" class="font-bold text-gray-950">Business hours</h2><p class="text-xs text-gray-500">Kenya time (EAT)</p></div>
                    </div>
                    <dl class="mt-5 space-y-3 text-sm">
                        <div class="flex justify-between gap-4"><dt class="text-gray-500">Monday – Friday</dt><dd class="text-right font-semibold text-gray-900">{{ \App\Helpers\SettingsHelper::getBusinessHours('monday_friday') ?: '9:00 AM – 6:00 PM' }}</dd></div>
                        <div class="flex justify-between gap-4"><dt class="text-gray-500">Saturday</dt><dd class="text-right font-semibold text-gray-900">{{ \App\Helpers\SettingsHelper::getBusinessHours('saturday') ?: '10:00 AM – 5:00 PM' }}</dd></div>
                        <div class="flex justify-between gap-4"><dt class="text-gray-500">Sunday</dt><dd class="text-right font-semibold text-gray-900">{{ \App\Helpers\SettingsHelper::getBusinessHours('sunday') ?: 'Closed' }}</dd></div>
                    </dl>
                    @if($instagram || $facebook || $twitter)
                        <div class="mt-5 border-t border-gray-100 pt-4">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">Follow Mars Collection</p>
                            <div class="mt-3 flex flex-wrap gap-2">
                                @foreach(['Instagram' => $instagram, 'Facebook' => $facebook, 'X' => $twitter] as $network => $url)
                                    @if($url)<a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="rounded-full border border-gray-200 px-3 py-1.5 text-xs font-semibold text-gray-600 transition hover:border-amber-300 hover:bg-amber-50 hover:text-amber-900">{{ $network }}</a>@endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </section>
            </aside>
        </div>

        @if(!empty($faqs))
            <section class="mt-14 border-t border-gray-200 pt-10 sm:mt-16 sm:pt-12" aria-labelledby="contact-faq-title">
                <div class="mb-6 max-w-xl">
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-amber-700">Quick answers</p>
                    <h2 id="contact-faq-title" class="mt-2 text-2xl font-black tracking-tight text-gray-950">Frequently asked questions</h2>
                    <p class="mt-2 text-sm leading-6 text-gray-500">A little help with common footwear and order questions.</p>
                </div>
                <div class="grid gap-3 md:grid-cols-2">
                    @foreach($faqs as $faq)
                        <details class="group rounded-2xl border border-gray-200 bg-white p-5 shadow-sm open:border-amber-200 open:bg-amber-50/40">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-sm font-bold text-gray-900 marker:hidden [&::-webkit-details-marker]:hidden">
                                {{ $faq['question'] }}
                                <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-600 transition group-open:rotate-45 group-open:bg-amber-100 group-open:text-amber-900" aria-hidden="true">+</span>
                            </summary>
                            <p class="mt-3 border-t border-gray-100 pt-3 text-sm leading-6 text-gray-600">{{ $faq['answer'] }}</p>
                        </details>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</div>
@endsection
