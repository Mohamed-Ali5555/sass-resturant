@extends('layouts.public')

@section('title', $menuItem->name.' · '.$restaurant->name)

@section('content')
    <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500"><a href="{{ route('public.restaurant.show', $restaurant) }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ $restaurant->name }}</a></p>
            <h1 class="text-2xl font-bold">{{ $menuItem->name }}</h1>
            @if ($activeTable)
                <p class="mt-1 text-sm text-amber-800 dark:text-amber-200">{{ __('Table') }}: <strong>{{ $activeTable->label }}</strong>
                    <a href="{{ route('public.restaurant.table.clear', $restaurant) }}" class="ms-2 text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Not my table') }}</a>
                </p>
            @endif
        </div>
        <div class="text-right">
            <div class="text-xl font-semibold">{{ $restaurant->currency }} {{ number_format((float) $menuItem->price, 2) }}</div>
            @if ($restaurant->canAcceptPublicOrders())
                <form method="post" action="{{ route('public.cart.store', $restaurant) }}" class="mt-3">
                    @csrf
                    <input type="hidden" name="menu_item_id" value="{{ $menuItem->id }}">
                    <input type="hidden" name="qty" value="1">
                    <button type="submit" class="btn-neon rounded-xl px-4 py-2 text-sm font-semibold">{{ __('Add to cart') }}</button>
                </form>
            @endif
        </div>
    </div>

    @if ($menuItem->description)
        <p class="mb-6 text-slate-400">{{ $menuItem->description }}</p>
    @endif

    <div class="flex flex-wrap gap-3 text-sm">
        <a href="{{ route('public.restaurant.show', $restaurant) }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Full menu') }}</a>
        <a href="{{ route('public.cart.index', $restaurant) }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Cart') }}</a>
    </div>
@endsection
