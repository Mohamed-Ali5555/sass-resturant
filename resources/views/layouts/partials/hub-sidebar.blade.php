@php
    $u = auth()->user();
@endphp

<div class="flex h-full min-h-0 flex-col border-r border-white/10 bg-slate-950/70 backdrop-blur-2xl">
    <div class="flex h-16 shrink-0 items-center gap-2 border-b border-white/10 px-4">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 rounded-xl px-2 py-1.5 transition hover:bg-white/5">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-cyan-400 to-teal-600 shadow-glow-sm ring-1 ring-white/20">
                <x-application-logo class="h-5 w-5 fill-current text-slate-950" />
            </span>
            <div class="min-w-0 leading-tight">
                <div class="truncate text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __('Account') }}</div>
                <div class="truncate text-sm font-semibold text-slate-100">{{ config('app.name') }}</div>
            </div>
        </a>
    </div>

    <nav class="hub-scrollbar flex-1 space-y-6 overflow-y-auto px-3 py-5">
        <div>
            <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Overview') }}</p>
            <div class="space-y-0.5">
                <x-hub-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25A2.25 2.25 0 0113.5 8.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                    <span>{{ __('Overview') }}</span>
                </x-hub-nav-link>
            </div>
        </div>

        <div>
            <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Ordering') }}</p>
            <div class="space-y-0.5">
                <x-hub-nav-link :href="route('account.orders.index')" :active="request()->routeIs('account.orders.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                    <span>{{ __('My orders') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('account.favorites.index')" :active="request()->routeIs('account.favorites.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" /></svg>
                    <span>{{ __('Saved items') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="url('/')" :active="request()->is('/')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" /></svg>
                    <span>{{ __('Discover') }}</span>
                </x-hub-nav-link>
            </div>
        </div>

        <div>
            <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Account') }}</p>
            <div class="space-y-0.5">
                <x-hub-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                    <span>{{ __('Profile & security') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('account.help')" :active="request()->routeIs('account.help')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" /></svg>
                    <span>{{ __('Help') }}</span>
                </x-hub-nav-link>
            </div>
        </div>
    </nav>

    <div class="hub-sidebar-footer mt-auto shrink-0 space-y-2 border-t border-white/10 p-3">
        @can('vendor.panel')
            <a href="{{ route('vendor.dashboard') }}" class="flex items-center gap-2 rounded-xl border border-cyan-400/20 bg-cyan-500/10 px-3 py-2 text-xs font-medium text-cyan-100 transition hover:border-cyan-300/40 hover:bg-cyan-500/20">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-16.5 0V9.75m11.25 11.25v-9m-9 0V9.75m0 0h3.375c.621 0 1.125.504 1.125 1.125V15" /></svg>
                {{ __('Vendor dashboard') }}
            </a>
        @endcan
        @can('admin.access')
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 rounded-xl border border-amber-400/25 bg-amber-500/10 px-3 py-2 text-xs font-medium text-amber-100 transition hover:border-amber-300/45 hover:bg-amber-500/20">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.37.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                {{ __('Admin') }}
            </a>
        @endcan

        <div class="flex items-center gap-3 rounded-xl bg-white/5 px-3 py-2.5 ring-1 ring-white/10">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-cyan-400 to-teal-600 text-xs font-bold text-slate-950">
                {{ mb_strtoupper(mb_substr($u->name, 0, 1, 'UTF-8'), 'UTF-8') }}
            </span>
            <div class="min-w-0 flex-1">
                <div class="truncate text-sm font-medium text-slate-100">{{ $u->name }}</div>
                <div class="truncate text-xs text-slate-500">{{ $u->email }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 px-3 py-2 text-xs font-medium text-slate-300 transition hover:border-red-400/30 hover:bg-red-500/10 hover:text-red-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                {{ __('Log out') }}
            </button>
        </form>
    </div>
</div>
