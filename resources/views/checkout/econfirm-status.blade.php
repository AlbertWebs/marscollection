@extends('layouts.app')

@section('title', 'Confirming Your Payment | Mars Collection')
@section('robots', 'noindex, nofollow')
@section('content')
<main class="min-h-[65vh] bg-stone-50 px-4 py-12 sm:py-16">
    <section class="mx-auto max-w-xl rounded-3xl border border-stone-200 bg-white p-6 text-center shadow-sm sm:p-10">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-700">
            <svg class="h-8 w-8 animate-pulse" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v2m0 14v2m9-9h-2M5 12H3m15.36-6.36-1.42 1.42M7.06 16.94l-1.42 1.42m12.72 0-1.42-1.42M7.06 7.06 5.64 5.64M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"/>
            </svg>
        </div>
        <p class="mt-6 text-xs font-bold uppercase tracking-[0.2em] text-emerald-700">Secure payment confirmation</p>
        <h1 class="mt-2 text-2xl font-black text-stone-950 sm:text-3xl">Confirming your payment</h1>
        <p class="mt-3 text-stone-600">Order <strong class="text-stone-900">{{ $payment->order->order_number }}</strong> is being confirmed with eConfirm. This usually takes a few moments.</p>
        <div class="mt-6 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-left text-sm leading-6 text-emerald-950" role="status" aria-live="polite">
            <p id="econfirm-status-message">We are checking your payment automatically. Please do not pay again while this is pending.</p>
        </div>
        <div class="mt-7 h-1.5 overflow-hidden rounded-full bg-stone-100" aria-hidden="true"><div class="h-full w-1/3 animate-pulse rounded-full bg-emerald-600"></div></div>
        <div class="mt-7 flex flex-wrap justify-center gap-3">
            <button id="econfirm-check-now" type="button" class="rounded-xl bg-stone-950 px-5 py-3 text-sm font-bold text-white transition hover:bg-stone-800">Check now</button>
            <a href="{{ route('home') }}" class="rounded-xl border border-stone-200 px-5 py-3 text-sm font-bold text-stone-700 transition hover:bg-stone-50">Continue shopping</a>
        </div>
        <p class="mt-5 text-xs leading-5 text-stone-500">You can leave this page; we have saved your order. We will only confirm it after eConfirm verifies the escrow funding.</p>
    </section>
</main>
<script>
(() => {
    const statusUrl = @js(route('checkout.econfirm.status', $payment->public_id));
    const completeUrl = @js(route('checkout.econfirm.complete', $payment->public_id));
    const message = document.getElementById('econfirm-status-message');
    const button = document.getElementById('econfirm-check-now');
    let delay = 2500;
    let busy = false;
    let timer;

    async function checkStatus() {
        if (busy) return;
        busy = true;
        button.disabled = true;
        button.textContent = 'Checking…';
        try {
            const response = await fetch(statusUrl, {
                method: 'POST',
                credentials: 'same-origin',
                cache: 'no-store',
                headers: {
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
            });
            if (!response.ok) throw new Error('Status check unavailable');
            const result = await response.json();
            if (result.status === 'funded') {
                message.textContent = 'Payment confirmed. Taking you to your order…';
                window.location.replace(completeUrl);
                return;
            }
            if (['failed', 'setup_required'].includes(result.status)) {
                message.textContent = 'We could not confirm this payment yet. Your order is saved. Please contact support before attempting another payment.';
            } else {
                message.textContent = 'We are checking your payment automatically. Please do not pay again while this is pending.';
            }
        } catch (error) {
            message.textContent = 'The status check was interrupted. We will retry automatically; please do not pay again while confirmation is pending.';
        } finally {
            busy = false;
            button.disabled = false;
            button.textContent = 'Check now';
            clearTimeout(timer);
            timer = window.setTimeout(checkStatus, delay);
            delay = Math.min(Math.round(delay * 1.5), 10000);
        }
    }

    button.addEventListener('click', () => {
        clearTimeout(timer);
        void checkStatus();
    });
    void checkStatus();
})();
</script>
@endsection
