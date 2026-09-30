@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 lg:py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Newsletter Subscribers</h1>
        <div class="text-sm text-gray-500">Total: {{ $subscribers->total() }}</div>
    </div>

    <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('admin.newsletter-subscribers.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search by email..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
                <option value="">All statuses</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700">
                Search
            </button>
        </form>
    </div>

    <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
        @if($subscribers->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Source</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscribed</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($subscribers as $subscriber)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $subscriber->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subscriber->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                        {{ $subscriber->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ ucfirst($subscriber->source) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ optional($subscriber->subscribed_at ?? $subscriber->created_at)->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <form action="{{ route('admin.newsletter-subscribers.destroy', $subscriber) }}" method="POST" onsubmit="return confirm('Delete this subscriber?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $subscribers->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <h3 class="text-sm font-medium text-gray-900">No subscribers found</h3>
                <p class="mt-1 text-sm text-gray-500">Newsletter signups will appear here.</p>
            </div>
        @endif
    </div>
</div>
@endsection
