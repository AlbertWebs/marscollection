@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="space-y-6">
    @php
        $brandLogoUrl = \App\Helpers\SettingsHelper::getBrandLogoUrl();
        $brandFaviconUrl = \App\Helpers\SettingsHelper::getBrandFaviconUrl();
    @endphp
    <div class="overflow-hidden rounded-2xl bg-gray-950 px-5 py-6 text-white shadow-sm sm:px-7">
        <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-400">Store control center</p>
                <h1 class="mt-2 text-2xl font-black sm:text-3xl">Settings</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-300">Manage your storefront identity, business details, and homepage content from one place.</p>
            </div>
            <button type="submit" form="store-settings-form" class="inline-flex items-center justify-center rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-gray-950 shadow-sm transition hover:bg-amber-300 focus:outline-none focus:ring-2 focus:ring-amber-200 focus:ring-offset-2 focus:ring-offset-gray-950">Save all changes</button>
        </div>
    </div>

    @if(session('success'))
        <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div role="alert" class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            <p class="font-semibold">Some settings need attention.</p>
            <ul class="mt-1 list-inside list-disc">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <nav aria-label="Settings sections" class="sticky top-0 z-20 -mx-1 flex gap-2 overflow-x-auto rounded-xl border border-gray-200 bg-white/95 p-2 shadow-sm backdrop-blur">
        <a href="#branding" class="shrink-0 rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-amber-50 hover:text-amber-800">Branding</a>
        <a href="#contact" class="shrink-0 rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-amber-50 hover:text-amber-800">Contact</a>
        <a href="#business" class="shrink-0 rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-amber-50 hover:text-amber-800">Business</a>
        <a href="#email" class="shrink-0 rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-amber-50 hover:text-amber-800">Email</a>
        <a href="#social" class="shrink-0 rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-amber-50 hover:text-amber-800">Social</a>
        <a href="#homepage" class="shrink-0 rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-amber-50 hover:text-amber-800">Homepage</a>
        <a href="#banner" class="shrink-0 rounded-lg px-3 py-2 text-xs font-semibold text-gray-600 hover:bg-amber-50 hover:text-amber-800">Banner</a>
    </nav>

    <form id="store-settings-form" method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        @method('PUT')

        <section id="branding" class="scroll-mt-24 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="mb-5">
                <p class="text-xs font-bold uppercase tracking-wider text-amber-700">Storefront identity</p>
                <h2 class="mt-1 text-lg font-bold text-gray-900">Logo & favicon</h2>
                <p class="mt-1 text-sm text-gray-500">These appear across the storefront, account pages, and browser tab.</p>
            </div>
            <div class="grid gap-4 lg:grid-cols-2">
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <div class="flex min-h-24 items-center justify-center rounded-lg border border-dashed border-gray-300 bg-white p-4">
                        <img src="{{ $brandLogoUrl }}" id="brand-logo-preview" alt="Current store logo" class="max-h-16 max-w-full object-contain">
                    </div>
                    <label for="brand_logo" class="mt-4 block text-sm font-semibold text-gray-800">Store logo</label>
                    <input type="file" id="brand_logo" name="brand_logo" accept="image/png,image/jpeg,image/webp" data-brand-preview="brand-logo-preview" class="mt-2 block w-full rounded-lg border border-gray-300 bg-white text-sm text-gray-700 file:mr-3 file:border-0 file:bg-gray-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-amber-50">
                    <p class="mt-2 text-xs leading-5 text-gray-500">PNG recommended for transparency. Use a wide logo around 1000 by 400 px. Maximum 2 MB. Leave empty to keep the current logo.</p>
                    @error('brand_logo')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                    <div class="flex min-h-24 items-center justify-center rounded-lg border border-dashed border-gray-300 bg-white p-4">
                        <img src="{{ $brandFaviconUrl }}" id="brand-favicon-preview" alt="Current browser icon" class="h-12 w-12 rounded-lg object-contain">
                    </div>
                    <label for="brand_favicon" class="mt-4 block text-sm font-semibold text-gray-800">Browser favicon</label>
                    <input type="file" id="brand_favicon" name="brand_favicon" accept="image/png" data-brand-preview="brand-favicon-preview" class="mt-2 block w-full rounded-lg border border-gray-300 bg-white text-sm text-gray-700 file:mr-3 file:border-0 file:bg-gray-100 file:px-4 file:py-2.5 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-amber-50">
                    <p class="mt-2 text-xs leading-5 text-gray-500">Use a square PNG, ideally 512 by 512 px, with the mark centered. Maximum 2 MB. Leave empty to keep the current favicon.</p>
                    @error('brand_favicon')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </section>
        
        <!-- Contact Settings -->
        <div id="contact" class="scroll-mt-24 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="mb-4 text-lg font-bold text-gray-900">Contact information</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label for="contact_phone_primary" class="block text-sm font-medium text-gray-700">Primary Phone</label>
                    <input type="text" id="contact_phone_primary" name="contact_phone_primary" 
                           value="{{ $contactSettings->where('key', 'contact_phone_primary')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="contact_phone_secondary" class="block text-sm font-medium text-gray-700">Secondary Phone</label>
                    <input type="text" id="contact_phone_secondary" name="contact_phone_secondary" 
                           value="{{ $contactSettings->where('key', 'contact_phone_secondary')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="contact_email_primary" class="block text-sm font-medium text-gray-700">Primary Email</label>
                    <input type="email" id="contact_email_primary" name="contact_email_primary" 
                           value="{{ $contactSettings->where('key', 'contact_email_primary')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="contact_email_support" class="block text-sm font-medium text-gray-700">Support Email</label>
                    <input type="email" id="contact_email_support" name="contact_email_support" 
                           value="{{ $contactSettings->where('key', 'contact_email_support')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div class="md:col-span-2">
                    <label for="contact_address_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                    <input type="text" id="contact_address_name" name="contact_address_name" 
                           value="{{ $contactSettings->where('key', 'contact_address_name')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div class="md:col-span-2">
                    <label for="contact_address_street" class="block text-sm font-medium text-gray-700">Street Address</label>
                    <input type="text" id="contact_address_street" name="contact_address_street" 
                           value="{{ $contactSettings->where('key', 'contact_address_street')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div class="md:col-span-2">
                    <label for="contact_address_city" class="block text-sm font-medium text-gray-700">City & Country</label>
                    <input type="text" id="contact_address_city" name="contact_address_city" 
                           value="{{ $contactSettings->where('key', 'contact_address_city')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div class="md:col-span-2">
                    <label for="contact_address_full" class="block text-sm font-medium text-gray-700">Full Address</label>
                    <textarea id="contact_address_full" name="contact_address_full" rows="3"
                              class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">{{ $contactSettings->where('key', 'contact_address_full')->first()->value ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Business Settings -->
        <div id="business" class="scroll-mt-24 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="mb-4 text-lg font-bold text-gray-900">Business information</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                    <input type="text" id="business_name" name="business_name" 
                           value="{{ $businessSettings->where('key', 'business_name')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="business_hours_monday_friday" class="block text-sm font-medium text-gray-700">Monday - Friday Hours</label>
                    <input type="text" id="business_hours_monday_friday" name="business_hours_monday_friday" 
                           value="{{ $businessSettings->where('key', 'business_hours_monday_friday')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="business_hours_saturday" class="block text-sm font-medium text-gray-700">Saturday Hours</label>
                    <input type="text" id="business_hours_saturday" name="business_hours_saturday" 
                           value="{{ $businessSettings->where('key', 'business_hours_saturday')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="business_hours_sunday" class="block text-sm font-medium text-gray-700">Sunday Hours</label>
                    <input type="text" id="business_hours_sunday" name="business_hours_sunday" 
                           value="{{ $businessSettings->where('key', 'business_hours_sunday')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div class="md:col-span-2">
                    <label for="business_note" class="block text-sm font-medium text-gray-700">Business Note</label>
                    <textarea id="business_note" name="business_note" rows="3"
                              class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">{{ $businessSettings->where('key', 'business_note')->first()->value ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Email Settings -->
        <div id="email" class="scroll-mt-24 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="mb-4 text-lg font-bold text-gray-900">Email settings</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label for="email_admin" class="block text-sm font-medium text-gray-700">Admin Email</label>
                    <input type="email" id="email_admin" name="email_admin" 
                           value="{{ $emailSettings->where('key', 'email_admin')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="email_from_name" class="block text-sm font-medium text-gray-700">From Name</label>
                    <input type="text" id="email_from_name" name="email_from_name" 
                           value="{{ $emailSettings->where('key', 'email_from_name')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div class="md:col-span-2">
                    <label for="email_from_address" class="block text-sm font-medium text-gray-700">From Address</label>
                    <input type="email" id="email_from_address" name="email_from_address" 
                           value="{{ $emailSettings->where('key', 'email_from_address')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
            </div>
        </div>

        <!-- Social Media Settings -->
        <div id="social" class="scroll-mt-24 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="mb-4 text-lg font-bold text-gray-900">Social media</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                <div>
                    <label for="social_facebook" class="block text-sm font-medium text-gray-700">Facebook URL</label>
                    <input type="url" id="social_facebook" name="social_facebook" 
                           value="{{ $socialSettings->where('key', 'social_facebook')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="social_instagram" class="block text-sm font-medium text-gray-700">Instagram URL</label>
                    <input type="url" id="social_instagram" name="social_instagram" 
                           value="{{ $socialSettings->where('key', 'social_instagram')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="social_twitter" class="block text-sm font-medium text-gray-700">Twitter URL</label>
                    <input type="url" id="social_twitter" name="social_twitter" 
                           value="{{ $socialSettings->where('key', 'social_twitter')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
            </div>
        </div>

        <!-- Hero Section Settings -->
        <div id="homepage" class="scroll-mt-24 space-y-5">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base lg:text-lg font-medium text-gray-900 mb-4">Hero Section</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div class="md:col-span-2">
                    <label for="hero_enabled" class="flex items-center">
                        <input type="checkbox" id="hero_enabled" name="hero_enabled" value="1"
                               {{ ($heroSettings->where('key', 'hero_enabled')->first()->value ?? '1') == '1' ? 'checked' : '' }}
                               class="rounded-md border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm font-medium text-gray-700">Enable Hero Section</span>
                    </label>
                </div>
                <div class="md:col-span-2">
                    <label for="hero_title" class="block text-sm font-medium text-gray-700">Hero Title</label>
                    <input type="text" id="hero_title" name="hero_title" 
                           value="{{ $heroSettings->where('key', 'hero_title')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div class="md:col-span-2">
                    <label for="hero_subtitle" class="block text-sm font-medium text-gray-700">Hero Description</label>
                    <textarea id="hero_subtitle" name="hero_subtitle" rows="3"
                              class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">{{ $heroSettings->where('key', 'hero_subtitle')->first()->value ?? '' }}</textarea>
                </div>
                <div class="md:col-span-2">
                    <label for="hero_image" class="block text-sm font-medium text-gray-700">Hero Image</label>
                    
                    <!-- Current Image Preview -->
                    @php
                        $currentHeroImage = $heroSettings->where('key', 'hero_image')->first()->value ?? '';
                    @endphp
                    @if($currentHeroImage)
                        <div class="mt-2 mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                            <div class="flex items-center space-x-4">
                                <img src="{{ $currentHeroImage }}" alt="Hero Image" 
                                     class="w-32 h-20 object-cover rounded-md border border-gray-200">
                                <div>
                                    <p class="text-sm text-gray-500">{{ basename($currentHeroImage) }}</p>
                                    <p class="text-xs text-gray-400">Click "Choose File" to replace this image</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-1 flex items-center">
                        <input type="file" id="hero_image" name="hero_image" accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 @error('hero_image') border-red-500 @enderror">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Upload a hero image (JPG, PNG, GIF, WebP). Max size: 2MB. Leave empty to keep current image.</p>
                    @error('hero_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="hero_stats_customers" class="block text-sm font-medium text-gray-700">Happy Customers Count</label>
                    <input type="text" id="hero_stats_customers" name="hero_stats_customers" 
                           value="{{ $heroSettings->where('key', 'hero_stats_customers')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="hero_stats_products" class="block text-sm font-medium text-gray-700">Premium Products Count</label>
                    <input type="text" id="hero_stats_products" name="hero_stats_products" 
                           value="{{ $heroSettings->where('key', 'hero_stats_products')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="hero_stats_rating" class="block text-sm font-medium text-gray-700">Average Rating</label>
                    <input type="text" id="hero_stats_rating" name="hero_stats_rating" 
                           value="{{ $heroSettings->where('key', 'hero_stats_rating')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
            </div>
        </div>
        </div>

        <!-- Video Section Settings -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base lg:text-lg font-medium text-gray-900 mb-4">Video Section</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div class="md:col-span-2">
                    <label for="video_enabled" class="flex items-center">
                        <input type="checkbox" id="video_enabled" name="video_enabled" value="1"
                               {{ ($videoSettings->where('key', 'video_enabled')->first()->value ?? '1') == '1' ? 'checked' : '' }}
                               class="rounded-md border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm font-medium text-gray-700">Enable Video Section</span>
                    </label>
                </div>
                <div class="md:col-span-2">
                    <label for="video_title" class="block text-sm font-medium text-gray-700">Video Section Title</label>
                    <input type="text" id="video_title" name="video_title" 
                           value="{{ $videoSettings->where('key', 'video_title')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div class="md:col-span-2">
                    <label for="video_description" class="block text-sm font-medium text-gray-700">Video Description</label>
                    <textarea id="video_description" name="video_description" rows="3"
                              class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">{{ $videoSettings->where('key', 'video_description')->first()->value ?? '' }}</textarea>
                </div>
                <div>
                    <label for="video_youtube_id" class="block text-sm font-medium text-gray-700">YouTube Video ID</label>
                    <input type="text" id="video_youtube_id" name="video_youtube_id" 
                           value="{{ $videoSettings->where('key', 'video_youtube_id')->first()->value ?? '' }}"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200"
                           placeholder="e.g., BNmXh0p0Py4">
                    <p class="mt-1 text-sm text-gray-500">Extract the ID from YouTube URL: https://www.youtube.com/watch?v=<strong>BNmXh0p0Py4</strong></p>
                </div>
                <div>
                    <label for="video_thumbnail" class="block text-sm font-medium text-gray-700">Video Thumbnail</label>
                    
                    <!-- Current Image Preview -->
                    @php
                        $currentVideoThumbnail = $videoSettings->where('key', 'video_thumbnail')->first()->value ?? '';
                    @endphp
                    @if($currentVideoThumbnail)
                        <div class="mt-2 mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current Thumbnail:</p>
                            <div class="flex items-center space-x-4">
                                <img src="{{ $currentVideoThumbnail }}" alt="Video Thumbnail" 
                                     class="w-24 h-16 object-cover rounded-md border border-gray-200">
                                <div>
                                    <p class="text-sm text-gray-500">{{ basename($currentVideoThumbnail) }}</p>
                                    <p class="text-xs text-gray-400">Click "Choose File" to replace this image</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-1 flex items-center">
                        <input type="file" id="video_thumbnail" name="video_thumbnail" accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 @error('video_thumbnail') border-red-500 @enderror">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Upload a video thumbnail (JPG, PNG, GIF, WebP). Max size: 2MB. Leave empty to keep current image.</p>
                    @error('video_thumbnail')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Promotional Banner -->
        <div id="banner" class="scroll-mt-24 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base lg:text-lg font-medium text-gray-900 mb-1">Promotional Banner</h2>
            <p class="text-sm text-gray-500 mb-4">Thin bar shown at the top of every page. Use it for announcements, free delivery thresholds, or ongoing offers.</p>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div class="lg:col-span-2">
                    <label for="banner_enabled" class="flex items-center">
                        <input type="checkbox" id="banner_enabled" name="banner_enabled" value="1"
                               {{ ($bannerSettings->where('key', 'banner_enabled')->first()->value ?? '0') == '1' ? 'checked' : '' }}
                               class="rounded-md border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm font-medium text-gray-700">Show banner on site</span>
                    </label>
                </div>
                <div class="lg:col-span-2">
                    <label for="banner_text" class="block text-sm font-medium text-gray-700">Banner Message</label>
                    <input type="text" id="banner_text" name="banner_text"
                           value="{{ $bannerSettings->where('key', 'banner_text')->first()->value ?? '' }}"
                           placeholder="e.g. Free delivery on orders over KSh 2,000 this weekend only"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="banner_cta_text" class="block text-sm font-medium text-gray-700">Button Text <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="text" id="banner_cta_text" name="banner_cta_text"
                           value="{{ $bannerSettings->where('key', 'banner_cta_text')->first()->value ?? '' }}"
                           placeholder="e.g. Shop Now"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
                <div>
                    <label for="banner_cta_url" class="block text-sm font-medium text-gray-700">Button URL <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="text" id="banner_cta_url" name="banner_cta_url"
                           value="{{ $bannerSettings->where('key', 'banner_cta_url')->first()->value ?? '/products' }}"
                           placeholder="/products"
                           class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-200">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="sticky bottom-3 z-20 flex justify-end rounded-xl border border-gray-200 bg-white/95 p-3 shadow-lg backdrop-blur">
            <button type="submit" 
                    class="w-full rounded-xl bg-gray-950 px-6 py-3 font-bold text-white transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-amber-400 sm:w-auto">
                Save all changes
            </button>
        </div>
    </form>
</div>
@endsection 

@section('scripts')
<script>
    document.querySelectorAll('[data-brand-preview]').forEach(input => {
        input.addEventListener('change', () => {
            const file = input.files && input.files[0];
            const preview = document.getElementById(input.dataset.brandPreview);
            if (!file || !preview) return;
            preview.src = URL.createObjectURL(file);
        });
    });
</script>
@endsection
