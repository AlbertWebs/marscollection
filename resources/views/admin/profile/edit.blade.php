@extends('layouts.admin')

@section('title', 'Admin profile')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <section class="overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
        <div class="bg-gray-950 px-6 py-7 text-white sm:px-8">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-300">Account settings</p>
            <h1 class="mt-2 text-2xl font-black tracking-tight sm:text-3xl">Admin profile</h1>
            <p class="mt-2 max-w-2xl text-sm leading-6 text-gray-300">Manage the name and email shown in your admin account. Update your password here when you need to.</p>
        </div>
        <div class="flex flex-col gap-4 border-b border-gray-100 bg-gray-50/70 px-6 py-5 sm:flex-row sm:items-center sm:px-8">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-100 text-xl font-black text-amber-900">{{ mb_strtoupper(mb_substr($admin->name, 0, 1)) }}</div>
            <div class="min-w-0"><p class="truncate text-lg font-extrabold text-gray-950">{{ $admin->name }}</p><p class="truncate text-sm text-gray-500">{{ $admin->email }}</p></div>
            <span class="sm:ml-auto inline-flex w-fit items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-800 ring-1 ring-emerald-200"><span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>Administrator account</span>
        </div>

        @if($errors->any())
            <div role="alert" class="mx-6 mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800 sm:mx-8">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" class="divide-y divide-gray-100">
            @csrf
            @method('PUT')
            <section class="grid gap-6 px-6 py-7 sm:grid-cols-[220px_minmax(0,1fr)] sm:px-8">
                <div><h2 class="font-extrabold text-gray-950">Personal details</h2><p class="mt-1 text-xs leading-5 text-gray-500">These details identify you throughout the admin panel.</p></div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2"><label for="name" class="mb-1.5 block text-sm font-semibold text-gray-800">Full name</label><input id="name" name="name" type="text" value="{{ old('name', $admin->name) }}" required maxlength="255" autocomplete="name" class="w-full rounded-xl border-gray-300 bg-white px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500">@error('name')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror</div>
                    <div class="sm:col-span-2"><label for="email" class="mb-1.5 block text-sm font-semibold text-gray-800">Email address</label><input id="email" name="email" type="email" value="{{ old('email', $admin->email) }}" required maxlength="255" autocomplete="email" class="w-full rounded-xl border-gray-300 bg-white px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500">@error('email')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror</div>
                </div>
            </section>

            <section class="grid gap-6 px-6 py-7 sm:grid-cols-[220px_minmax(0,1fr)] sm:px-8">
                <div><h2 class="font-extrabold text-gray-950">Change password</h2><p class="mt-1 text-xs leading-5 text-gray-500">Leave these fields empty to keep your current password. New passwords must be at least 12 characters.</p></div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2"><label for="current_password" class="mb-1.5 block text-sm font-semibold text-gray-800">Current password</label><input id="current_password" name="current_password" type="password" autocomplete="current-password" class="w-full rounded-xl border-gray-300 bg-white px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500">@error('current_password')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror</div>
                    <div><label for="password" class="mb-1.5 block text-sm font-semibold text-gray-800">New password</label><input id="password" name="password" type="password" minlength="12" autocomplete="new-password" class="w-full rounded-xl border-gray-300 bg-white px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500">@error('password')<p class="mt-1 text-xs text-red-700">{{ $message }}</p>@enderror</div>
                    <div><label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-gray-800">Confirm new password</label><input id="password_confirmation" name="password_confirmation" type="password" minlength="12" autocomplete="new-password" class="w-full rounded-xl border-gray-300 bg-white px-3.5 py-3 text-sm focus:border-amber-500 focus:ring-amber-500"></div>
                </div>
            </section>

            <div class="flex flex-col-reverse gap-3 bg-gray-50/70 px-6 py-5 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                <p class="text-xs text-gray-500">Changes apply to your signed-in admin account.</p>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-950 px-5 py-3 text-sm font-extrabold text-white shadow-sm transition hover:bg-amber-700 focus:outline-none focus:ring-4 focus:ring-amber-200">Save profile <span aria-hidden="true">→</span></button>
            </div>
        </form>
    </section>
</div>
@endsection
