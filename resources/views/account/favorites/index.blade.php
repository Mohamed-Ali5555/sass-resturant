<x-hub-layout :title="__('Account · Saved items')" :mobile-title="__('Saved')">
    <x-slot name="header">
        <h1>{{ __('Saved items') }}</h1>
        <p>{{ __('Dishes you saved for quick access. Availability follows each restaurant.') }}</p>
    </x-slot>

    @if ($favorites->isEmpty())
        <div class="glass-panel p-12 text-center shadow-glow">
            <p class="text-slate-400">{{ __('Nothing saved yet. Open a menu and tap the heart on items you love.') }}</p>
            <a href="{{ url('/') }}" class="btn-neon mt-6 inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold">{{ __('Discover') }}</a>
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($favorites as $fav)
                @php $item = $fav->product; $restaurant = $item->restaurant; @endphp
                <article class="glass-panel flex flex-col overflow-hidden shadow-glow">
                    <div class="border-b border-white/10 px-5 py-4">
                        <h2 class="font-semibold text-slate-100">{{ $item->name }}</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ $restaurant->name }}</p>
                    </div>
                    <div class="flex flex-1 flex-col justify-end gap-3 px-5 py-4">
                        <div class="text-lg font-bold text-white">${{ number_format((float) $item->price, 2) }}</div>
                        <a href="{{ route('public.menu.item', ['restaurant' => $restaurant, 'item' => $item->getKey()]) }}" class="btn-neon inline-flex items-center justify-center rounded-xl px-4 py-2 text-center text-sm font-semibold">
                            {{ __('View on menu') }}
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-8">{{ $favorites->links() }}</div>
    @endif
</x-hub-layout>
