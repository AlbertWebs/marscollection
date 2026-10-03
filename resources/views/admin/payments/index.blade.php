@extends('layouts.admin')

@section('title', 'Payment Records')

@section('content')
@php
    $statusStyle = [
        'pending' => 'bg-amber-50 text-amber-800 ring-amber-200',
        'initiated' => 'bg-sky-50 text-sky-800 ring-sky-200',
        'succeeded' => 'bg-emerald-50 text-emerald-800 ring-emerald-200',
        'failed' => 'bg-rose-50 text-rose-800 ring-rose-200',
        'cancelled' => 'bg-gray-100 text-gray-700 ring-gray-200',
        'refunded' => 'bg-violet-50 text-violet-800 ring-violet-200',
        'setup_required' => 'bg-orange-50 text-orange-800 ring-orange-200',
    ];
@endphp
<div class="space-y-6">
    <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
        <div><p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-700">Money in · one clear ledger</p><h1 class="mt-1 text-2xl font-black tracking-tight text-gray-950">Payments</h1><p class="mt-1 max-w-xl text-sm text-gray-500">Track storefront attempts, reconcile offline payments and try KopoKopo STK from one place.</p></div>
        <a href="{{ route('admin.orders.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-950 px-4 py-3 text-sm font-bold text-white transition hover:bg-amber-700">＋ Create customer order</a>
    </div>

    @foreach(['success' => 'emerald', 'warning' => 'amber', 'error' => 'rose'] as $flash => $tone)
        @if(session($flash))<div class="rounded-xl border border-{{ $tone }}-200 bg-{{ $tone }}-50 px-4 py-3 text-sm font-medium text-{{ $tone }}-900" role="status">{{ session($flash) }}</div>@endif
    @endforeach
    @if($errors->any())<div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-900">{{ $errors->first() }}</div>@endif

    <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-2xl border border-gray-200 bg-white p-4 shadow-sm"><p class="text-xs font-bold uppercase tracking-wider text-gray-400">All records</p><p class="mt-2 text-2xl font-black text-gray-950">{{ number_format($stats['all']) }}</p></div>
        <div class="rounded-2xl border border-sky-100 bg-sky-50/60 p-4"><p class="text-xs font-bold uppercase tracking-wider text-sky-700">STK pending</p><p class="mt-2 text-2xl font-black text-sky-950">{{ number_format($stats['initiated']) }}</p></div>
        <div class="rounded-2xl border border-emerald-100 bg-emerald-50/60 p-4"><p class="text-xs font-bold uppercase tracking-wider text-emerald-700">Received</p><p class="mt-2 text-2xl font-black text-emerald-950">{{ number_format($stats['succeeded']) }}</p></div>
        <div class="rounded-2xl border border-orange-100 bg-orange-50/60 p-4"><p class="text-xs font-bold uppercase tracking-wider text-orange-700">Needs attention</p><p class="mt-2 text-2xl font-black text-orange-950">{{ number_format($stats['attention']) }}</p></div>
    </div>

    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="grid gap-0 lg:grid-cols-[minmax(0,1fr)_350px]">
            <div class="p-5 sm:p-7">
                <div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18m9-9H3m15.364-6.364-12.728 12.728m12.728 0L5.636 5.636"/></svg></span><div><h2 class="text-lg font-extrabold text-gray-950">KopoKopo STK playground</h2><p class="mt-1 text-sm text-gray-500">Send a real or sandbox payment prompt and capture the result here.</p></div></div>
                @if(!$kopokopoConfigured)
                    <div class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-950"><p class="font-bold">Credentials not configured</p><p class="mt-1 text-xs leading-5">Add the KopoKopo client ID, client secret, API key and till number to the server environment. Attempts can still be recorded here as setup required.</p></div>
                @else
                    <div class="mt-5 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-950"><p class="font-bold">{{ str_contains(config('services.kopokopo.base_url'), 'sandbox') ? 'Sandbox connection configured' : 'Live KopoKopo connection configured' }}</p><p class="mt-1 text-xs">STK requests are sent from the server and confirmed by the signed KopoKopo callback.</p></div>
                @endif
            </div>
            <div class="border-t border-gray-100 bg-gray-50/70 p-5 sm:p-7 lg:border-l lg:border-t-0">
                <form action="{{ route('admin.payments.stk-playground') }}" method="POST" class="space-y-3">
                    @csrf
                    <div><label for="playground_order" class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-500">Attach to pending order <span class="font-normal normal-case tracking-normal">(optional)</span></label><select id="playground_order" name="order_id" class="w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm"><option value="">Standalone STK test</option>@foreach($openOrders as $order)<option value="{{ $order->id }}" data-name="{{ $order->customer_name }}" data-email="{{ $order->customer_email }}" data-phone="{{ $order->customer_phone }}" data-amount="{{ $order->total }}">#{{ $order->order_number }} · {{ $order->customer_name }} · KES {{ number_format($order->total) }}</option>@endforeach</select></div>
                    <div><label for="playground_name" class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-500">Customer name</label><input id="playground_name" name="customer_name" value="{{ old('customer_name') }}" required class="w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm"></div>
                    <div class="grid grid-cols-2 gap-3"><div><label for="playground_phone" class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-500">Phone</label><input id="playground_phone" name="phone" value="{{ old('phone') }}" required placeholder="0712 345 678" class="w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm"></div><div><label for="playground_amount" class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-500">Amount (KES)</label><input id="playground_amount" name="amount" value="{{ old('amount') }}" type="number" min="1" step="1" required class="w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm"></div></div>
                    <div><label for="playground_email" class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-500">Email <span class="font-normal normal-case tracking-normal">(optional)</span></label><input id="playground_email" name="customer_email" type="email" value="{{ old('customer_email') }}" class="w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm"></div>
                    <div><label for="playground_notes" class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-500">Reference note</label><input id="playground_notes" name="notes" value="{{ old('notes') }}" placeholder="e.g. Payment for order" class="w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm"></div>
                    <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-700 px-4 py-3 text-sm font-extrabold text-white transition hover:bg-emerald-800 focus:outline-none focus:ring-4 focus:ring-emerald-200">Send STK prompt <span aria-hidden="true">→</span></button>
                </form>
            </div>
        </div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between sm:px-6">
            <div><h2 class="text-lg font-extrabold text-gray-950">Payment activity</h2><p class="mt-0.5 text-xs text-gray-500">Storefront payments, admin assisted payments and STK attempts.</p></div>
            <form method="GET" class="flex flex-col gap-2 sm:flex-row"><input name="search" value="{{ request('search') }}" placeholder="Reference, customer or phone" class="rounded-lg border-gray-300 px-3 py-2 text-sm"><select name="status" class="rounded-lg border-gray-300 py-2 text-sm"><option value="">All statuses</option>@foreach(['pending','initiated','succeeded','failed','cancelled','refunded','setup_required'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ str_replace('_', ' ', ucfirst($status)) }}</option>@endforeach</select><button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-bold text-white">Filter</button></form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100 text-left">
                <thead class="bg-gray-50"><tr><th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-gray-400">Reference / order</th><th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-gray-400">Customer</th><th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-gray-400">Amount</th><th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-gray-400">State / source</th><th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-gray-400">Activity</th><th class="px-5 py-3 text-[10px] font-bold uppercase tracking-wider text-gray-400">Reconcile</th></tr></thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($payments as $payment)
                        <tr class="align-top hover:bg-gray-50/70">
                            <td class="px-5 py-4"><p class="font-mono text-xs font-bold text-gray-950">{{ $payment->reference }}</p><p class="mt-1 text-xs text-amber-800">{{ $payment->order?->order_number ? '#' . $payment->order->order_number : 'No linked order' }}</p><p class="mt-1 text-[10px] text-gray-400">{{ strtoupper($payment->provider) }} · {{ str_replace('_', ' ', $payment->source) }}</p></td>
                            <td class="px-5 py-4"><p class="text-sm font-bold text-gray-900">{{ $payment->customer_name ?: '—' }}</p><p class="mt-1 text-xs text-gray-500">{{ $payment->phone ?: 'No phone' }}</p><p class="text-xs text-gray-400">{{ $payment->customer_email }}</p></td>
                            <td class="px-5 py-4"><p class="whitespace-nowrap text-sm font-black text-gray-950">{{ $payment->formatted_amount }}</p><p class="mt-1 text-[10px] uppercase text-gray-400">{{ $payment->method }}</p></td>
                            <td class="px-5 py-4"><span class="inline-flex rounded-full px-2.5 py-1 text-[11px] font-bold ring-1 {{ $statusStyle[$payment->status] ?? 'bg-gray-100 text-gray-700 ring-gray-200' }}">{{ str_replace('_', ' ', ucfirst($payment->status)) }}</span><p class="mt-2 text-xs text-gray-500">{{ $payment->provider_reference ?: ($payment->provider_request_id ? 'Request ' . \Illuminate\Support\Str::limit($payment->provider_request_id, 12, '') : 'No provider receipt') }}</p>@if($payment->failure_reason)<p class="mt-1 max-w-xs text-xs text-rose-700">{{ $payment->failure_reason }}</p>@endif</td>
                            <td class="whitespace-nowrap px-5 py-4"><p class="text-xs font-semibold text-gray-700">{{ $payment->created_at->format('M j, Y') }}</p><p class="mt-1 text-xs text-gray-400">{{ $payment->created_at->format('g:i A') }}</p></td>
                            <td class="min-w-64 px-5 py-4"><form method="POST" action="{{ route('admin.payments.update-status', $payment) }}" class="space-y-2">@csrf @method('PATCH')<select name="status" class="w-full rounded-lg border-gray-300 py-2 text-xs"><option value="pending" @selected($payment->status === 'pending')>Pending</option><option value="initiated" @selected($payment->status === 'initiated')>STK initiated</option><option value="succeeded" @selected($payment->status === 'succeeded')>Received</option><option value="failed" @selected($payment->status === 'failed')>Failed</option><option value="cancelled" @selected($payment->status === 'cancelled')>Cancelled</option><option value="refunded" @selected($payment->status === 'refunded')>Refunded</option><option value="setup_required" @selected($payment->status === 'setup_required')>Setup required</option></select><input name="admin_note" value="" placeholder="Reason / receipt note" class="w-full rounded-lg border-gray-300 px-2.5 py-2 text-xs"><button class="rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-bold text-gray-700 hover:bg-gray-100">Save reconciliation</button></form></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center"><span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100 text-gray-400">₭</span><p class="mt-3 text-sm font-bold text-gray-800">No payment records yet</p><p class="mt-1 text-xs text-gray-500">Storefront and admin payment attempts will appear here.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())<div class="border-t border-gray-100 px-5 py-4">{{ $payments->links() }}</div>@endif
    </section>
</div>

<script>
document.getElementById('playground_order')?.addEventListener('change', function () {
    const option = this.selectedOptions[0];
    if (!this.value) return;
    document.getElementById('playground_name').value = option.dataset.name || '';
    document.getElementById('playground_email').value = option.dataset.email || '';
    document.getElementById('playground_phone').value = option.dataset.phone || '';
    document.getElementById('playground_amount').value = Math.round(Number(option.dataset.amount || 0));
});
</script>
@endsection
