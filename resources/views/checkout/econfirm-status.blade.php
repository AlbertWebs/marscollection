@extends('layouts.app')

@section('robots', 'noindex, nofollow')
@section('content')
<main class="min-h-[60vh] bg-stone-50 px-4 py-16">
    <div class="mx-auto max-w-xl rounded-2xl border border-stone-200 bg-white p-8 text-center shadow-sm">
        <h1 class="text-2xl font-bold text-stone-900">Payment is not confirmed yet</h1>
        <p class="mt-3 text-stone-600">Order {{ $payment->order->order_number }} is still awaiting eConfirm’s funding confirmation. Your cart has been kept safe.</p>
        <p class="mt-2 text-sm text-stone-500">If you completed payment, check the status again in a moment. Do not pay again while the status is pending.</p>
        <a href="{{ route('checkout.econfirm.complete', $payment->public_id) }}" class="mt-6 inline-flex rounded-lg bg-amber-600 px-5 py-3 font-semibold text-white hover:bg-amber-700">Check payment status</a>
        <div class="mt-4"><a href="{{ route('cart.index') }}" class="text-sm font-medium text-stone-600 hover:text-stone-900">Return to cart</a></div>
    </div>
</main>
@endsection
