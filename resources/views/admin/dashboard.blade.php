@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6" id="admin-dashboard" data-analytics-url="{{ route('admin.dashboard.analytics') }}">
    <section class="flex flex-col justify-between gap-4 rounded-2xl bg-gradient-to-r from-gray-950 via-gray-900 to-gray-800 px-5 py-6 text-white shadow-sm sm:flex-row sm:items-center sm:px-7">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-300">Mars Collection overview</p>
            <h1 class="mt-2 text-2xl font-black tracking-tight sm:text-3xl">Good {{ now()->format('H') < 12 ? 'morning' : (now()->format('H') < 18 ? 'afternoon' : 'evening') }}, {{ auth()->user()->name }}</h1>
            <p class="mt-1.5 text-sm text-gray-300">Here’s what’s happening with your store today.</p>
        </div>
        <div class="flex items-center gap-3 self-start rounded-xl border border-white/10 bg-white/5 px-4 py-3 sm:self-auto">
            <span class="relative flex h-2.5 w-2.5" aria-hidden="true"><span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-50"></span><span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span></span>
            <div><p class="text-xs font-bold text-white" id="live-status">Live updates on</p><p class="mt-0.5 text-[11px] text-gray-400">Updated <time id="last-updated">{{ \Illuminate\Support\Carbon::parse($analytics['updated_at'])->format('g:i:s A') }}</time></p></div>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Today's store metrics">
        <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 7h12l1 14H5L6 7Zm3 0V5a3 3 0 0 1 6 0v2"/></svg></span><span class="rounded-full bg-gray-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-gray-500">Today</span></div>
            <p class="mt-4 text-sm font-medium text-gray-500">Orders placed</p><p id="metric-orders" class="mt-1 text-3xl font-black tracking-tight text-gray-950">{{ number_format($analytics['metrics']['orders_today']) }}</p>
            <p class="mt-1 text-xs text-gray-500"><span id="metric-pending">{{ number_format($analytics['metrics']['pending_orders']) }}</span> awaiting fulfillment</p>
        </article>
        <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-emerald-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3v18m6-14.5c0-1.4-1.8-2.5-4-2.5h-4c-2.2 0-4 1.1-4 2.5S7.8 9 10 9h4c2.2 0 4 1.1 4 2.5S16.2 14 14 14h-4c-2.2 0-4 1.1-4 2.5S7.8 19 10 19h4c2.2 0 4-1.1 4-2.5"/></svg></span><span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-emerald-700">Fulfilled</span></div>
            <p class="mt-4 text-sm font-medium text-gray-500">Sales today</p><p id="metric-revenue-today" class="mt-1 text-3xl font-black tracking-tight text-gray-950">KES {{ number_format($analytics['metrics']['revenue_today']) }}</p>
            <p class="mt-1 text-xs text-gray-500">KES <span id="metric-revenue-total">{{ number_format($analytics['metrics']['revenue_total']) }}</span> total fulfilled sales</p>
        </article>
        <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100 text-sky-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3" stroke-width="1.8"/></svg></span><span class="rounded-full bg-sky-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-sky-700">Storefront</span></div>
            <p class="mt-4 text-sm font-medium text-gray-500">Unique visitors today</p><p id="metric-visitors" class="mt-1 text-3xl font-black tracking-tight text-gray-950">{{ number_format($analytics['metrics']['visitors_today']) }}</p>
            <p class="mt-1 text-xs text-gray-500"><span id="metric-pageviews">{{ number_format($analytics['metrics']['page_views_today']) }}</span> page views</p>
        </article>
        <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-start justify-between"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-violet-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3a9 9 0 1 0 9 9"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 7v5l3 2m2-11v5h5"/></svg></span><span class="relative inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-emerald-700"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Last 5 min</span></div>
            <p class="mt-4 text-sm font-medium text-gray-500">Visitors online</p><p id="metric-active" class="mt-1 text-3xl font-black tracking-tight text-gray-950">{{ number_format($analytics['metrics']['active_visitors']) }}</p>
            <p class="mt-1 text-xs text-gray-500">Based on recent storefront visits</p>
        </article>
    </section>

    <section class="grid grid-cols-1 gap-5 xl:grid-cols-2" aria-label="Store activity charts">
        <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div><p class="text-xs font-bold uppercase tracking-[0.14em] text-gray-400">Store traffic</p><h2 class="mt-1 text-lg font-bold text-gray-950">Visitors over time</h2><p class="mt-1 text-xs text-gray-500">Unique storefront visitors and page views, last 7 days</p></div>
                <span class="rounded-lg bg-gray-50 px-3 py-1.5 text-xs font-semibold text-gray-500">7 days</span>
            </div>
            <div class="mt-5 overflow-hidden" role="img" aria-label="Bar chart showing daily visitors and page views for the past seven days"><svg id="traffic-chart" viewBox="0 0 680 250" class="h-56 w-full" preserveAspectRatio="none"></svg></div>
            <div class="mt-2 flex items-center gap-5 text-xs text-gray-500"><span class="inline-flex items-center gap-2"><i class="h-2.5 w-2.5 rounded-sm bg-amber-500"></i>Visitors</span><span class="inline-flex items-center gap-2"><i class="h-2.5 w-2.5 rounded-sm bg-gray-200"></i>Page views</span></div>
        </article>

        <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div><p class="text-xs font-bold uppercase tracking-[0.14em] text-gray-400">Orders</p><h2 class="mt-1 text-lg font-bold text-gray-950">Order activity</h2><p class="mt-1 text-xs text-gray-500">Orders placed each day, last 7 days</p></div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-amber-800 hover:text-amber-950">Manage orders <span aria-hidden="true">→</span></a>
            </div>
            <div class="mt-5 overflow-hidden" role="img" aria-label="Bar chart showing daily orders for the past seven days"><svg id="orders-chart" viewBox="0 0 680 250" class="h-56 w-full" preserveAspectRatio="none"></svg></div>
            <p class="mt-2 text-xs text-gray-500">Sales figures count delivered orders only.</p>
        </article>
    </section>

    <section class="grid grid-cols-1 gap-5 xl:grid-cols-[minmax(0,1.5fr)_minmax(18rem,0.8fr)]">
        <article class="rounded-2xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4 sm:px-6">
                <div><h2 class="text-base font-bold text-gray-950">Recent orders</h2><p class="mt-1 text-xs text-gray-500">Latest activity from your customers</p></div>
                <a href="{{ route('admin.orders.index') }}" class="rounded-lg border border-gray-200 px-3 py-2 text-xs font-semibold text-gray-600 transition hover:border-amber-300 hover:text-amber-800">All orders</a>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($stats['recent_orders'] as $order)
                    <a href="{{ route('admin.orders.show', $order) }}" class="flex items-center justify-between gap-3 px-5 py-4 transition hover:bg-gray-50 sm:px-6">
                        <div class="flex min-w-0 items-center gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-xs font-black text-amber-800">#{{ substr((string)($order->order_number ?? $order->id), -3) }}</span>
                            <div class="min-w-0"><p class="truncate text-sm font-semibold text-gray-900">{{ $order->customer_name ?: ($order->user->name ?? 'Guest customer') }}</p><p class="mt-0.5 truncate text-xs text-gray-500">{{ $order->order_number ?? 'Order #' . $order->id }} · {{ $order->created_at->diffForHumans() }}</p></div>
                        </div>
                        <div class="shrink-0 text-right"><p class="text-sm font-bold text-gray-900">KES {{ number_format($order->total) }}</p><span class="mt-1 inline-flex rounded-full px-2 py-0.5 text-[10px] font-bold @if($order->status === 'delivered' || $order->status === 'completed') bg-emerald-50 text-emerald-700 @elseif($order->status === 'pending') bg-amber-50 text-amber-800 @elseif($order->status === 'cancelled') bg-red-50 text-red-700 @else bg-sky-50 text-sky-700 @endif">{{ ucfirst($order->status) }}</span></div>
                    </a>
                @empty
                    <div class="px-6 py-12 text-center"><span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-100 text-gray-400"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M6 7h12l1 14H5L6 7Zm3 0V5a3 3 0 0 1 6 0v2"/></svg></span><p class="mt-3 text-sm font-semibold text-gray-800">No orders yet</p><p class="mt-1 text-xs text-gray-500">New orders will appear here.</p></div>
                @endforelse
            </div>
        </article>

        <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex items-center justify-between"><div><h2 class="text-base font-bold text-gray-950">Order status</h2><p class="mt-1 text-xs text-gray-500">All orders by current status</p></div><span id="order-status-total" class="rounded-lg bg-gray-100 px-2.5 py-1.5 text-xs font-bold text-gray-700">{{ number_format($stats['total_orders']) }} total</span></div>
            <div id="order-status-bars" class="mt-6 flex h-3 overflow-hidden rounded-full bg-gray-100" role="img" aria-label="Order status breakdown"></div>
            <div id="order-status-list" class="mt-5 space-y-3"></div>
            <div class="mt-6 border-t border-gray-100 pt-5">
                <div class="flex items-center justify-between text-sm"><span class="font-medium text-gray-600">Active products</span><span class="font-bold text-gray-950">{{ number_format($stats['active_products']) }} <span class="font-normal text-gray-400">/ {{ number_format($stats['total_products']) }}</span></span></div>
                <div class="mt-2 h-2 overflow-hidden rounded-full bg-gray-100"><div class="h-full rounded-full bg-amber-400" style="width: {{ $stats['total_products'] ? min(100, round($stats['active_products'] / $stats['total_products'] * 100)) : 0 }}%"></div></div>
                <p class="mt-2 text-xs text-gray-500">{{ number_format($stats['total_users']) }} customer accounts · {{ number_format($stats['total_categories']) }} categories</p>
            </div>
        </article>
    </section>

    <section class="grid grid-cols-1 gap-5 xl:grid-cols-2">
        <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex items-center justify-between"><div><h2 class="text-base font-bold text-gray-950">Popular products</h2><p class="mt-1 text-xs text-gray-500">Items most often included in orders</p></div><a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-amber-800 hover:text-amber-950">View products →</a></div>
            <div class="mt-4 space-y-2">
                @forelse($stats['top_products'] as $index => $product)
                    <div class="flex items-center justify-between gap-3 rounded-xl px-2 py-2.5 transition hover:bg-gray-50">
                        <div class="flex min-w-0 items-center gap-3"><span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $index === 0 ? 'bg-amber-100 text-amber-800' : 'bg-gray-100 text-gray-500' }} text-xs font-bold">{{ str_pad((string)($index + 1), 2, '0', STR_PAD_LEFT) }}</span><div class="min-w-0"><p class="truncate text-sm font-semibold text-gray-900">{{ $product->name }}</p><p class="mt-0.5 text-xs text-gray-500">{{ $product->brand->name ?? 'Mars Collection' }}</p></div></div>
                        <div class="shrink-0 text-right"><p class="text-sm font-bold text-gray-900">{{ number_format($product->order_items_count) }}</p><p class="text-[10px] text-gray-400">order lines</p></div>
                    </div>
                @empty
                    <p class="py-8 text-center text-sm text-gray-500">Product order activity will show here.</p>
                @endforelse
            </div>
        </article>

        <article class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex items-center justify-between"><div><h2 class="text-base font-bold text-gray-950">Storefront traffic</h2><p class="mt-1 text-xs text-gray-500">Most viewed pages in the last 7 days</p></div><span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[10px] font-bold text-emerald-700">First-party data</span></div>
            <div id="top-pages-list" class="mt-4 space-y-3"></div>
            <p id="traffic-empty" class="hidden py-8 text-center text-sm text-gray-500">Traffic data will appear as customers browse the storefront.</p>
        </article>
    </section>

    <section class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3"><div><h2 class="text-base font-bold text-gray-950">Quick actions</h2><p class="mt-1 text-xs text-gray-500">Common store management tasks</p></div></div>
        <div class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            <a href="{{ route('admin.products.create') }}" class="group flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 transition hover:border-amber-200 hover:bg-amber-50"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-100 text-amber-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-width="2" d="M12 5v14m-7-7h14"/></svg></span><span><span class="block text-sm font-bold text-gray-900">Add product</span><span class="mt-0.5 block text-xs text-gray-500">Create a listing</span></span></a>
            <a href="{{ route('admin.orders.index') }}" class="group flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 transition hover:border-sky-200 hover:bg-sky-50"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-sky-100 text-sky-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 7h12l1 14H5L6 7Zm3 0V5a3 3 0 0 1 6 0v2"/></svg></span><span><span class="block text-sm font-bold text-gray-900">Manage orders</span><span class="mt-0.5 block text-xs text-gray-500">Review and update</span></span></a>
            <a href="{{ route('admin.categories.index') }}" class="group flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 transition hover:border-violet-200 hover:bg-violet-50"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-100 text-violet-800"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 13 11 22l-9-9V2h11l9 11Z"/><circle cx="7" cy="7" r="1"/></svg></span><span><span class="block text-sm font-bold text-gray-900">Categories</span><span class="mt-0.5 block text-xs text-gray-500">Organize footwear</span></span></a>
            <a href="{{ route('admin.settings.index') }}" class="group flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4 transition hover:border-gray-300 hover:bg-gray-100"><span class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-200 text-gray-700"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="3" stroke-width="1.8"/><path stroke-linecap="round" stroke-width="1.8" d="m19.4 15 .1.1 1.4 1.1-1.4 2.4-1.7-.7a8 8 0 0 1-1.8 1l-.3 1.8h-2.8l-.3-1.8a8 8 0 0 1-1.8-1l-1.7.7-1.4-2.4 1.4-1.1a7 7 0 0 1 0-2l-1.4-1.1 1.4-2.4 1.7.7a8 8 0 0 1 1.8-1l.3-1.8h2.8l.3 1.8a8 8 0 0 1 1.8 1l1.7-.7 1.4 2.4-1.4 1.1a7 7 0 0 1 0 2Z"/></svg></span><span><span class="block text-sm font-bold text-gray-900">Store settings</span><span class="mt-0.5 block text-xs text-gray-500">Update store details</span></span></a>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
