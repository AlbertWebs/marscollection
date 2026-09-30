@php($homeContent = $homeContent ?? collect())
<section class="py-14 bg-amber-50 border-t border-amber-100">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-xl text-center">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $homeContent->get('home.newsletter.title', 'Get new arrivals & offers first') }}</h2>
        <p class="text-gray-500 text-sm mb-6">{{ $homeContent->get('home.newsletter.description', 'Footwear drops, exclusive offers, and updates from Mars Collection.') }}</p>

        @if(session('newsletter_success'))
            <div class="mb-4 border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 rounded-md">
                {{ session('newsletter_success') }}
            </div>
        @endif

        <form action="{{ route('newsletter.subscribe') }}" method="POST"
              class="flex flex-col sm:flex-row gap-3">
            @csrf
            <input type="email" name="email" required
                   placeholder="{{ $homeContent->get('home.newsletter.placeholder', 'your@email.com') }}"
                   class="flex-1 px-4 py-3 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent">
            <button type="submit"
                    class="bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold px-6 py-3 rounded-md transition-colors">
                {{ $homeContent->get('home.newsletter.button', 'Subscribe') }}
            </button>
        </form>
    </div>
</section>
