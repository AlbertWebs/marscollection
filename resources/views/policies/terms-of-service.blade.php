@extends('layouts.app')

@section('title', 'Terms of Service - Zayn\'s Beauty')

@section('content')
<div class="min-h-screen bg-stone-50">
    <section class="border-b border-stone-200 bg-white">
        <div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-pink-600">Legal</p>
            <h1 class="mt-4 max-w-3xl text-4xl font-semibold tracking-tight text-stone-900 sm:text-5xl">Terms of Service</h1>
            <p class="mt-5 max-w-2xl text-base leading-7 text-stone-600 sm:text-lg">
                These terms explain the rules that apply when you browse our website, place an order, book a service, or interact with Zayn's Beauty online.
            </p>
            <div class="mt-6 text-sm text-stone-500">
                Effective date: January 1, 2024 · Last updated: January 1, 2024
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[220px_minmax(0,1fr)]">
            <aside class="lg:sticky lg:top-24 lg:self-start">
                <nav class="space-y-3 text-sm text-stone-600">
                    <a href="#acceptance" class="block hover:text-pink-600">Acceptance</a>
                    <a href="#use" class="block hover:text-pink-600">Use of Site</a>
                    <a href="#accounts" class="block hover:text-pink-600">Accounts</a>
                    <a href="#orders" class="block hover:text-pink-600">Orders and Pricing</a>
                    <a href="#shipping" class="block hover:text-pink-600">Shipping and Returns</a>
                    <a href="#content" class="block hover:text-pink-600">Content and Reviews</a>
                    <a href="#liability" class="block hover:text-pink-600">Liability</a>
                    <a href="#contact" class="block hover:text-pink-600">Contact</a>
                </nav>
            </aside>

            <div class="bg-white px-6 py-8 shadow-sm ring-1 ring-stone-200 sm:px-10">
                <div id="acceptance" class="border-b border-stone-200 pb-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Acceptance</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            By accessing or using our website and services, you agree to these Terms of Service.
                        </p>
                        <p>
                            If you do not agree with these terms, you should not use the website or place orders through it.
                        </p>
                    </div>
                </div>

                <div id="use" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Use of Site</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            You may use this website only for lawful purposes and in a way that does not interfere with its operation or other users.
                        </p>
                        <ul class="space-y-3">
                            <li>Do not misuse, disrupt, or attempt to gain unauthorized access to the site</li>
                            <li>Do not copy, republish, or exploit site materials for commercial use without permission</li>
                            <li>Do not use automated tools in a way that harms performance or availability</li>
                        </ul>
                    </div>
                </div>

                <div id="accounts" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Accounts</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            If you create an account, you are responsible for keeping your login details secure and for ensuring your account information stays accurate.
                        </p>
                        <p>
                            We may suspend or remove accounts where misuse, fraud, or false information is involved.
                        </p>
                    </div>
                </div>

                <div id="orders" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Orders and Pricing</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            Product listings, pricing, and availability may change without notice. We do our best to keep information accurate, but errors can still happen.
                        </p>
                        <ul class="space-y-3">
                            <li>All prices are shown in Kenyan Shillings unless stated otherwise</li>
                            <li>Payment is required at checkout unless another arrangement is clearly stated</li>
                            <li>We reserve the right to cancel orders affected by pricing, stock, or verification issues</li>
                        </ul>
                    </div>
                </div>

                <div id="shipping" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Shipping and Returns</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            Delivery windows are estimates and may change due to courier or operational factors outside our control.
                        </p>
                        <p>
                            Returns and refunds are handled according to our published returns policy. Some beauty and personal-use items may not qualify for return once opened.
                        </p>
                    </div>
                </div>

                <div id="content" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Content and Reviews</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            If you submit reviews, comments, or other content, you confirm that you have the right to share it and that it does not violate anyone else's rights.
                        </p>
                        <p>
                            We may remove content that is misleading, abusive, unlawful, or otherwise inappropriate.
                        </p>
                    </div>
                </div>

                <div id="liability" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Liability</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            We aim to keep the website accurate and available, but we do not guarantee uninterrupted access or that every detail will always be error-free.
                        </p>
                        <p>
                            To the extent allowed by law, Zayn's Beauty is not liable for indirect losses, service interruptions, or delays outside reasonable control.
                        </p>
                        <p>
                            These terms are governed by the laws of Kenya.
                        </p>
                    </div>
                </div>

                <div id="contact" class="pt-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Contact</h2>
                    <div class="mt-5 space-y-3 text-base leading-7 text-stone-700">
                        <p><strong class="font-semibold text-stone-900">Email:</strong> {{ \App\Helpers\SettingsHelper::getEmail('support') }}</p>
                        <p><strong class="font-semibold text-stone-900">Phone:</strong> {{ \App\Helpers\SettingsHelper::getPhone('primary') }}</p>
                        <p><strong class="font-semibold text-stone-900">Address:</strong> {{ \App\Helpers\SettingsHelper::getAddress('full') }}</p>
                    </div>
                    <p class="mt-6 text-sm leading-6 text-stone-500">
                        We may update these terms from time to time. Continued use of the website after changes are posted means you accept the revised version.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
