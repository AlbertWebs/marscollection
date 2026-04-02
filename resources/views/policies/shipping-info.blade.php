@extends('layouts.app')

@section('title', 'Shipping Information - Zayn\'s Beauty')

@section('content')
<div class="min-h-screen bg-stone-50">
    <section class="border-b border-stone-200 bg-white">
        <div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-pink-600">Delivery</p>
            <h1 class="mt-4 max-w-3xl text-4xl font-semibold tracking-tight text-stone-900 sm:text-5xl">Shipping Information</h1>
            <p class="mt-5 max-w-2xl text-base leading-7 text-stone-600 sm:text-lg">
                This page explains how we process orders, where we deliver, and what to expect once your package leaves us.
            </p>
            <div class="mt-6 text-sm text-stone-500">
                Shipping support: {{ \App\Helpers\SettingsHelper::getEmailByType('shipping') }} · {{ \App\Helpers\SettingsHelper::getPhone('primary') }}
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[220px_minmax(0,1fr)]">
            <aside class="lg:sticky lg:top-24 lg:self-start">
                <nav class="space-y-3 text-sm text-stone-600">
                    <a href="#overview" class="block hover:text-pink-600">Overview</a>
                    <a href="#areas" class="block hover:text-pink-600">Delivery Areas</a>
                    <a href="#processing" class="block hover:text-pink-600">Order Processing</a>
                    <a href="#timing" class="block hover:text-pink-600">Delivery Timelines</a>
                    <a href="#tracking" class="block hover:text-pink-600">Order Tracking</a>
                    <a href="#restrictions" class="block hover:text-pink-600">Restrictions</a>
                    <a href="#contact" class="block hover:text-pink-600">Contact</a>
                </nav>
            </aside>

            <div class="bg-white px-6 py-8 shadow-sm ring-1 ring-stone-200 sm:px-10">
                <div id="overview" class="border-b border-stone-200 pb-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Overview</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            We currently deliver within Kenya. Shipping costs and timelines may vary depending on your location,
                            order size, and whether a faster dispatch option is available.
                        </p>
                        <p>
                            Delivery estimates are provided in good faith, but they are not guaranteed. Public holidays, courier delays,
                            weather, and high-order periods may affect timing.
                        </p>
                    </div>
                </div>

                <div id="areas" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Delivery Areas</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>We currently ship to selected areas across Kenya, including:</p>
                        <ul class="space-y-3">
                            <li>Nairobi and surrounding areas</li>
                            <li>Mombasa</li>
                            <li>Kisumu</li>
                            <li>Nakuru</li>
                            <li>Eldoret</li>
                            <li>Thika</li>
                            <li>Other major towns where courier service is available</li>
                        </ul>
                        <p>
                            If you are unsure whether your area is covered, contact us before placing the order.
                        </p>
                    </div>
                </div>

                <div id="processing" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Order Processing</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            Most orders are processed within 24 hours after payment confirmation. Orders placed outside working hours,
                            over weekends, or on public holidays may be processed on the next business day.
                        </p>
                        <p>
                            Once the order has been packed and handed over for delivery, you will receive a shipping or dispatch update.
                        </p>
                    </div>
                </div>

                <div id="timing" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Delivery Timelines</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>Typical delivery windows are as follows:</p>
                        <ul class="space-y-3">
                            <li><strong class="font-semibold text-stone-900">Nairobi:</strong> usually 1 to 2 business days</li>
                            <li><strong class="font-semibold text-stone-900">Other major towns:</strong> usually 3 to 5 business days</li>
                            <li><strong class="font-semibold text-stone-900">Express options:</strong> may be available for selected locations</li>
                        </ul>
                        <p>
                            Some remote destinations may take longer depending on courier coverage.
                        </p>
                    </div>
                </div>

                <div id="tracking" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Order Tracking</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            Where tracking is available, we will share the relevant delivery details once the package has been dispatched.
                        </p>
                        <p>
                            If you need a manual status update, contact our support team with your order number and we will assist.
                        </p>
                    </div>
                </div>

                <div id="restrictions" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Restrictions</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>Some orders may need special handling or may not qualify for every shipping option.</p>
                        <ul class="space-y-3">
                            <li>Fragile items may require extra packaging and care</li>
                            <li>Large or bulky orders may attract additional delivery charges</li>
                            <li>Some products may be affected by temperature or handling limitations</li>
                            <li>International shipping is not currently available</li>
                        </ul>
                    </div>
                </div>

                <div id="contact" class="pt-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Contact</h2>
                    <div class="mt-5 space-y-3 text-base leading-7 text-stone-700">
                        <p><strong class="font-semibold text-stone-900">Email:</strong> {{ \App\Helpers\SettingsHelper::getEmailByType('shipping') }}</p>
                        <p><strong class="font-semibold text-stone-900">Phone:</strong> {{ \App\Helpers\SettingsHelper::getPhone('primary') }}</p>
                        <p><strong class="font-semibold text-stone-900">Hours:</strong> Monday to Friday, {{ \App\Helpers\SettingsHelper::getBusinessHours('monday_friday') }}</p>
                    </div>
                    <p class="mt-6 text-sm leading-6 text-stone-500">
                        Delivery times can change due to factors outside our control. If anything affects your order, we will update you as soon as possible.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
