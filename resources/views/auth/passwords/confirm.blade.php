@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 to-purple-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ __('Confirm Password') }}
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                {{ __('Please confirm your password before continuing.') }}
            </p>
        </div>
        
        <div class="bg-white shadow rounded-sm p-6">
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-sm focus:outline-none focus:ring-pink-500 focus:border-pink-500 focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                           placeholder="{{ __('Password') }}">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" 
                            class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded-sm">
                        {{ __('Confirm Password') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="text-pink-600 hover:text-pink-700 text-sm">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
