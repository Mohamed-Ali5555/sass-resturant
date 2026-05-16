<x-vendor-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Tables') }}</h2>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('vendor.tables.create') }}" class="btn-neon rounded-lg px-4 py-2 font-semibold">{{ __('+ New table') }}</a>
                <a href="{{ route('vendor.dashboard') }}" class="rounded-lg border border-white/10 px-4 py-2 text-slate-400 transition hover:border-cyan-400/30 hover:text-cyan-300">{{ __('Home') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $columns = [
                    ['key' => 'label', 'label' => __('Label')],
                    ['key' => 'table_code', 'label' => __('Code')],
                    ['key' => 'branch.name', 'label' => __('Branch'), 'format' => fn($v) => $v ?? '—'],
                    ['key' => 'qr_token', 'label' => __('QR Token'), 'format' => fn($v) => Str::limit($v, 20)],
                ];

                $actions = [
                    [
                        'label' => __('QR'),
                        'route' => fn($row) => route('vendor.tables.qr-print', $row),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 002 2 2 2 0 012 2v2.094m0 0a2 2 0 01-1 1.732m0 0a2 2 0 01-2 0m0 0a2 2 0 01-1-1.732m0 0a2 2 0 011-1.732" />',
                        'mobile_class' => 'bg-blue-500/20 text-blue-300 hover:bg-blue-500/30',
                    ],
                    [
                        'label' => __('Edit'),
                        'route' => fn($row) => route('vendor.tables.edit', $row),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />',
                        'class' => 'text-cyan-400 hover:text-cyan-300',
                        'mobile_class' => 'bg-cyan-500/20 text-cyan-300 hover:bg-cyan-500/30',
                    ],
                    [
                        'label' => __('Delete'),
                        'route' => fn($row) => route('vendor.tables.destroy', $row),
                        'method' => 'POST',
                        'confirm' => __('Delete this table? This action cannot be undone.'),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />',
                        'class' => 'text-red-400 hover:text-red-300',
                        'mobile_class' => 'bg-red-500/20 text-red-300 hover:bg-red-500/30',
                    ],
                ];
            @endphp

            <x-data-table
                :columns="$columns"
                :rows="$tables"
                :actions="$actions"
            >
                <x-slot name="footer">
                    <div class="mt-6">{{ $tables->links() }}</div>
                </x-slot>
            </x-data-table>
                <div class="mt-4">{{ $tables->links() }}</div>
            </div>
        </div>
    </div>
</x-vendor-layout>


