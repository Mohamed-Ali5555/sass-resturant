<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" id="login-form">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-cyan-400/35 bg-slate-950/50 accent-cyan-500 text-cyan-300 shadow-sm focus:ring-cyan-400 dark:focus:ring-cyan-500 dark:focus:ring-offset-slate-900" name="remember">
                <span class="ms-2 text-sm text-slate-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-slate-400 hover:text-cyan-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-400 dark:focus:ring-offset-slate-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Quick Demo Login -->
    <div class="mt-8">
        <div class="relative">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-slate-700/60"></div>
            </div>
            <div class="relative flex justify-center text-xs uppercase">
                <span class="px-3 bg-transparent text-slate-500 tracking-widest">Quick Demo Login</span>
            </div>
        </div>

        <div class="mt-4 grid grid-cols-2 gap-2 sm:grid-cols-2">

            {{-- Super Admin --}}
            <button type="button"
                onclick="demoLogin('admin@foodmenu.local')"
                class="group relative flex items-center gap-3 rounded-xl border border-violet-500/30 bg-violet-950/30 px-3 py-2.5 text-left transition-all duration-200 hover:border-violet-400/60 hover:bg-violet-900/40 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-violet-500/50">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-violet-500/20 text-violet-300 group-hover:bg-violet-500/30">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </span>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-violet-200">Super Admin</p>
                    <p class="truncate text-[10px] text-slate-500">admin@foodmenu.local</p>
                </div>
            </button>

            {{-- Restaurant Owner --}}
            <button type="button"
                onclick="demoLogin('vendor@demo.local')"
                class="group relative flex items-center gap-3 rounded-xl border border-cyan-500/30 bg-cyan-950/30 px-3 py-2.5 text-left transition-all duration-200 hover:border-cyan-400/60 hover:bg-cyan-900/40 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-cyan-500/50">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-cyan-500/20 text-cyan-300 group-hover:bg-cyan-500/30">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </span>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-cyan-200">Restaurant Owner</p>
                    <p class="truncate text-[10px] text-slate-500">vendor@demo.local</p>
                </div>
            </button>

            {{-- Branch Manager --}}
            <button type="button"
                onclick="demoLogin('manager@demo.local')"
                class="group relative flex items-center gap-3 rounded-xl border border-emerald-500/30 bg-emerald-950/30 px-3 py-2.5 text-left transition-all duration-200 hover:border-emerald-400/60 hover:bg-emerald-900/40 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-500/20 text-emerald-300 group-hover:bg-emerald-500/30">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </span>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-emerald-200">Branch Manager</p>
                    <p class="truncate text-[10px] text-slate-500">manager@demo.local</p>
                </div>
            </button>

            {{-- Cashier --}}
            <button type="button"
                onclick="demoLogin('cashier@demo.local')"
                class="group relative flex items-center gap-3 rounded-xl border border-amber-500/30 bg-amber-950/30 px-3 py-2.5 text-left transition-all duration-200 hover:border-amber-400/60 hover:bg-amber-900/40 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-amber-500/50">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-amber-500/20 text-amber-300 group-hover:bg-amber-500/30">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </span>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-amber-200">Cashier</p>
                    <p class="truncate text-[10px] text-slate-500">cashier@demo.local</p>
                </div>
            </button>

            {{-- Customer --}}
            <button type="button"
                onclick="demoLogin('customer@demo.local')"
                class="group relative col-span-2 flex items-center gap-3 rounded-xl border border-rose-500/30 bg-rose-950/30 px-3 py-2.5 text-left transition-all duration-200 hover:border-rose-400/60 hover:bg-rose-900/40 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-rose-500/50">
                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-rose-500/20 text-rose-300 group-hover:bg-rose-500/30">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </span>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-rose-200">Customer</p>
                    <p class="truncate text-[10px] text-slate-500">customer@demo.local</p>
                </div>
                <span class="ml-auto text-[10px] text-slate-600 hidden sm:block">All passwords: <code class="text-slate-400">password</code></span>
            </button>

        </div>
    </div>

    <script>
        function demoLogin(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
            document.getElementById('login-form').submit();
        }
    </script>
</x-guest-layout>
