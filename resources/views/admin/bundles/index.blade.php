@extends('layouts.admin')

@section('title', 'Shoe Pairings')

@section('content')
<div class="space-y-6">
    <section class="relative isolate overflow-hidden rounded-2xl bg-gray-950 px-5 py-6 text-white sm:px-7">
        <div class="absolute -right-8 -top-14 -z-10 h-56 w-56 rounded-full border-[28px] border-amber-400/10" aria-hidden="true"></div>
        <div class="relative flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
            <div><p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-300">Curated footwear sets</p><h1 class="mt-2 text-2xl font-black sm:text-3xl">Shoe pairings</h1><p class="mt-1.5 max-w-xl text-sm text-gray-300">Group complementary shoes into a set, set a combined price, and feature the pairing in your store.</p></div>
            <a href="{{ route('admin.bundles.create') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-gray-950 transition hover:bg-amber-300"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-width="2" d="M12 5v14m-7-7h14"/></svg>Create shoe pairing</a>
        </div>
    </section>

    <section class="grid gap-4 sm:grid-cols-2" aria-label="Shoe pairing summary">
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm"><span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-100 text-amber-800"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 15c2.2 0 3-1.4 4-3l1-2 4 2c2 1 3 3 6 3h3v4H3v-4Z"/><path stroke-linecap="round" stroke-width="1.5" d="M8 10 6 7m5 6-1 2m5-1-1 2"/></svg></span><div><p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Active shoe pairings</p><p class="mt-1 text-2xl font-black text-gray-950">{{ number_format($pairingCounts['active']) }}</p></div></div>
        <div class="flex items-center gap-4 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm"><span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100 text-gray-600"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-width="1.8" d="M12 3v18m7-14.5c0-1.4-1.8-2.5-4-2.5H9c-2.2 0-4 1.1-4 2.5S6.8 9 9 9h6c2.2 0 4 1.1 4 2.5S17.2 14 15 14H9c-2.2 0-4 1.1-4 2.5S6.8 19 9 19h6c2.2 0 4-1.1 4-2.5"/></svg></span><div><p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Archived sets</p><p class="mt-1 text-2xl font-black text-gray-950">{{ number_format($pairingCounts['inactive']) }}</p></div></div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="flex flex-col justify-between gap-4 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:px-6">
            <div><h2 class="font-bold text-gray-950">{{ $status === 'active' ? 'Live footwear pairings' : 'Archived sets' }}</h2><p class="mt-1 text-xs text-gray-500">{{ $bundles->total() }} {{ \Illuminate\Support\Str::plural('set', $bundles->total()) }} in this view</p></div>
            <nav class="flex w-fit rounded-xl bg-gray-100 p-1" aria-label="Shoe pairing status filter"><a href="{{ route('admin.bundles.index', ['status' => 'active']) }}" @if($status === 'active') aria-current="page" @endif class="rounded-lg px-3 py-2 text-xs font-bold transition {{ $status === 'active' ? 'bg-white text-gray-950 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">Active</a><a href="{{ route('admin.bundles.index', ['status' => 'inactive']) }}" @if($status === 'inactive') aria-current="page" @endif class="rounded-lg px-3 py-2 text-xs font-bold transition {{ $status === 'inactive' ? 'bg-white text-gray-950 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">Archived</a></nav>
        </div>
        @if($bundles->count())
            <div class="divide-y divide-gray-100">
                @foreach($bundles as $bundle)
                    <article class="flex flex-col justify-between gap-4 px-5 py-5 transition hover:bg-gray-50 sm:flex-row sm:items-center sm:px-6">
                        <div class="flex min-w-0 items-center gap-4"><span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-amber-50 text-amber-800"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 15c2.2 0 3-1.4 4-3l1-2 4 2c2 1 3 3 6 3h3v4H3v-4Z"/><path stroke-linecap="round" stroke-width="1.5" d="M8 10 6 7m5 6-1 2m5-1-1 2"/></svg></span><div class="min-w-0"><div class="flex flex-wrap items-center gap-2"><h3 class="truncate font-bold text-gray-950">{{ $bundle->name }}</h3><span class="rounded-full px-2 py-0.5 text-[10px] font-bold {{ $bundle->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{ $bundle->is_active ? 'On storefront' : 'Archived' }}</span></div><p class="mt-1 max-w-2xl truncate text-sm text-gray-500">{{ $bundle->description ?: 'A curated shoe set from Mars Collection.' }}</p><p class="mt-1 text-xs text-gray-400">{{ $bundle->bundle_items_count }} {{ \Illuminate\Support\Str::plural('shoe', $bundle->bundle_items_count) }} in this set</p></div></div>
                        <div class="flex items-center justify-between gap-4 sm:justify-end"><div class="text-left sm:text-right"><p class="text-lg font-black text-gray-950">KES {{ number_format($bundle->price) }}</p><p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400">Pairing price</p></div><div class="flex items-center gap-3 text-xs font-bold"><a href="{{ route('admin.bundles.edit', $bundle) }}" class="text-amber-800 hover:text-amber-950">Edit</a><form method="POST" action="{{ route('admin.bundles.destroy', $bundle) }}" onsubmit="return confirm('Delete this shoe pairing?')">@csrf @method('DELETE')<button class="text-gray-400 transition hover:text-red-600">Delete</button></form></div></div>
                    </article>
                @endforeach
            </div>
            @if($bundles->hasPages())<div class="border-t border-gray-100 px-5 py-4">{{ $bundles->withQueryString()->links() }}</div>@endif
        @else
            <div class="px-6 py-14 text-center"><span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 text-amber-800"><svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-width="1.6" d="M3 15c2.2 0 3-1.4 4-3l1-2 4 2c2 1 3 3 6 3h3v4H3v-4Z"/></svg></span><h3 class="mt-4 font-bold text-gray-900">{{ $status === 'active' ? 'No shoe pairings live yet' : 'No archived sets' }}</h3><p class="mx-auto mt-1 max-w-md text-sm text-gray-500">{{ $status === 'active' ? 'Create a footwear set from products in your catalog. Add the shoes, set a combined price and publish it for shoppers.' : 'Inactive pairings will appear here.' }}</p>@if($status === 'active')<a href="{{ route('admin.bundles.create') }}" class="mt-5 inline-flex rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-bold text-gray-950 hover:bg-amber-400">Create your first shoe pairing</a>@endif</div>
        @endif
    </section>
</div>
@endsection
