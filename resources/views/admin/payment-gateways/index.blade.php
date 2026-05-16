<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Payment gateways') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @php
                $columns = [
                    ['key' => 'owner_scope', 'label' => __('Scope')],
                    ['key' => 'restaurant.name', 'label' => __('Restaurant'), 'format' => fn($v) => $v ?? '—'],
                    ['key' => 'driver', 'label' => __('Driver')],
                    ['key' => 'enabled', 'label' => __('Status'), 'format' => fn($v) => $v ? '<span class="inline-flex items-center gap-1 rounded-full bg-emerald-500/20 px-2 py-1 text-xs font-medium text-emerald-300">✓</span>' : '<span class="inline-flex items-center gap-1 rounded-full bg-slate-500/20 px-2 py-1 text-xs font-medium text-slate-300">✗</span>'],
                    ['key' => 'public_key_masked', 'label' => __('Public Key'), 'format' => fn($v) => Str::limit($v ?? '—', 24)],
                ];

                $actions = [
                    [
                        'label' => __('Edit'),
                        'route' => fn($row) => route('admin.payment-gateways.edit', $row),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />',
                        'class' => 'text-cyan-400 hover:text-cyan-300',
                        'mobile_class' => 'bg-cyan-500/20 text-cyan-300 hover:bg-cyan-500/30',
                    ],
                ];
            @endphp

            <x-data-table
                :columns="$columns"
                :rows="$configs"
                :actions="$actions"
            >
                <x-slot name="footer">
                    <div class="mt-6">{{ $configs->links() }}</div>
                </x-slot>
            </x-data-table>
        </div>
    </div>
</x-admin-layout>


