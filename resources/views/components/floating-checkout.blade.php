<a id="floating-checkout" href="{{ route('cart.index') }}" aria-hidden="true" tabindex="-1"
   class="fixed bottom-5 left-1/2 z-[100000] flex w-[calc(100%-2rem)] max-w-sm -translate-x-1/2 translate-y-8 scale-95 items-center gap-3 rounded-full bg-gray-950 p-2 pl-4 text-white opacity-0 shadow-2xl ring-1 ring-white/15 transition-[opacity,transform] duration-500 ease-out pointer-events-none sm:bottom-7"
   style="padding-bottom: max(0.5rem, env(safe-area-inset-bottom));"
   aria-label="Checkout, 0 items in cart">
    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-amber-400 text-gray-950 shadow-inner">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3h2l2.2 11.1a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 1.9-1.4L21 8H6M10 20h.01M18 20h.01"/>
        </svg>
    </span>
    <span class="min-w-0 flex-1 leading-tight">
        <span class="block text-sm font-extrabold uppercase tracking-wide">Checkout</span>
        <span id="floating-checkout-count" class="mt-0.5 block text-xs text-gray-300">0 items in your cart</span>
    </span>
    <span class="mr-1 flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-400 text-gray-950 transition-transform duration-300 group-hover:translate-x-0.5" aria-hidden="true">
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
    </span>
</a>

<style>
    @keyframes floating-checkout-arrive {
        0% { transform: translate(-50%, 2rem) scale(.94); opacity: 0; }
        65% { transform: translate(-50%, -.3rem) scale(1.02); opacity: 1; }
        100% { transform: translate(-50%, 0) scale(1); opacity: 1; }
    }
    #floating-checkout.is-visible {
        transform: translate(-50%, 0) scale(1);
        opacity: 1;
        pointer-events: auto;
        animation: floating-checkout-arrive .55s cubic-bezier(.2,.8,.2,1) both;
    }
    @media (prefers-reduced-motion: reduce) {
        #floating-checkout { transition: none; }
        #floating-checkout.is-visible { animation: none; }
    }
</style>

<script>
(() => {
    const checkout = document.getElementById('floating-checkout');
    const countLabel = document.getElementById('floating-checkout-count');
    if (!checkout || !countLabel) return;

    const update = count => {
        const quantity = Number(count) || 0;
        countLabel.textContent = `${quantity} ${quantity === 1 ? 'item' : 'items'} in your cart`;
        checkout.setAttribute('aria-label', `Checkout, ${quantity} ${quantity === 1 ? 'item' : 'items'} in cart`);
        checkout.setAttribute('aria-hidden', quantity > 0 ? 'false' : 'true');
        checkout.tabIndex = quantity > 0 ? 0 : -1;
        checkout.classList.toggle('is-visible', quantity > 0);
    };

    window.addEventListener('cartCountChanged', event => update(event.detail?.count));
    fetch('{{ route('cart.count') }}', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' })
        .then(response => response.ok ? response.json() : { count: 0 })
        .then(data => update(data.count))
        .catch(() => update(0));
})();
</script>
