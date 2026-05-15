@extends('layouts.public')

@section('title', $restaurant->name.' · '.config('app.name'))

@section('content')
    @if (session('status'))
        <div class="mb-4 rounded-md border border-emerald-400/30 bg-emerald-500/10 px-4 py-3 text-sm text-green-900 border-emerald-400/25 bg-emerald-950/40 text-emerald-100">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold">{{ $restaurant->name }}</h1>
            @if (! empty($activeTable))
                <p class="mt-2 text-sm text-amber-800 dark:text-amber-200">
                    {{ __('Ordering for table') }}: <strong>{{ $activeTable->label }}</strong>
                    <a href="{{ route('public.restaurant.table.clear', $restaurant) }}" class="ms-2 text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Not my table') }}</a>
                </p>
            @endif
        </div>
        <div class="w-full max-w-md">
            <label class="text-xs font-medium uppercase tracking-wide text-gray-500">Public menu URL</label>
            <input readonly class="ui-field mt-1 w-full border px-3 py-2 text-sm" value="{{ $menuUrl }}">
        </div>
    </div>

    <div class="mb-6 flex flex-wrap gap-3">
        <a href="{{ route('public.cart.index', $restaurant) }}" class="btn-neon rounded-xl px-4 py-2 text-sm font-semibold">View cart</a>
        @if ($restaurant->canAcceptPublicOrders())
            <a href="{{ route('public.checkout.show', $restaurant) }}" class="rounded-xl border border-cyan-400/30 bg-cyan-500/10 px-4 py-2 text-sm font-semibold text-cyan-100 transition hover:border-cyan-300/50 hover:bg-cyan-500/20">Checkout</a>
        @else
            <span class="rounded-md border border-amber-400/30 bg-amber-500/10 px-4 py-2 text-sm text-amber-900 border-amber-400/25 bg-amber-950/40 text-amber-100">Online ordering is paused for this restaurant.</span>
        @endif
    </div>

    @foreach ($categories as $category)
        <section class="mb-10">
            <h2 class="mb-3 text-lg font-semibold">{{ $category->name }}</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ($category->menuItems as $item)
                    <div class="glass-panel p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="font-medium">{{ $item->name }}</h3>
                                @if ($item->description)
                                    <p class="mt-1 text-sm text-slate-400">{{ $item->description }}</p>
                                @endif
                                @if ($item->track_inventory)
                                    <p class="mt-2 text-xs text-gray-500">Stock: {{ $item->stock_qty ?? 'n/a' }}</p>
                                @endif
                            </div>
                                <div class="text-right">
                                <div class="font-semibold">{{ $restaurant->currency }} {{ number_format((float) $item->price, 2) }}</div>
                                <a href="{{ route('public.menu.item', ['restaurant' => $restaurant->slug, 'item' => $item->id]) }}" class="mt-1 block text-xs text-gray-500 hover:text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Details') }}</a>
                                @if ($restaurant->canAcceptPublicOrders())
                                    <form method="post" action="{{ route('public.cart.store', $restaurant) }}" class="mt-3">
                                        @csrf
                                        <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="text-sm font-semibold text-cyan-300 hover:text-cyan-100 hover:underline">Add</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
@endsection
