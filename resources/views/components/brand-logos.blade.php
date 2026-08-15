@php
    $brands = \App\Models\Brand::whereNotNull('logo')->where('logo', '!=', '')->get();
    $row1 = $brands->filter(fn($b, $k) => $k % 2 === 0)->values();
    $row2 = $brands->filter(fn($b, $k) => $k % 2 === 1)->values();
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

        <!-- Both rows scroll together in one track -->
        <div id="brands-track" class="flex flex-col gap-3" style="width: max-content; animation: brands-scroll 40s linear infinite;">

            @foreach([1, 2] as $_)
            <!-- Row 1 -->
            <div class="flex gap-3">
                @foreach($row1 as $brand)
                @php $logoUrl = str_starts_with($brand->logo, 'http') ? $brand->logo : \Storage::disk('s3')->url($brand->logo); @endphp
                <a href="{{ route('products.index', ['brand' => $brand->slug]) }}"
                   class="flex-shrink-0 relative rounded-md overflow-hidden group"
                   style="width: 140px; height: 96px;">
                    <img src="{{ $logoUrl }}" alt="{{ $brand->name }}"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/55 transition-colors duration-200 flex items-center justify-center">
                        <span class="text-white text-xs font-bold text-center px-2 drop-shadow leading-tight">{{ $brand->name }}</span>
                    </div>
                </a>
                @endforeach
            </div>

            @if($row2->count() > 0)
            <!-- Row 2 (offset for stagger) -->
            <div class="flex gap-3" style="margin-left: 76px;">
                @foreach($row2 as $brand)
                @php $logoUrl = str_starts_with($brand->logo, 'http') ? $brand->logo : \Storage::disk('s3')->url($brand->logo); @endphp
                <a href="{{ route('products.index', ['brand' => $brand->slug]) }}"
                   class="flex-shrink-0 relative rounded-md overflow-hidden group"
                   style="width: 140px; height: 96px;">
                    <img src="{{ $logoUrl }}" alt="{{ $brand->name }}"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/55 transition-colors duration-200 flex items-center justify-center">
                        <span class="text-white text-xs font-bold text-center px-2 drop-shadow leading-tight">{{ $brand->name }}</span>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
            @endforeach

        </div>
    </div>
</section>

<style>
@keyframes brands-scroll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
#brands-track:hover {
    animation-play-state: paused;
}
</style>
@endif
