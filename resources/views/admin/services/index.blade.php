@extends('layouts.admin')

@section('title', 'Services Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Services Management</h1>
        <a href="{{ route('admin.services.create') }}"
           class="bg-amber-600 text-white px-4 py-2 rounded-md hover:bg-amber-700 transition-colors w-full sm:w-auto text-center">
            Add New Service
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-md p-4 lg:p-6">
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                       placeholder="Search services..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Services Table -->
    <div class="bg-white shadow rounded-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 hidden sm:table-header-group">
                    <tr>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Duration</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Sort Order</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($services as $service)
                        <tr class="hover:bg-gray-50 border-b border-gray-200 sm:border-0">
                            <td class="px-3 lg:px-6 py-3 sm:py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="text-sm font-medium text-gray-900">{{ $service->name }}</div>
                                        <div class="flex items-center gap-2 sm:hidden">
                                            <span class="text-xs font-medium text-gray-900">{{ $service->formatted_price }}</span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium
                                                {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                    @if($service->description)
                                        <div class="text-xs sm:text-sm text-gray-500 line-clamp-2 whitespace-pre-line">{{ $service->description }}</div>
                                        <button type="button"
                                                onclick="openServiceDrawer({{ $service->id }})"
                                                class="text-xs text-amber-500 hover:text-amber-700 flex items-center gap-0.5 font-medium mt-0.5">
                                            Read more
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </button>
                                    @endif
                                    <div class="text-xs text-gray-500 sm:hidden">{{ $service->formatted_duration }}</div>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="text-sm font-medium text-gray-900">{{ $service->formatted_price }}</span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="text-sm text-gray-900">{{ $service->formatted_duration }}</span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $service->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                <span class="text-sm text-gray-900">{{ $service->sort_order }}</span>
                            </td>
                            <td class="px-3 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.services.edit', $service) }}"
                                       class="text-amber-600 hover:text-amber-900 whitespace-nowrap">Edit</a>
                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}"
                                          class="inline" onsubmit="return confirm('Are you sure you want to delete this service?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 whitespace-nowrap">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                No services found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($services->hasPages())
            <div class="px-4 lg:px-6 py-4 border-t border-gray-200">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Side Drawer -->
<div id="service-drawer" class="fixed inset-0 z-50 hidden" aria-modal="true" role="dialog">
    <!-- Backdrop -->
    <div id="drawer-backdrop" class="absolute inset-0 bg-black/40 transition-opacity duration-300 opacity-0"
         onclick="closeServiceDrawer()"></div>

    <!-- Panel -->
    <div id="drawer-panel"
         class="absolute right-0 top-0 h-full w-full max-w-md bg-white shadow-xl flex flex-col translate-x-full transition-transform duration-300 ease-in-out">

        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <p class="text-xs uppercase tracking-widest text-amber-500 font-medium mb-0.5">Service Details</p>
                <h2 id="drawer-title" class="text-lg font-semibold text-gray-900"></h2>
            </div>
            <button onclick="closeServiceDrawer()"
                    class="text-gray-400 hover:text-gray-600 p-1.5 rounded-md hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Meta -->
        <div id="drawer-meta" class="flex items-center gap-4 px-6 py-3 border-b border-gray-100 text-sm text-gray-600"></div>

        <!-- Description -->
        <div class="flex-1 overflow-y-auto px-6 py-5">
            <p class="text-xs uppercase tracking-widest text-gray-400 font-medium mb-3">Description</p>
            <div id="drawer-description" class="text-sm text-gray-700 whitespace-pre-line leading-relaxed"></div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-gray-100">
            <a id="drawer-edit-link" href="#"
               class="block w-full text-center bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                Edit Service
            </a>
        </div>
    </div>
</div>

@php
    $servicesJson = $services->map(fn($s) => [
        'id'          => $s->id,
        'name'        => $s->name,
        'description' => $s->description,
        'price'       => $s->formatted_price,
        'duration'    => $s->formatted_duration,
        'status'      => $s->is_active ? 'Active' : 'Inactive',
        'edit_url'    => route('admin.services.edit', $s),
    ]);
@endphp

<script>
const services = @json($servicesJson);

function openServiceDrawer(id) {
    const service = services.find(s => s.id === id);
    if (!service) return;

    document.getElementById('drawer-title').textContent = service.name;
    document.getElementById('drawer-description').textContent = service.description || 'Not provided';
    document.getElementById('drawer-edit-link').href = service.edit_url;
    document.getElementById('drawer-meta').innerHTML =
        `<span class="font-medium text-gray-900">${service.price}</span>
         <span class="text-gray-300">|</span>
         <span>${service.duration}</span>
         <span class="text-gray-300">|</span>
         <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium ${service.status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">${service.status}</span>`;

    const drawer = document.getElementById('service-drawer');
    const panel  = document.getElementById('drawer-panel');
    const backdrop = document.getElementById('drawer-backdrop');

    drawer.classList.remove('hidden');
    requestAnimationFrame(() => {
        backdrop.classList.remove('opacity-0');
        panel.classList.remove('translate-x-full');
    });
    document.body.style.overflow = 'hidden';
}

function closeServiceDrawer() {
    const panel  = document.getElementById('drawer-panel');
    const backdrop = document.getElementById('drawer-backdrop');

    panel.classList.add('translate-x-full');
    backdrop.classList.add('opacity-0');
    setTimeout(() => {
        document.getElementById('service-drawer').classList.add('hidden');
        document.body.style.overflow = '';
    }, 300);
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeServiceDrawer(); });
</script>
@endsection
