@extends('layouts.admin')

@section('title', 'Users Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-xl lg:text-2xl font-bold text-gray-900">Users</h1>
    </div>

    <!-- Users Table -->
    <div class="bg-white shadow rounded-md overflow-hidden">
        <div class="px-4 lg:px-6 py-4 border-b border-gray-200">
            <h3 class="text-base lg:text-lg font-medium text-gray-900">All Users</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 hidden sm:table-header-group">
                    <tr>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Email</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Joined</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-3 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 border-b border-gray-200 sm:border-0">
                            <td class="px-3 lg:px-6 py-3 sm:py-4">
                                <div class="flex items-center justify-between sm:justify-start">
                                    <div class="flex items-center flex-1 min-w-0">
                                        <div class="flex-shrink-0 h-8 w-8 sm:h-10 sm:w-10">
                                            <div class="h-8 w-8 sm:h-10 sm:w-10 rounded-full bg-amber-100 flex items-center justify-center">
                                                <span class="text-xs sm:text-sm font-medium text-amber-600">{{ substr($user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-3 sm:ml-4 flex-1 min-w-0">
                                            <div class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500 sm:hidden truncate">{{ $user->email }}</div>
                                            <div class="text-xs text-gray-500 sm:hidden mt-0.5">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                    @if($user->isAdmin()) bg-purple-100 text-purple-800 @else bg-gray-100 text-gray-800 @endif">
                                                    {{ $user->isAdmin() ? 'Admin' : 'User' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                <div class="text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-3 lg:px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($user->isAdmin()) bg-purple-100 text-purple-800 @else bg-gray-100 text-gray-800 @endif">
                                    {{ $user->isAdmin() ? 'Admin' : 'User' }}
                                </span>
                            </td>
                            <td class="px-3 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-sm font-medium">
                                <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" 
                                            class="text-xs sm:text-sm px-2 sm:px-3 py-1 rounded-md 
                                                   @if($user->isAdmin()) 
                                                       bg-red-100 text-red-700 hover:bg-red-200 
                                                   @else 
                                                       bg-green-100 text-green-700 hover:bg-green-200 
                                                   @endif whitespace-nowrap">
                                        <span class="hidden sm:inline">{{ $user->isAdmin() ? 'Remove Admin' : 'Make Admin' }}</span>
                                        <span class="sm:hidden">{{ $user->isAdmin() ? 'Remove' : 'Admin' }}</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
            <div class="px-4 lg:px-6 py-4 border-t border-gray-200">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 