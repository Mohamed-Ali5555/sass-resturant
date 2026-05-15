<x-admin-layout :title="__('Admin · Dashboard')" :mobile-title="__('Dashboard')">
    <x-slot name="header">
        <h1>{{ __('Dashboard') }}</h1>
        <p>{{ __('High-level KPIs and last 7 days of activity. Open Analytics for a 30-day view.') }}</p>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.analytics') }}" class="btn-neon inline-flex items-center rounded-xl px-4 py-2 text-sm font-semibold">{{ __('Open analytics') }}</a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="glass-panel p-4">
                    <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ __('Orders (all time)') }}</div>
                    <div class="mt-1 text-2xl font-semibold text-slate-50">{{ number_format($ordersTotal) }}</div>
                </div>
                <div class="glass-panel p-4">
                    <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ __('GMV (excl. canceled / unpaid)') }}</div>
                    <div class="mt-1 text-2xl font-semibold text-slate-50">${{ number_format($gmvTotal, 2) }}</div>
                </div>
                <div class="glass-panel p-4">
                    <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ __('Est. platform commission') }}</div>
                    <div class="mt-1 text-2xl font-semibold text-slate-50">${{ number_format($estimatedCommissions, 2) }}</div>
                    <div class="mt-1 text-xs text-slate-500">{{ __('Using default rate :rate%', ['rate' => number_format($platformRate, 2)]) }}</div>
                </div>
                <div class="glass-panel p-4">
                    <div class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ __('Active restaurants') }}</div>
                    <div class="mt-1 text-2xl font-semibold text-slate-50">{{ number_format($activeRestaurantsCount) }}</div>
                    <div class="mt-1 text-xs text-slate-500">{{ __('Total :t · Suspended :s', ['t' => $restaurantsCount, 's' => $suspendedRestaurantsCount]) }}</div>
                </div>
            </div>

        <div class="grid gap-6 lg:grid-cols-2">
                <div class="glass-panel p-6">
                    <h3 class="font-semibold text-slate-50">{{ __('Orders last 7 days') }}</h3>
                    <div class="mt-4 flex h-40 items-end gap-2">
                        @foreach ($chartDays as $day)
                            <div class="flex flex-1 flex-col items-center gap-1">
                                <div
                                    class="w-full rounded-t bg-gradient-to-t from-cyan-700 to-cyan-400 shadow-glow-sm"
                                    style="height: {{ (int) (($day['orders'] / $maxChartOrders) * 100) }}px; min-height: 2px;"
                                    title="{{ $day['label'] }}: {{ $day['orders'] }}"
                                ></div>
                                <span class="text-[10px] text-slate-500">{{ $day['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="glass-panel p-6">
                    <h3 class="font-semibold text-slate-50">{{ __('GMV last 7 days') }}</h3>
                    <div class="mt-4 flex h-40 items-end gap-2">
                        @foreach ($chartDays as $day)
                            <div class="flex flex-1 flex-col items-center gap-1">
                                <div
                                    class="w-full rounded-t bg-emerald-500 dark:bg-emerald-400"
                                    style="height: {{ (int) (($day['gmv'] / $maxChartGmv) * 100) }}px; min-height: 2px;"
                                    title="{{ $day['label'] }}: ${{ number_format($day['gmv'], 2) }}"
                                ></div>
                                <span class="text-[10px] text-slate-500">{{ $day['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        <div class="glass-panel p-6 text-sm text-slate-200 shadow-glow">
                <div class="font-semibold text-slate-50">{{ __('Catalog') }}</div>
                <p class="mt-2 text-slate-400">{{ __('Subscription plans in system: :n', ['n' => $plansCount]) }}</p>
            </div>
    </div>
</x-admin-layout>