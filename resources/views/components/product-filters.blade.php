<aside class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm lg:sticky lg:top-20 lg:self-start lg:max-h-[calc(100vh-6rem)] lg:overflow-y-auto">
    <div class="relative overflow-hidden bg-gray-950 px-5 py-5 text-white">
        <div class="absolute -right-7 -top-10 h-28 w-28 rounded-full border-[18px] border-amber-500/10" aria-hidden="true"></div>
        <div class="relative flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500 text-gray-950 shadow-lg shadow-amber-950/30">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5h16l-6.2 7.1v5.3l-3.6 1.8v-7.1L4 5Z"/></svg>
            </span>
            <div>
                <h2 class="text-base font-bold tracking-wide">Find your pair</h2>
                <p class="mt-0.5 text-xs text-gray-400">Fine-tune your search</p>
            </div>
        </div>
        @if(request()->hasAny(['category', 'brand', 'search', 'min_price', 'max_price']))
            <div class="relative mt-4 inline-flex items-center gap-1.5 rounded-full border border-white/10 bg-white/5 px-2.5 py-1 text-[11px] font-medium text-amber-200">
                <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span> Filters applied
            </div>
        @endif
    </div>

    <div class="p-5">
        <form method="GET" action="{{ route('products.index') }}" class="space-y-5">
            @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
            @if(request('brand'))<input type="hidden" name="brand" value="{{ request('brand') }}">@endif

            <div>
                <label for="filter-search" class="mb-2 block text-xs font-bold uppercase tracking-[0.12em] text-gray-500">Search shoes</label>
                <div class="relative">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="11" cy="11" r="7" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="m16 16 4 4"/></svg>
                    <input id="filter-search" type="search" name="search" value="{{ request('search') }}"
                           class="w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-9 pr-3 text-sm text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10"
                           placeholder="e.g. leather, black...">
                </div>
            </div>

            <div class="border-t border-gray-100 pt-4">
                <div class="mb-3 flex items-center justify-between">
                    <label class="text-xs font-bold uppercase tracking-[0.12em] text-gray-500">Price range</label>
                    <span class="text-[11px] font-medium text-gray-400">KES</span>
                </div>
                <div class="grid grid-cols-2 gap-2.5">
                    <label class="block">
                        <span class="mb-1 block text-[11px] text-gray-400">Minimum</span>
                        <input type="number" name="min_price" value="{{ request('min_price', '') }}" placeholder="1,000" min="0"
                               class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10">
                    </label>
                    <label class="block">
                        <span class="mb-1 block text-[11px] text-gray-400">Maximum</span>
                        <input type="number" name="max_price" value="{{ request('max_price', '') }}" placeholder="50,000" min="0"
                               class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2.5 text-sm text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10">
                    </label>
                </div>
            </div>

            <button type="submit" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-amber-500 px-4 py-3 text-sm font-bold text-gray-950 shadow-sm transition hover:bg-amber-400 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600">
                Show matching shoes
                <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </button>
            @if(request()->hasAny(['search', 'min_price', 'max_price']))
                <a href="{{ route('products.index', array_merge(request()->except(['search', 'min_price', 'max_price', 'page']))) }}" class="-mt-2 block text-center text-xs font-medium text-gray-500 underline decoration-gray-300 underline-offset-4 transition hover:text-amber-700">Clear search and price</a>
            @endif
        </form>

        <section class="mt-6 border-t border-gray-100 pt-5" aria-labelledby="filter-categories-title">
            <div class="mb-3 flex items-center justify-between">
                <h3 id="filter-categories-title" class="text-xs font-bold uppercase tracking-[0.12em] text-gray-500">Shop by category</h3>
                <span class="rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-semibold text-gray-500">{{ $activeCategories->count() }}</span>
            </div>
            <nav class="space-y-1" aria-label="Product categories">
                <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']))) }}" @if(!request('category')) aria-current="page" @endif
                   class="group flex items-center justify-between rounded-xl px-3 py-2.5 text-sm transition {{ !request('category') ? 'bg-amber-50 font-semibold text-amber-900 ring-1 ring-inset ring-amber-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950' }}">
                    <span class="flex items-center gap-2.5"><span class="h-1.5 w-1.5 rounded-full {{ !request('category') ? 'bg-amber-500' : 'bg-gray-300 group-hover:bg-amber-400' }}"></span>All categories</span>
                    @if(!request('category'))<svg class="h-4 w-4 text-amber-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.2 7.26a1 1 0 0 1-1.42.003l-3.8-3.8a1 1 0 0 1 1.414-1.414l3.09 3.09 6.493-6.547a1 1 0 0 1 1.417-.006Z" clip-rule="evenodd"/></svg>@endif
                </a>
                @foreach($activeCategories as $cat)
                    @php $categoryIsSelected = request('category') === $cat->slug; @endphp
                    <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}" @if($categoryIsSelected) aria-current="page" @endif
                       class="group flex items-center justify-between rounded-xl px-3 py-2.5 text-sm transition {{ $categoryIsSelected ? 'bg-amber-50 font-semibold text-amber-900 ring-1 ring-inset ring-amber-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950' }}">
                        <span class="flex min-w-0 items-center gap-2.5"><span class="h-1.5 w-1.5 shrink-0 rounded-full {{ $categoryIsSelected ? 'bg-amber-500' : 'bg-gray-300 group-hover:bg-amber-400' }}"></span><span class="truncate">{{ $cat->name }}</span></span>
                        @if($categoryIsSelected)<svg class="h-4 w-4 shrink-0 text-amber-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.2 7.26a1 1 0 0 1-1.42.003l-3.8-3.8a1 1 0 0 1 1.414-1.414l3.09 3.09 6.493-6.547a1 1 0 0 1 1.417-.006Z" clip-rule="evenodd"/></svg>@endif
                    </a>
                @endforeach
            </nav>
        </section>

        <section class="mt-6 border-t border-gray-100 pt-5" aria-labelledby="filter-brands-title">
            <div class="mb-3 flex items-center justify-between">
                <h3 id="filter-brands-title" class="text-xs font-bold uppercase tracking-[0.12em] text-gray-500">Brands</h3>
                <span class="rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-semibold text-gray-500">{{ $brands->count() }}</span>
            </div>
            <nav class="space-y-1" aria-label="Product brands">
                <a href="{{ route('products.index', array_merge(request()->except(['brand', 'page']))) }}" @if(!request('brand')) aria-current="page" @endif
                   class="group flex items-center justify-between rounded-xl px-3 py-2.5 text-sm transition {{ !request('brand') ? 'bg-amber-50 font-semibold text-amber-900 ring-1 ring-inset ring-amber-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950' }}">
                    <span class="flex items-center gap-2.5"><span class="h-1.5 w-1.5 rounded-full {{ !request('brand') ? 'bg-amber-500' : 'bg-gray-300 group-hover:bg-amber-400' }}"></span>All brands</span>
                </a>
                @foreach($brands as $br)
                    @php $brandIsSelected = request('brand') === $br->slug; @endphp
                    <a href="{{ route('products.index', array_merge(request()->except(['brand', 'page']), ['brand' => $br->slug])) }}" @if($brandIsSelected) aria-current="page" @endif
                       class="group flex items-center justify-between rounded-xl px-3 py-2.5 text-sm transition {{ $brandIsSelected ? 'bg-amber-50 font-semibold text-amber-900 ring-1 ring-inset ring-amber-200' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-950' }}">
                        <span class="flex min-w-0 items-center gap-2.5"><span class="h-1.5 w-1.5 shrink-0 rounded-full {{ $brandIsSelected ? 'bg-amber-500' : 'bg-gray-300 group-hover:bg-amber-400' }}"></span><span class="truncate">{{ $br->name }}</span></span>
                        @if($brandIsSelected)<svg class="h-4 w-4 shrink-0 text-amber-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.2 7.26a1 1 0 0 1-1.42.003l-3.8-3.8a1 1 0 0 1 1.414-1.414l3.09 3.09 6.493-6.547a1 1 0 0 1 1.417-.006Z" clip-rule="evenodd"/></svg>@endif
                    </a>
                @endforeach
            </nav>
        </section>

        @if(request()->hasAny(['search', 'category', 'brand', 'min_price', 'max_price']))
            <div class="mt-6 border-t border-gray-100 pt-5">
                <div class="mb-3 flex items-center justify-between">
                    <h3 class="text-xs font-bold uppercase tracking-[0.12em] text-gray-500">Your filters</h3>
                    <a href="{{ route('products.index') }}" class="text-[11px] font-semibold text-amber-700 hover:text-amber-900">Clear all</a>
                </div>
                <div class="flex flex-wrap gap-2">
                    @if(request('search'))<span class="rounded-full border border-gray-200 bg-gray-50 px-2.5 py-1 text-[11px] text-gray-600">“{{ request('search') }}”</span>@endif
                    @if(request('category') && ($selectedCategory = $activeCategories->firstWhere('slug', request('category'))))<span class="rounded-full border border-amber-200 bg-amber-50 px-2.5 py-1 text-[11px] text-amber-900">{{ $selectedCategory->name }}</span>@endif
                    @if(request('brand') && ($selectedBrand = $brands->firstWhere('slug', request('brand'))))<span class="rounded-full border border-amber-200 bg-amber-50 px-2.5 py-1 text-[11px] text-amber-900">{{ $selectedBrand->name }}</span>@endif
                    @if(request('min_price') || request('max_price'))<span class="rounded-full border border-gray-200 bg-gray-50 px-2.5 py-1 text-[11px] text-gray-600">KES {{ request('min_price', '0') }}–{{ request('max_price', '∞') }}</span>@endif
                </div>
            </div>
        @endif
    </div>
</aside>
