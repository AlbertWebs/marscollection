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
        <div class="pointer-events-none absolute left-0 top-0 h-full w-20 z-10"
             style="background: linear-gradient(to right, white, transparent);"></div>
        <div class="pointer-events-none absolute right-0 top-0 h-full w-20 z-10"
             style="background: linear-gradient(to left, white, transparent);"></div>

        <div class="flex flex-col gap-3"
             id="brands-outer"
             onmouseenter="document.getElementById('brands-r1').style.animationPlayState='paused'; document.getElementById('brands-r2').style.animationPlayState='paused';"
             onmouseleave="document.getElementById('brands-r1').style.animationPlayState='running'; document.getElementById('brands-r2').style.animationPlayState='running';">

            <!-- Row 1 -->
            <div class="overflow-hidden">
                <div id="brands-r1" class="brands-row flex gap-3" style="width: max-content;">
                    @foreach([1,2] as $_)
                        @foreach($row1 as $brand)
                        @php $logoUrl = str_starts_with($brand->logo, 'http') ? $brand->logo : \Storage::disk('s3')->url($brand->logo); @endphp
                        <a href="{{ route('products.index', ['brand' => $brand->slug]) }}"
                           class="flex-shrink-0 relative rounded-md overflow-hidden group"
                           style="width: 150px; height: 100px;">
                            <img src="{{ $logoUrl }}" alt="{{ $brand->name }}"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                            <div class="absolute inset-0 bg-black/45 group-hover:bg-black/60 transition-colors duration-200 flex items-center justify-center p-2">
                                <span class="text-white text-sm font-bold text-center leading-tight drop-shadow-md">{{ $brand->name }}</span>
                            </div>
                        </a>
                        @endforeach
                    @endforeach
                </div>
            </div>

            <!-- Row 2 -->
            @if($row2->count() > 0)
            <div class="overflow-hidden">
                <div id="brands-r2" class="brands-row-reverse flex gap-3" style="width: max-content;">
                    @foreach([1,2] as $_)
                        @foreach($row2 as $brand)
                        @php $logoUrl = str_starts_with($brand->logo, 'http') ? $brand->logo : \Storage::disk('s3')->url($brand->logo); @endphp
                        <a href="{{ route('products.index', ['brand' => $brand->slug]) }}"
                           class="flex-shrink-0 relative rounded-md overflow-hidden group"
                           style="width: 150px; height: 100px;">
                            <img src="{{ $logoUrl }}" alt="{{ $brand->name }}"
                                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                            <div class="absolute inset-0 bg-black/45 group-hover:bg-black/60 transition-colors duration-200 flex items-center justify-center p-2">
                                <span class="text-white text-sm font-bold text-center leading-tight drop-shadow-md">{{ $brand->name }}</span>
                            </div>
                        </a>
                        @endforeach
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</section>

<style>
.brands-row {
    animation: brands-ltr 35s linear infinite;
}
.brands-row-reverse {
    animation: brands-rtl 38s linear infinite;
}
@keyframes brands-ltr {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
@keyframes brands-rtl {
    0%   { transform: translateX(-50%); }
    100% { transform: translateX(0); }
}
</style>
@endif
