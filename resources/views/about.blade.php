@extends('layouts.app')

@section('title', 'About Zayn\'s Beauty')

@section('content')
<div class="min-h-screen bg-stone-50">
    <section class="border-b border-stone-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[minmax(0,1.2fr)_minmax(280px,0.8fr)] lg:items-end">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-pink-600">About Us</p>
                    <h1 class="mt-4 max-w-3xl text-4xl font-semibold tracking-tight text-stone-900 sm:text-5xl">
                        A beauty store built around what people actually want to buy and use.
                    </h1>
                    <p class="mt-6 max-w-2xl text-base leading-7 text-stone-600 sm:text-lg">
                        Zayn's Beauty brings together beauty products, professional makeup services, and practical guidance in one place.
                        The aim is simple: make it easier to shop well, book well, and come back because the experience is clear and reliable.
                    </p>
                </div>
                <div class="border-l-0 border-stone-200 pt-0 lg:border-l lg:pl-8">
                    <dl class="space-y-5">
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Focus</dt>
                            <dd class="mt-1 text-lg text-stone-900">Beauty retail and makeup services</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">Based In</dt>
                            <dd class="mt-1 text-lg text-stone-900">Nairobi, Kenya</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-[0.24em] text-stone-500">What We Care About</dt>
                            <dd class="mt-1 text-lg text-stone-900">Useful selection, honest service, smooth delivery</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-stone-500">Who We Are</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-stone-900">Built for everyday beauty shopping, not just polished marketing.</h2>
            </div>
            <div class="space-y-5 text-base leading-7 text-stone-700">
                <p>
                    Zayn's Beauty was built to serve customers looking for a dependable beauty destination rather than a noisy catalogue.
                    That means keeping the product mix focused, making service booking straightforward, and speaking in a way that feels clear instead of inflated.
                </p>
                <p>
                    We sell products people come back for, not just products that photograph well. We also treat makeup appointments and beauty services as part of the same customer experience, not as a separate business bolted on at the side.
                </p>
                <p>
                    The result is a store that aims to feel edited, practical, and easy to trust.
                </p>
            </div>
        </div>
    </section>

    <section class="border-y border-stone-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-3">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-stone-500">Selection</p>
                    <p class="mt-4 text-lg leading-8 text-stone-800">
                        We focus on products that fit real routines, skin needs, and beauty habits rather than filling the store with noise.
                    </p>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-stone-500">Service</p>
                    <p class="mt-4 text-lg leading-8 text-stone-800">
                        Whether someone is shopping online or booking an appointment, the process should feel direct, helpful, and well handled.
                    </p>
                </div>
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.24em] text-stone-500">Standards</p>
                    <p class="mt-4 text-lg leading-8 text-stone-800">
                        We care about product quality, accurate communication, and delivering an experience that feels considered from start to finish.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-[minmax(0,1fr)_320px]">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-stone-500">How We Work</p>
                <div class="mt-5 space-y-8">
                    <div class="border-b border-stone-200 pb-6">
                        <h3 class="text-2xl font-semibold text-stone-900">We keep the offer tight.</h3>
                        <p class="mt-3 text-base leading-7 text-stone-700">
                            A better beauty store is not always the one with the most products. It is the one that makes choosing easier.
                            We prefer a tighter, clearer offer over a crowded shelf.
                        </p>
                    </div>
                    <div class="border-b border-stone-200 pb-6">
                        <h3 class="text-2xl font-semibold text-stone-900">We value clarity over slogans.</h3>
                        <p class="mt-3 text-base leading-7 text-stone-700">
                            Customers should know what they are buying, what to expect from delivery, and how to get help when they need it.
                            That standard shapes both the site and the service behind it.
                        </p>
                    </div>
                    <div>
                        <h3 class="text-2xl font-semibold text-stone-900">We want repeat trust, not one-time attention.</h3>
                        <p class="mt-3 text-base leading-7 text-stone-700">
                            The long-term goal is to be the kind of store people recommend because it is dependable, not because it made a loud first impression.
                        </p>
                    </div>
                </div>
            </div>

            <div class="self-start border border-stone-200 bg-white p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.24em] text-stone-500">Contact</p>
                <div class="mt-5 space-y-4 text-sm leading-6 text-stone-700">
                    <p><strong class="font-semibold text-stone-900">Email:</strong> {{ \App\Helpers\SettingsHelper::getEmail('support') }}</p>
                    <p><strong class="font-semibold text-stone-900">Phone:</strong> {{ \App\Helpers\SettingsHelper::getPhone('primary') }}</p>
                    <p><strong class="font-semibold text-stone-900">Address:</strong> {{ \App\Helpers\SettingsHelper::getAddress('full') }}</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
