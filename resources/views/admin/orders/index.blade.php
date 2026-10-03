@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div><p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-700">Commerce · fulfilment</p><h1 class="mt-1 text-xl lg:text-2xl font-bold text-gray-900">Orders</h1></div>
        <div class="flex gap-2"><a href="{{ route('admin.payments.index') }}" class="rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">Payments</a><a href="{{ route('admin.orders.create') }}" class="rounded-lg bg-gray-950 px-3 py-2 text-sm font-semibold text-white hover:bg-amber-700">＋ Create order</a></div>
    </div>

    @if(session('success') || session('error'))
        <div role="status" class="rounded-xl border px-4 py-3 text-sm {{ session('error') ? 'border-red-200 bg-red-50 text-red-800' : 'border-emerald-200 bg-emerald-50 text-emerald-800' }}">{{ session('error') ?? session('success') }}</div>
    @endif

    <!-- Orders Table -->
    <div class="bg-white shadow rounded-md overflow-hidden">
        <div class="px-4 lg:px-6 py-4 border-b border-gray-200">
            <h3 class="text-base lg:text-lg font-medium text-gray-900">All Orders</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 hidden sm:table-header-group">
                    <tr>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Items</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Date</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50 border-b border-gray-200 sm:border-0">
                            <td class="px-3 lg:px-6 py-3 sm:py-4">
                                <div class="space-y-1">
                                    <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                                    <div class="flex items-center gap-2 text-xs sm:hidden">
                                        <span class="text-gray-500">{{ $order->orderItems->count() }} items</span>
                                        <span class="text-gray-400">•</span>
                                        <span class="text-gray-500">{{ $order->created_at->format('M d') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-3 sm:py-4">
                                <div class="space-y-0.5">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->customer_name ?? $order->user->name ?? 'Guest' }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500">{{ $order->customer_email ?? $order->user->email ?? 'No email' }}</div>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <div class="text-sm text-gray-900">{{ $order->orderItems->count() }} items</div>
                            </td>
                            <td class="px-3 lg:px-6 py-3 sm:py-4">
                                <div class="space-y-1 sm:space-y-0">
                                    <span class="text-sm font-medium text-gray-900">KSh {{ number_format($order->total) }}</span>
                                    <div class="sm:hidden">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                            @if($order->status === 'completed') bg-green-100 text-green-800
                                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($order->status === 'completed') bg-green-100 text-green-800
                                    @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-800
                                    @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-3 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-amber-700 hover:text-amber-900 whitespace-nowrap">View</a>
                                    <button type="button" class="order-delete-trigger text-red-600 hover:text-red-800" data-order="{{ $order->order_number }}" data-code-url="{{ route('admin.orders.delete-code', $order) }}" data-delete-url="{{ route('admin.orders.destroy', $order) }}">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($orders->hasPages())
            <div class="px-4 lg:px-6 py-4 border-t border-gray-200">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>

<div id="order-delete-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-gray-950/60 p-4" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
        <div class="flex items-start justify-between gap-4"><div><p class="text-xs font-bold uppercase tracking-[0.16em] text-red-600">Protected action</p><h2 id="delete-modal-title" class="mt-1 text-xl font-black text-gray-950">Delete order?</h2></div><button type="button" id="close-delete-modal" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100" aria-label="Close">✕</button></div>
        <p class="mt-3 text-sm leading-6 text-gray-600">This permanently removes the order and its items. Payment records stay in the ledger. Generate a one-time code, then enter it below to continue.</p>
        <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4"><div class="flex items-center justify-between gap-3"><div><p class="text-xs font-bold uppercase tracking-wider text-amber-900">One-time code</p><p id="delete-code" class="mt-1 font-mono text-2xl font-black tracking-[0.3em] text-gray-950">······</p></div><button id="generate-delete-code" type="button" class="rounded-lg bg-gray-950 px-3 py-2 text-xs font-bold text-white hover:bg-amber-700">Generate code</button></div><p id="delete-code-hint" class="mt-2 text-xs text-gray-600">Code expires after 3 minutes and 5 incorrect attempts.</p></div>
        <form id="delete-order-form" method="POST" class="mt-4 space-y-3">@csrf @method('DELETE')<label for="delete_code" class="block text-sm font-semibold text-gray-800">Enter the 6-digit code</label><input id="delete_code" name="delete_code" inputmode="numeric" autocomplete="off" maxlength="6" pattern="[0-9]{6}" required class="w-full rounded-xl border-gray-300 text-center font-mono text-xl tracking-[0.35em] focus:border-red-500 focus:ring-red-500" placeholder="••••••"><p id="delete-code-error" class="hidden text-sm text-red-700"></p><div class="flex justify-end gap-2 pt-2"><button type="button" id="cancel-delete" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">Cancel</button><button id="confirm-delete" type="submit" disabled class="rounded-lg bg-red-700 px-4 py-2 text-sm font-bold text-white disabled:cursor-not-allowed disabled:opacity-40">Delete order permanently</button></div></form>
    </div>
</div>
<script>
(() => {
    const modal = document.getElementById('order-delete-modal');
    const form = document.getElementById('delete-order-form');
    const codeEl = document.getElementById('delete-code');
    const errorEl = document.getElementById('delete-code-error');
    const input = document.getElementById('delete_code');
    const submit = document.getElementById('confirm-delete');
    let codeReady = false;
    const close = () => { modal.classList.add('hidden'); modal.classList.remove('flex'); input.value = ''; submit.disabled = true; codeReady = false; };
    document.querySelectorAll('.order-delete-trigger').forEach(button => button.addEventListener('click', () => {
        form.action = button.dataset.deleteUrl;
        document.getElementById('delete-modal-title').textContent = `Delete ${button.dataset.order}?`;
        document.getElementById('generate-delete-code').dataset.url = button.dataset.codeUrl;
        codeEl.textContent = '······';
        errorEl.classList.add('hidden');
        modal.classList.remove('hidden'); modal.classList.add('flex');
    }));
    document.getElementById('generate-delete-code').addEventListener('click', async event => {
        const button = event.currentTarget;
        button.disabled = true; button.textContent = 'Generating…'; errorEl.classList.add('hidden');
        try {
            const response = await fetch(button.dataset.url, { method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json'} });
            if (!response.ok) throw new Error('Could not generate a code. Refresh and try again.');
            const payload = await response.json(); codeEl.textContent = payload.code; codeReady = true; input.focus();
            document.getElementById('delete-code-hint').textContent = 'This code expires in 3 minutes. Keep it private and enter it to confirm.';
        } catch (error) { errorEl.textContent = error.message; errorEl.classList.remove('hidden'); }
        finally { button.disabled = false; button.textContent = 'Generate code'; }
    });
    input.addEventListener('input', () => { input.value = input.value.replace(/\D/g, '').slice(0, 6); submit.disabled = !(codeReady && input.value.length === 6); });
    document.getElementById('close-delete-modal').addEventListener('click', close);
    document.getElementById('cancel-delete').addEventListener('click', close);
    modal.addEventListener('click', event => { if (event.target === modal) close(); });
})();
</script>
@endsection
