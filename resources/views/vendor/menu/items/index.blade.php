<x-vendor-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Menu items') }}</h2>
            <a href="{{ route('vendor.menu.items.create') }}" class="btn-neon rounded-lg px-4 py-2 font-semibold">{{ __('+ New item') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Desktop Grid View --}}
            <div class="hidden gap-6 sm:grid sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($items as $item)
                    <div class="group animate-slide-in-up rounded-xl border border-white/10 bg-gradient-to-br from-white/5 to-white/[0.02] p-5 shadow-lg transition-all duration-300 hover:border-cyan-400/30 hover:shadow-cyan-500/10">
                        @if ($item->image)
                            <div class="relative mb-4 overflow-hidden rounded-xl">
                                <img src="{{ $item->image }}" alt="{{ $item->name }}" class="h-40 w-full object-cover">
                                <div class="absolute inset-0 rounded-xl bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                <div class="absolute left-3 bottom-3">
                                    <span class="inline-flex items-center rounded-full bg-black/60 px-3 py-1 text-sm font-bold text-white">{{ $restaurant->currency }} {{ number_format((float)$item->price,2) }}</span>
                                </div>
                            </div>
                        @endif
                        <div class="space-y-3">
                            <div>
                                <h3 class="font-semibold text-slate-100 line-clamp-2">{{ $item->name }}</h3>
                                <div class="mt-1 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center rounded-full bg-cyan-500/20 px-2 py-1 text-xs font-medium text-cyan-300">
                                        {{ $item->category?->name ?? __('No category') }}
                                    </span>
                                    @if ($item->is_available)
                                        <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-2 py-1 text-xs font-medium text-emerald-300">✓ Available</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-slate-500/20 px-2 py-1 text-xs font-medium text-slate-400">Hidden</span>
                                    @endif
                                </div>
                            </div>
                            <div class="border-t border-white/10 pt-3">
                                <p class="text-sm text-slate-400 line-clamp-2">{{ $item->description }}</p>
                                @if (! $item->image)
                                    <p class="mt-2 text-lg font-bold text-white tabular-nums">{{ $restaurant->currency }} {{ number_format((float) $item->price, 2) }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4 flex flex-wrap gap-2 border-t border-white/10 pt-3">
                            <a href="{{ route('vendor.menu.items.qr-print', $item) }}" target="_blank" class="flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-blue-500/20 px-3 py-2 text-xs font-medium text-blue-300 transition hover:bg-blue-500/30">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 012 2v2.094m0 0a2 2 0 01-1 1.732m0 0a2 2 0 01-2 0m0 0a2 2 0 01-1-1.732m0 0a2 2 0 011-1.732" />
                                </svg>
                                QR
                            </a>
                            <a href="{{ route('vendor.menu.items.edit', $item) }}" class="flex flex-1 items-center justify-center gap-1.5 rounded-lg bg-cyan-500/20 px-3 py-2 text-xs font-medium text-cyan-300 transition hover:bg-cyan-500/30">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                            <form method="post" action="{{ route('vendor.menu.items.destroy', $item) }}" class="flex flex-1" onsubmit="return confirm('{{ __('Delete this item?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded-lg bg-red-500/20 px-3 py-2 text-xs font-medium text-red-300 transition hover:bg-red-500/30 flex items-center justify-center gap-1.5">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full rounded-xl border border-white/10 bg-white/5 py-12 text-center">
                        <p class="text-slate-600">{{ __('No items yet') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Mobile List View --}}
            <div class="space-y-3 sm:hidden">
                @forelse ($items as $item)
                    <div class="group animate-slide-in-up rounded-xl border border-white/10 bg-gradient-to-br from-white/5 to-white/[0.02] p-4 shadow-lg">
                        <div class="mb-3 flex items-start justify-between gap-2">
                            <div class="flex items-center gap-3">
                                @if ($item->image)
                                    <img src="{{ $item->image }}" alt="{{ $item->name }}" class="h-14 w-14 rounded-lg object-cover">
                                @else
                                    <div class="h-14 w-14 rounded-lg bg-white/5 flex items-center justify-center text-slate-500">No</div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-semibold text-slate-100 line-clamp-2">{{ $item->name }}</h3>
                                    <span class="text-sm font-bold text-white tabular-nums">{{ $restaurant->currency }} {{ number_format((float) $item->price, 2) }}</span>
                                </div>
                            </div>
                            @if ($item->is_available)
                                <span class="inline-flex items-center rounded-full bg-emerald-500/20 px-2 py-1 text-[10px] font-bold text-emerald-300">✓</span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-slate-500/20 px-2 py-1 text-[10px] font-bold text-slate-400">○</span>
                            @endif
                        </div>
                        @if ($item->description)
                            <p class="mb-3 text-xs text-slate-400 line-clamp-2">{{ $item->description }}</p>
                        @endif
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('vendor.menu.items.qr-print', $item) }}" target="_blank" class="flex-1 rounded-lg bg-blue-500/20 px-3 py-2 text-center text-xs font-medium text-blue-300 transition hover:bg-blue-500/30">
                                QR
                            </a>
                            <a href="{{ route('vendor.menu.items.edit', $item) }}" class="flex-1 rounded-lg bg-cyan-500/20 px-3 py-2 text-center text-xs font-medium text-cyan-300 transition hover:bg-cyan-500/30">
                                Edit
                            </a>
                            <form method="post" action="{{ route('vendor.menu.items.destroy', $item) }}" class="flex-1" onsubmit="return confirm('{{ __('Delete this item?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded-lg bg-red-500/20 px-3 py-2 text-xs font-medium text-red-300 transition hover:bg-red-500/30">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-white/10 bg-white/5 py-12 text-center">
                        <p class="text-slate-600">{{ __('No items yet') }}</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">{{ $items->links() }}</div>
        </div>
    </div>

    <style>
        @keyframes slide-in-up {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-in-up {
            animation: slide-in-up 0.3s ease-out;
        }
    </style>
</x-vendor-layout>

