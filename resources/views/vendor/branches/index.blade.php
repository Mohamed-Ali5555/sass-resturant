<x-vendor-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Branches') }}</h2>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('vendor.branches.create') }}" class="btn-neon rounded-lg px-4 py-2 font-semibold">{{ __('+ New branch') }}</a>
                <a href="{{ route('vendor.dashboard') }}" class="rounded-lg border border-white/10 px-4 py-2 text-slate-400 transition hover:border-cyan-400/30 hover:text-cyan-300">{{ __('Home') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $statusColors = [
                    'active' => 'bg-emerald-500/20 text-emerald-300',
                    'inactive' => 'bg-slate-500/20 text-slate-300',
                    'draft' => 'bg-amber-500/20 text-amber-300',
                ];

                $columns = [
                    ['key' => 'name', 'label' => __('Name')],
                    ['key' => 'slug', 'label' => __('Slug')],
                    ['key' => 'status', 'label' => __('Status'), 'format' => fn($v) => '<span class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-medium ' . ($statusColors[$v] ?? 'bg-slate-500/20 text-slate-300') . '">' . ucfirst($v) . '</span>'],
                ];

                $actions = [
                    [
                        'label' => __('Edit'),
                        'route' => fn($row) => route('vendor.branches.edit', $row),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />',
                        'class' => 'text-cyan-400 hover:text-cyan-300',
                        'mobile_class' => 'bg-cyan-500/20 text-cyan-300 hover:bg-cyan-500/30',
                    ],
                    [
                        'label' => __('Delete'),
                        'route' => fn($row) => route('vendor.branches.destroy', $row),
                        'method' => 'POST',
                        'confirm' => __('Delete this branch? This action cannot be undone.'),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />',
                        'class' => 'text-red-400 hover:text-red-300',
                        'mobile_class' => 'bg-red-500/20 text-red-300 hover:bg-red-500/30',
                    ],
                ];
            @endphp

            <x-data-table
                :columns="$columns"
                :rows="$branches"
                :actions="$actions"
            >
                <x-slot name="footer">
                    <div class="mt-6">{{ $branches->links() }}</div>
                </x-slot>
            </x-data-table>
        </div>
    </div>
</x-vendor-layout>


