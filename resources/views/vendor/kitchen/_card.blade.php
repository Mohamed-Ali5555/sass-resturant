<div class="p-4">
    <div class="mb-3 flex items-start justify-between gap-2">
        <div>
            <div class="flex items-center gap-2">
                <span class="font-mono text-base font-extrabold text-white">#{{ $order['public_ref'] ?? $order->public_ref }}</span>
                @if(!empty($order['table_number'] ?? $order->table_number))
                    <span class="rounded-lg bg-slate-800 px-2 py-0.5 text-[11px] font-bold uppercase text-slate-300">
                        T{{ $order['table_number'] ?? $order->table_number }}
                    </span>
                @endif
            </div>
            @php
                $orderType = $order['order_type'] ?? ($order->order_type ?? null);
                $orderTypeLabel = $orderType ? str_replace('_', ' ', $orderType) : __('order');
                $orderTypeClasses = 'bg-slate-500/20 text-slate-300';
                if ($orderType === 'dine_in') {
                    $orderTypeClasses = 'bg-amber-500/20 text-amber-300';
                } elseif ($orderType === 'delivery') {
                    $orderTypeClasses = 'bg-blue-500/20 text-blue-300';
                } elseif ($orderType === 'takeaway') {
                    $orderTypeClasses = 'bg-violet-500/20 text-violet-300';
                }
            @endphp
            <div class="mt-1 flex items-center gap-2">
                <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase {{ $orderTypeClasses }}">
                    {{ $orderTypeLabel }}
                </span>
            </div>
        </div>

        <div class="text-right">
            <div class="text-lg font-extrabold tabular-nums kds-timer-ok">{{ __('Timer') }}</div>
            <div class="text-[10px] text-slate-600">{{ __('est.') }} {{ $order['est_prep_minutes'] ?? ($order->est_prep_minutes ?? 0) }} {{ __('min') }}</div>
        </div>
    </div>

    <div class="mb-3 space-y-1.5 rounded-xl bg-black/30 p-3">
        @php $items = $order['items'] ?? ($order->items ?? []); @endphp
        @if(count($items) > 0)
            @foreach($items as $item)
                <div class="flex items-baseline gap-2">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-slate-800 text-xs font-bold text-slate-200">{{ $item['qty'] ?? $item->qty }}x</span>
                    <span class="text-sm font-semibold text-slate-100 leading-tight">{{ $item['name'] ?? $item->name }}</span>
                </div>
            @endforeach
        @else
            <p class="text-xs text-slate-600">{{ __('No items') }}</p>
        @endif
    </div>

    @if(!empty($order['customer_notes'] ?? $order->customer_notes))
        <div class="mb-3 rounded-xl border border-amber-500/20 bg-amber-500/5 px-3 py-2">
            <p class="text-[11px] font-semibold uppercase tracking-wide text-amber-500/70">{{ __('Note') }}</p>
            <p class="text-xs text-amber-200/80">{{ $order['customer_notes'] ?? $order->customer_notes }}</p>
        </div>
    @endif
</div>
