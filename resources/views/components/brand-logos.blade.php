@php
    $brands = \App\Models\Brand::whereNotNull('logo')->where('logo', '!=', '')->get();
@endphp

@if($brands->isNotEmpty())
<section class="py-12 bg-white overflow-hidden">
    <p class="text-center text-xs uppercase tracking-widest text-gray-400 font-medium mb-8">Brands We Carry</p>

    <div class="relative">
        <!-- Fade edges -->
        <div class="pointer-events-none absolute left-0 top-0 h-full w-24 z-10"
             style="background: linear-gradient(to right, white, transparent);"></div>
        <div class="pointer-events-none absolute right-0 top-0 h-full w-24 z-10"
             style="background: linear-gradient(to left, white, transparent);"></div>

        <!-- Marquee track -->
        <div class="marquee-track flex items-stretch gap-3" style="width: max-content;">
            @foreach([1,2] as $_)
                @foreach($brands as $brand)
                @php
                    $logoUrl = str_starts_with($brand->logo, 'http')
                        ? $brand->logo
                        : \Storage::disk('s3')->url($brand->logo);
                @endphp
                <a href="{{ route('products.index', ['brand' => $brand->slug]) }}"
                   class="flex-shrink-0 relative rounded-md overflow-hidden group"
                   style="width: 140px; height: 100px;"
                   title="{{ $brand->name }}">
                    <!-- Brand image fills card -->
                    <img src="{{ $logoUrl }}"
                         alt="{{ $brand->name }}"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                         loading="lazy">
                    <!-- Dark gradient overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                    <!-- Brand name bottom-left -->
                    <span class="absolute bottom-2 left-2.5 text-white text-xs font-semibold drop-shadow leading-tight">
                        {{ $brand->name }}
                    </span>
                </a>
                @endforeach
            @endforeach
        </div>
    </div>
</section>

<style>
.marquee-track {
    animation: marquee-scroll 35s linear infinite;
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
