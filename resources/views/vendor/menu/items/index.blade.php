<x-vendor-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">Menu items</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="flex justify-end">
                <a href="{{ route('vendor.menu.items.create') }}" class="btn-neon rounded-xl px-4 py-2 text-sm font-semibold">New item</a>
            </div>

            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <ul class="divide-y divide-cyan-500/15 text-sm">
                    @foreach ($items as $item)
                        <li class="py-3 flex items-start justify-between gap-3">
                            <div>
                                <div class="font-medium">{{ $item->name }}</div>
                                <div class="text-xs text-gray-500">{{ $item->category?->name }} · {{ $item->is_available ? 'available' : 'hidden' }}</div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold">{{ $restaurant->currency }} {{ number_format((float) $item->price, 2) }}</div>
                                <div class="mt-2 flex justify-end gap-3">
                                    <a class="text-cyan-300 hover:text-cyan-100 hover:underline" href="{{ route('vendor.menu.items.qr-print', $item) }}" target="_blank">{{ __('Print QR cards') }}</a>
                                    <a class="text-cyan-300 hover:text-cyan-100 hover:underline" href="{{ route('vendor.menu.items.edit', $item) }}">Edit</a>
                                    <form method="post" action="{{ route('vendor.menu.items.destroy', $item) }}" onsubmit="return confirm('Delete item?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4">{{ $items->links() }}</div>
            </div>
        </div>
    </div>
</x-vendor-layout>

