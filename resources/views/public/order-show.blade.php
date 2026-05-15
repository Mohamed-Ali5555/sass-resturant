@extends('layouts.public')

@section('title', 'Order '.$order->public_ref)

@section('content')
    <h1 class="mb-2 text-2xl font-bold">Order {{ $order->public_ref }}</h1>
    <p class="text-sm text-slate-400">{{ $restaurant->name }}</p>

    @if ($order->status === \App\Enums\OrderStatus::PendingPayment)
        <div class="mt-4 rounded-md border border-amber-400/30 bg-amber-500/10 px-4 py-3 text-sm text-amber-900 border-amber-400/25 bg-amber-950/40 text-amber-100">
            Waiting for payment confirmation. If you just paid with Stripe, this page will update shortly after the webhook is processed.
        </div>
    @endif

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="glass-panel p-4">
            <h2 class="font-semibold">Details</h2>
            <dl class="mt-3 space-y-2 text-sm">
                <div class="flex justify-between gap-3"><dt>Status</dt><dd class="font-medium">{{ $order->status->value }}</dd></div>
                <div class="flex justify-between gap-3"><dt>Mode</dt><dd class="font-medium">{{ $order->order_mode->value }}</dd></div>
                <div class="flex justify-between gap-3"><dt>Payment</dt><dd class="font-medium">{{ $order->orderPayments->first()?->type?->value ?? '—' }}</dd></div>
                <div class="flex justify-between gap-3"><dt>Total</dt><dd class="font-medium">{{ $restaurant->currency }} {{ number_format((float) $order->grand_total, 2) }}</dd></div>
            </dl>
        </div>

        <div class="glass-panel p-4">
            <h2 class="font-semibold">Customer</h2>
            <dl class="mt-3 space-y-2 text-sm">
                <div><dt class="text-gray-500">Name</dt><dd class="font-medium">{{ $order->customer_name }}</dd></div>
                <div><dt class="text-gray-500">Phone</dt><dd class="font-medium">{{ $order->customer_phone }}</dd></div>
                @if ($order->delivery_address)
                    <div><dt class="text-gray-500">Address</dt><dd class="font-medium whitespace-pre-line">{{ $order->delivery_address }}</dd></div>
                @endif
                @if ($order->table_number)
                    <div><dt class="text-gray-500">Table</dt><dd class="font-medium">{{ $order->table_number }}</dd></div>
                @endif
            </dl>
        </div>
    </div>

    <div class="mt-6 glass-panel p-4">
        <h2 class="font-semibold">Items</h2>
        <ul class="mt-3 divide-y divide-gray-200 dark:divide-gray-800">
            @foreach ($order->orderItems as $line)
                <li class="flex justify-between gap-3 py-2 text-sm">
                    <span>{{ $line->item_name_snapshot }} × {{ $line->qty }}</span>
                    <span>{{ $restaurant->currency }} {{ number_format((float) $line->line_total, 2) }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    <a href="{{ route('public.restaurant.show', $restaurant) }}" class="mt-6 inline-block text-sm text-cyan-300 hover:text-cyan-100 hover:underline">Back to menu</a>
@endsection
