<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Users') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="get" class="glass-panel mb-6 flex flex-wrap items-end gap-3 rounded-xl p-4">
                <div>
                    <label for="q" class="block text-xs font-medium text-slate-500">{{ __('Search') }}</label>
                    <input type="search" id="q" name="q" value="{{ $q }}" placeholder="{{ __('Name or email...') }}" class="mt-2 block w-64 rounded-lg border border-cyan-400/20 bg-slate-950/50 px-3 py-2 text-sm text-slate-100 transition focus:border-cyan-400/50 focus:outline-none focus:ring-2 focus:ring-cyan-400/10" />
                </div>
                <button type="submit" class="btn-neon rounded-lg px-4 py-2 font-semibold">{{ __('Search') }}</button>
            </form>

            @php
                $columns = [
                    ['key' => 'name', 'label' => __('Name')],
                    ['key' => 'email', 'label' => __('Email')],
                    ['key' => 'roles', 'label' => __('Roles'), 'format' => fn($v, $row) => $row->roles->pluck('name')->join(', ') ?: '—'],
                    ['key' => 'is_disabled', 'label' => __('Status'), 'format' => fn($v) => $v ? '<span class="inline-flex items-center gap-1 rounded-full bg-red-500/20 px-2 py-1 text-xs font-medium text-red-300">🔴 ' . __('Disabled') . '</span>' : '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-500/20 px-2 py-1 text-xs font-medium text-emerald-300">🟢 ' . __('Active') . '</span>'],
                ];

                $actions = [
                    [
                        'label' => __('Manage'),
                        'route' => fn($row) => route('admin.users.show', $row),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 1 0 15 0 7.5 7.5 0 0 0-15 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M21.08 8.29l-.98 9.02c-.119 1.12-1.022 1.85-2.146 1.85H7.04c-1.123 0-2.027-.73-2.146-1.85l-.98-9.02m16.24-1.46h.008v.008h-.008v-.008zm1.00-6.045a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z" />',
                        'class' => 'text-cyan-400 hover:text-cyan-300',
                        'mobile_class' => 'bg-cyan-500/20 text-cyan-300 hover:bg-cyan-500/30',
                    ],
                ];
            @endphp

            <x-data-table
                :columns="$columns"
                :rows="$users"
                :actions="$actions"
            >
                <x-slot name="footer">
                    <div class="mt-6">{{ $users->links() }}</div>
                </x-slot>
            </x-data-table>
        </div>
    </div>
</x-admin-layout>

