@extends('layouts.app')

@section('title', 'Privacy Policy - Zayn\'s Beauty')

@section('content')
<div class="min-h-screen bg-stone-50">
    <section class="border-b border-stone-200 bg-white">
        <div class="mx-auto max-w-5xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-pink-600">Privacy</p>
            <h1 class="mt-4 max-w-3xl text-4xl font-semibold tracking-tight text-stone-900 sm:text-5xl">Privacy Policy</h1>
            <p class="mt-5 max-w-2xl text-base leading-7 text-stone-600 sm:text-lg">
                This page explains what information we collect, how we use it, and the choices you have when using Zayn's Beauty.
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
                    <a href="#introduction" class="block hover:text-pink-600">Introduction</a>
                    <a href="#collection" class="block hover:text-pink-600">Information We Collect</a>
                    <a href="#use" class="block hover:text-pink-600">How We Use Information</a>
                    <a href="#sharing" class="block hover:text-pink-600">Sharing</a>
                    <a href="#security" class="block hover:text-pink-600">Security and Retention</a>
                    <a href="#rights" class="block hover:text-pink-600">Your Choices</a>
                    <a href="#cookies" class="block hover:text-pink-600">Cookies</a>
                    <a href="#contact" class="block hover:text-pink-600">Contact</a>
                </nav>
            </aside>

            <div class="bg-white px-6 py-8 shadow-sm ring-1 ring-stone-200 sm:px-10">
                <div id="introduction" class="border-b border-stone-200 pb-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Introduction</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            This Privacy Policy applies to customers, visitors, and anyone who interacts with our website or services.
                        </p>
                        <p>
                            By using our website, placing an order, booking an appointment, or contacting us, you agree to the way we handle
                            information as described on this page.
                        </p>
                    </div>
                </div>

                <div id="collection" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Information We Collect</h2>
                    <div class="mt-5 space-y-5 text-base leading-7 text-stone-700">
                        <div>
                            <h3 class="text-lg font-semibold text-stone-900">Information you provide directly</h3>
                            <ul class="mt-3 space-y-3">
                                <li>Name, email address, phone number, and delivery address</li>
                                <li>Account and login details where applicable</li>
                                <li>Order history, appointment details, and support messages</li>
                                <li>Payment and billing information processed through our payment providers</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-stone-900">Information collected automatically</h3>
                            <ul class="mt-3 space-y-3">
                                <li>IP address, browser type, device information, and operating system</li>
                                <li>Pages visited, time spent on the site, and general usage activity</li>
                                <li>Cookie and analytics data used to improve website performance</li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-stone-900">Information from third parties</h3>
                            <ul class="mt-3 space-y-3">
                                <li>Payment processors</li>
                                <li>Delivery and logistics providers</li>
                                <li>Marketing or analytics tools where used</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div id="use" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">How We Use Information</h2>
                    <ul class="mt-5 space-y-3 text-base leading-7 text-stone-700">
                        <li>To process orders, payments, deliveries, and appointment bookings</li>
                        <li>To communicate with you about your orders, bookings, or support requests</li>
                        <li>To improve our products, service quality, and website performance</li>
                        <li>To send marketing messages where you have agreed to receive them</li>
                        <li>To prevent fraud, misuse, and security issues</li>
                        <li>To comply with legal or regulatory requirements</li>
                    </ul>
                </div>

                <div id="sharing" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Sharing</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            We do not sell your personal information. We only share it where necessary to operate the business and fulfill your requests.
                        </p>
                        <ul class="space-y-3">
                            <li>With payment providers to complete transactions</li>
                            <li>With delivery partners to fulfill orders</li>
                            <li>With service providers who help us run the website or support operations</li>
                            <li>Where disclosure is required by law or to protect our business and customers</li>
                        </ul>
                    </div>
                </div>

                <div id="security" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Security and Retention</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            We take reasonable technical and organizational steps to protect the information we hold.
                        </p>
                        <p>
                            We keep personal information only for as long as it is needed for operational, legal, accounting, or customer-service purposes.
                        </p>
                        <p>
                            No online system can guarantee absolute security, but we work to reduce unnecessary risk and limit access appropriately.
                        </p>
                    </div>
                </div>

                <div id="rights" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Your Choices</h2>
                    <ul class="mt-5 space-y-3 text-base leading-7 text-stone-700">
                        <li>You may ask to review or correct the information we hold about you</li>
                        <li>You may opt out of marketing communications</li>
                        <li>You may ask questions about how your information is used</li>
                        <li>You may request deletion where retention is no longer required and the law allows it</li>
                    </ul>
                </div>

                <div id="cookies" class="border-b border-stone-200 py-8">
                    <h2 class="text-2xl font-semibold text-stone-900">Cookies</h2>
                    <div class="mt-5 space-y-4 text-base leading-7 text-stone-700">
                        <p>
                            We may use cookies and similar technologies to keep the site functioning properly, understand usage patterns,
                            and improve the customer experience.
                        </p>
                        <p>
                            You can manage cookie behavior through your browser settings, though some website features may not work as intended if certain cookies are disabled.
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
                        We may update this policy from time to time. The most current version will always appear on this page.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
