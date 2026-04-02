<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 fade-in">
            <!-- Book a Service -->
            <div class="relative overflow-hidden rounded-xl bg-gray-900 text-white">
                <img src="https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=800&q=80"
                     alt="Beauty salon"
                     class="absolute inset-0 w-full h-full object-cover opacity-40">
                <div class="relative z-10 p-8">
                    <p class="text-pink-300 text-xs uppercase tracking-widest font-medium mb-3">Professional Services</p>
                    <h2 class="text-2xl font-bold mb-3">Salon & Beauty Services</h2>
                    <p class="text-gray-300 text-sm mb-6 max-w-xs">From facials to full glam, book a session with our certified beauty experts in Nairobi.</p>
                    <a href="{{ route('appointments.create') }}"
                       class="inline-block bg-white text-gray-900 text-sm font-semibold px-6 py-3 rounded-lg hover:bg-pink-50 transition-colors">
                        Book Appointment
                    </a>
                </div>
            </div>

            <!-- Shop Products -->
            <div class="relative overflow-hidden rounded-xl bg-pink-50 text-gray-900">
                <img src="https://images.unsplash.com/photo-1607006344380-b6775a0824a7?auto=format&fit=crop&w=800&q=80"
                     alt="Makeup products"
                     class="absolute inset-0 w-full h-full object-cover opacity-20">
                <div class="relative z-10 p-8">
                    <p class="text-pink-600 text-xs uppercase tracking-widest font-medium mb-3">New Arrivals</p>
                    <h2 class="text-2xl font-bold mb-3">Fresh Stock, Every Week</h2>
                    <p class="text-gray-600 text-sm mb-6 max-w-xs">Skincare, makeup and accessories, sourced and stocked for Nairobi's climate and skin tones.</p>
                    <a href="{{ route('products.index') }}"
                       class="inline-block bg-pink-600 text-white text-sm font-semibold px-6 py-3 rounded-lg hover:bg-pink-700 transition-colors">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
