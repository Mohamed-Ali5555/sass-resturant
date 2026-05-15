<x-hub-layout :title="__('Account · Orders')" :mobile-title="__('Orders')">
    <x-slot name="header">
        <h1>{{ __('My orders') }}</h1>
        <p>{{ __('Every order placed while you were signed in appears here.') }}</p>
    </x-slot>

    @if ($orders->isEmpty())
        <div class="glass-panel p-12 text-center shadow-glow">
            <p class="text-slate-400">{{ __('You have no orders yet.') }}</p>
            <a href="{{ url('/') }}" class="btn-neon mt-6 inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold">{{ __('Discover restaurants') }}</a>
        </div>
    @else
        <div class="hub-table-wrap">
            <div class="divide-y divide-white/10">
                @foreach ($orders as $o)
                    <div class="flex flex-col gap-3 px-4 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-6">
                        <div class="min-w-0">
                            <div class="font-mono text-sm font-semibold text-cyan-200">{{ $o->public_ref }}</div>
                            <div class="mt-0.5 truncate text-sm text-slate-400">{{ $o->restaurant?->name ?? '—' }}</div>
                            <div class="mt-1 text-xs uppercase tracking-wide text-slate-500">{{ $o->status->value }}</div>
                        </div>
                        <div class="flex flex-wrap items-center gap-4 sm:justify-end">
                            <div class="text-lg font-bold tabular-nums text-white">${{ number_format((float) $o->grand_total, 2) }}</div>
                            <div class="text-xs text-slate-500">{{ $o->created_at?->format('M j, Y g:i A') }}</div>
                            <a href="{{ route('account.orders.show', $o) }}" class="rounded-xl border border-cyan-400/25 bg-cyan-500/10 px-4 py-2 text-sm font-medium text-cyan-100 transition hover:border-cyan-300/45 hover:bg-cyan-500/20">
                                {{ __('View') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</x-hub-layout>
