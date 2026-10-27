@extends('layouts.app')

@section('title', 'Buy with Escrow | Mars Collection')
@section('robots', 'noindex, nofollow')

@section('content')
<main class="min-h-[70vh] bg-stone-50 px-4 py-8 sm:py-12">
    <div class="mx-auto w-[90vw] max-w-none">
        <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-stone-600 hover:text-stone-950">
            <span aria-hidden="true">←</span> Back to cart
        </a>

        <section class="mt-5 overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="flex flex-col gap-3 border-b border-stone-100 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                <div>
                    <h1 class="text-xl font-black text-stone-950 sm:text-2xl">Buy with Escrow</h1>
                    <p class="mt-1 text-sm text-stone-600">Complete your secure eConfirm payment here without leaving Mars Collection.</p>
                </div>
                <p class="shrink-0 rounded-full bg-amber-50 px-4 py-2 text-sm font-extrabold text-amber-900">KES {{ number_format($payment->amount) }}</p>
            </div>

            <div class="relative bg-stone-100 p-2 sm:p-4">
                <iframe
                    id="econfirm-checkout"
                    title="eConfirm secure escrow checkout"
                    class="h-[85vh] min-h-[760px] w-full rounded-xl border border-stone-200 bg-white"
                    loading="eager"
                    referrerpolicy="strict-origin-when-cross-origin"
                    allow="payment"
                ></iframe>
                <div id="econfirm-closed" class="absolute inset-2 hidden items-center justify-center rounded-xl bg-white/95 p-6 text-center sm:inset-4">
                    <div class="max-w-sm">
                        <h2 class="text-lg font-extrabold text-stone-950">Checkout closed</h2>
                        <p class="mt-2 text-sm leading-6 text-stone-600">Your cart and delivery details are saved. You can reopen the secure checkout or return to your cart.</p>
                        <button id="econfirm-retry" type="button" class="mt-5 rounded-xl bg-stone-950 px-5 py-3 text-sm font-bold text-white hover:bg-amber-700">Reopen checkout</button>
                        <a href="{{ route('cart.index') }}" class="ml-3 inline-flex px-2 py-3 text-sm font-bold text-stone-700 hover:text-stone-950">Return to cart</a>
                    </div>
                </div>
            </div>
            <p class="px-5 py-4 text-xs leading-5 text-stone-500 sm:px-7">Your payment is handled securely by eConfirm. We verify escrow funding with eConfirm before confirming your order.</p>
        </section>
    </div>
</main>

<script>
(() => {
    const checkout = @js($checkout);
    const frame = document.getElementById('econfirm-checkout');
    const closedPanel = document.getElementById('econfirm-closed');
    const completeUrl = @js(route('checkout.econfirm.complete', $payment->public_id));
    const checkoutUrl = new URL(checkout.checkout_url);
    const checkoutOrigin = checkoutUrl.origin;

    function openCheckout() {
        closedPanel.classList.add('hidden');
        closedPanel.classList.remove('flex');
        frame.src = checkoutUrl.href + '#secret=' + encodeURIComponent(checkout.checkout_secret);
    }

    document.getElementById('econfirm-retry').addEventListener('click', openCheckout);
    window.addEventListener('message', (event) => {
        if (event.origin !== checkoutOrigin || event.source !== frame.contentWindow || event.data?.source !== 'econfirm') return;

        if (event.data.event === 'checkout.completed' && event.data.status === 'funded') {
            window.location.assign(completeUrl);
        } else if (event.data.event === 'checkout.closed') {
            frame.removeAttribute('src');
            closedPanel.classList.remove('hidden');
            closedPanel.classList.add('flex');
        }
    });

    openCheckout();
})();
</script>
@endsection
