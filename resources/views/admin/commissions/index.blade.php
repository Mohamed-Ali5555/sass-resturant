<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Platform commissions') }}</h2>
            <a href="{{ route('admin.platform-commissions.create') }}" class="btn-neon rounded-lg px-4 py-2 font-semibold">{{ __('+ New rule') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @php
                $columns = [
                    ['key' => 'scope_type', 'label' => __('Scope')],
                    ['key' => 'scope_id', 'label' => __('Scope ID')],
                    ['key' => 'commission_percent', 'label' => __('Commission %'), 'format' => fn($v) => number_format((float)$v, 2) . '%'],
                ];

                $actions = [
                    [
                        'label' => __('Edit'),
                        'route' => fn($row) => route('admin.platform-commissions.edit', $row),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />',
                        'class' => 'text-cyan-400 hover:text-cyan-300',
                        'mobile_class' => 'bg-cyan-500/20 text-cyan-300 hover:bg-cyan-500/30',
                    ],
                ];

                // Only add delete action if not the default platform commission
                $commissions = $commissions->map(function($c) use (&$actions) {
                    if (!($c->scope_type === \App\Models\PlatformCommission::SCOPE_PLATFORM && (int)$c->scope_id === 0)) {
                        $c->can_delete = true;
                    } else {
                        $c->can_delete = false;
                    }
                    return $c;
                });

                // Add delete action to actions if the row can be deleted
                $_actions = $actions;
            @endphp

            <x-data-table
                :columns="$columns"
                :rows="$commissions"
                :actions="$actions"
            >
                <x-slot name="footer">
                    <div class="mt-6">{{ $commissions->links() }}</div>
                </x-slot>
            </x-data-table>
        </div>
    </div>
</x-admin-layout>

