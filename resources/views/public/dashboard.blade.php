<x-hub-layout :title="__('Account · Overview')" :mobile-title="__('Overview')">
    <x-slot name="header">
        <h1>{{ __('Welcome back') }}, {{ auth()->user()->name }}</h1>
        <p>{{ __('Your orders, saved items, and account settings in one place.') }}</p>
    </x-slot>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="hub-stat-card">
            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __('Total orders') }}</div>
            <div class="mt-2 text-3xl font-bold tabular-nums text-white">{{ number_format($ordersCount) }}</div>
            <a href="{{ route('account.orders.index') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-cyan-300 hover:text-cyan-100">
                {{ __('View all') }}
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>
        <div class="hub-stat-card">
            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __('Saved items') }}</div>
            <div class="mt-2 text-3xl font-bold tabular-nums text-white">{{ number_format($favoritesCount) }}</div>
            <a href="{{ route('account.favorites.index') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-medium text-cyan-300 hover:text-cyan-100">
                {{ __('Browse saved') }}
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>
            </a>
        </div>
        <div class="hub-stat-card sm:col-span-2 lg:col-span-1">
            <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __('Quick links') }}</div>
            <ul class="mt-3 space-y-2 text-sm text-slate-300">
                <li><a href="{{ url('/') }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Discover restaurants') }}</a></li>
                <li><a href="{{ route('profile.edit') }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Profile & security') }}</a></li>
                <li><a href="{{ route('account.help') }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Help & support') }}</a></li>
            </ul>
        </div>
    </div>

    <div class="mt-10">
        <div class="mb-4 flex flex-wrap items-end justify-between gap-3">
            <div>
                <h2 class="text-lg font-semibold text-white">{{ __('Recent orders') }}</h2>
                <p class="mt-0.5 text-sm text-slate-500">{{ __('Last five orders linked to your account.') }}</p>
            </div>
            <a href="{{ route('account.orders.index') }}" class="text-sm font-medium text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('See full history') }}</a>
        </div>

        @if ($recentOrders->isEmpty())
            <div class="glass-panel p-10 text-center shadow-glow">
                <p class="text-slate-400">{{ __('No orders yet. Explore a menu and place your first order.') }}</p>
                <a href="{{ url('/') }}" class="btn-neon mt-6 inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold">{{ __('Discover') }}</a>
            </div>
        @else
            <div class="hub-table-wrap">
                <div class="divide-y divide-white/10">
                    @foreach ($recentOrders as $o)
                        <div class="flex flex-wrap items-center justify-between gap-3 px-4 py-4 sm:px-6">
                            <div>
                                <div class="font-mono text-sm font-medium text-cyan-200">{{ $o->public_ref }}</div>
                                <div class="mt-0.5 text-sm text-slate-400">{{ $o->restaurant?->name ?? '—' }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-semibold text-white">${{ number_format((float) $o->grand_total, 2) }}</div>
                                <div class="mt-0.5 text-xs uppercase tracking-wide text-slate-500">{{ $o->status->value }}</div>
                            </div>
                            <a href="{{ route('account.orders.show', $o) }}" class="w-full rounded-xl border border-cyan-400/25 bg-cyan-500/10 px-4 py-2 text-center text-sm font-medium text-cyan-100 transition hover:border-cyan-300/45 hover:bg-cyan-500/20 sm:w-auto">
                                {{ __('Details') }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-hub-layout>
