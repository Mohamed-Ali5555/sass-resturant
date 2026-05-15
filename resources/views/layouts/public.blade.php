<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <header class="glass-nav sticky top-0 z-40">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-4">
            <a href="{{ url('/') }}" class="font-semibold tracking-tight text-cyan-100 drop-shadow-[0_0_12px_rgba(34,211,238,0.35)]">{{ config('app.name') }}</a>
            <div class="flex items-center gap-4 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-full border border-cyan-400/25 bg-cyan-500/10 px-4 py-1.5 text-cyan-100 transition hover:border-cyan-300/50 hover:bg-cyan-500/20">Account</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-full border border-cyan-400/25 bg-cyan-500/10 px-4 py-1.5 text-cyan-100 transition hover:border-cyan-300/50 hover:bg-cyan-500/20">Log in</a>
                @endauth
            </div>
        </div>
    </header>
    <main class="mx-auto max-w-5xl px-4 py-8">
        @if (session('status'))
            <div class="mb-4 rounded-2xl border border-emerald-400/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-100 shadow-glow-sm backdrop-blur-md">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>
