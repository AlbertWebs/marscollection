@extends('layouts.app')

@section('robots', 'noindex, nofollow')
@section('content')
<main class="min-h-screen bg-stone-50 px-4 py-8 sm:py-12">
    <div class="mx-auto max-w-4xl">
        <a href="{{ route('cart.index') }}" class="text-sm font-medium text-amber-700 hover:text-amber-800">← Back to cart</a>
        <div class="mt-5 overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
            <div class="flex flex-col gap-2 border-b border-stone-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                <div>
                    <h1 class="text-xl font-bold text-stone-900">Secure checkout</h1>
                    <p class="mt-1 text-sm text-stone-600">Order {{ $payment->order->order_number }} · KES {{ number_format((float) $payment->amount) }}</p>
                </div>
                <span class="inline-flex w-fit items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800">Hosted securely by eConfirm</span>
            </div>
            <iframe id="econfirm-checkout" title="Secure eConfirm hosted checkout" class="block h-[72vh] min-h-[560px] w-full border-0 bg-white"></iframe>
            <div class="border-t border-stone-200 px-5 py-4 text-center text-xs text-stone-500 sm:px-7">
                Keep this page open until checkout confirms your payment. Your order is processed only after eConfirm verifies the funds.
            </div>
        </div>
    </div>
</main>
<script>
(() => {
    const checkout = @js($checkout);
    const frame = document.getElementById('econfirm-checkout');
    const checkoutOrigin = new URL(checkout.checkout_url).origin;
    const completeUrl = @js(route('checkout.econfirm.complete', $payment->public_id));

    frame.src = checkout.checkout_url + '#secret=' + encodeURIComponent(checkout.checkout_secret);

    window.addEventListener('message', (event) => {
        if (event.origin !== checkoutOrigin || event.source !== frame.contentWindow || event.data?.source !== 'econfirm') return;
        if (event.data.event === 'checkout.completed' && event.data.status === 'funded') {
            window.location.assign(completeUrl);
        }
        if (event.data.event === 'checkout.closed') {
            window.location.assign(@js(route('cart.index')));
        }
    });
})();
</script>
@endsection
