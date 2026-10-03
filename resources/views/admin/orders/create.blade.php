@extends('layouts.admin')

@section('title', 'Create Customer Order')

@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-amber-700 hover:text-amber-900">← Back to orders</a>
            <h1 class="mt-2 text-2xl font-black tracking-tight text-gray-950">Create an order</h1>
            <p class="mt-1 text-sm text-gray-500">Build the customer’s basket, add delivery details, and create the order with a matching payment record.</p>
        </div>
        <span class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-50 px-3 py-2 text-xs font-bold text-emerald-800"><span class="h-2 w-2 rounded-full bg-emerald-500"></span> Staff assisted checkout</span>
    </div>

    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800"><p class="font-bold">Please review the order details.</p><ul class="mt-2 list-inside list-disc space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form action="{{ route('admin.orders.store') }}" method="POST" id="admin-order-form" class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        @csrf
        <div class="space-y-6">
            <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="mb-5 flex items-center gap-3"><span class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-100 text-sm font-black text-amber-900">01</span><div><h2 class="font-extrabold text-gray-950">Customer details</h2><p class="text-xs text-gray-500">Where should we send the order?</p></div></div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div><label for="customer_name" class="mb-1.5 block text-sm font-bold text-gray-700">Full name</label><input id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required class="w-full rounded-xl border-gray-300 px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500"></div>
                    <div><label for="customer_phone" class="mb-1.5 block text-sm font-bold text-gray-700">Phone</label><input id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required placeholder="0712 345 678" class="w-full rounded-xl border-gray-300 px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500"></div>
                    <div><label for="customer_email" class="mb-1.5 block text-sm font-bold text-gray-700">Email</label><input type="email" id="customer_email" name="customer_email" value="{{ old('customer_email') }}" required class="w-full rounded-xl border-gray-300 px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500"></div>
                    <div><label for="customer_city" class="mb-1.5 block text-sm font-bold text-gray-700">City / town</label><input id="customer_city" name="customer_city" value="{{ old('customer_city') }}" required placeholder="Nairobi" class="w-full rounded-xl border-gray-300 px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500"></div>
                    <div class="sm:col-span-2"><label for="delivery_address" class="mb-1.5 block text-sm font-bold text-gray-700">Delivery address</label><textarea id="delivery_address" name="delivery_address" rows="2" required placeholder="Estate, building, street or pickup point" class="w-full rounded-xl border-gray-300 px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500">{{ old('delivery_address') }}</textarea></div>
                </div>
            </section>

            <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3"><span class="flex h-9 w-9 items-center justify-center rounded-xl bg-violet-100 text-sm font-black text-violet-900">02</span><div><h2 class="font-extrabold text-gray-950">Items in this order</h2><p class="text-xs text-gray-500">Choose products, sizes and quantities.</p></div></div>
                    <button type="button" id="add-order-item" class="inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 px-4 py-2.5 text-sm font-bold text-gray-700 transition hover:border-amber-400 hover:bg-amber-50 hover:text-amber-900"><span class="text-lg leading-none">+</span> Add product</button>
                </div>
                <div id="order-items" class="space-y-3">
                    @foreach(old('items', [['product_id' => '', 'quantity' => 1, 'size' => '']]) as $index => $oldItem)
                        <div class="order-item-row grid gap-3 rounded-xl border border-gray-200 bg-gray-50/70 p-3 sm:grid-cols-[minmax(0,1fr)_145px_95px_40px] sm:items-end">
                            <div><label class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-500">Product</label><select name="items[{{ $index }}][product_id]" required class="order-product w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500"><option value="">Choose a product</option>@foreach($products as $product)<option value="{{ $product->id }}" data-price="{{ $product->price }}" data-sizes="{{ implode(',', $product->sizes ?? []) }}" @selected(($oldItem['product_id'] ?? '') == $product->id)>{{ $product->name }} · KES {{ number_format($product->price) }} ({{ $product->stock_quantity }} in stock)</option>@endforeach</select></div>
                            <div><label class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-500">Shoe size</label><select name="items[{{ $index }}][size]" class="order-size w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500"><option value="">No size / select product</option></select></div>
                            <div><label class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-500">Quantity</label><input name="items[{{ $index }}][quantity]" type="number" min="1" max="100" value="{{ $oldItem['quantity'] ?? 1 }}" required class="order-quantity w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500"></div>
                            <button type="button" class="remove-order-item flex h-10 w-10 items-center justify-center rounded-lg text-gray-400 transition hover:bg-red-50 hover:text-red-700" aria-label="Remove item"><svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.5 2.5A1.5 1.5 0 0 0 7 4H4.75a.75.75 0 0 0 0 1.5h.4l.67 9.41A2.25 2.25 0 0 0 8.06 17h3.88a2.25 2.25 0 0 0 2.24-2.09l.67-9.41h.4a.75.75 0 0 0 0-1.5H13a1.5 1.5 0 0 0-1.5-1.5h-3Zm3 1.5a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 0-.5.5h3Z" clip-rule="evenodd"/></svg></button>
                        </div>
                    @endforeach
                </div>
                @error('items')<p class="mt-3 text-sm text-red-700">{{ $message }}</p>@enderror
            </section>

            <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-7">
                <div class="mb-5 flex items-center gap-3"><span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-sm font-black text-emerald-900">03</span><div><h2 class="font-extrabold text-gray-950">Payment & delivery</h2><p class="text-xs text-gray-500">Choose how this customer plans to pay.</p></div></div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div><label for="payment_method" class="mb-1.5 block text-sm font-bold text-gray-700">Payment method</label><select id="payment_method" name="payment_method" required class="w-full rounded-xl border-gray-300 px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500"><option value="mpesa" @selected(old('payment_method') === 'mpesa')>M-Pesa STK</option><option value="cash_on_delivery" @selected(old('payment_method', 'cash_on_delivery') === 'cash_on_delivery')>Cash on delivery</option><option value="credit_card" @selected(old('payment_method') === 'credit_card')>Card on delivery</option><option value="bank_transfer" @selected(old('payment_method') === 'bank_transfer')>Bank / Airtel transfer</option></select></div>
                    <div><label for="shipping_cost" class="mb-1.5 block text-sm font-bold text-gray-700">Delivery fee (KES)</label><input id="shipping_cost" name="shipping_cost" type="number" min="0" step="1" value="{{ old('shipping_cost', 0) }}" class="w-full rounded-xl border-gray-300 px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500"></div>
                    <div class="sm:col-span-2"><label for="notes" class="mb-1.5 block text-sm font-bold text-gray-700">Order note <span class="font-normal text-gray-400">(optional)</span></label><textarea id="notes" name="notes" rows="2" class="w-full rounded-xl border-gray-300 px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500">{{ old('notes') }}</textarea></div>
                </div>
            </section>
        </div>

        <aside class="h-fit rounded-2xl border border-gray-200 bg-white p-5 shadow-sm xl:sticky xl:top-6 sm:p-6">
            <h2 class="text-lg font-extrabold text-gray-950">Order total</h2>
            <div class="mt-5 space-y-3 text-sm"><div class="flex justify-between text-gray-600"><span>Items subtotal</span><span id="order-subtotal" class="font-bold text-gray-900">KES 0</span></div><div class="flex justify-between text-gray-600"><span>Tax (15%)</span><span id="order-tax" class="font-bold text-gray-900">KES 0</span></div><div class="flex justify-between text-gray-600"><span>Delivery</span><span id="order-shipping" class="font-bold text-gray-900">KES 0</span></div><div class="border-t border-dashed border-gray-200 pt-4"><div class="flex justify-between"><span class="font-extrabold text-gray-950">Total</span><span id="order-total" class="text-xl font-black text-amber-800">KES 0</span></div></div></div>
            <p class="mt-4 rounded-xl bg-amber-50 p-3 text-xs leading-5 text-amber-950">Prices are pulled from the catalog at save time. A payment record will be created with the order.</p>
            <button type="submit" class="mt-5 w-full rounded-xl bg-gray-950 px-5 py-3.5 text-sm font-extrabold text-white transition hover:bg-amber-700 focus:outline-none focus:ring-4 focus:ring-amber-200">Create order</button>
            <a href="{{ route('admin.payments.index') }}" class="mt-3 flex w-full items-center justify-center rounded-xl border border-gray-200 px-5 py-3 text-sm font-bold text-gray-700 transition hover:bg-gray-50">Open payment records</a>
        </aside>
    </form>

    <template id="order-item-template">
        <div class="order-item-row grid gap-3 rounded-xl border border-gray-200 bg-gray-50/70 p-3 sm:grid-cols-[minmax(0,1fr)_145px_95px_40px] sm:items-end">
            <div><label class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-500">Product</label><select required class="order-product w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500"><option value="">Choose a product</option>@foreach($products as $product)<option value="{{ $product->id }}" data-price="{{ $product->price }}" data-sizes="{{ implode(',', $product->sizes ?? []) }}">{{ $product->name }} · KES {{ number_format($product->price) }} ({{ $product->stock_quantity }} in stock)</option>@endforeach</select></div>
            <div><label class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-500">Shoe size</label><select class="order-size w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500"><option value="">No size / select product</option></select></div>
            <div><label class="mb-1 block text-xs font-bold uppercase tracking-wider text-gray-500">Quantity</label><input type="number" min="1" max="100" value="1" required class="order-quantity w-full rounded-lg border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500"></div>
            <button type="button" class="remove-order-item flex h-10 w-10 items-center justify-center rounded-lg text-gray-400 transition hover:bg-red-50 hover:text-red-700" aria-label="Remove item"><svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.5 2.5A1.5 1.5 0 0 0 7 4H4.75a.75.75 0 0 0 0 1.5h.4l.67 9.41A2.25 2.25 0 0 0 8.06 17h3.88a2.25 2.25 0 0 0 2.24-2.09l.67-9.41h.4a.75.75 0 0 0 0-1.5H13a1.5 1.5 0 0 0-1.5-1.5h-3Zm3 1.5a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 0-.5.5h3Z" clip-rule="evenodd"/></svg></button>
        </div>
    </template>
