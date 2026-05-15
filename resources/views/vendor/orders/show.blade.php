<x-vendor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">Order {{ $order->public_ref }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <dl class="grid gap-3 text-sm sm:grid-cols-2">
                    <div><dt class="text-gray-500">Status</dt><dd class="font-medium">{{ $order->status->value }}</dd></div>
                    <div><dt class="text-gray-500">Mode</dt><dd class="font-medium">{{ $order->order_mode->value }}</dd></div>
                    <div><dt class="text-gray-500">Payment</dt><dd class="font-medium">{{ $order->orderPayments->first()?->type?->value ?? '—' }}</dd></div>
                    <div><dt class="text-gray-500">Total</dt><dd class="font-medium">{{ $restaurant->currency }} {{ number_format((float) $order->grand_total, 2) }}</dd></div>
                </dl>

                <form method="post" action="{{ route('vendor.orders.update-status', $order) }}" class="mt-6 flex flex-wrap items-end gap-3">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="text-xs font-medium text-gray-500">Update status</label>
                        <select name="status" class="mt-1 block w-56 ui-field">
                            @foreach (\App\Enums\OrderStatus::cases() as $case)
                                @continue($case === \App\Enums\OrderStatus::PendingPayment)
                                <option value="{{ $case->value }}" @selected($order->status === $case)>{{ $case->value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn-neon rounded-xl px-4 py-2 text-sm font-semibold">Save</button>
                </form>
            </div>

            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <h3 class="font-semibold">Lines</h3>
                <ul class="mt-3 divide-y divide-cyan-500/15 text-sm">
                    @foreach ($order->orderItems as $line)
                        <li class="py-2 flex justify-between gap-3">
                            <span>{{ $line->item_name_snapshot }} × {{ $line->qty }}</span>
                            <span>{{ $restaurant->currency }} {{ number_format((float) $line->line_total, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-vendor-layout>

