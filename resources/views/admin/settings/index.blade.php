@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Settings</h1>
    </div>



    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')
        
        <!-- Contact Settings -->
        <div class="bg-white shadow rounded-lg p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-medium text-gray-900 mb-4">Contact Information</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label for="contact_phone_primary" class="block text-sm font-medium text-gray-700">Primary Phone</label>
                    <input type="text" id="contact_phone_primary" name="contact_phone_primary" 
                           value="{{ $contactSettings->where('key', 'contact_phone_primary')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="contact_phone_secondary" class="block text-sm font-medium text-gray-700">Secondary Phone</label>
                    <input type="text" id="contact_phone_secondary" name="contact_phone_secondary" 
                           value="{{ $contactSettings->where('key', 'contact_phone_secondary')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="contact_email_primary" class="block text-sm font-medium text-gray-700">Primary Email</label>
                    <input type="email" id="contact_email_primary" name="contact_email_primary" 
                           value="{{ $contactSettings->where('key', 'contact_email_primary')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="contact_email_support" class="block text-sm font-medium text-gray-700">Support Email</label>
                    <input type="email" id="contact_email_support" name="contact_email_support" 
                           value="{{ $contactSettings->where('key', 'contact_email_support')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div class="md:col-span-2">
                    <label for="contact_address_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                    <input type="text" id="contact_address_name" name="contact_address_name" 
                           value="{{ $contactSettings->where('key', 'contact_address_name')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div class="md:col-span-2">
                    <label for="contact_address_street" class="block text-sm font-medium text-gray-700">Street Address</label>
                    <input type="text" id="contact_address_street" name="contact_address_street" 
                           value="{{ $contactSettings->where('key', 'contact_address_street')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div class="md:col-span-2">
                    <label for="contact_address_city" class="block text-sm font-medium text-gray-700">City & Country</label>
                    <input type="text" id="contact_address_city" name="contact_address_city" 
                           value="{{ $contactSettings->where('key', 'contact_address_city')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div class="md:col-span-2">
                    <label for="contact_address_full" class="block text-sm font-medium text-gray-700">Full Address</label>
                    <textarea id="contact_address_full" name="contact_address_full" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">{{ $contactSettings->where('key', 'contact_address_full')->first()->value ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Business Settings -->
        <div class="bg-white shadow rounded-lg p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-medium text-gray-900 mb-4">Business Information</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label for="business_name" class="block text-sm font-medium text-gray-700">Business Name</label>
                    <input type="text" id="business_name" name="business_name" 
                           value="{{ $businessSettings->where('key', 'business_name')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="business_hours_monday_friday" class="block text-sm font-medium text-gray-700">Monday - Friday Hours</label>
                    <input type="text" id="business_hours_monday_friday" name="business_hours_monday_friday" 
                           value="{{ $businessSettings->where('key', 'business_hours_monday_friday')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="business_hours_saturday" class="block text-sm font-medium text-gray-700">Saturday Hours</label>
                    <input type="text" id="business_hours_saturday" name="business_hours_saturday" 
                           value="{{ $businessSettings->where('key', 'business_hours_saturday')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="business_hours_sunday" class="block text-sm font-medium text-gray-700">Sunday Hours</label>
                    <input type="text" id="business_hours_sunday" name="business_hours_sunday" 
                           value="{{ $businessSettings->where('key', 'business_hours_sunday')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div class="md:col-span-2">
                    <label for="business_note" class="block text-sm font-medium text-gray-700">Business Note</label>
                    <textarea id="business_note" name="business_note" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">{{ $businessSettings->where('key', 'business_note')->first()->value ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Email Settings -->
        <div class="bg-white shadow rounded-lg p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-medium text-gray-900 mb-4">Email Settings</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label for="email_admin" class="block text-sm font-medium text-gray-700">Admin Email</label>
                    <input type="email" id="email_admin" name="email_admin" 
                           value="{{ $emailSettings->where('key', 'email_admin')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="email_from_name" class="block text-sm font-medium text-gray-700">From Name</label>
                    <input type="text" id="email_from_name" name="email_from_name" 
                           value="{{ $emailSettings->where('key', 'email_from_name')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div class="md:col-span-2">
                    <label for="email_from_address" class="block text-sm font-medium text-gray-700">From Address</label>
                    <input type="email" id="email_from_address" name="email_from_address" 
                           value="{{ $emailSettings->where('key', 'email_from_address')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
            </div>
        </div>

        <!-- Social Media Settings -->
        <div class="bg-white shadow rounded-lg p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-medium text-gray-900 mb-4">Social Media</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                <div>
                    <label for="social_facebook" class="block text-sm font-medium text-gray-700">Facebook URL</label>
                    <input type="url" id="social_facebook" name="social_facebook" 
                           value="{{ $socialSettings->where('key', 'social_facebook')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="social_instagram" class="block text-sm font-medium text-gray-700">Instagram URL</label>
                    <input type="url" id="social_instagram" name="social_instagram" 
                           value="{{ $socialSettings->where('key', 'social_instagram')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="social_twitter" class="block text-sm font-medium text-gray-700">Twitter URL</label>
                    <input type="url" id="social_twitter" name="social_twitter" 
                           value="{{ $socialSettings->where('key', 'social_twitter')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
            </div>
        </div>

        <!-- Hero Section Settings -->
        <div class="bg-white shadow rounded-lg p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-medium text-gray-900 mb-4">Hero Section</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div class="md:col-span-2">
                    <label for="hero_enabled" class="flex items-center">
                        <input type="checkbox" id="hero_enabled" name="hero_enabled" value="1"
                               {{ ($heroSettings->where('key', 'hero_enabled')->first()->value ?? '1') == '1' ? 'checked' : '' }}
                               class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm font-medium text-gray-700">Enable Hero Section</span>
                    </label>
                </div>
                <div class="md:col-span-2">
                    <label for="hero_title" class="block text-sm font-medium text-gray-700">Hero Title</label>
                    <input type="text" id="hero_title" name="hero_title" 
                           value="{{ $heroSettings->where('key', 'hero_title')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div class="md:col-span-2">
                    <label for="hero_subtitle" class="block text-sm font-medium text-gray-700">Hero Description</label>
                    <textarea id="hero_subtitle" name="hero_subtitle" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">{{ $heroSettings->where('key', 'hero_subtitle')->first()->value ?? '' }}</textarea>
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
                                     class="w-32 h-20 object-cover rounded-lg border border-gray-200">
                                <div>
                                    <p class="text-sm text-gray-500">{{ basename($currentHeroImage) }}</p>
                                    <p class="text-xs text-gray-400">Click "Choose File" to replace this image</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-1 flex items-center">
                        <input type="file" id="hero_image" name="hero_image" accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 @error('hero_image') border-red-500 @enderror">
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
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="hero_stats_products" class="block text-sm font-medium text-gray-700">Premium Products Count</label>
                    <input type="text" id="hero_stats_products" name="hero_stats_products" 
                           value="{{ $heroSettings->where('key', 'hero_stats_products')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="hero_stats_rating" class="block text-sm font-medium text-gray-700">Average Rating</label>
                    <input type="text" id="hero_stats_rating" name="hero_stats_rating" 
                           value="{{ $heroSettings->where('key', 'hero_stats_rating')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
            </div>
        </div>

        <!-- Video Section Settings -->
        <div class="bg-white shadow rounded-lg p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-medium text-gray-900 mb-4">Video Section</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div class="md:col-span-2">
                    <label for="video_enabled" class="flex items-center">
                        <input type="checkbox" id="video_enabled" name="video_enabled" value="1"
                               {{ ($videoSettings->where('key', 'video_enabled')->first()->value ?? '1') == '1' ? 'checked' : '' }}
                               class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm font-medium text-gray-700">Enable Video Section</span>
                    </label>
                </div>
                <div class="md:col-span-2">
                    <label for="video_title" class="block text-sm font-medium text-gray-700">Video Section Title</label>
                    <input type="text" id="video_title" name="video_title" 
                           value="{{ $videoSettings->where('key', 'video_title')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div class="md:col-span-2">
                    <label for="video_description" class="block text-sm font-medium text-gray-700">Video Description</label>
                    <textarea id="video_description" name="video_description" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">{{ $videoSettings->where('key', 'video_description')->first()->value ?? '' }}</textarea>
                </div>
                <div>
                    <label for="video_youtube_id" class="block text-sm font-medium text-gray-700">YouTube Video ID</label>
                    <input type="text" id="video_youtube_id" name="video_youtube_id" 
                           value="{{ $videoSettings->where('key', 'video_youtube_id')->first()->value ?? '' }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500"
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
                                     class="w-24 h-16 object-cover rounded-lg border border-gray-200">
                                <div>
                                    <p class="text-sm text-gray-500">{{ basename($currentVideoThumbnail) }}</p>
                                    <p class="text-xs text-gray-400">Click "Choose File" to replace this image</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-1 flex items-center">
                        <input type="file" id="video_thumbnail" name="video_thumbnail" accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 @error('video_thumbnail') border-red-500 @enderror">
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Upload a video thumbnail (JPG, PNG, GIF, WebP). Max size: 2MB. Leave empty to keep current image.</p>
                    @error('video_thumbnail')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Promotional Banner -->
        <div class="bg-white shadow rounded-lg p-4 lg:p-6">
            <h2 class="text-base lg:text-lg font-medium text-gray-900 mb-1">Promotional Banner</h2>
            <p class="text-sm text-gray-500 mb-4">Thin bar shown at the top of every page. Use it for announcements, free delivery thresholds, or ongoing offers.</p>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div class="lg:col-span-2">
                    <label for="banner_enabled" class="flex items-center">
                        <input type="checkbox" id="banner_enabled" name="banner_enabled" value="1"
                               {{ ($bannerSettings->where('key', 'banner_enabled')->first()->value ?? '0') == '1' ? 'checked' : '' }}
                               class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-300 focus:ring focus:ring-pink-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm font-medium text-gray-700">Show banner on site</span>
                    </label>
                </div>
                <div class="lg:col-span-2">
                    <label for="banner_text" class="block text-sm font-medium text-gray-700">Banner Message</label>
                    <input type="text" id="banner_text" name="banner_text"
                           value="{{ $bannerSettings->where('key', 'banner_text')->first()->value ?? '' }}"
                           placeholder="e.g. Free delivery on orders over KSh 2,000 this weekend only"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="banner_cta_text" class="block text-sm font-medium text-gray-700">Button Text <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="text" id="banner_cta_text" name="banner_cta_text"
                           value="{{ $bannerSettings->where('key', 'banner_cta_text')->first()->value ?? '' }}"
                           placeholder="e.g. Shop Now"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
                <div>
                    <label for="banner_cta_url" class="block text-sm font-medium text-gray-700">Button URL <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="text" id="banner_cta_url" name="banner_cta_url"
                           value="{{ $bannerSettings->where('key', 'banner_cta_url')->first()->value ?? '/products' }}"
                           placeholder="/products"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-pink-500 focus:border-pink-500">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" 
                    class="bg-pink-600 hover:bg-pink-700 text-white px-4 lg:px-6 py-2 rounded-lg font-medium w-full sm:w-auto">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection 