(() => {
    const dashboard = document.getElementById('admin-dashboard');
    const endpoint = dashboard.dataset.analyticsUrl;
    const initial = @json($analytics, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    const nf = new Intl.NumberFormat('en-KE');
    const money = value => 'KES ' + nf.format(Math.round(Number(value || 0)));
    const ns = 'http://www.w3.org/2000/svg';
    const colors = { Pending: '#f59e0b', Processing: '#0ea5e9', Shipped: '#8b5cf6', Delivered: '#10b981', Completed: '#10b981', Cancelled: '#ef4444' };

    function svgElement(name, attrs = {}, text = '') {
        const element = document.createElementNS(ns, name);
        Object.entries(attrs).forEach(([key, value]) => element.setAttribute(key, value));
        if (text) element.textContent = text;
        return element;
    }

    function drawBars(id, rows, key, fill, tooltipKey = null) {
        const svg = document.getElementById(id);
        svg.replaceChildren();
        const width = 680, height = 250, left = 42, right = 12, top = 16, bottom = 38;
        const chartHeight = height - top - bottom;
        const max = Math.max(4, ...rows.map(row => Number(row[key] || 0)));
        const step = (width - left - right) / Math.max(1, rows.length);
        for (let i = 0; i <= 4; i++) {
            const y = top + chartHeight * i / 4;
            svg.append(svgElement('line', { x1: left, y1: y, x2: width - right, y2: y, stroke: '#e5e7eb', 'stroke-dasharray': i === 4 ? '0' : '3 5' }));
            svg.append(svgElement('text', { x: left - 8, y: y + 4, fill: '#9ca3af', 'font-size': 10, 'text-anchor': 'end' }, nf.format(Math.round(max * (4 - i) / 4))));
        }
        rows.forEach((row, index) => {
            const value = Number(row[key] || 0);
            const barWidth = Math.min(36, step * 0.5);
            const barHeight = value ? Math.max(3, value / max * chartHeight) : 2;
            const x = left + step * index + (step - barWidth) / 2;
            const y = top + chartHeight - barHeight;
            const rect = svgElement('rect', { x, y, width: barWidth, height: barHeight, rx: 6, fill, opacity: value ? 0.9 : 0.25 });
            const detail = tooltipKey ? `, ${tooltipKey === 'page_views' ? 'page views' : 'sales'}: ${tooltipKey === 'revenue' ? money(row[tooltipKey]) : nf.format(row[tooltipKey] || 0)}` : '';
            rect.append(svgElement('title', {}, `${row.date}: ${nf.format(value)}${detail}`));
            svg.append(rect);
            svg.append(svgElement('text', { x: left + step * index + step / 2, y: height - 12, fill: '#6b7280', 'font-size': 11, 'text-anchor': 'middle' }, row.label));
        });
    }

    function drawTraffic(rows) {
        const svg = document.getElementById('traffic-chart');
        svg.replaceChildren();
        const width = 680, height = 250, left = 42, right = 12, top = 16, bottom = 38;
        const chartHeight = height - top - bottom;
        const max = Math.max(4, ...rows.flatMap(row => [Number(row.visitors || 0), Number(row.page_views || 0)]));
        const step = (width - left - right) / Math.max(1, rows.length);
        for (let i = 0; i <= 4; i++) {
            const y = top + chartHeight * i / 4;
            svg.append(svgElement('line', { x1: left, y1: y, x2: width - right, y2: y, stroke: '#e5e7eb', 'stroke-dasharray': i === 4 ? '0' : '3 5' }));
            svg.append(svgElement('text', { x: left - 8, y: y + 4, fill: '#9ca3af', 'font-size': 10, 'text-anchor': 'end' }, nf.format(Math.round(max * (4 - i) / 4))));
        }
        rows.forEach((row, index) => {
            const groupWidth = Math.min(42, step * 0.64);
            [['visitors', '#f59e0b'], ['page_views', '#d1d5db']].forEach(([key, color], seriesIndex) => {
                const value = Number(row[key] || 0);
                const barWidth = groupWidth / 2 - 2;
                const barHeight = value ? Math.max(3, value / max * chartHeight) : 2;
                const x = left + step * index + (step - groupWidth) / 2 + seriesIndex * (barWidth + 3);
                const rect = svgElement('rect', { x, y: top + chartHeight - barHeight, width: barWidth, height: barHeight, rx: 4, fill: color, opacity: value ? 0.9 : 0.25 });
                rect.append(svgElement('title', {}, `${row.date}: ${nf.format(value)} ${key === 'visitors' ? 'visitors' : 'page views'}`));
                svg.append(rect);
            });
            svg.append(svgElement('text', { x: left + step * index + step / 2, y: height - 12, fill: '#6b7280', 'font-size': 11, 'text-anchor': 'middle' }, row.label));
        });
    }

    function drawStatus(data) {
        const bar = document.getElementById('order-status-bars');
        const list = document.getElementById('order-status-list');
        bar.replaceChildren(); list.replaceChildren();
        const total = data.reduce((sum, item) => sum + item.count, 0);
        document.getElementById('order-status-total').textContent = `${nf.format(total)} total`;
        data.forEach(item => {
            const color = colors[item.status] || '#9ca3af';
            if (total) {
                const segment = document.createElement('span');
                segment.className = 'block h-full';
                segment.style.cssText = `width:${item.count / total * 100}%;background:${color}`;
                segment.title = `${item.status}: ${item.count}`;
                bar.append(segment);
            }
            const row = document.createElement('div');
            row.className = 'flex items-center justify-between text-sm';
            const left = document.createElement('span'); left.className = 'flex items-center gap-2 text-gray-600';
            const dot = document.createElement('i'); dot.className = 'h-2.5 w-2.5 rounded-full'; dot.style.backgroundColor = color;
            left.append(dot, document.createTextNode(item.status));
            const count = document.createElement('span'); count.className = 'font-bold text-gray-900'; count.textContent = nf.format(item.count);
            row.append(left, count); list.append(row);
        });
        if (!data.length) list.innerHTML = '<p class="text-sm text-gray-500">No order activity yet.</p>';
    }

    function drawPages(pages) {
        const list = document.getElementById('top-pages-list');
        const empty = document.getElementById('traffic-empty');
        list.replaceChildren();
        empty.classList.toggle('hidden', pages.length > 0);
        const max = Math.max(1, ...pages.map(page => page.views));
        pages.forEach(page => {
            const row = document.createElement('div'); row.className = 'space-y-1.5';
            const line = document.createElement('div'); line.className = 'flex items-center justify-between gap-3 text-xs';
            const path = document.createElement('span'); path.className = 'truncate font-medium text-gray-700'; path.textContent = page.path === '/' ? 'Homepage' : page.path;
            const views = document.createElement('span'); views.className = 'shrink-0 font-bold text-gray-900'; views.textContent = nf.format(page.views);
            line.append(path, views);
            const track = document.createElement('div'); track.className = 'h-1.5 overflow-hidden rounded-full bg-gray-100';
            const fill = document.createElement('div'); fill.className = 'h-full rounded-full bg-amber-400'; fill.style.width = `${page.views / max * 100}%`;
            track.append(fill); row.append(line, track); list.append(row);
        });
    }

    function render(data) {
        const m = data.metrics;
        document.getElementById('metric-orders').textContent = nf.format(m.orders_today);
        document.getElementById('metric-pending').textContent = nf.format(m.pending_orders);
        document.getElementById('metric-revenue-today').textContent = money(m.revenue_today);
        document.getElementById('metric-revenue-total').textContent = nf.format(Math.round(m.revenue_total));
        document.getElementById('metric-visitors').textContent = nf.format(m.visitors_today);
        document.getElementById('metric-pageviews').textContent = nf.format(m.page_views_today);
        document.getElementById('metric-active').textContent = nf.format(m.active_visitors);
        drawTraffic(data.daily);
        drawBars('orders-chart', data.daily, 'orders', '#111827', 'revenue');
        drawStatus(data.order_status);
        drawPages(data.top_pages);
        const updated = new Date(data.updated_at);
        document.getElementById('last-updated').textContent = updated.toLocaleTimeString('en-KE', { hour: 'numeric', minute: '2-digit', second: '2-digit' });
    }

    render(initial);
    async function refreshDashboard() {
        try {
            const response = await fetch(endpoint, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }, cache: 'no-store' });
            if (!response.ok) throw new Error('Analytics refresh failed');
            render(await response.json());
            document.getElementById('live-status').textContent = 'Live updates on';
        } catch (error) {
            document.getElementById('live-status').textContent = 'Reconnecting';
        }
    }
    window.setInterval(refreshDashboard, 15000);
})();
</script>
@endsection
