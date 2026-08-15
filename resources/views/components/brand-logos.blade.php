@php
    $brands = \App\Models\Brand::whereNotNull('logo')->where('logo', '!=', '')->get();
@endphp

@if($brands->isNotEmpty())
<section class="py-12 border-y border-gray-100 bg-white overflow-hidden">
    <p class="text-center text-xs uppercase tracking-widest text-gray-400 font-medium mb-8">Brands We Carry</p>

    <div class="relative">
        <!-- Fade edges -->
        <div class="pointer-events-none absolute left-0 top-0 h-full w-24 z-10"
             style="background: linear-gradient(to right, white, transparent);"></div>
        <div class="pointer-events-none absolute right-0 top-0 h-full w-24 z-10"
             style="background: linear-gradient(to left, white, transparent);"></div>

        <!-- Marquee track -->
        <div class="marquee-track flex items-center gap-16" style="width: max-content;">
            {{-- Rendered twice for seamless loop --}}
            @foreach([1,2] as $_)
                @foreach($brands as $brand)
                    <a href="{{ route('products.index', ['brand' => $brand->slug]) }}"
                       title="{{ $brand->name }}"
                       class="flex-shrink-0">
                        <img src="{{ str_starts_with($brand->logo, 'http') ? $brand->logo : \Storage::disk('s3')->url($brand->logo) }}"
                             alt="{{ $brand->name }}"
                             class="h-12 w-auto object-contain grayscale hover:grayscale-0 opacity-50 hover:opacity-100 transition-all duration-300"
                             loading="lazy">
                    </a>
                @endforeach
            @endforeach
        </div>
    </div>
</section>

<style>
.marquee-track {
    animation: marquee-scroll 30s linear infinite;
}
.marquee-track:hover {
    animation-play-state: paused;
}
@keyframes marquee-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
</style>
@endif
