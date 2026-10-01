@extends('layouts.auth')

@section('title', 'Reset your password | Mars Collection')

@section('content')
<main class="grid min-h-screen lg:grid-cols-2">
    <section class="relative isolate flex min-h-[300px] overflow-hidden bg-gray-950 text-white lg:min-h-screen" aria-label="Mars Collection">
        <div class="absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
            <div class="absolute -left-32 -top-32 h-[30rem] w-[30rem] rounded-full bg-amber-500/10 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-24 h-[34rem] w-[34rem] rounded-full bg-amber-400/10 blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.08]" style="background-image: radial-gradient(#fbbf24 0.7px, transparent 0.7px); background-size: 22px 22px;"></div>
        </div>
        <div class="relative mx-auto flex w-full max-w-2xl flex-col justify-between px-6 py-7 sm:px-10 sm:py-9 lg:px-14 lg:py-12 xl:px-20">
            <a href="{{ route('home') }}" aria-label="Mars Collection home" class="inline-flex w-fit rounded-lg bg-white px-3 py-2 shadow-lg shadow-black/20">
                <img src="{{ \App\Helpers\SettingsHelper::getBrandLogoUrl() }}" alt="Mars Collection" class="h-10 w-auto max-w-[200px] object-contain sm:h-12">
            </a>

            <div class="py-10 lg:py-16">
                <p class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.24em] text-amber-300"><span class="h-1.5 w-1.5 rounded-full bg-amber-300"></span> Account recovery</p>
                <h1 class="mt-5 max-w-lg text-4xl font-black leading-[1.08] tracking-tight sm:text-5xl xl:text-6xl">Let’s get you back in.</h1>
                <p class="mt-5 max-w-md text-sm leading-7 text-gray-300 sm:text-base">Enter the email connected to your Mars Collection account and we’ll send you a secure link to reset your password.</p>

                <div class="mt-9 flex max-w-md flex-wrap gap-2">
                    @foreach(['Secure reset link', 'Your account stays protected', 'Back to shopping soon'] as $label)
                        <span class="rounded-full border border-white/15 bg-white/[0.04] px-3 py-1.5 text-xs font-medium text-gray-300">{{ $label }}</span>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-between gap-4 border-t border-white/10 pt-5 text-xs text-gray-500">
                <span>Mars Collection <span class="text-gray-700">&middot;</span> Kenya</span>
                <a href="{{ route('products.index') }}" class="font-semibold text-gray-300 transition hover:text-amber-300">Continue shopping <span aria-hidden="true">&rarr;</span></a>
            </div>
        </div>
    </section>

    <section class="flex items-center justify-center px-4 py-10 sm:px-8 sm:py-14 lg:px-12" aria-labelledby="reset-title">
        <div class="w-full max-w-md">
            <a href="{{ route('home') }}" class="mb-8 inline-flex items-center gap-2 text-xs font-semibold text-gray-500 transition hover:text-gray-950 lg:hidden"><span aria-hidden="true">&larr;</span> Back to Mars Collection</a>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-[0_24px_80px_-36px_rgba(17,24,39,0.24)] sm:p-9">
                <div class="mb-8">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-700">Account recovery</p>
                    <h2 id="reset-title" class="mt-2 text-3xl font-black tracking-tight text-gray-950">Reset your password</h2>
                    <p class="mt-2 text-sm leading-6 text-gray-500">We’ll email you a link to choose a new password.</p>
                </div>

                @if(session('status'))
                    <div role="status" class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('status') }}</div>
                @endif
                @if($errors->any())
                    <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <p class="font-semibold">We couldn’t send the reset link.</p>
                        <p class="mt-1">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-gray-800">Email address</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 6h18v12H3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m3 7 9 6 9-6"/></svg>
                            <input id="email" name="email" type="email" required autocomplete="email" autofocus value="{{ old('email') }}" @if($errors->has('email')) aria-invalid="true" aria-describedby="email-error" @endif
                                   class="w-full rounded-xl border bg-gray-50 py-3.5 pl-11 pr-4 text-sm text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10 @error('email') border-red-400 @else border-gray-200 @enderror"
                                   placeholder="you@example.com">
                        </div>
                        @error('email')<p id="email-error" class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-gray-950 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-gray-950/10 transition hover:bg-amber-500 hover:text-gray-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600">
                        Send reset link <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </button>
                </form>

                <p class="mt-7 border-t border-gray-100 pt-6 text-center text-sm text-gray-500">Remember your password? <a href="{{ route('login') }}" class="font-bold text-amber-800 underline decoration-amber-200 underline-offset-4 transition hover:text-amber-950">Sign in</a></p>
            </div>
            <p class="mt-5 text-center text-xs text-gray-400">Need a hand? <a href="{{ route('contact') }}" class="font-semibold text-gray-600 transition hover:text-amber-800">Contact our team</a></p>
        </div>
    </section>
</main>
@endsection