</div>

<script>
(() => {
    const rows = document.getElementById('order-items');
    const template = document.getElementById('order-item-template');
    let nextIndex = {{ count(old('items', [['product_id' => '', 'quantity' => 1, 'size' => '']])) }};
    const money = value => `KES ${Math.round(value).toLocaleString()}`;

    function updateSizeOptions(row, selected = '') {
        const product = row.querySelector('.order-product');
        const size = row.querySelector('.order-size');
        const values = (product.selectedOptions[0]?.dataset.sizes || '').split(',').filter(Boolean);
        size.replaceChildren(new Option(values.length ? 'Choose size' : 'Size not configured', ''));
        values.forEach(value => size.add(new Option(value, value, false, String(value) === String(selected))));
        size.required = values.length > 0;
    }

    function recalculate() {
        let subtotal = 0;
        rows.querySelectorAll('.order-item-row').forEach(row => {
            const selected = row.querySelector('.order-product').selectedOptions[0];
            subtotal += Number(selected?.dataset.price || 0) * Number(row.querySelector('.order-quantity').value || 0);
        });
        const tax = subtotal * 0.15;
        const shipping = Number(document.getElementById('shipping_cost').value || 0);
        document.getElementById('order-subtotal').textContent = money(subtotal);
        document.getElementById('order-tax').textContent = money(tax);
        document.getElementById('order-shipping').textContent = money(shipping);
        document.getElementById('order-total').textContent = money(subtotal + tax + shipping);
    }

    rows.querySelectorAll('.order-item-row').forEach(row => {
        const product = row.querySelector('.order-product');
        const selectedSize = @json(old('items', []));
        product.addEventListener('change', () => { updateSizeOptions(row); recalculate(); });
        row.querySelector('.order-quantity').addEventListener('input', recalculate);
        updateSizeOptions(row, selectedSize[Array.from(rows.children).indexOf(row)]?.size || '');
    });

    rows.addEventListener('change', event => { if (event.target.matches('.order-product')) updateSizeOptions(event.target.closest('.order-item-row')); recalculate(); });
    rows.addEventListener('input', recalculate);
    rows.addEventListener('click', event => {
        const remove = event.target.closest('.remove-order-item');
        if (remove) {
            const allRows = rows.querySelectorAll('.order-item-row');
            if (allRows.length > 1) remove.closest('.order-item-row').remove();
            recalculate();
        }
    });

    document.getElementById('add-order-item').addEventListener('click', () => {
        const clone = template.content.cloneNode(true);
        clone.querySelector('.order-product').name = `items[${nextIndex}][product_id]`;
        clone.querySelector('.order-size').name = `items[${nextIndex}][size]`;
        clone.querySelector('.order-quantity').name = `items[${nextIndex}][quantity]`;
        nextIndex++;
        rows.appendChild(clone);
        recalculate();
    });
    document.getElementById('shipping_cost').addEventListener('input', recalculate);
    recalculate();
})();
</script>
@endsection
