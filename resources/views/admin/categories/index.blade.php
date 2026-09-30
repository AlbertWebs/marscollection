@extends('layouts.admin')

@section('title', 'Footwear Categories')

@section('content')
<div class="space-y-6">
    <section class="flex flex-col justify-between gap-4 rounded-2xl bg-gray-950 px-5 py-6 text-white sm:flex-row sm:items-center sm:px-7">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-300">Catalog organization</p>
            <h1 class="mt-2 text-2xl font-black sm:text-3xl">Shoe categories</h1>
            <p class="mt-1.5 max-w-xl text-sm text-gray-300">Group your footwear by style so shoppers can quickly find the right kind of pair.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-gray-950 transition hover:bg-amber-300"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-width="2" d="M12 5v14m-7-7h14"/></svg>Add shoe category</a>
    </section>

    <section class="grid gap-4 sm:grid-cols-3" aria-label="Category summary">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Active categories</p><p class="mt-2 text-3xl font-black text-gray-950">{{ number_format($catalogCounts['active']) }}</p><p class="mt-1 text-xs text-gray-500">Visible in the storefront</p></div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Active shoe listings</p><p class="mt-2 text-3xl font-black text-gray-950">{{ number_format($catalogCounts['products']) }}</p><p class="mt-1 text-xs text-gray-500">Products shoppers can browse</p></div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Archived categories</p><p class="mt-2 text-3xl font-black text-gray-950">{{ number_format($catalogCounts['inactive']) }}</p><p class="mt-1 text-xs text-gray-500">Hidden from the storefront</p></div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="flex flex-col justify-between gap-4 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:px-6">
            <div><h2 class="font-bold text-gray-950">{{ $status === 'active' ? 'Storefront categories' : 'Archived categories' }}</h2><p class="mt-1 text-xs text-gray-500">{{ $categories->total() }} {{ \Illuminate\Support\Str::plural('category', $categories->total()) }} in this view</p></div>
            <nav class="flex w-fit rounded-xl bg-gray-100 p-1" aria-label="Category status filter">
                <a href="{{ route('admin.categories.index', ['status' => 'active']) }}" @if($status === 'active') aria-current="page" @endif class="rounded-lg px-3 py-2 text-xs font-bold transition {{ $status === 'active' ? 'bg-white text-gray-950 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">Active</a>
                <a href="{{ route('admin.categories.index', ['status' => 'inactive']) }}" @if($status === 'inactive') aria-current="page" @endif class="rounded-lg px-3 py-2 text-xs font-bold transition {{ $status === 'inactive' ? 'bg-white text-gray-950 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">Archived</a>
            </nav>
        </div>
        @if($categories->count())
            <div class="grid gap-4 p-4 sm:grid-cols-2 xl:grid-cols-3 sm:p-6">
                @foreach($categories as $category)
                    <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition hover:-translate-y-0.5 hover:border-amber-200 hover:shadow-md">
                        <div class="relative h-36 overflow-hidden bg-gray-100">
                            @if($category->image)
                                <img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($category->image) }}" alt="{{ $category->name }} shoes" loading="lazy" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                            @else
                                <div class="flex h-full items-center justify-center bg-gradient-to-br from-gray-100 to-amber-50 text-gray-300"><svg class="h-12 w-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.4" d="M3 15c2.2 0 3-1.4 4-3l1-2 4 2c2 1 3 3 6 3h3v4H3v-4Z"/><path stroke-linecap="round" stroke-width="1.4" d="M8 10 6 7m5 6-1 2m5-1-1 2"/></svg></div>
                            @endif
                            <span class="absolute left-3 top-3 rounded-full border border-white/70 bg-white/90 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-gray-700">{{ $status === 'active' ? 'On storefront' : 'Archived' }}</span>
                        </div>
                        <div class="p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0"><h3 class="truncate text-base font-bold text-gray-950">{{ $category->name }}</h3><p class="mt-1 line-clamp-2 min-h-10 text-xs leading-5 text-gray-500">{{ $category->description ?: 'Add a short description to help shoppers understand this shoe category.' }}</p></div>
                                <span class="shrink-0 rounded-xl bg-amber-50 px-2.5 py-1.5 text-center"><span class="block text-base font-black text-amber-900">{{ number_format($category->products_count) }}</span><span class="block text-[9px] font-bold uppercase tracking-wide text-amber-700">active shoes</span></span>
                            </div>
                            <div class="mt-4 flex items-center justify-between border-t border-gray-100 pt-3">
                                <span class="truncate text-[11px] text-gray-400">/{{ $category->slug }}</span>
                                <div class="flex shrink-0 items-center gap-3 text-xs font-bold"><a href="{{ route('admin.categories.edit', $category) }}" class="text-amber-800 hover:text-amber-950">Edit</a><form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this shoe category? Categories with products cannot be deleted.')">@csrf @method('DELETE')<button class="text-gray-400 transition hover:text-red-600">Delete</button></form></div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
            @if($categories->hasPages())<div class="border-t border-gray-100 px-5 py-4">{{ $categories->withQueryString()->links() }}</div>@endif
        @else
            <div class="px-6 py-14 text-center"><span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 text-amber-700"><svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-width="1.8" d="M3 15c2.2 0 3-1.4 4-3l1-2 4 2c2 1 3 3 6 3h3v4H3v-4Z"/></svg></span><h3 class="mt-4 font-bold text-gray-900">{{ $status === 'active' ? 'No active shoe categories yet' : 'No archived categories' }}</h3><p class="mx-auto mt-1 max-w-md text-sm text-gray-500">{{ $status === 'active' ? 'Create categories such as sneakers, formal shoes, loafers, flats, sandals or boots.' : 'When you archive a category, it will be listed here.' }}</p>@if($status === 'active')<a href="{{ route('admin.categories.create') }}" class="mt-5 inline-flex rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-bold text-gray-950 hover:bg-amber-400">Create a shoe category</a>@endif</div>
        @endif
    </section>
</div>
@endsection
