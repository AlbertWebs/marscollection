@php
    $brands = \App\Models\Brand::whereNotNull('logo')->where('logo', '!=', '')->get();
    $row1 = $brands->filter(fn($b, $k) => $k % 2 === 0)->values();
    $row2 = $brands->filter(fn($b, $k) => $k % 2 === 1)->values();
@endphp

@if($brands->isNotEmpty())
<section class="py-12 bg-white">
    <p class="text-center text-xs uppercase tracking-widest text-gray-400 font-medium mb-8">Brands We Carry</p>

    <div class="flex flex-col gap-3 overflow-hidden"
         onmouseenter="brandsStop()" onmouseleave="brandsStart()">

        <!-- Row 1 — scrolls left -->
        <div class="overflow-hidden">
            <div id="brands-r1" class="flex gap-3" style="width: max-content; will-change: transform;">
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

        <!-- Row 2 — scrolls right -->
        @if($row2->count() > 0)
        <div class="overflow-hidden">
            <div id="brands-r2" class="flex gap-3" style="width: max-content; will-change: transform;">
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
</section>

<script>
(function () {
    const r1 = document.getElementById('brands-r1');
    const r2 = document.getElementById('brands-r2');
    if (!r1) return;

    let p1 = 0, p2 = 0;
    const SPEED1 = 0.5;
    const SPEED2 = 0.38;
    let running = true;

    function half(el) { return el.scrollWidth / 2; }

    function tick() {
        if (running) {
            p1 += SPEED1;
            if (p1 >= half(r1)) p1 = 0;
            r1.style.transform = `translateX(-${p1}px)`;

            if (r2) {
                p2 += SPEED2;
                if (p2 >= half(r2)) p2 = 0;
                r2.style.transform = `translateX(-${p2}px)`;
            }
        }
        requestAnimationFrame(tick);
    }

    requestAnimationFrame(tick);

    window.brandsStop  = () => { running = false; };
    window.brandsStart = () => { running = true; };
})();
</script>
@endif
