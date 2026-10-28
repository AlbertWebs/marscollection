@extends('layouts.app')

@section('title', 'Buy with Escrow | Mars Collection')
@section('robots', 'noindex, nofollow')

@section('content')
<main class="w-full bg-white">
    <iframe
        id="econfirm-checkout"
        title="eConfirm secure escrow checkout"
        class="block h-[85vh] min-h-[760px] w-full border-0 bg-white"
        loading="eager"
        referrerpolicy="strict-origin-when-cross-origin"
        allow="payment"
    ></iframe>
</main>

<script>
(() => {
    const checkout = @js($checkout);
    const frame = document.getElementById('econfirm-checkout');
    const completeUrl = @js(route('checkout.econfirm.complete', $payment->public_id));
    const statusUrl = @js(route('checkout.econfirm.status', $payment->public_id));
    const checkoutUrl = new URL(checkout.checkout_url);
    const checkoutOrigin = checkoutUrl.origin;
    let pollStarted = false;
    let polling = false;
    let pollDelay = 2500;

    function openCheckout() {
        frame.src = checkoutUrl.href + '#secret=' + encodeURIComponent(checkout.checkout_secret);
    }

    function startConfirmation() {
        if (pollStarted) return;
        pollStarted = true;
        void checkFunding();
    }

    async function checkFunding() {
        if (polling) return;
        polling = true;
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
            if (!response.ok) throw new Error('Payment status is temporarily unavailable.');
            const result = await response.json();
            if (result.status === 'funded') {
                window.location.replace(completeUrl);
                return;
            }
        } catch (error) {
            // Keep polling; the hosted checkout remains visible inside the iframe.
        } finally {
            polling = false;
            if (pollStarted) {
                window.setTimeout(checkFunding, pollDelay);
                pollDelay = Math.min(Math.round(pollDelay * 1.5), 10000);
            }
        }
    }

    window.addEventListener('message', (event) => {
        if (event.origin !== checkoutOrigin || event.source !== frame.contentWindow || event.data?.source !== 'econfirm') return;

        if ((event.data.event === 'checkout.completed' || event.data.event === 'checkout.return') && event.data.status === 'funded') {
            startConfirmation();
        }
    });

    openCheckout();
})();
</script>
@endsection
