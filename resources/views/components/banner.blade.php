@php
    $bannerEnabled = \App\Models\Setting::get('banner_enabled', '0');
    $bannerText    = \App\Models\Setting::get('banner_text', '');
    $bannerCta     = \App\Models\Setting::get('banner_cta_text', '');
    $bannerUrl     = \App\Models\Setting::get('banner_cta_url', '/products');
@endphp

@if($bannerEnabled && $bannerText)
<div class="bg-amber-600 text-white text-sm py-2.5 px-4">
    <div class="container mx-auto flex items-center justify-center gap-4 text-center">
        <span>{{ $bannerText }}</span>
        @if($bannerCta)
            <a href="{{ $bannerUrl }}"
               class="underline underline-offset-2 font-semibold hover:text-amber-200 transition-colors whitespace-nowrap">
                {{ $bannerCta }} →
            </a>
        @endif
    </div>
</div>
@endif
