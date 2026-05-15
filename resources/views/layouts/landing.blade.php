<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name') . ' — Restaurant Management Platform')</title>
    <meta name="description" content="@yield('meta_description', 'The all-in-one SaaS platform for restaurants & cafes. QR menus, Kitchen Display, POS, Analytics & more.')">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800,900&family=inter:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="page-landing font-hub antialiased text-slate-100">

    {{-- ── Navigation ────────────────────────────────── --}}
    <nav class="fixed inset-x-0 top-0 z-50 border-b border-white/8 bg-[#07080f]/80 backdrop-blur-2xl">
        <div class="land-section flex h-16 items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5">
                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-orange-600 shadow-glow-orange-sm">
                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /></svg>
                </span>
                <span class="text-lg font-extrabold text-white">{{ config('app.name') }}</span>
            </a>

            <div class="hidden items-center gap-8 lg:flex">
                <a href="{{ url('/') }}#features" class="text-sm font-medium text-slate-400 transition hover:text-white">Features</a>
                <a href="{{ url('/') }}#how-it-works" class="text-sm font-medium text-slate-400 transition hover:text-white">How it works</a>
                <a href="{{ route('pricing') }}" class="text-sm font-medium text-slate-400 transition hover:text-white">Pricing</a>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="hidden rounded-xl border border-white/15 px-4 py-2 text-sm font-medium text-slate-300 transition hover:border-white/30 hover:text-white sm:block">Sign in</a>
                <a href="{{ route('register') }}" class="btn-orange rounded-xl px-4 py-2 text-sm">Start free →</a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    {{-- ── Footer ─────────────────────────────────────── --}}
    <footer class="border-t border-white/8 bg-[#07080f]/90">
        <div class="land-section py-12">
            <div class="grid gap-8 md:grid-cols-4">
                <div class="md:col-span-2">
                    <a href="{{ url('/') }}" class="flex items-center gap-2 text-lg font-extrabold text-white">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-brand-500 to-orange-600">
                            <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /></svg>
                        </span>
                        {{ config('app.name') }}
                    </a>
                    <p class="mt-3 max-w-xs text-sm text-slate-500">The complete restaurant management platform for the modern era. QR menus, orders, analytics — all in one place.</p>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500">Product</h3>
                    <ul class="mt-3 space-y-2 text-sm text-slate-400">
                        <li><a href="{{ url('/') }}#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="{{ route('pricing') }}" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="{{ url('/') }}#how-it-works" class="hover:text-white transition">How it works</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-widest text-slate-500">Account</h3>
                    <ul class="mt-3 space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Sign in</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition">Sign up free</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-8 border-t border-white/8 pt-6 flex items-center justify-between text-xs text-slate-600">
                <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                <p>Built for restaurants, cafes & cloud kitchens.</p>
            </div>
        </div>
    </footer>
</body>
</html>
