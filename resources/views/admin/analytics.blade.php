<x-admin-layout :title="__('Admin · Analytics')" :mobile-title="__('Analytics')">
    <x-slot name="header">
        <h1>{{ __('Platform analytics') }}</h1>
        <p>{{ __('Order volume, GMV, and distribution across the last 30 days.') }}</p>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-8">
        <div class="grid gap-6 lg:grid-cols-2">
            <div class="glass-panel p-6 shadow-glow">
                <h2 class="text-lg font-semibold text-white">{{ __('Orders per day (30d)') }}</h2>
                <div class="mt-4 flex h-48 items-end gap-0.5 overflow-x-auto pb-1 sm:gap-1">
                    @foreach ($chartDays as $day)
                        <div class="flex w-6 shrink-0 flex-col items-center gap-1 sm:w-7">
                            <div
                                class="w-full rounded-t bg-gradient-to-t from-cyan-700 to-cyan-400 shadow-glow-sm"
                                style="height: {{ (int) (($day['orders'] / $maxChartOrders) * 140) }}px; min-height: 2px;"
                                title="{{ $day['label'] }}: {{ $day['orders'] }}"
                            ></div>
                            <span class="text-[9px] text-slate-600 sm:text-[10px]">{{ mb_substr($day['label'], 0, 3, 'UTF-8') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="glass-panel p-6 shadow-glow">
                <h2 class="text-lg font-semibold text-white">{{ __('GMV per day (30d)') }}</h2>
                <div class="mt-4 flex h-48 items-end gap-0.5 overflow-x-auto pb-1 sm:gap-1">
                    @foreach ($chartDays as $day)
                        <div class="flex w-6 shrink-0 flex-col items-center gap-1 sm:w-7">
                            <div
                                class="w-full rounded-t bg-gradient-to-t from-teal-700 to-emerald-400 shadow-glow-sm"
                                style="height: {{ (int) (($day['gmv'] / $maxChartGmv) * 140) }}px; min-height: 2px;"
                                title="{{ $day['label'] }}: ${{ number_format($day['gmv'], 2) }}"
                            ></div>
                            <span class="text-[9px] text-slate-600 sm:text-[10px]">{{ mb_substr($day['label'], 0, 3, 'UTF-8') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="glass-panel p-6 shadow-glow">
                <h2 class="text-lg font-semibold text-white">{{ __('Orders by status (30d)') }}</h2>
                <ul class="mt-4 space-y-2">
                    @foreach ($statusRows as $row)
                        <li class="flex items-center justify-between rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm">
                            <span class="font-medium text-slate-200">{{ $row->status }}</span>
                            <span class="tabular-nums text-slate-400">{{ number_format((int) $row->cnt) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="glass-panel p-6 shadow-glow">
                <h2 class="text-lg font-semibold text-white">{{ __('Top restaurants by GMV (30d)') }}</h2>
                <div class="mt-4 overflow-x-auto">
                    <table class="w-full min-w-[300px] text-left text-sm">
                        <thead>
                            <tr class="border-b border-white/10 text-xs uppercase tracking-wide text-slate-500">
                                <th class="pb-2 font-medium">{{ __('Restaurant') }}</th>
                                <th class="pb-2 font-medium text-right">{{ __('Orders') }}</th>
                                <th class="pb-2 font-medium text-right">{{ __('GMV') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10">
                            @foreach ($topRestaurants as $row)
                                <tr>
                                    <td class="py-2 font-medium text-slate-200">
                                        <a href="{{ route('admin.restaurants.show', $row->restaurant_id) }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">
                                            {{ $restaurantNames[$row->restaurant_id] ?? ('#'.$row->restaurant_id) }}
                                        </a>
                                    </td>
                                    <td class="py-2 text-right tabular-nums text-slate-400">{{ number_format((int) $row->order_cnt) }}</td>
                                    <td class="py-2 text-right font-semibold tabular-nums text-white">${{ number_format((float) $row->gmv, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
