@php($heroImage = ltrim($homeContent->get('home.hero.image', '/images/mars-footwear-hero.png'), '/'))
<section class="relative isolate flex min-h-[620px] items-center overflow-hidden bg-[#080808] sm:min-h-[680px]">
    <img src="{{ asset($heroImage) }}" alt="{{ $homeContent->get('home.hero.image_alt', 'Mars Collection footwear') }}" class="absolute inset-0 -z-20 h-full w-full object-cover object-center">
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-black via-black/80 to-black/10"></div>
    <div class="mx-auto w-full max-w-7xl px-5 py-20 sm:px-8 lg:px-12">
        <div class="max-w-2xl">
            <p class="mb-5 text-xs font-semibold uppercase tracking-[0.32em] text-amber-300">{{ $homeContent->get('home.hero.eyebrow', 'Footwear for every move') }}</p>
            <h1 class="max-w-xl text-5xl font-black leading-[0.98] tracking-tight text-white sm:text-6xl lg:text-7xl">{{ $homeContent->get('home.hero.title_start', 'Own Every') }} <span class="text-amber-300">{{ $homeContent->get('home.hero.title_end', 'Step.') }}</span></h1>
            <p class="mt-6 max-w-lg text-base leading-7 text-gray-300 sm:text-lg">{{ $homeContent->get('home.hero.description', 'Fresh kicks, timeless classics and everyday comfort. Find your next favourite pair at Mars Collection.') }}</p>
            <div class="mt-9 flex flex-wrap gap-3">
                <a href="{{ route('products.index') }}" class="inline-flex items-center rounded-full bg-amber-400 px-7 py-3.5 text-sm font-bold uppercase tracking-wide text-gray-950 transition hover:bg-amber-300">{{ $homeContent->get('home.hero.primary_button', 'Shop footwear') }} <span aria-hidden="true" class="ml-3">→</span></a>
                <a href="{{ route('categories.index') }}" class="inline-flex items-center rounded-full border border-white/40 px-7 py-3.5 text-sm font-semibold text-white transition hover:border-amber-300 hover:text-amber-300">{{ $homeContent->get('home.hero.secondary_button', 'Browse categories') }}</a>
            </div>
            <div class="mt-12 flex items-center gap-3 text-xs font-medium uppercase tracking-[0.18em] text-gray-400">
                <span class="h-px w-10 bg-amber-400"></span> {{ $homeContent->get('home.hero.categories', 'Sneakers · Formal · Everyday') }}
            </div>
        </div>
    </div>
</section>
