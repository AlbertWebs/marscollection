@php
    $brands = \App\Models\Brand::whereNotNull('logo')->where('logo', '!=', '')->get();
    $row1 = $brands->filter(fn($b, $k) => $k % 2 === 0)->values();
    $row2 = $brands->filter(fn($b, $k) => $k % 2 === 1)->values();
@endphp

@if($brands->isNotEmpty())
<section class="py-12 bg-white">
    <p class="text-center text-xs uppercase tracking-widest text-gray-400 font-medium mb-8">Brands We Carry</p>

    <div class="flex flex-col gap-3 overflow-hidden"
         onmouseenter="brandsRunning=false" onmouseleave="brandsRunning=true">

        <!-- Row 1 -->
        <div class="overflow-hidden">
            <div id="brands-r1" class="flex gap-3" style="width: max-content; will-change: transform;">
                @foreach([1,2,3] as $_)
                    @foreach($row1 as $brand)
                    @php $logoUrl = \App\Helpers\ImageHelper::getProductImageUrl($brand->logo); @endphp
                    <a href="{{ route('brands.show', $brand) }}"
                       class="brand-card flex-shrink-0 relative rounded-md overflow-hidden group"
                       style="width: 150px; height: 100px;">
                        <img src="{{ $logoUrl }}" alt="{{ $brand->name }}"
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                        <div class="absolute inset-0 bg-black/45 group-hover:bg-black/60 transition-colors duration-200 flex items-center justify-center p-2">
                            <span class="text-white text-base font-bold text-center leading-tight drop-shadow-md">{{ $brand->name }}</span>
                        </div>
                    </a>
                    @endforeach
                @endforeach
            </div>
        </div>

        <!-- Row 2 -->
        @if($row2->count() > 0)
        <div class="overflow-hidden">
            <div id="brands-r2" class="flex gap-3" style="width: max-content; will-change: transform;">
                @foreach([1,2,3] as $_)
                    @foreach($row2 as $brand)
                    @php $logoUrl = \App\Helpers\ImageHelper::getProductImageUrl($brand->logo); @endphp
                    <a href="{{ route('brands.show', $brand) }}"
                       class="brand-card flex-shrink-0 relative rounded-md overflow-hidden group"
                       style="width: 150px; height: 100px;">
                        <img src="{{ $logoUrl }}" alt="{{ $brand->name }}"
                             class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105" loading="lazy">
                        <div class="absolute inset-0 bg-black/45 group-hover:bg-black/60 transition-colors duration-200 flex items-center justify-center p-2">
                            <span class="text-white text-base font-bold text-center leading-tight drop-shadow-md">{{ $brand->name }}</span>
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
    var r1 = document.getElementById('brands-r1');
    var r2 = document.getElementById('brands-r2');
    if (!r1) return;

    var p1 = 0, p2 = 0;
    var unit1, unit2; // width of ONE set of brands
    window.brandsRunning = true;

    function measure() {
        // Each row has 3 copies. One copy = scrollWidth / 3
        unit1 = r1.scrollWidth / 3;
        if (r2) unit2 = r2.scrollWidth / 3;
    }

    function tick() {
        if (window.brandsRunning) {
            p1 += 0.5;
            if (unit1 && p1 >= unit1) p1 -= unit1;
            r1.style.transform = 'translateX(-' + p1 + 'px)';

            if (r2) {
                p2 += 0.38;
                if (unit2 && p2 >= unit2) p2 -= unit2;
                r2.style.transform = 'translateX(-' + p2 + 'px)';
            }
        }
        requestAnimationFrame(tick);
    }

    // Measure after all images in section have loaded (or after 1s fallback)
    var images = document.querySelectorAll('.brand-card img');
    var loaded = 0;
    function onLoad() {
        loaded++;
        if (loaded >= images.length) measure();
    }
    images.forEach(function(img) {
        if (img.complete) { onLoad(); }
        else { img.addEventListener('load', onLoad); img.addEventListener('error', onLoad); }
    });
    setTimeout(measure, 800); // fallback

    requestAnimationFrame(tick);
})();
</script>
@endif
