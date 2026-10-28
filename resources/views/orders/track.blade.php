@extends('layouts.app')

@section('title', 'Track Your Order - Mars Collection')
@section('robots', 'noindex, nofollow')

@section('content')
<main class="min-h-[65vh] bg-gray-50 px-4 py-10 sm:py-16">
    <div class="mx-auto max-w-xl">
        <div class="mb-7 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-700">Mars Collection</p>
            <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900">Track your order</h1>
            <p class="mt-3 text-sm leading-6 text-gray-600">Enter the order number from your confirmation email or checkout page to check its latest status. No account is needed.</p>
        </div>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-7">
            <form method="POST" action="{{ route('orders.track.lookup') }}" class="space-y-4">
                @csrf
                <label for="order_number" class="block text-sm font-semibold text-gray-800">Order number</label>
                <input id="order_number" name="order_number" type="text" value="{{ old('order_number', $orderNumber) }}"
                    placeholder="ORD-XXXXXXXX" autocomplete="off" autocapitalize="characters" required maxlength="32"
                    class="block w-full rounded-lg border border-gray-300 px-4 py-3 text-base uppercase tracking-wide text-gray-900 placeholder:normal-case placeholder:tracking-normal focus:border-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-100">
                @error('order_number')<p class="text-sm text-red-700" role="alert">{{ $message }}</p>@enderror
                <button type="submit" class="w-full rounded-lg bg-amber-600 px-5 py-3 font-semibold text-white transition hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">Find order</button>
            </form>

            @if($lookupAttempted && !$order)
                <div class="mt-5 rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900" role="status">
                    We couldn't find an order with that number. Check it and try again, or contact support for help.
                </div>
            @elseif($order)
                @php
                    $statusDetails = [
                        'pending' => $order->payment_method === 'cash_on_delivery'
                            ? ['Order received', 'Your order has been received and is awaiting processing.']
                            : ['Payment pending', 'We are waiting for payment confirmation.'],
                        'processing' => ['Processing', 'Your order is confirmed and is being prepared.'],
                        'shipped' => ['Shipped', 'Your order is on its way.'],
                        'delivered' => ['Delivered', 'This order has been marked as delivered.'],
                        'cancelled' => ['Cancelled', 'This order has been cancelled. Please contact support if you need help.'],
                    ];
                    [$statusLabel, $statusMessage] = $statusDetails[$order->status] ?? [\Illuminate\Support\Str::headline($order->status), 'Contact support if you need more information about this order.'];
                @endphp
                <div class="mt-6 border-t border-gray-100 pt-5" role="status" aria-live="polite">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">Order {{ $order->order_number }}</p>
                            <h2 class="mt-1 text-xl font-bold text-gray-900">{{ $statusLabel }}</h2>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->status === 'cancelled' ? 'bg-red-50 text-red-700' : ($order->status === 'delivered' ? 'bg-green-50 text-green-700' : 'bg-amber-50 text-amber-800') }}">{{ $statusLabel }}</span>
                    </div>
                    <p class="mt-3 text-sm leading-6 text-gray-600">{{ $statusMessage }}</p>
                    <p class="mt-4 text-xs text-gray-500">Placed {{ $order->created_at->format('M j, Y') }} · {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $order->payment_method)) }}</p>
                </div>
            @endif
        </section>

        <p class="mt-5 text-center text-sm text-gray-500">Need help? <a href="{{ route('contact') }}" class="font-semibold text-amber-700 underline underline-offset-2">Contact support</a></p>
    </div>
</main>
@endsection
