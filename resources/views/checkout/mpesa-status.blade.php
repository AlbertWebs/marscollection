@extends('layouts.app')

@section('title', 'M-Pesa Payment Status | Mars Collection')
@section('robots', 'noindex, nofollow')
@section('canonical', route('checkout.mpesa.status', $payment->public_id))

@section('head')
    @if(in_array($payment->status, ['pending', 'initiated'], true))
        <meta http-equiv="refresh" content="8">
    @endif
@endsection

@section('content')
@php
    $isPaid = $payment->status === 'succeeded';
    $isWaiting = in_array($payment->status, ['pending', 'initiated'], true);
    $isSetup = $payment->status === 'setup_required';
@endphp
<main class="flex min-h-[75vh] items-center justify-center bg-[#f6f7f4] px-4 py-12 sm:px-6">
    <section class="w-full max-w-2xl overflow-hidden rounded-[2rem] border border-stone-200 bg-white shadow-2xl shadow-stone-900/10">
        <div class="relative overflow-hidden px-6 py-10 text-center sm:px-12 sm:py-14 {{ $isPaid ? 'bg-gradient-to-br from-emerald-800 to-emerald-600' : ($isWaiting ? 'bg-gradient-to-br from-stone-950 to-stone-800' : 'bg-gradient-to-br from-amber-800 to-amber-600') }} text-white">
            <div class="pointer-events-none absolute -right-20 -top-28 h-72 w-72 rounded-full border border-white/10"></div>
            <div class="relative mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-white/15 ring-1 ring-white/25">
                @if($isPaid)
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="m5 12 4 4L19 6"/></svg>
                @elseif($isWaiting)
                    <svg class="h-8 w-8 animate-pulse" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m5-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                @else
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v4m0 4h.01M10.3 3.9 1.8 18.6A1.6 1.6 0 0 0 3.2 21h17.6a1.6 1.6 0 0 0 1.4-2.4L13.7 3.9a2 2 0 0 0-3.4 0Z"/></svg>
                @endif
            </div>
            <p class="relative mt-5 text-xs font-bold uppercase tracking-[0.22em] text-white/70">{{ $isPaid ? 'Payment confirmed' : ($isWaiting ? 'Waiting for confirmation' : ($isSetup ? 'Payment setup required' : 'Payment not completed')) }}</p>
            <h1 class="relative mt-2 text-3xl font-black tracking-tight sm:text-4xl">{{ $isPaid ? 'You’re all set.' : ($isWaiting ? 'Check your phone.' : ($isSetup ? 'STK is not ready yet.' : 'Let’s try that again.')) }}</h1>
            <p class="relative mx-auto mt-3 max-w-md text-sm leading-6 text-white/80">
                {{ $isPaid ? 'We received your M-Pesa payment. Your order is now being prepared.' : ($isWaiting ? 'Approve the M-Pesa request on your handset. We’ll update this page when KopoKopo confirms the result.' : ($isSetup ? 'KopoKopo credentials are not configured on this server, so no prompt was sent.' : 'No payment was taken. Your items remain in your cart so you can retry.')) }}
            </p>
        </div>

        <div class="p-6 sm:p-9">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-2xl bg-stone-50 p-4"><p class="text-[11px] font-bold uppercase tracking-widest text-stone-400">Amount</p><p class="mt-1 text-xl font-black text-stone-950">{{ $payment->formatted_amount }}</p></div>
                <div class="rounded-2xl bg-stone-50 p-4"><p class="text-[11px] font-bold uppercase tracking-widest text-stone-400">Payment reference</p><p class="mt-1 break-all text-sm font-extrabold text-stone-950">{{ $payment->reference }}</p></div>
                @if($payment->order)
                    <div class="rounded-2xl bg-stone-50 p-4"><p class="text-[11px] font-bold uppercase tracking-widest text-stone-400">Order</p><p class="mt-1 text-sm font-bold text-stone-950">#{{ $payment->order->order_number }}</p></div>
                @endif
                <div class="rounded-2xl bg-stone-50 p-4"><p class="text-[11px] font-bold uppercase tracking-widest text-stone-400">Phone</p><p class="mt-1 text-sm font-bold text-stone-950">{{ $payment->phone }}</p></div>
            </div>

            @if($isWaiting)
                <div class="mt-5 flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-950"><span class="h-2.5 w-2.5 animate-pulse rounded-full bg-emerald-500"></span><span>This page checks for your payment update automatically.</span></div>
            @elseif($isPaid && $payment->provider_reference)
                <p class="mt-5 text-sm text-stone-600">M-Pesa receipt: <strong class="text-stone-950">{{ $payment->provider_reference }}</strong></p>
            @elseif($payment->failure_reason)
                <p class="mt-5 rounded-xl bg-amber-50 p-4 text-sm text-amber-950">{{ $payment->failure_reason }}</p>
            @endif

            <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                @if($isPaid && $payment->order)
                    <a href="{{ route('checkout.success', $payment->order) }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-emerald-700 px-5 py-3.5 text-sm font-bold text-white transition hover:bg-emerald-800">Continue to order confirmation</a>
                @elseif(session()->has('pending_mpesa_checkout'))
                    <a href="{{ route('checkout.mpesa') }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-stone-950 px-5 py-3.5 text-sm font-bold text-white transition hover:bg-stone-800">Return to payment</a>
                @else
                    <a href="{{ route('products.index') }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-stone-950 px-5 py-3.5 text-sm font-bold text-white transition hover:bg-stone-800">Continue shopping</a>
                @endif
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-xl border border-stone-200 px-5 py-3.5 text-sm font-bold text-stone-700 transition hover:bg-stone-50">Need help?</a>
            </div>
        </div>
    </section>
</main>
@endsection
