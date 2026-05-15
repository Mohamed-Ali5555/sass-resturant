<x-vendor-layout :title="__('Orders — ') . $restaurant->name" :mobile-title="__('Orders')">
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-slate-100">{{ __('Orders') }}</h1>
                <p class="mt-0.5 text-sm text-slate-400">{{ __('All orders for :name', ['name' => $restaurant->name]) }}</p>
            </div>
            <span class="flex items-center gap-1.5 text-[10px] text-emerald-400" id="live-indicator">
                <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-400"></span>{{ __('Auto-refresh every 30s') }}
            </span>
        </div>
    </x-slot>

    @include('vendor.partials.flash')

    <div class="mx-auto max-w-6xl space-y-4">

        {{-- Status filter tabs --}}
        <div class="flex flex-wrap gap-2">
            @php
                $statusFilters = [
                    '' => __('All'),
                    'new' => __('New'),
                    'preparing' => __('Preparing'),
                    'ready' => __('Ready'),
                    'completed' => __('Completed'),
                    'canceled' => __('Canceled'),
                ];
                $activeStatus = request('status', '');
            @endphp
            @foreach ($statusFilters as $val => $label)
                <a href="{{ route('vendor.orders.index', array_filter(['status' => $val])) }}"
                    class="rounded-xl border px-3 py-1.5 text-xs font-medium transition
                        {{ $activeStatus === $val
                            ? 'border-cyan-400/60 bg-cyan-500/20 text-cyan-300'
                            : 'border-white/10 text-slate-400 hover:border-cyan-400/30 hover:text-cyan-200' }}">
                    {{ $label }}
                    @if ($val === '' && $orders->total() > 0)
                        <span class="ml-1 rounded-full bg-white/10 px-1.5 text-[10px]">{{ $orders->total() }}</span>
                    @endif
                </a>
            @endforeach
        </div>

        @if ($orders->isEmpty())
            <div class="glass-panel flex flex-col items-center justify-center gap-3 rounded-2xl p-16 text-center">
                <svg class="h-12 w-12 text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25" /></svg>
                <p class="text-slate-400">{{ __('No orders found.') }}</p>
            </div>
        @else
            <div class="glass-panel overflow-hidden rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/10 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                <th class="px-5 py-3">{{ __('Order') }}</th>
                                <th class="px-5 py-3">{{ __('Status') }}</th>
                                <th class="px-5 py-3">{{ __('Type') }}</th>
                                <th class="px-5 py-3">{{ __('Total') }}</th>
                                <th class="px-5 py-3">{{ __('When') }}</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach ($orders as $o)
                                @php
                                    $statusColors = [
                                        'new' => 'bg-amber-500/20 text-amber-300',
                                        'preparing' => 'bg-blue-500/20 text-blue-300',
                                        'ready' => 'bg-emerald-500/20 text-emerald-300',
                                        'completed' => 'bg-teal-500/15 text-teal-400',
                                        'canceled' => 'bg-red-500/15 text-red-400',
                                        'pending_payment' => 'bg-slate-500/20 text-slate-400',
                                    ];
                                    $color = $statusColors[$o->status->value] ?? 'bg-slate-500/20 text-slate-400';
                                @endphp
                                <tr class="transition hover:bg-white/[0.02]">
                                    <td class="px-5 py-3">
                                        <a href="{{ route('vendor.orders.show', $o) }}" class="font-mono text-sm font-semibold text-cyan-300 hover:text-cyan-100 hover:underline">{{ $o->public_ref }}</a>
                                        @if ($o->table_session_id)
                                            <p class="text-[10px] text-slate-500">{{ __('Dine-in') }}</p>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-[11px] font-semibold {{ $color }}">
                                            {{ strtoupper(str_replace('_', ' ', $o->status->value)) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-xs text-slate-400">{{ $o->order_type ?? '—' }}</td>
                                    <td class="px-5 py-3 font-semibold text-slate-200">{{ $restaurant->currency }} {{ number_format((float) $o->grand_total, 2) }}</td>
                                    <td class="px-5 py-3 text-xs text-slate-500">{{ $o->created_at?->diffForHumans() }}</td>
                                    <td class="px-5 py-3">
                                        <a href="{{ route('vendor.orders.show', $o) }}" class="text-xs font-medium text-cyan-400 hover:text-cyan-200 hover:underline">{{ __('View') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-4 border-t border-white/5">{{ $orders->appends(request()->query())->links() }}</div>
            </div>
        @endif
    </div>

    <script>
        let refreshTimer = setInterval(function () {
            if (!document.hidden) window.location.reload();
        }, 30000);
        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) {
                clearInterval(refreshTimer);
                refreshTimer = setInterval(function () {
                    if (!document.hidden) window.location.reload();
                }, 30000);
            }
        });
    </script>
</x-vendor-layout>
