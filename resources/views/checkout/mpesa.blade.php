@extends('layouts.app')

@section('title', 'Pay with M-Pesa | Mars Collection')
@section('robots', 'noindex, nofollow')
@section('canonical', route('checkout.mpesa'))

@section('content')
<main class="min-h-[80vh] bg-[#f6f7f4] px-4 py-8 sm:px-6 sm:py-12">
    <div class="mx-auto max-w-6xl">
        <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-stone-600 transition hover:text-stone-950">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 18-6-6 6-6M9 12h12"/></svg>
            Back to your bag
        </a>

        <div class="mt-7 grid gap-8 lg:grid-cols-[minmax(0,1fr)_390px] lg:items-start">
            <section>
                <div class="mb-7 flex items-center gap-3 text-xs font-bold uppercase tracking-[0.16em] text-stone-400" aria-label="Checkout progress">
                    <span class="flex items-center gap-2 text-emerald-700"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-emerald-100 text-[11px]">✓</span> Details</span>
                    <span class="h-px w-8 bg-emerald-300 sm:w-14"></span>
                    <span class="flex items-center gap-2 text-stone-950"><span class="flex h-7 w-7 items-center justify-center rounded-full bg-stone-950 text-[11px] text-white">02</span> Payment</span>
                    <span class="h-px w-8 bg-stone-200 sm:w-14"></span>
                    <span>Confirmation</span>
                </div>

                <div class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-[#092e25] via-[#07563f] to-[#0c7b55] p-6 text-white shadow-xl shadow-emerald-950/10 sm:p-9">
                    <div class="pointer-events-none absolute -right-16 -top-24 h-72 w-72 rounded-full border border-white/10"></div>
                    <div class="pointer-events-none absolute -right-5 -top-14 h-52 w-52 rounded-full border border-white/10"></div>
                    <div class="relative flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-200">Fast, secure checkout</p>
                            <h1 class="mt-3 text-3xl font-black tracking-tight sm:text-4xl">Pay with M-Pesa</h1>
                            <p class="mt-3 max-w-xl text-sm leading-6 text-emerald-50/80">We’ll send a payment request to your phone. Enter your M-Pesa PIN on your handset to approve it.</p>
                        </div>
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-white text-lg font-black tracking-tight text-emerald-800 shadow-lg sm:h-16 sm:w-16 sm:text-xl" aria-label="M-Pesa">M-PESA</div>
                    </div>

                    <div class="relative mt-7 flex flex-wrap gap-x-5 gap-y-2 text-xs font-medium text-emerald-50/90">
                        <span class="inline-flex items-center gap-2"><svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 1.667 3.333 4.5v4.167c0 4.25 2.85 8.225 6.667 9.166 3.817-.941 6.667-4.916 6.667-9.166V4.5L10 1.667Zm3.22 6.386a.75.75 0 0 1 .06 1.06l-3.5 4a.75.75 0 0 1-1.09.03l-2-2a.75.75 0 1 1 1.06-1.06l1.43 1.428 2.98-3.4a.75.75 0 0 1 1.06-.058Z" clip-rule="evenodd"/></svg> Secure mobile payment</span>
                        <span class="inline-flex items-center gap-2"><svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M2.5 5.833A2.5 2.5 0 0 1 5 3.333h10a2.5 2.5 0 0 1 2.5 2.5v8.334a2.5 2.5 0 0 1-2.5 2.5H5a2.5 2.5 0 0 1-2.5-2.5V5.833Zm2.5-.833a.833.833 0 0 0-.833.833v.834h11.666v-.834A.833.833 0 0 0 15 5H5Z"/><path d="M5.833 12.5a.833.833 0 1 0 0 1.667h1.25a.833.833 0 0 0 0-1.667h-1.25Z"/></svg> Total today <strong class="text-white">KES {{ number_format($total) }}</strong></span>
                    </div>
                </div>

                @if(session('stk_pending'))
                    <div class="mt-5 flex gap-3 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-950" role="status">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-amber-700" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11.5a.75.75 0 0 0-1.5 0v4a.75.75 0 0 0 1.5 0v-4Zm-.75 8a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd"/></svg>
                        <p>{{ session('stk_pending') }}</p>
                    </div>
                @endif

                <div class="mt-5 rounded-[1.75rem] border border-stone-200 bg-white p-5 shadow-sm sm:p-7">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-stone-400">Payment step</p>
                            <h2 class="mt-1 text-xl font-bold text-stone-950">Where should we send the prompt?</h2>
                            <p class="mt-1 text-sm text-stone-500">Use the Safaricom number registered with M-Pesa.</p>
                        </div>
                        <span class="hidden rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-800 sm:inline-flex">STK Push</span>
                    </div>

                    <form action="{{ route('checkout.mpesa.stk') }}" method="POST" class="mt-6">
                        @csrf
                        <label for="mpesa-phone" class="mb-2 block text-sm font-bold text-stone-800">M-Pesa phone number</label>
                        <div class="flex overflow-hidden rounded-xl border {{ $errors->has('phone') ? 'border-red-400 ring-4 ring-red-50' : 'border-stone-300 focus-within:border-emerald-600 focus-within:ring-4 focus-within:ring-emerald-50' }} transition">
                            <span class="flex items-center border-r border-stone-200 bg-stone-50 px-4 text-sm font-bold text-stone-500">KENYA</span>
                            <input id="mpesa-phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" value="{{ old('phone', $checkoutDetails['customer_phone']) }}" placeholder="712 345 678" required class="min-w-0 flex-1 border-0 px-4 py-4 text-base font-semibold text-stone-950 outline-none ring-0 placeholder:font-normal placeholder:text-stone-400 focus:border-0 focus:ring-0">
                        </div>
                        @error('phone')<p class="mt-2 text-sm font-medium text-red-700">{{ $message }}</p>@enderror
                        <p class="mt-2 text-xs leading-5 text-stone-500">You can approve the prompt on your phone. <strong>Never share your M-Pesa PIN with anyone.</strong></p>

                        <button type="submit" class="mt-6 flex w-full items-center justify-center gap-3 rounded-xl bg-[#08794f] px-5 py-4 text-sm font-extrabold text-white shadow-lg shadow-emerald-900/15 transition hover:bg-[#066542] focus:outline-none focus:ring-4 focus:ring-emerald-200 active:scale-[0.99]">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/></svg>
                            Send M-Pesa STK push
                        </button>
                    </form>

                    <div class="mt-5 flex items-start gap-3 rounded-xl border border-stone-200 bg-stone-50 p-4">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-white text-amber-600 shadow-sm"><svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9.401 1.667a1.75 1.75 0 0 1 3.198 0l6.1 13.581A1.75 1.75 0 0 1 17.1 17.75H2.9a1.75 1.75 0 0 1-1.599-2.502l6.1-13.581ZM10 6a.75.75 0 0 0-.75.75v3.5a.75.75 0 0 0 1.5 0v-3.5A.75.75 0 0 0 10 6Zm0 7a1 1 0 1 0 0 2 1 1 0 0 0 0-2Z" clip-rule="evenodd"/></svg></span>
                        <div>
                            <p class="text-sm font-bold text-stone-900">{{ $kopokopoConfigured ? 'Your phone is next' : 'KopoKopo setup is needed' }}</p>
                            <p class="mt-1 text-xs leading-5 text-stone-600">{{ $kopokopoConfigured ? 'After you send the request, keep this page open and approve the prompt on your phone. Your cart stays safe until payment is confirmed.' : 'This server has no KopoKopo credentials yet. The request will be recorded, but no STK prompt can be sent until credentials are added.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-5 flex items-center gap-3 rounded-2xl px-1 py-2 text-xs leading-5 text-stone-500">
                    <svg class="h-5 w-5 shrink-0 text-emerald-700" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 1.667 3.333 4.5v4.167c0 4.25 2.85 8.225 6.667 9.166 3.817-.941 6.667-4.916 6.667-9.166V4.5L10 1.667ZM8.72 11.78l-1.5-1.5a.75.75 0 1 0-1.06 1.06l2.03 2.03a.75.75 0 0 0 1.09-.03l4.5-5a.75.75 0 0 0-1.12-1l-3.94 4.44Z" clip-rule="evenodd"/></svg>
                    <span>Your delivery details are saved for this checkout. You can return to your bag without losing your items.</span>
                </div>
            </section>

            <aside class="overflow-hidden rounded-[1.75rem] border border-stone-200 bg-white shadow-sm lg:sticky lg:top-8">
                <div class="border-b border-stone-100 p-5 sm:p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-extrabold text-stone-950">Your order</h2>
                        <span class="rounded-full bg-stone-100 px-2.5 py-1 text-xs font-bold text-stone-600">{{ $cartItems->sum('quantity') }} {{ \Illuminate\Support\Str::plural('item', $cartItems->sum('quantity')) }}</span>
                    </div>
                    <div class="mt-5 max-h-72 space-y-4 overflow-y-auto pr-1">
                        @foreach($cartItems as $item)
                            @php
                                $isBundle = (bool) $item->bundle_id;
                                $itemName = $isBundle ? $item->bundle->name : $item->product->name;
                                $itemImage = $isBundle ? $item->bundle->image : $item->product->image;
                                $itemPrice = $isBundle ? $item->bundle->price : $item->product->price;
                            @endphp
                            <div class="flex items-center gap-3">
                                <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($itemImage) }}" alt="{{ $itemName }}" class="h-14 w-14 shrink-0 rounded-xl bg-stone-100 object-cover">
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-bold text-stone-900">{{ $itemName }}</p>
                                    <p class="mt-1 text-xs text-stone-500">Qty {{ $item->quantity }}@if(!$isBundle && $item->selected_size) · Size {{ $item->selected_size }}@endif</p>
                                </div>
                                <p class="shrink-0 text-sm font-bold text-stone-900">KES {{ number_format($itemPrice * $item->quantity) }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="space-y-3 p-5 sm:p-6">
                    <div class="flex justify-between text-sm text-stone-600"><span>Subtotal</span><span class="font-semibold text-stone-900">KES {{ number_format($subtotal) }}</span></div>
                    <div class="flex justify-between text-sm text-stone-600"><span>Tax</span><span class="font-semibold text-stone-900">KES {{ number_format($tax) }}</span></div>
                    <div class="flex justify-between text-sm text-stone-600"><span>Delivery</span><span class="font-semibold {{ $shipping ? 'text-stone-900' : 'text-emerald-700' }}">{{ $shipping ? 'KES ' . number_format($shipping) : 'FREE' }}</span></div>
                    <div class="border-t border-dashed border-stone-200 pt-4">
                        <div class="flex items-end justify-between gap-3">
                            <div><p class="text-xs font-bold uppercase tracking-widest text-stone-400">Amount to pay</p><p class="mt-1 text-xs text-stone-500">Charged once via M-Pesa</p></div>
                            <p class="text-2xl font-black tracking-tight text-stone-950">KES {{ number_format($total) }}</p>
                        </div>
                    </div>
                    <div class="rounded-xl bg-emerald-50 p-3 text-xs leading-5 text-emerald-900"><strong>Delivering to:</strong> {{ $checkoutDetails['customer_city'] }} · {{ $checkoutDetails['delivery_address'] }}</div>
                    <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-2 pt-1 text-sm font-bold text-stone-600 transition hover:text-stone-950">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12.78 15.53a.75.75 0 0 1-1.06 0l-5-5a.75.75 0 0 1 0-1.06l5-5a.75.75 0 1 1 1.06 1.06L8.31 10l4.47 4.47a.75.75 0 0 1 0 1.06Z" clip-rule="evenodd"/></svg>
                        Change cart or delivery details
                    </a>
                </div>
            </aside>
        </div>
    </div>
</main>
@endsection
