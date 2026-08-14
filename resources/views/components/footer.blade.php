@php
    $phone    = \App\Models\Setting::get('contact_phone_primary', '');
    $email    = \App\Models\Setting::get('contact_email_primary', '');
    $address  = \App\Models\Setting::get('contact_address_city', 'Nairobi, Kenya');
    $facebook = \App\Models\Setting::get('social_facebook', '');
    $instagram= \App\Models\Setting::get('social_instagram', '');
    $twitter  = \App\Models\Setting::get('social_twitter', '');
@endphp

<footer class="bg-gray-950 text-gray-400">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-12">

            <!-- Brand column -->
            <div class="md:col-span-4">
                <a href="{{ route('home') }}" aria-label="Zayn's Beauty">
                    <img src="{{ asset('logo.svg') }}" alt="Zayn's Beauty" class="h-9 w-auto brightness-0 invert">
                </a>
                <p class="mt-3 text-sm leading-relaxed text-gray-500 max-w-xs">
                    Premium beauty products and salon services, based in Nairobi, serving all of Kenya.
                </p>

                <!-- Contact details -->
                <ul class="mt-5 space-y-2 text-sm">
                    @if($address)
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $address }}</span>
                    </li>
                    @endif
                    @if($phone)
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:{{ $phone }}" class="hover:text-white transition-colors">{{ $phone }}</a>
                    </li>
                    @endif
                    @if($email)
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0 text-pink-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <a href="mailto:{{ $email }}" class="hover:text-white transition-colors">{{ $email }}</a>
                    </li>
                    @endif
                </ul>

                <!-- Social icons -->
                @if($instagram || $facebook || $twitter)
                <div class="flex gap-4 mt-6">
                    @if($instagram)
                    <a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"
                       class="hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    @endif
                    @if($facebook)
                    <a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"
                       class="hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 01-1.93.07 4.28 4.28 0 004 2.98 8.521 8.521 0 01-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                        </svg>
                    </a>
                    @endif
                    @if($twitter)
                    <a href="{{ $twitter }}" target="_blank" rel="noopener noreferrer" aria-label="Twitter/X"
                       class="hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    @endif
                </div>
                @endif
            </div>

            <!-- Nav columns: 2×2 on mobile, 4 equal cols on desktop -->
            <div class="md:col-span-8 grid grid-cols-2 md:grid-cols-4 gap-6">

                <!-- Shop -->
                <div>
                    <h4 class="text-white text-sm font-semibold uppercase tracking-wider mb-4">Shop</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">All Products</a></li>
                        <li><a href="{{ route('categories.index') }}" class="hover:text-white transition-colors">Categories</a></li>
                        <li><a href="{{ route('brands.index') }}" class="hover:text-white transition-colors">Brands</a></li>
                        <li><a href="{{ route('bundles.index') }}" class="hover:text-white transition-colors">Bundles</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-white transition-colors">My Cart</a></li>
                    </ul>
                </div>

                <!-- Services -->
                <div>
                    <h4 class="text-white text-sm font-semibold uppercase tracking-wider mb-4">Services</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('appointments.create') }}" class="hover:text-white transition-colors">Book Makeup Session</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Help -->
                <div>
                    <h4 class="text-white text-sm font-semibold uppercase tracking-wider mb-4">Help</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('shipping-info') }}" class="hover:text-white transition-colors">Shipping Info</a></li>
                        <li><a href="{{ route('returns-policy') }}" class="hover:text-white transition-colors">Returns Policy</a></li>
                        <li><a href="{{ route('privacy-policy') }}" class="hover:text-white transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('terms-of-service') }}" class="hover:text-white transition-colors">Terms of Service</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div class="col-span-2 md:col-span-1">
                    <h4 class="text-white text-sm font-semibold uppercase tracking-wider mb-4">Stay Updated</h4>
                    <p class="text-sm mb-4">New arrivals and offers, straight to your inbox.</p>
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-2">
                        @csrf
                        <input type="hidden" name="subject" value="Newsletter Signup">
                        <input type="hidden" name="first_name" value="Newsletter">
                        <input type="hidden" name="last_name" value="Subscriber">
                        <input type="hidden" name="message" value="Newsletter signup">
                        <input type="email" name="email" required placeholder="your@email.com"
                               class="w-full px-3 py-2.5 bg-gray-800 border border-gray-700 rounded-md text-white text-sm placeholder-gray-500 focus:outline-none focus:border-pink-500 transition-colors">
                        <button type="submit"
                                class="w-full bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold py-2.5 rounded-md transition-colors">
                            Subscribe
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <!-- Bottom bar -->
        <div class="border-t border-gray-800 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-600">
            <span>© {{ date('Y') }} Zayn's Beauty. All rights reserved.</span>
            <span>Designed by <a href="https://velinexlabs.com" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">Velinex Labs</a></span>
        </div>
    </div>
</footer>
