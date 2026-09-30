@extends('layouts.auth')

@section('title', 'Create a Mars Collection Account | Kenya')

@section('content')
<main class="grid min-h-screen lg:grid-cols-2">
    <section class="relative isolate flex min-h-[280px] overflow-hidden bg-gray-950 text-white lg:min-h-screen" aria-label="Mars Collection">
        <div class="absolute inset-0 -z-10 overflow-hidden" aria-hidden="true">
            <div class="absolute -left-32 -top-32 h-[30rem] w-[30rem] rounded-full bg-amber-500/10 blur-3xl"></div>
            <div class="absolute -bottom-40 -right-24 h-[34rem] w-[34rem] rounded-full bg-amber-400/10 blur-3xl"></div>
            <div class="absolute inset-0 opacity-[0.08]" style="background-image: radial-gradient(#fbbf24 0.7px, transparent 0.7px); background-size: 22px 22px;"></div>
        </div>
        <div class="relative mx-auto flex w-full max-w-2xl flex-col justify-between px-6 py-7 sm:px-10 sm:py-9 lg:px-14 lg:py-12 xl:px-20">
            <a href="{{ route('home') }}" aria-label="Mars Collection home" class="inline-flex w-fit rounded-lg bg-white px-3 py-2 shadow-lg shadow-black/20">
                <img src="{{ \App\Helpers\SettingsHelper::getBrandLogoUrl() }}" alt="Mars Collection" class="h-10 w-auto max-w-[200px] object-contain sm:h-12">
            </a>

            <div class="py-9 lg:py-16">
                <p class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.24em] text-amber-300"><span class="h-1.5 w-1.5 rounded-full bg-amber-300"></span> Join Mars Collection</p>
                <h1 class="mt-5 max-w-lg text-4xl font-black leading-[1.08] tracking-tight sm:text-5xl xl:text-6xl">Your next pair starts here.</h1>
                <p class="mt-5 max-w-md text-sm leading-7 text-gray-300 sm:text-base">Create an account to shop footwear from Mars Collection and keep your account details ready for your next visit.</p>

                <div class="mt-8 max-w-md space-y-3">
                    @foreach(['Browse shoes for every day', 'Explore styles for different occasions', 'Get in touch when you need help'] as $item)
                        <p class="flex items-center gap-3 text-sm text-gray-300"><span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-amber-400/15 text-amber-300"><svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M16.704 5.29a1 1 0 0 1 .006 1.414l-7.2 7.26a1 1 0 0 1-1.42.003l-3.8-3.8a1 1 0 0 1 1.414-1.414l3.09 3.09 6.493-6.547a1 1 0 0 1 1.417-.006Z" clip-rule="evenodd"/></svg></span>{{ $item }}</p>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-between gap-4 border-t border-white/10 pt-5 text-xs text-gray-500">
                <span>Mars Collection <span class="text-gray-700">·</span> Kenya</span>
                <a href="{{ route('products.index') }}" class="font-semibold text-gray-300 transition hover:text-amber-300">Browse shoes <span aria-hidden="true">→</span></a>
            </div>
        </div>
    </section>

    <section class="flex items-center justify-center px-4 py-10 sm:px-8 sm:py-14 lg:px-12" aria-labelledby="register-title">
        <div class="w-full max-w-md">
            <a href="{{ route('home') }}" class="mb-7 inline-flex items-center gap-2 text-xs font-semibold text-gray-500 transition hover:text-gray-950 lg:hidden"><span aria-hidden="true">←</span> Back to Mars Collection</a>

            <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-[0_24px_80px_-36px_rgba(17,24,39,0.24)] sm:p-9">
                <div class="mb-7">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-amber-700">A few details to get started</p>
                    <h2 id="register-title" class="mt-2 text-3xl font-black tracking-tight text-gray-950">Create your account</h2>
                    <p class="mt-2 text-sm leading-6 text-gray-500">Use an email address you can access.</p>
                </div>

                @if($errors->any())
                    <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <p class="font-semibold">Please check your details.</p>
                        <p class="mt-1">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-semibold text-gray-800">Full name</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><circle cx="12" cy="8" r="4" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M4 21a8 8 0 0 1 16 0"/></svg>
                            <input id="name" name="name" type="text" required maxlength="255" autocomplete="name" autofocus value="{{ old('name') }}" @if($errors->has('name')) aria-invalid="true" aria-describedby="name-error" @endif
                                   class="w-full rounded-xl border bg-gray-50 py-3.5 pl-11 pr-4 text-sm text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10 @error('name') border-red-400 @else border-gray-200 @enderror" placeholder="Your full name">
                        </div>
                        @error('name')<p id="name-error" class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-gray-800">Email address</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M3 6h18v12H3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="m3 7 9 6 9-6"/></svg>
                            <input id="email" name="email" type="email" required maxlength="255" autocomplete="email" value="{{ old('email') }}" @if($errors->has('email')) aria-invalid="true" aria-describedby="email-error" @endif
                                   class="w-full rounded-xl border bg-gray-50 py-3.5 pl-11 pr-4 text-sm text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10 @error('email') border-red-400 @else border-gray-200 @enderror" placeholder="you@example.com">
                        </div>
                        @error('email')<p id="email-error" class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-sm font-semibold text-gray-800">Password</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><rect x="4" y="10" width="16" height="11" rx="2" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                            <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password" @if($errors->has('password')) aria-invalid="true" aria-describedby="password-hint password-error" @else aria-describedby="password-hint" @endif
                                   class="w-full rounded-xl border bg-gray-50 py-3.5 pl-11 pr-12 text-sm text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10 @error('password') border-red-400 @else border-gray-200 @enderror" placeholder="Create a password">
                            <button type="button" data-password-toggle="password" class="absolute inset-y-0 right-0 inline-flex items-center rounded-r-xl px-3.5 text-gray-400 transition hover:text-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-amber-600" aria-label="Show password" aria-pressed="false"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M2.5 12s3.4-7 9.5-7 9.5 7 9.5 7-3.4 7-9.5 7-9.5-7-9.5-7Z"/><circle cx="12" cy="12" r="3" stroke-width="1.7"/></svg></button>
                        </div>
                        <p id="password-hint" class="mt-1.5 text-xs text-gray-400">Use at least 8 characters.</p>
                        @error('password')<p id="password-error" class="mt-1.5 text-xs font-medium text-red-700">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="password-confirm" class="mb-1.5 block text-sm font-semibold text-gray-800">Confirm password</label>
                        <div class="relative">
                            <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><rect x="4" y="10" width="16" height="11" rx="2" stroke-width="1.7"/><path stroke-linecap="round" stroke-width="1.7" d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                            <input id="password-confirm" name="password_confirmation" type="password" required minlength="8" autocomplete="new-password" class="w-full rounded-xl border border-gray-200 bg-gray-50 py-3.5 pl-11 pr-12 text-sm text-gray-900 transition placeholder:text-gray-400 hover:border-gray-300 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/10" placeholder="Enter your password again">
                            <button type="button" data-password-toggle="password-confirm" class="absolute inset-y-0 right-0 inline-flex items-center rounded-r-xl px-3.5 text-gray-400 transition hover:text-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-amber-600" aria-label="Show password confirmation" aria-pressed="false"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M2.5 12s3.4-7 9.5-7 9.5 7 9.5 7-3.4 7-9.5 7-9.5-7-9.5-7Z"/><circle cx="12" cy="12" r="3" stroke-width="1.7"/></svg></button>
                        </div>
                        <p id="password-match" aria-live="polite" class="mt-1.5 min-h-4 text-xs text-gray-400"></p>
                    </div>

                    <button type="submit" class="group flex w-full items-center justify-center gap-2 rounded-xl bg-gray-950 px-5 py-3.5 text-sm font-bold text-white shadow-lg shadow-gray-950/10 transition hover:bg-amber-500 hover:text-gray-950 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-600">
                        Create account <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </button>
                </form>

                <p class="mt-6 border-t border-gray-100 pt-5 text-center text-sm text-gray-500">Already have an account? <a href="{{ route('login') }}" class="font-bold text-amber-800 underline decoration-amber-200 underline-offset-4 transition hover:text-amber-950">Sign in</a></p>
            </div>
            <p class="mt-5 text-center text-xs text-gray-400">Need a hand? <a href="{{ route('contact') }}" class="font-semibold text-gray-600 transition hover:text-amber-800">Contact our team</a></p>
        </div>
    </section>
</main>

<script>
    document.querySelectorAll('[data-password-toggle]').forEach(button => {
        button.addEventListener('click', function () {
            const field = document.getElementById(this.dataset.passwordToggle);
            const isVisible = field.type === 'text';
            field.type = isVisible ? 'password' : 'text';
            this.setAttribute('aria-pressed', String(!isVisible));
            this.setAttribute('aria-label', isVisible ? 'Show password' : 'Hide password');
        });
    });

    const passwordField = document.getElementById('password');
    const confirmationField = document.getElementById('password-confirm');
    const matchMessage = document.getElementById('password-match');
    function updatePasswordMatch() {
        if (!confirmationField.value) {
            matchMessage.textContent = '';
            matchMessage.className = 'mt-1.5 min-h-4 text-xs text-gray-400';
            return;
        }
        const matches = passwordField.value === confirmationField.value;
        matchMessage.textContent = matches ? 'Passwords match.' : 'Passwords do not match yet.';
        matchMessage.className = `mt-1.5 min-h-4 text-xs ${matches ? 'text-emerald-700' : 'text-red-700'}`;
    }
    passwordField.addEventListener('input', updatePasswordMatch);
    confirmationField.addEventListener('input', updatePasswordMatch);
</script>
@endsection
