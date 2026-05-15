<x-hub-layout :title="__('Account · Order :ref', ['ref' => $order->public_ref])" :mobile-title="__('Order')">
    <x-slot name="header">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="font-mono text-xl tracking-tight text-cyan-100 sm:text-2xl">{{ $order->public_ref }}</h1>
                <p class="mt-1">{{ $order->restaurant?->name ?? '—' }} · {{ $order->created_at?->format('M j, Y g:i A') }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-300">{{ $order->status->value }}</span>
                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-slate-300">{{ $order->order_type->value }}</span>
            </div>
        </div>
    </x-slot>

    <div class="mb-6 flex flex-wrap gap-3">
        <a href="{{ route('account.orders.index') }}" class="text-sm font-medium text-cyan-300 hover:text-cyan-100 hover:underline">← {{ __('Back to orders') }}</a>
        @if ($order->restaurant)
            <a href="{{ route('public.order.show', ['restaurant' => $order->restaurant, 'publicRef' => $order->public_ref]) }}" class="text-sm font-medium text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Public tracking page') }}</a>
        @endif
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="glass-panel p-6 shadow-glow lg:col-span-2">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">{{ __('Items') }}</h2>
            <ul class="mt-4 divide-y divide-white/10">
                @foreach ($order->orderItems as $line)
                    <li class="flex justify-between gap-4 py-3 text-sm">
                        <div>
                            <div class="font-medium text-slate-100">{{ $line->item_name_snapshot }}</div>
                            <div class="mt-0.5 text-slate-500">× {{ $line->qty }}</div>
                        </div>
                        <div class="shrink-0 font-semibold tabular-nums text-slate-200">${{ number_format((float) $line->line_total, 2) }}</div>
                    </li>
                @endforeach
            </ul>
            <dl class="mt-6 space-y-2 border-t border-white/10 pt-4 text-sm">
                <div class="flex justify-between text-slate-400"><dt>{{ __('Subtotal') }}</dt><dd class="tabular-nums text-slate-200">${{ number_format((float) $order->subtotal, 2) }}</dd></div>
                <div class="flex justify-between text-slate-400"><dt>{{ __('Tax') }}</dt><dd class="tabular-nums text-slate-200">${{ number_format((float) $order->tax_total, 2) }}</dd></div>
                <div class="flex justify-between text-slate-400"><dt>{{ __('Delivery') }}</dt><dd class="tabular-nums text-slate-200">${{ number_format((float) $order->delivery_fee, 2) }}</dd></div>
                <div class="flex justify-between border-t border-white/10 pt-3 text-base font-semibold text-white"><dt>{{ __('Total') }}</dt><dd class="tabular-nums">${{ number_format((float) $order->grand_total, 2) }}</dd></div>
            </dl>
        </div>

        <div class="glass-panel p-6 shadow-glow">
            <h2 class="text-sm font-semibold uppercase tracking-wider text-slate-500">{{ __('Payments') }}</h2>
            @if ($order->orderPayments->isEmpty())
                <p class="mt-3 text-sm text-slate-500">{{ __('No payment records.') }}</p>
            @else
                <ul class="mt-3 space-y-2 text-sm">
                    @foreach ($order->orderPayments as $p)
                        <li class="rounded-xl border border-white/10 bg-white/5 px-3 py-2">
                            <div class="font-medium text-slate-200">{{ $p->type instanceof \BackedEnum ? $p->type->value : $p->type }}</div>
                            <div class="text-xs uppercase text-slate-500">{{ $p->status instanceof \BackedEnum ? $p->status->value : $p->status }}</div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</x-hub-layout>
