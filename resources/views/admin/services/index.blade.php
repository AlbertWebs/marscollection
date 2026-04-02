@extends('layouts.admin')

@section('title', 'Services Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Services Management</h1>
        <a href="{{ route('admin.services.create') }}" 
           class="bg-pink-600 text-white px-4 py-2 rounded-md hover:bg-pink-700 transition-colors w-full sm:w-auto text-center">
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
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select id="status" name="status" 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-pink-500">
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
                                    <div class="text-xs sm:text-sm text-gray-500">{{ Str::limit($service->description, 60) }}</div>
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
                                       class="text-pink-600 hover:text-pink-900 whitespace-nowrap">Edit</a>
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
@endsection 