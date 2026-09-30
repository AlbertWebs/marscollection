@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4 lg:py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Contact Messages</h1>
        <div class="flex flex-wrap gap-2 sm:gap-3 w-full sm:w-auto">
            <a href="{{ route('admin.contacts.index', ['type' => 'legitimate']) }}" 
               class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 {{ request('type') === 'legitimate' ? 'bg-green-700' : '' }}">
                Legitimate Messages
            </a>
            <a href="{{ route('admin.contacts.index', ['type' => 'bots']) }}" 
               class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 {{ request('type') === 'bots' ? 'bg-red-700' : '' }}">
                Bot Messages
            </a>
            <a href="{{ route('admin.contacts.index') }}" 
               class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 {{ !request('type') ? 'bg-gray-700' : '' }}">
                All Messages
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('admin.contacts.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Search by name, email, subject, or message..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-amber-500">
            </div>
            <button type="submit" 
                    class="px-6 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700">
                Search
            </button>
            @if(request('search') || request('type'))
                <a href="{{ route('admin.contacts.index') }}" 
                   class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                    Clear
                </a>
            @endif
        </form>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-6">
        <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-md">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Messages</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $contacts->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-md">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Legitimate Messages</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Contact::legitimate()->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-md shadow-sm border border-gray-200 p-6">
            <div class="flex items-center">
                <div class="p-2 bg-red-100 rounded-md">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Bot Messages</p>
                    <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Contact::bots()->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Messages Table -->
    <div class="bg-white rounded-md shadow-sm border border-gray-200 overflow-hidden">
        @if($contacts->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 hidden sm:table-header-group">
                        <tr>
                            <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Email</th>
                            <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Subject</th>
                            <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Date</th>
                            <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($contacts as $contact)
                            <tr class="hover:bg-gray-50 border-b border-gray-200 sm:border-0">
                                <td class="px-3 lg:px-6 py-3 sm:py-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center justify-between gap-2">
                                            <div class="text-sm font-medium text-gray-900">{{ $contact->full_name }}</div>
                                            <div class="sm:hidden">
                                                @if($contact->is_bot)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        Bot
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        Legitimate
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-xs sm:text-sm text-gray-500 sm:hidden">{{ $contact->email }}</div>
                                        @if($contact->phone)
                                            <div class="text-xs sm:text-sm text-gray-500">{{ $contact->phone }}</div>
                                        @endif
                                        <div class="text-xs text-gray-500 md:hidden">{{ Str::limit($contact->subject_display, 30) }}</div>
                                    </div>
                                </td>
                                <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                    <div class="text-sm text-gray-900">{{ $contact->email }}</div>
                                </td>
                                <td class="px-3 lg:px-6 py-4 hidden md:table-cell">
                                    <div class="text-sm text-gray-900">{{ $contact->subject_display }}</div>
                                </td>
                                <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                    @if($contact->is_bot)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Bot
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Legitimate
                                        </span>
                                    @endif
                                </td>
                                <td class="px-3 lg:px-6 py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 hidden lg:table-cell">
                                    {{ $contact->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-3 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.contacts.show', $contact) }}" 
                                           class="text-amber-600 hover:text-amber-900 whitespace-nowrap">View</a>
                                        <form action="{{ route('admin.contacts.destroy', $contact) }}" 
                                              method="POST" 
                                              class="inline"
                                              onsubmit="return confirm('Are you sure you want to delete this message?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 whitespace-nowrap">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $contacts->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No contact messages found</h3>
                <p class="mt-1 text-sm text-gray-500">No contact messages match your current filters.</p>
            </div>
        @endif
    </div>
</div>
@endsection 