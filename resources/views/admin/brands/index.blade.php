@extends('layouts.admin')

@section('title', 'Footwear Brands')

@section('content')
<div class="space-y-6">
    <section class="flex flex-col justify-between gap-4 rounded-2xl bg-gradient-to-r from-gray-950 to-gray-800 px-5 py-6 text-white sm:flex-row sm:items-center sm:px-7">
        <div><p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-300">Footwear catalog</p><h1 class="mt-2 text-2xl font-black sm:text-3xl">Shoe brands</h1><p class="mt-1.5 max-w-xl text-sm text-gray-300">Manage the footwear labels connected to your product listings and their storefront identity.</p></div>
        <a href="{{ route('admin.brands.create') }}" class="inline-flex shrink-0 items-center justify-center gap-2 rounded-xl bg-amber-400 px-5 py-3 text-sm font-bold text-gray-950 transition hover:bg-amber-300"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-width="2" d="M12 5v14m-7-7h14"/></svg>Add footwear brand</a>
    </section>

    <section class="grid gap-4 sm:grid-cols-3" aria-label="Brand summary">
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Active brands</p><p class="mt-2 text-3xl font-black text-gray-950">{{ number_format($catalogCounts['active']) }}</p><p class="mt-1 text-xs text-gray-500">Available for product listings</p></div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Active shoe listings</p><p class="mt-2 text-3xl font-black text-gray-950">{{ number_format($catalogCounts['products']) }}</p><p class="mt-1 text-xs text-gray-500">Currently visible in your store</p></div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Archived brands</p><p class="mt-2 text-3xl font-black text-gray-950">{{ number_format($catalogCounts['inactive']) }}</p><p class="mt-1 text-xs text-gray-500">Hidden from current listings</p></div>
    </section>

    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="flex flex-col justify-between gap-4 border-b border-gray-100 px-5 py-4 sm:flex-row sm:items-center sm:px-6">
            <div><h2 class="font-bold text-gray-950">{{ $status === 'active' ? 'Storefront brands' : 'Archived brands' }}</h2><p class="mt-1 text-xs text-gray-500">{{ $brands->total() }} {{ \Illuminate\Support\Str::plural('brand', $brands->total()) }} in this view</p></div>
            <nav class="flex w-fit rounded-xl bg-gray-100 p-1" aria-label="Brand status filter"><a href="{{ route('admin.brands.index', ['status' => 'active']) }}" @if($status === 'active') aria-current="page" @endif class="rounded-lg px-3 py-2 text-xs font-bold transition {{ $status === 'active' ? 'bg-white text-gray-950 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">Active</a><a href="{{ route('admin.brands.index', ['status' => 'inactive']) }}" @if($status === 'inactive') aria-current="page" @endif class="rounded-lg px-3 py-2 text-xs font-bold transition {{ $status === 'inactive' ? 'bg-white text-gray-950 shadow-sm' : 'text-gray-500 hover:text-gray-900' }}">Archived</a></nav>
        </div>
        @if($brands->count())
            <div class="grid gap-4 p-4 sm:grid-cols-2 xl:grid-cols-3 sm:p-6">
                @foreach($brands as $brand)
                    <article class="rounded-2xl border border-gray-200 p-5 transition hover:border-amber-200 hover:shadow-md">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex min-w-0 items-center gap-3">
                                <span class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-gray-100 bg-gray-50 p-2">
                                    @if($brand->logo)<img src="{{ \App\Helpers\ImageHelper::getProductImageUrl($brand->logo) }}" alt="{{ $brand->name }} logo" class="max-h-full max-w-full object-contain">@else<span class="text-xl font-black text-amber-700">{{ mb_substr($brand->name, 0, 1) }}</span>@endif
                                </span>
                                <div class="min-w-0"><h3 class="truncate font-bold text-gray-950">{{ $brand->name }}</h3><p class="mt-1 text-xs text-gray-400">/{{ $brand->slug }}</p></div>
                            </div>
                            <span class="shrink-0 rounded-full px-2.5 py-1 text-[10px] font-bold {{ $brand->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-500' }}">{{ $brand->is_active ? 'Active' : 'Archived' }}</span>
                        </div>
                        <p class="mt-4 min-h-10 text-sm leading-5 text-gray-600">{{ $brand->description ?: 'Add a short description for this footwear brand.' }}</p>
                        <div class="mt-4 flex items-end justify-between border-t border-gray-100 pt-4">
                            <div><span class="block text-2xl font-black text-gray-950">{{ number_format($brand->products_count) }}</span><span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">active shoe listings</span></div>
                            <div class="flex items-center gap-3 text-xs font-bold"><a href="{{ route('admin.brands.edit', $brand) }}" class="text-amber-800 hover:text-amber-950">Edit brand</a><form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" onsubmit="return confirm('Delete this brand? Brands with assigned products cannot be deleted.')">@csrf @method('DELETE')<button class="text-gray-400 transition hover:text-red-600">Delete</button></form></div>
                        </div>
                    </article>
                @endforeach
            </div>
            @if($brands->hasPages())<div class="border-t border-gray-100 px-5 py-4">{{ $brands->withQueryString()->links() }}</div>@endif
        @else
            <div class="px-6 py-14 text-center"><span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-50 text-amber-800"><svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M4 8h16l-1 12H5L4 8Zm4 0V6a4 4 0 0 1 8 0v2"/></svg></span><h3 class="mt-4 font-bold text-gray-900">{{ $status === 'active' ? 'No active footwear brands yet' : 'No archived brands' }}</h3><p class="mx-auto mt-1 max-w-md text-sm text-gray-500">{{ $status === 'active' ? 'Add a footwear label, then assign products to it from the product editor.' : 'Archived brands will appear here.' }}</p>@if($status === 'active')<a href="{{ route('admin.brands.create') }}" class="mt-5 inline-flex rounded-xl bg-amber-500 px-4 py-2.5 text-sm font-bold text-gray-950 hover:bg-amber-400">Add a footwear brand</a>@endif</div>
        @endif
    </section>
</div>
@endsection
