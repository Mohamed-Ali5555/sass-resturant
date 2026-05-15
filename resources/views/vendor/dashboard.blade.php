<x-vendor-layout :title="$restaurant->name . ' — ' . __('Dashboard')" :mobile-title="__('Dashboard')">
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-slate-100">{{ $restaurant->name }}</h1>
                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-slate-400">
                    <span class="font-mono text-cyan-400/80">{{ $restaurant->slug }}</span>
                    @if ($subscription)
                        <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5
                            {{ in_array($subscription->status->value, ['active','trialing']) ? 'bg-emerald-500/15 text-emerald-400' : 'bg-amber-500/15 text-amber-400' }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ in_array($subscription->status->value, ['active','trialing']) ? 'bg-emerald-400' : 'bg-amber-400' }}"></span>
                            {{ ucfirst($subscription->status->value) }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('public.restaurant.show', $restaurant) }}" target="_blank"
                    class="inline-flex items-center gap-1.5 rounded-xl border border-white/10 px-3 py-2 text-xs font-medium text-slate-300 transition hover:border-cyan-400/30 hover:text-cyan-200">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                    {{ __('Live menu') }}
                </a>
                <a href="{{ route('vendor.analytics') }}"
                    class="btn-neon inline-flex items-center gap-1.5 rounded-xl px-3 py-2 text-xs font-semibold">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                    {{ __('Full analytics') }}
                </a>
            </div>
        </div>
    </x-slot>

    @include('vendor.partials.flash')

    <div class="mx-auto max-w-7xl space-y-6">

        {{-- KPI Cards --}}
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div class="glass-panel rounded-2xl p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __("Today's orders") }}</p>
                <p class="mt-2 text-3xl font-bold text-slate-100">{{ $todayOrders }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ __('orders placed today') }}</p>
            </div>
            <div class="glass-panel rounded-2xl p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __("Today's revenue") }}</p>
                <p class="mt-2 text-3xl font-bold text-cyan-300">{{ $restaurant->currency }} {{ number_format($todayRevenue, 2) }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ __('excl. canceled') }}</p>
            </div>
            <div class="glass-panel rounded-2xl p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __('Last 30 days') }}</p>
                <p class="mt-2 text-3xl font-bold text-slate-100">{{ $monthOrders }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ $restaurant->currency }} {{ number_format($monthRevenue, 2) }} {{ __('revenue') }}</p>
            </div>
            <div class="glass-panel rounded-2xl p-5">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __('Open orders now') }}</p>
                <p class="mt-2 text-3xl font-bold {{ $openOrders->count() > 0 ? 'text-amber-400' : 'text-slate-100' }}">{{ $openOrders->count() }}</p>
                <p class="mt-1 text-xs text-slate-500">{{ __('awaiting action') }}</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">

            {{-- Weekly bar chart --}}
            <div class="glass-panel col-span-2 rounded-2xl p-6">
                <h2 class="text-sm font-semibold text-slate-300">{{ __('Orders — last 7 days') }}</h2>
                <div class="mt-4 flex h-36 items-end gap-2">
                    @php $maxOrders = max(1, ...array_column($weeklyChart, 'orders')); @endphp
                    @foreach ($weeklyChart as $day)
                        <div class="flex flex-1 flex-col items-center gap-1">
                            <span class="text-[10px] text-slate-500">{{ $day['orders'] > 0 ? $day['orders'] : '' }}</span>
                            <div class="w-full rounded-t-md bg-gradient-to-t from-cyan-600/60 to-cyan-400/80 transition-all duration-500"
                                style="height: {{ max(4, round(($day['orders'] / $maxOrders) * 112)) }}px">
                            </div>
                            <span class="text-[10px] text-slate-500">{{ $day['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Quick stats --}}
            <div class="space-y-3">
                <a href="{{ route('vendor.menu.items.index') }}" class="glass-panel flex items-center gap-4 rounded-2xl p-4 transition hover:border-cyan-400/20">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-cyan-500/20 text-cyan-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513m-3 4.65v-1.5m-6 1.5v-1.5m12 0a3 3 0 01-3 3H9a3 3 0 01-3-3z" /></svg>
                    </span>
                    <div>
                        <p class="text-2xl font-bold text-slate-100">{{ $totalMenuItems }}</p>
                        <p class="text-xs text-slate-500">{{ __('Menu items') }}</p>
                    </div>
                </a>
                <a href="{{ route('vendor.tables.index') }}" class="glass-panel flex items-center gap-4 rounded-2xl p-4 transition hover:border-cyan-400/20">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-teal-500/20 text-teal-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6z" /></svg>
                    </span>
                    <div>
                        <p class="text-2xl font-bold text-slate-100">{{ $totalTables }}</p>
                        <p class="text-xs text-slate-500">{{ __('Tables') }}</p>
                    </div>
                </a>
                <a href="{{ route('vendor.staff.index') }}" class="glass-panel flex items-center gap-4 rounded-2xl p-4 transition hover:border-cyan-400/20">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-violet-500/20 text-violet-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    </span>
                    <div>
                        <p class="text-2xl font-bold text-slate-100">{{ $totalStaff }}</p>
                        <p class="text-xs text-slate-500">{{ __('Staff members') }}</p>
                    </div>
                </a>
                <a href="{{ route('vendor.promotions.index') }}" class="glass-panel flex items-center gap-4 rounded-2xl p-4 transition hover:border-cyan-400/20">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-pink-500/20 text-pink-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L9.568 3z" /></svg>
                    </span>
                    <div>
                        <p class="text-2xl font-bold text-slate-100">{{ $activeCoupons }}</p>
                        <p class="text-xs text-slate-500">{{ __('Active coupons') }}</p>
                    </div>
                </a>
            </div>
        </div>

        {{-- Live orders + top items --}}
        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Live open orders with auto-refresh --}}
            <div class="glass-panel rounded-2xl p-6" id="live-orders-panel">
                <div class="flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-slate-300">{{ __('Live open orders') }}</h2>
                    <span class="flex items-center gap-1.5 text-[10px] text-emerald-400" id="live-indicator">
                        <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-400"></span>{{ __('Live') }}
                    </span>
                </div>

                <div id="open-orders-list" class="mt-4">
                    @forelse ($openOrders as $o)
                        <div class="flex items-center justify-between gap-2 rounded-xl border border-white/5 bg-white/[0.03] px-4 py-3 mb-2 transition hover:border-cyan-400/20">
                            <div>
                                <a href="{{ route('vendor.orders.show', $o) }}" class="font-mono text-sm font-semibold text-cyan-300 hover:text-cyan-100">{{ $o->public_ref }}</a>
                                <p class="text-xs text-slate-500">{{ $o->created_at?->diffForHumans() }}</p>
                            </div>
                            <div class="text-right">
                                <span class="block text-xs font-semibold text-slate-200">{{ $restaurant->currency }} {{ number_format((float) $o->grand_total, 2) }}</span>
                                @php
                                    $statusColor = match($o->status->value) {
                                        'new' => 'bg-amber-500/20 text-amber-300',
                                        'preparing' => 'bg-blue-500/20 text-blue-300',
                                        'ready' => 'bg-emerald-500/20 text-emerald-300',
                                        default => 'bg-slate-500/20 text-slate-300',
                                    };
                                @endphp
                                <span class="mt-1 inline-block rounded-full px-2 py-0.5 text-[10px] font-medium {{ $statusColor }}">
                                    {{ strtoupper($o->status->value) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="py-6 text-center text-sm text-slate-500" id="no-orders-msg">{{ __('No open orders right now. 🎉') }}</p>
                    @endforelse
                </div>

                <a href="{{ route('vendor.orders.index') }}" class="mt-3 inline-block text-xs font-medium text-cyan-400 hover:text-cyan-200 hover:underline">{{ __('View all orders →') }}</a>
            </div>

            {{-- Top selling items --}}
            <div class="glass-panel rounded-2xl p-6">
                <h2 class="text-sm font-semibold text-slate-300">{{ __('Top items — last 30 days') }}</h2>
                <div class="mt-4 space-y-3">
                    @forelse ($topItems as $i => $item)
                        <div class="flex items-center gap-3">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-cyan-500/15 text-xs font-bold text-cyan-400">{{ $i + 1 }}</span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-slate-200">{{ $item->name }}</p>
                            </div>
                            <span class="text-sm font-semibold text-slate-100">×{{ $item->qty }}</span>
                        </div>
                    @empty
                        <p class="py-4 text-center text-sm text-slate-500">{{ __('No order data yet.') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="glass-panel rounded-2xl p-6">
            <h2 class="mb-4 text-sm font-semibold text-slate-400">{{ __('Quick actions') }}</h2>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
                @foreach ([
                    ['route' => 'vendor.menu.items.create', 'icon' => 'M12 4.5v15m7.5-7.5h-15', 'label' => __('Add item')],
                    ['route' => 'vendor.menu.categories.create', 'icon' => 'M8.25 6.75h12M8.25 12h12m-12 5.25h12', 'label' => __('Add category')],
                    ['route' => 'vendor.tables.create', 'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25', 'label' => __('Add table')],
                    ['route' => 'vendor.staff.create', 'icon' => 'M19 7.5v3m0 0v3m0-3h3m-3 0h-3', 'label' => __('Add staff')],
                    ['route' => 'vendor.promotions.create', 'icon' => 'M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318', 'label' => __('New coupon')],
                    ['route' => 'vendor.branches.create', 'icon' => 'M2.25 21h19.5m-18-18v18m10.5-18v18', 'label' => __('Add branch')],
                ] as $action)
                    <a href="{{ route($action['route']) }}"
                        class="flex flex-col items-center gap-2 rounded-xl border border-white/10 px-3 py-4 text-center text-xs font-medium text-slate-300 transition hover:border-cyan-400/30 hover:bg-cyan-500/10 hover:text-cyan-200">
                        <svg class="h-5 w-5 text-cyan-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $action['icon'] }}" />
                        </svg>
                        {{ $action['label'] }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Live order polling every 30s --}}
    <script>
        (function () {
            const refreshInterval = 30000;
            const ordersUrl = '{{ route('vendor.orders.index') }}';

            function fetchOpenOrders() {
                fetch('{{ route('vendor.dashboard') }}?_fragment=open_orders', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                }).catch(() => {});
            }

            // Simple page refresh for the open orders section every 30s
            let timer = setInterval(function () {
                // Only reload if user is not interacting
                if (!document.hidden) {
                    window.location.reload();
                }
            }, refreshInterval);

            document.addEventListener('visibilitychange', function () {
                if (!document.hidden) {
                    clearInterval(timer);
                    timer = setInterval(function () {
                        if (!document.hidden) window.location.reload();
                    }, refreshInterval);
                }
            });
        })();
    </script>
</x-vendor-layout>
