{{--
    2-row auto-scrolling product carousel
    Props: $carouselProducts (collection), $carouselId (unique string)
--}}
@php
    // Split into 2 rows: odd-indexed → row1, even-indexed → row2
    $row1 = $carouselProducts->filter(fn($p, $k) => $k % 2 === 0)->values();
    $row2 = $carouselProducts->filter(fn($p, $k) => $k % 2 === 1)->values();
@endphp

<div class="product-carousel-wrap relative" id="{{ $carouselId }}-wrap">
    <!-- Fade edges -->
    <div class="pointer-events-none absolute left-0 top-0 h-full w-16 z-10"
         style="background: linear-gradient(to right, {{ $carouselBg ?? 'white' }}, transparent);"></div>
    <div class="pointer-events-none absolute right-0 top-0 h-full w-16 z-10"
         style="background: linear-gradient(to left, {{ $carouselBg ?? 'white' }}, transparent);"></div>

    <!-- Prev / Next buttons -->
    <button type="button"
            onclick="carouselScroll('{{ $carouselId }}', -1)"
            class="carousel-btn absolute left-0 top-1/2 -translate-y-1/2 z-20 bg-white border border-gray-200 shadow-md rounded-full w-9 h-9 flex items-center justify-center hover:bg-amber-50 hover:border-amber-300 transition-colors"
            aria-label="Scroll left">
        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>
    <button type="button"
            onclick="carouselScroll('{{ $carouselId }}', 1)"
            class="carousel-btn absolute right-0 top-1/2 -translate-y-1/2 z-20 bg-white border border-gray-200 shadow-md rounded-full w-9 h-9 flex items-center justify-center hover:bg-amber-50 hover:border-amber-300 transition-colors"
            aria-label="Scroll right">
        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
    </button>

    <!-- Scrollable track (both rows move together) -->
    <div id="{{ $carouselId }}"
         class="overflow-x-auto scrollbar-hide cursor-grab active:cursor-grabbing select-none px-8"
         style="-webkit-overflow-scrolling: touch;">
        <div class="flex flex-col gap-3 pb-2" style="width: max-content;">
            <!-- Row 1 -->
            <div class="flex gap-3">
                @foreach($row1 as $product)
                    <div class="flex-shrink-0 w-40 sm:w-44">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @endforeach
                {{-- Duplicate for seamless loop --}}
                @foreach($row1 as $product)
                    <div class="flex-shrink-0 w-40 sm:w-44">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            <!-- Row 2 (offset by half a card for stagger feel) -->
            @if($row2->count() > 0)
            <div class="flex gap-3" style="margin-left: 88px;">
                @foreach($row2 as $product)
                    <div class="flex-shrink-0 w-40 sm:w-44">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @endforeach
                @foreach($row2 as $product)
                    <div class="flex-shrink-0 w-40 sm:w-44">
                        @include('components.product-card', ['product' => $product])
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
(function () {
    const id = '{{ $carouselId }}';
    const track = document.getElementById(id);
    if (!track) return;

    // ---- Auto-scroll ----
    let autoInterval;
    const SPEED = 0.6; // px per frame
    let pos = 0;
    const halfWidth = () => track.scrollWidth / 2;

    function startAuto() {
        autoInterval = setInterval(() => {
            pos += SPEED;
            if (pos >= halfWidth()) pos = 0;
            track.scrollLeft = pos;
        }, 16);
    }

    function stopAuto() { clearInterval(autoInterval); }

    startAuto();
    track.addEventListener('mouseenter', stopAuto);
    track.addEventListener('mouseleave', () => { pos = track.scrollLeft; startAuto(); });

    // ---- Drag to scroll ----
    let isDragging = false, startX = 0, startScroll = 0;

    track.addEventListener('mousedown', e => {
        stopAuto();
        isDragging = true;
        startX = e.pageX - track.offsetLeft;
        startScroll = track.scrollLeft;
        pos = track.scrollLeft;
    });
    track.addEventListener('mousemove', e => {
        if (!isDragging) return;
        const x = e.pageX - track.offsetLeft;
        track.scrollLeft = startScroll - (x - startX);
        pos = track.scrollLeft;
    });
    track.addEventListener('mouseup',   () => { isDragging = false; startAuto(); });
    track.addEventListener('mouseleave',() => { isDragging = false; });

    // Touch
    let touchStartX = 0, touchStartScroll = 0;
    track.addEventListener('touchstart', e => {
        stopAuto();
        touchStartX = e.touches[0].pageX;
        touchStartScroll = track.scrollLeft;
        pos = track.scrollLeft;
    }, { passive: true });
    track.addEventListener('touchmove', e => {
        const dx = touchStartX - e.touches[0].pageX;
        track.scrollLeft = touchStartScroll + dx;
        pos = track.scrollLeft;
    }, { passive: true });
    track.addEventListener('touchend', () => startAuto());

    // ---- Button scroll ----
    window.carouselScroll = window.carouselScroll || function(cid, dir) {
        const el = document.getElementById(cid);
        if (!el) return;
        stopAuto();
        el.scrollBy({ left: dir * 220, behavior: 'smooth' });
        pos = el.scrollLeft + dir * 220;
        setTimeout(startAuto, 1000);
    };
})();
</script>
