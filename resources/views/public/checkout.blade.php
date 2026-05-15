@extends('layouts.public')

@section('title', 'Checkout · '.$restaurant->name)

@section('content')
    <h1 class="mb-4 text-2xl font-bold">Checkout</h1>

    @if ($errors->any())
        <div class="mb-4 rounded-md border border-rose-400/30 bg-rose-500/10 px-4 py-3 text-sm text-red-800 border-rose-400/25 bg-rose-950/40 text-rose-100">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (count($summary['lines']) === 0)
        <p class="text-slate-400">Your cart is empty.</p>
        <a href="{{ route('public.restaurant.show', $restaurant) }}" class="mt-4 inline-block text-cyan-300 hover:text-cyan-100 hover:underline">Back to menu</a>
    @else
        <form method="post" action="{{ route('public.checkout.store', $restaurant) }}" class="grid gap-6 lg:grid-cols-3">
            @csrf

            <div class="space-y-4 lg:col-span-2">
                <div>
                    <label class="text-sm font-medium">Order mode</label>
                    <select name="order_mode" class="mt-1 w-full ui-field border px-3 py-2 text-sm">
                        <option value="dine_in" @selected(old('order_mode') === 'dine_in')>Dine-in</option>
                        <option value="takeaway" @selected(old('order_mode') === 'takeaway')>Takeaway</option>
                        <option value="delivery" @selected(old('order_mode') === 'delivery')>Delivery</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Your name</label>
                    <input name="customer_name" value="{{ old('customer_name', auth()->user()?->name) }}" class="mt-1 w-full ui-field border px-3 py-2 text-sm" required>
                </div>

                <div>
                    <label class="text-sm font-medium">Phone</label>
                    <input name="customer_phone" value="{{ old('customer_phone') }}" class="mt-1 w-full ui-field border px-3 py-2 text-sm" required>
                </div>

                <div>
                    <label class="text-sm font-medium">{{ __('Table number (dine-in)') }}</label>
                    <input name="table_number" value="{{ old('table_number', $activeTable->label ?? '') }}" class="mt-1 w-full ui-field border px-3 py-2 text-sm">
                    @if ($activeTable ?? null)
                        <p class="mt-1 text-xs text-gray-500">{{ __('Linked from table QR: :label', ['label' => $activeTable->label]) }}</p>
                    @endif
                </div>

                <div>
                    <label class="text-sm font-medium">Delivery address (delivery)</label>
                    <textarea name="delivery_address" rows="3" class="mt-1 w-full ui-field border px-3 py-2 text-sm">{{ old('delivery_address') }}</textarea>
                </div>

                <div>
                    <label class="text-sm font-medium">Notes</label>
                    <textarea name="customer_notes" rows="3" class="mt-1 w-full ui-field border px-3 py-2 text-sm">{{ old('customer_notes') }}</textarea>
                </div>

                <div>
                    <label class="text-sm font-medium">Payment</label>
                    <select name="payment_method" class="mt-1 w-full ui-field border px-3 py-2 text-sm">
                        <option value="cod" @selected(old('payment_method', 'cod') === 'cod')>Cash on delivery / pay at counter</option>
                        <option value="stripe" @selected(old('payment_method') === 'stripe')>Card (Stripe)</option>
                    </select>
                    <p class="mt-2 text-xs text-gray-500">Stripe requires keys in <code class="rounded bg-slate-900/80 px-1 py-0.5 text-[11px] text-cyan-200/90 ring-1 ring-cyan-400/20">.env</code>.</p>
                </div>
            </div>

            <aside class="glass-panel p-4">
                <h2 class="font-semibold">Summary</h2>
                <ul class="mt-3 space-y-2 text-sm">
                    @foreach ($summary['lines'] as $row)
                        <li class="flex justify-between gap-3">
                            <span>{{ $row['item']->name }} × {{ $row['qty'] }}</span>
                            <span>{{ $restaurant->currency }} {{ $row['line_total'] }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4 border-t border-gray-200 pt-3 text-sm dark:border-gray-800">
                    <div class="flex justify-between"><span>Subtotal</span><span>{{ $restaurant->currency }} {{ $summary['subtotal'] }}</span></div>
                    <div class="mt-1 text-xs text-gray-500">Tax & fees are calculated on the server when you place the order.</div>
                </div>
                <button class="mt-4 w-full btn-neon rounded-xl px-4 py-2 text-sm font-semibold">Place order</button>
            </aside>
        </form>
    @endif
@endsection
