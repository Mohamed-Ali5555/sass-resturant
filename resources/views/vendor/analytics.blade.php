<x-vendor-layout :title="__('Vendor · Analytics')" :mobile-title="__('Analytics')">
    <x-slot name="header">
        <h1>{{ __('Analytics') }}</h1>
        <p>{{ __('Performance for :name over the last 14–30 days.', ['name' => $restaurant->name]) }}</p>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-8">
        <div class="grid gap-4 sm:grid-cols-3">
            <div class="hub-stat-card">
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __('Orders (30d)') }}</div>
                <div class="mt-2 text-3xl font-bold tabular-nums text-white">{{ number_format($ordersLast30) }}</div>
            </div>
            <div class="hub-stat-card">
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __('GMV (30d)') }}</div>
                <div class="mt-2 text-3xl font-bold tabular-nums text-white">${{ number_format($gmvLast30, 2) }}</div>
            </div>
            <div class="hub-stat-card">
                <div class="text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __('Avg. order value (30d)') }}</div>
                <div class="mt-2 text-3xl font-bold tabular-nums text-white">${{ number_format($aovLast30, 2) }}</div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="glass-panel p-6 shadow-glow">
                <h2 class="text-lg font-semibold text-white">{{ __('Orders (14 days)') }}</h2>
                <div class="mt-4 flex h-44 items-end gap-1.5 sm:gap-2">
                    @foreach ($chartDays as $day)
                        <div class="flex min-w-0 flex-1 flex-col items-center gap-1">
                            <div
                                class="w-full max-w-[2.5rem] rounded-t bg-gradient-to-t from-cyan-700 to-cyan-400 shadow-glow-sm"
                                style="height: {{ (int) (($day['orders'] / $maxChartOrders) * 120) }}px; min-height: 2px;"
                                title="{{ $day['label'] }}: {{ $day['orders'] }}"
                            ></div>
                            <span class="hidden text-[10px] text-slate-500 sm:inline">{{ $day['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="glass-panel p-6 shadow-glow">
                <h2 class="text-lg font-semibold text-white">{{ __('GMV (14 days)') }}</h2>
                <div class="mt-4 flex h-44 items-end gap-1.5 sm:gap-2">
                    @foreach ($chartDays as $day)
                        <div class="flex min-w-0 flex-1 flex-col items-center gap-1">
                            <div
                                class="w-full max-w-[2.5rem] rounded-t bg-gradient-to-t from-emerald-700 to-emerald-400 shadow-glow-sm"
                                style="height: {{ (int) (($day['gmv'] / $maxChartGmv) * 120) }}px; min-height: 2px;"
                                title="{{ $day['label'] }}: ${{ number_format($day['gmv'], 2) }}"
                            ></div>
                            <span class="hidden text-[10px] text-slate-500 sm:inline">{{ $day['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="glass-panel p-6 shadow-glow">
                <h2 class="text-lg font-semibold text-white">{{ __('Orders by status (30d)') }}</h2>
                <ul class="mt-4 space-y-2">
                    @forelse ($statusRows as $row)
                        <li class="flex items-center justify-between rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm">
                            <span class="font-medium text-slate-200">{{ $row->status }}</span>
                            <span class="tabular-nums text-slate-400">{{ number_format((int) $row->cnt) }}</span>
                        </li>
                    @empty
                        <li class="text-sm text-slate-500">{{ __('No orders in this window.') }}</li>
                    @endforelse
                </ul>
            </div>
            <div class="glass-panel p-6 shadow-glow">
                <h2 class="text-lg font-semibold text-white">{{ __('Top items by revenue (30d)') }}</h2>
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full min-w-[280px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-white/10 text-xs uppercase tracking-wide text-slate-500">
                                <th class="pb-2 font-medium">{{ __('Item') }}</th>
                                <th class="pb-2 font-medium text-right">{{ __('Qty') }}</th>
                                <th class="pb-2 font-medium text-right">{{ __('Revenue') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @forelse ($topLines as $line)
                                <tr>
                                    <td class="py-2 font-medium text-slate-200">{{ $line->name }}</td>
                                    <td class="py-2 text-right tabular-nums text-slate-400">{{ number_format((int) $line->qty) }}</td>
                                    <td class="py-2 text-right font-semibold tabular-nums text-white">${{ number_format((float) $line->revenue, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="py-4 text-slate-500">{{ __('No line items in this window.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-vendor-layout>
