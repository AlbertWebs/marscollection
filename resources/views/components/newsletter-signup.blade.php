<section class="py-14 bg-pink-50 border-t border-pink-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-xl text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Get beauty tips & offers first</h2>
        <p class="text-gray-500 text-sm mb-6">New arrivals, exclusive deals, and skincare advice, straight to your inbox. No spam.</p>

        @if(session('newsletter_success'))
            <div class="mb-4 border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 rounded-md">
                {{ session('newsletter_success') }}
            </div>
        @endif

        <form action="{{ route('newsletter.subscribe') }}" method="POST"
              class="flex flex-col sm:flex-row gap-3">
            @csrf
            <input type="email" name="email" required
                   placeholder="your@email.com"
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent">
            <button type="submit"
                    class="bg-pink-600 hover:bg-pink-700 text-white text-sm font-semibold px-6 py-3 rounded-md transition-colors">
                Subscribe
            </button>
        </form>
    </div>
</section>
