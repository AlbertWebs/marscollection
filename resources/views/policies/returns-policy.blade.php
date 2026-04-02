@extends('layouts.app')

@section('title', 'Returns Policy - Zayn\'s Beauty')

@section('content')
<div class="min-h-screen bg-stone-50">
    <section class="border-b border-stone-200 bg-white">
        <div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-pink-600">Customer Care</p>
            <h1 class="mt-4 max-w-3xl text-4xl font-semibold tracking-tight text-stone-900 sm:text-5xl">Returns Policy</h1>
            <p class="mt-5 max-w-2xl text-base leading-7 text-stone-600 sm:text-lg">
                We handle returns carefully because beauty products are personal-use items. This page explains what we can accept,
                what we cannot accept, and how to contact us before sending anything back.
            </p>
            <div class="mt-6 text-sm text-stone-500">
                Returns support: {{ \App\Helpers\SettingsHelper::getEmailByType('returns') }} · {{ \App\Helpers\SettingsHelper::getPhone('primary') }}
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[220px_minmax(0,1fr)]">
            <aside class="lg:sticky lg:top-24 lg:self-start">
                <nav class="space-y-3 text-sm text-stone-600">
                    <a href="#overview" class="block hover:text-pink-600">Overview</a>
                    <a href="#eligible" class="block hover:text-pink-600">Eligible Returns</a>
                    <a href="#not-eligible" class="block hover:text-pink-600">Items We Cannot Accept</a>
                    <a href="#process" class="block hover:text-pink-600">How Returns Work</a>
                    <a href="#refunds" class="block hover:text-pink-600">Refunds</a>
                    <a href="#damaged-items" class="block hover:text-pink-600">Damaged or Incorrect Items</a>
                    <a href="#exchanges" class="block hover:text-pink-600">Exchanges</a>
                    <a href="#contact" class="block hover:text-pink-600">Contact</a>
                </nav>
            </aside>

            <div class="bg-white px-6 py-8 shadow-sm ring-1 ring-stone-200 sm:px-10">
                <div id="overview" class="border-b border-stone-200 pb-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Overview</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            Most eligible products may be returned within 30 days of purchase if they are unused, unopened, and in their
                            original packaging.
                        </p>
                        <p>
                            Before returning any order, contact our team first. We will review the issue and confirm the next step so your
                            return is handled correctly.
                        </p>
                    </div>
                </div>

                <div id="eligible" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Eligible Returns</h2>
                    <ul class="mt-5 space-y-3 text-base leading-7 text-stone-700">
                        <li>Unopened products in original packaging</li>
                        <li>Items with confirmed manufacturing defects</li>
                        <li>Orders that arrived damaged in transit</li>
                        <li>Incorrect items sent by our team</li>
                    </ul>
                </div>

                <div id="not-eligible" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Items We Cannot Accept</h2>
                    <ul class="mt-5 space-y-3 text-base leading-7 text-stone-700">
                        <li>Opened or used beauty products</li>
                        <li>Personal care items that cannot be resold for hygiene reasons</li>
                        <li>Clearance or final-sale items, unless they arrive faulty or incorrect</li>
                        <li>Gift cards</li>
                    </ul>
                </div>

                <div id="process" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">How Returns Work</h2>
                    <ol class="mt-5 space-y-5 text-base leading-7 text-stone-700">
                        <li>
                            <strong class="font-semibold text-stone-900">1. Contact us first.</strong>
                            Email {{ \App\Helpers\SettingsHelper::getEmailByType('returns') }} or call {{ \App\Helpers\SettingsHelper::getPhone('primary') }}
                            with your order number and the reason for the return.
                        </li>
                        <li>
                            <strong class="font-semibold text-stone-900">2. Wait for confirmation.</strong>
                            We will confirm whether the item qualifies and explain what to send back.
                        </li>
                        <li>
                            <strong class="font-semibold text-stone-900">3. Pack the item securely.</strong>
                            Include the order details and keep the product in its original condition.
                        </li>
                        <li>
                            <strong class="font-semibold text-stone-900">4. Send it using a traceable method.</strong>
                            Keep your shipping receipt until the return has been completed.
                        </li>
                    </ol>
                </div>

                <div id="refunds" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Refunds</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            Once we receive and inspect an approved return, refunds are usually processed within 5 to 7 business days.
                        </p>
                        <ul class="space-y-3">
                            <li>Refunds are sent back to the original payment method.</li>
                            <li>Original delivery charges are not refunded unless the item was faulty, damaged, or incorrect.</li>
                            <li>We will notify you by email once the refund has been processed.</li>
                        </ul>
                    </div>
                </div>

                <div id="damaged-items" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Damaged or Incorrect Items</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            If your order arrives damaged or you receive the wrong item, contact us as soon as possible after delivery.
                        </p>
                        <p>
                            Include your order number and, where possible, clear photos of the item and packaging. This helps us resolve the
                            issue faster and arrange a replacement or refund where appropriate.
                        </p>
                    </div>
                </div>

                <div id="exchanges" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Exchanges</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            Exchanges are handled case by case, depending on product condition and available stock.
                        </p>
                        <p>
                            If you would like a replacement item, contact us first and we will advise whether an exchange or refund is the
                            better route for your order.
                        </p>
                    </div>
                </div>

                <div id="contact" class="pt-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Contact</h2>
                    <div class="mt-5 space-y-3 text-base leading-7 text-stone-700">
                        <p><strong class="font-semibold text-stone-900">Email:</strong> {{ \App\Helpers\SettingsHelper::getEmailByType('returns') }}</p>
                        <p><strong class="font-semibold text-stone-900">Phone:</strong> {{ \App\Helpers\SettingsHelper::getPhone('primary') }}</p>
                        <p><strong class="font-semibold text-stone-900">Hours:</strong> Monday to Friday, {{ \App\Helpers\SettingsHelper::getBusinessHours('monday_friday') }}</p>
                        <p><strong class="font-semibold text-stone-900">Address:</strong> {{ \App\Helpers\SettingsHelper::getAddress('full') }}</p>
                    </div>
                    <p class="mt-6 text-sm leading-6 text-stone-500">
                        This policy may be updated from time to time. For questions about a specific order, contact our team before returning the item.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
