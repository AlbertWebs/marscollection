@php
    $phone    = \App\Models\Setting::get('contact_phone_primary', '');
    $email    = \App\Models\Setting::get('contact_email_primary', '');
    $address  = \App\Models\Setting::get('contact_address_city', 'Nairobi, Kenya');
    $facebook = \App\Models\Setting::get('social_facebook', '');
    $instagram= \App\Models\Setting::get('social_instagram', '');
    $twitter  = \App\Models\Setting::get('social_twitter', '');
@endphp

<footer class="bg-gray-950 text-gray-400" style="background-image: linear-gradient(rgba(3, 7, 18, 0.965), rgba(3, 7, 18, 0.965)), url('{{ asset('images/sneakers-runner.jpg') }}'); background-size: cover; background-position: center 58%;">
    {{-- Reassurance / Trust Highlights Strip --}}
    <div class="border-b border-gray-800/80 bg-gray-900/60">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center md:text-left">
                
                {{-- Free Delivery --}}
                <div class="flex flex-col md:flex-row items-center md:items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider">Delivery across Kenya</h5>
                        <p class="text-[11px] sm:text-xs text-gray-400 mt-0.5">Shoes for your next step</p>
                    </div>
                </div>

                {{-- M-Pesa Support --}}
                <div class="flex flex-col md:flex-row items-center md:items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider">Lipa Na M-Pesa</h5>
                        <p class="text-[11px] sm:text-xs text-gray-400 mt-0.5">Till, STK Push & Paybill accepted</p>
                    </div>
                </div>

                {{-- Fit support --}}
                <div class="flex flex-col md:flex-row items-center md:items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider">Need a size?</h5>
                        <p class="text-[11px] sm:text-xs text-gray-400 mt-0.5">Contact us before you order</p>
                    </div>
                </div>

                {{-- Same-Day Dispatch --}}
                <div class="flex flex-col md:flex-row items-center md:items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-purple-500/10 border border-purple-500/20 flex items-center justify-center text-purple-400 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider">Same-Day Delivery</h5>
                        <p class="text-[11px] sm:text-xs text-gray-400 mt-0.5">Nairobi CBD & countrywide dispatch</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 mb-12">

            <!-- Brand column -->
            <div class="md:col-span-4">
                <a href="{{ route('home') }}" aria-label="Mars Collection">
                    <img src="{{ \App\Helpers\SettingsHelper::getBrandLogoUrl() }}" alt="Mars Collection" class="h-10 w-auto">
                </a>
                <p class="mt-3 text-sm leading-relaxed text-gray-400 max-w-xs">
                    Sneakers, smart classics and everyday footwear. Find your fit with Mars Collection.
                </p>

                <!-- Contact details -->
                <ul class="mt-5 space-y-2 text-sm">
                    @if($address)
                    <li class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>{{ $address }}</span>
                    </li>
                    @endif
                    @if($phone)
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        <a href="tel:{{ $phone }}" class="hover:text-white transition-colors">{{ $phone }}</a>
                    </li>
                    @endif
                    @if($email)
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <li><a href="{{ route('products.index') }}" class="hover:text-white transition-colors">All Footwear</a></li>
                        <li><a href="{{ route('categories.index') }}" class="hover:text-white transition-colors">Categories</a></li>
                        <li><a href="{{ route('brands.index') }}" class="hover:text-white transition-colors">Labels</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-white transition-colors">My Cart</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div>
                    <h4 class="text-white text-sm font-semibold uppercase tracking-wider mb-4">Mars Collection</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('about') }}" class="hover:text-white transition-colors">Our Story</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

                <!-- Help -->
                <div>
                    <h4 class="text-white text-sm font-semibold uppercase tracking-wider mb-4">Help & Policy</h4>
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
                    <p class="text-sm mb-4 text-gray-400">New arrivals and exclusive offers, straight to your inbox.</p>
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-2">
                        @csrf
                        <input type="hidden" name="subject" value="Newsletter Signup">
                        <input type="hidden" name="first_name" value="Newsletter">
                        <input type="hidden" name="last_name" value="Subscriber">
                        <input type="hidden" name="message" value="Newsletter signup">
                        <input type="email" name="email" required placeholder="your@email.com"
                               class="w-full px-3 py-2.5 bg-gray-900 border border-gray-800 rounded-md text-white text-sm placeholder-gray-500 focus:outline-none focus:border-amber-500 transition-colors">
                        <button type="submit"
                                class="w-full bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold py-2.5 rounded-md transition-colors shadow-sm">
                            Subscribe
                        </button>
                    </form>
                </div>

            </div>
        </div>

        <!-- Payment methods & reassurance bar -->
        <div class="border-t border-gray-800/80 pt-6 pb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2 text-xs text-gray-400">
                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <span>Guaranteed Safe & Secure Checkout</span>
            </div>

            {{-- Payment Badges: M-Pesa, Visa, Mastercard, Cash on Delivery --}}
            <div class="flex flex-wrap items-center justify-center gap-2">
                {{-- M-Pesa Badge --}}
                <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded bg-white border border-gray-200 shadow-2xs">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#00A34F]"></span>
                    <span class="text-xs font-black tracking-tight text-[#00A34F]">M-PESA</span>
                    <span class="text-[9px] font-semibold text-gray-500 uppercase tracking-tighter">Till / STK</span>
                </div>

                {{-- Visa Badge --}}
                <div class="inline-flex items-center px-2.5 py-1.5 rounded bg-white border border-gray-200 shadow-2xs">
                    <span class="text-xs font-black italic tracking-tighter text-[#1434CB]">VISA</span>
                </div>

                {{-- Mastercard Badge --}}
                <div class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded bg-white border border-gray-200 shadow-2xs">
                    <div class="flex -space-x-1">
                        <span class="w-3 h-3 rounded-full bg-[#EB001B] inline-block opacity-90"></span>
                        <span class="w-3 h-3 rounded-full bg-[#F79E1B] inline-block opacity-90"></span>
                    </div>
                    <span class="text-[10px] font-bold text-gray-800">Mastercard</span>
                </div>

                {{-- Airtel Money Badge --}}
                <div class="inline-flex items-center px-2.5 py-1.5 rounded bg-white border border-gray-200 shadow-2xs">
                    <span class="text-xs font-bold text-[#E40000]">airtel <span class="font-normal text-[10px]">money</span></span>
                </div>

                {{-- Cash on Delivery Badge --}}
                <div class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded bg-gray-900 border border-gray-800 text-gray-300 shadow-2xs">
                    <svg class="w-3 h-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="text-[10px] font-semibold">Cash / Card on Delivery</span>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="border-t border-gray-900 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-600">
            <span>© {{ date('Y') }} Mars Collection. All rights reserved.</span>
            <span>Designed by <a href="http://designekta.com/" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">Designekta Studios</a></span>
        </div>
    </div>
</footer>
