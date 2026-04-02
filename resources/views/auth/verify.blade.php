@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                {{ __('Verify Your Email Address') }}
            </h2>
        </div>
        
        <div class="bg-white shadow rounded-md p-6">
            @if (session('resent'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </div>
            @endif

            <p class="text-gray-600 mb-4">
                {{ __('Before proceeding, please check your email for a verification link.') }}
            </p>
            
            <p class="text-gray-600">
                {{ __('If you did not receive the email') }},
                <form class="inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="text-pink-600 hover:text-pink-700 underline">
                        {{ __('click here to request another') }}
                    </button>.
                </form>
            </p>
        </div>
    </div>
</div>
@endsection
