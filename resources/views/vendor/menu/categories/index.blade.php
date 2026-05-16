<x-vendor-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Menu categories') }}</h2>
            <a href="{{ route('vendor.menu.categories.create') }}" class="btn-neon rounded-lg px-4 py-2 font-semibold">{{ __('+ New category') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Desktop Grid View --}}
            <div class="hidden gap-6 sm:grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @forelse ($categories as $c)
                    <div class="group animate-slide-in-up rounded-xl border border-white/10 bg-gradient-to-br from-white/5 to-white/[0.02] p-5 shadow-lg transition-all duration-300 hover:border-cyan-400/30 hover:shadow-cyan-500/10">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex-1">
                                <h3 class="font-semibold text-slate-100 line-clamp-2">{{ $c->name }}</h3>
                                <p class="text-xs text-slate-500 mt-1">{{ __('Sort order:') }} {{ $c->sort_order ?? '0' }}</p>
                            </div>
                            <div class="inline-flex items-center justify-center h-10 w-10 rounded-lg bg-cyan-500/20 text-lg">
                                📁
                            </div>
                        </div>
                        <div class="mt-4 flex gap-2 border-t border-white/10 pt-3">
                            <a href="{{ route('vendor.menu.categories.edit', $c) }}" class="flex-1 rounded-lg bg-cyan-500/20 px-3 py-2 text-center text-xs font-medium text-cyan-300 transition hover:bg-cyan-500/30 flex items-center justify-center gap-1">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit
                            </a>
                            <form method="post" action="{{ route('vendor.menu.categories.destroy', $c) }}" class="flex-1" onsubmit="return confirm('{{ __('Delete this category?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded-lg bg-red-500/20 px-3 py-2 text-xs font-medium text-red-300 transition hover:bg-red-500/30 flex items-center justify-center gap-1">
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
                        <p class="text-slate-600">{{ __('No categories yet') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Mobile List View --}}
            <div class="space-y-3 sm:hidden">
                @forelse ($categories as $c)
                    <div class="group animate-slide-in-up rounded-xl border border-white/10 bg-gradient-to-br from-white/5 to-white/[0.02] p-4 shadow-lg">
                        <div class="mb-3 flex items-center justify-between gap-2">
                            <div>
                                <h3 class="font-semibold text-slate-100">{{ $c->name }}</h3>
                                <p class="text-xs text-slate-500 mt-1">{{ __('Sort:') }} {{ $c->sort_order ?? '0' }}</p>
                            </div>
                            <div class="text-2xl">📁</div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('vendor.menu.categories.edit', $c) }}" class="flex-1 rounded-lg bg-cyan-500/20 px-3 py-2 text-center text-xs font-medium text-cyan-300 transition hover:bg-cyan-500/30">
                                Edit
                            </a>
                            <form method="post" action="{{ route('vendor.menu.categories.destroy', $c) }}" class="flex-1" onsubmit="return confirm('{{ __('Delete this category?') }}');">
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
                        <p class="text-slate-600">{{ __('No categories yet') }}</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">{{ $categories->links() }}</div>
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

