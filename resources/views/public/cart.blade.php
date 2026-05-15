@extends('layouts.public')

@section('title', 'Cart · '.$restaurant->name)

@section('content')
    <h1 class="mb-4 text-2xl font-bold">Cart · {{ $restaurant->name }}</h1>

    @if (count($summary['lines']) === 0)
        <p class="text-slate-400">Your cart is empty.</p>
        <a href="{{ route('public.restaurant.show', $restaurant) }}" class="mt-4 inline-block text-cyan-300 hover:text-cyan-100 hover:underline">Back to menu</a>
    @else
        <div class="space-y-4">
            @foreach ($summary['lines'] as $row)
                @php($item = $row['item'])
                <div class="flex items-center justify-between glass-panel p-4">
                    <div>
                        <div class="font-medium">{{ $item->name }}</div>
                        <div class="text-sm text-slate-400">{{ $restaurant->currency }} {{ number_format((float) $item->price, 2) }} each</div>
                    </div>
                    <div class="flex items-center gap-3">
                        <form method="post" action="{{ route('public.cart.update', $restaurant) }}" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                            <input type="number" name="qty" value="{{ $row['qty'] }}" min="0" class="ui-field w-20 border px-2 py-1 text-sm">
                            <button class="rounded-lg bg-gradient-to-r from-cyan-600 to-teal-600 px-3 py-1 text-xs font-semibold text-white shadow-glow-sm hover:from-cyan-500 hover:to-teal-500">Update</button>
                        </form>
                        <form method="post" action="{{ route('public.cart.destroy', [$restaurant, $item->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-xs font-semibold text-red-600 hover:underline">Remove</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex items-center justify-between border-t border-gray-200 pt-4 dark:border-gray-800">
            <div class="text-lg font-semibold">Subtotal</div>
            <div class="text-lg font-semibold">{{ $restaurant->currency }} {{ $summary['subtotal'] }}</div>
        </div>

        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('public.restaurant.show', $restaurant) }}" class="text-sm text-cyan-300 hover:text-cyan-100 hover:underline">Continue shopping</a>
            @if ($restaurant->canAcceptPublicOrders())
                <a href="{{ route('public.checkout.show', $restaurant) }}" class="btn-neon rounded-xl px-4 py-2 text-sm font-semibold">Proceed to checkout</a>
            @endif
        </div>
    @endif
@endsection
