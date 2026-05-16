<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Support tickets') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="get" class="glass-panel mb-6 flex flex-wrap items-end gap-3 rounded-xl p-4">
                <div>
                    <label for="status" class="block text-xs font-medium text-slate-500">{{ __('Status') }}</label>
                    <select id="status" name="status" class="mt-2 rounded-lg border border-cyan-400/20 bg-slate-950/50 px-3 py-2 text-sm text-slate-100 transition focus:border-cyan-400/50 focus:outline-none focus:ring-2 focus:ring-cyan-400/10">
                        <option value="all" @selected($status === 'all')>{{ __('All') }}</option>
                        <option value="open" @selected($status === 'open')>{{ __('Open') }}</option>
                        <option value="pending" @selected($status === 'pending')>{{ __('Pending') }}</option>
                        <option value="resolved" @selected($status === 'resolved')>{{ __('Resolved') }}</option>
                        <option value="closed" @selected($status === 'closed')>{{ __('Closed') }}</option>
                    </select>
                </div>
                <button type="submit" class="btn-neon rounded-lg px-4 py-2 font-semibold">{{ __('Filter') }}</button>
            </form>

            @php
                $statusColors = [
                    'open' => 'bg-red-500/20 text-red-300',
                    'pending' => 'bg-amber-500/20 text-amber-300',
                    'resolved' => 'bg-blue-500/20 text-blue-300',
                    'closed' => 'bg-slate-500/20 text-slate-300',
                ];

                $columns = [
                    ['key' => 'id', 'label' => '#'],
                    ['key' => 'subject', 'label' => __('Subject')],
                    ['key' => 'user.email', 'label' => __('User'), 'format' => fn($v) => $v ?? '—'],
                    ['key' => 'restaurant.name', 'label' => __('Restaurant'), 'format' => fn($v) => $v ?? '—'],
                    ['key' => 'status', 'label' => __('Status'), 'format' => fn($v) => '<span class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-medium ' . ($statusColors[$v] ?? 'bg-slate-500/20 text-slate-300') . '">' . ucfirst($v) . '</span>'],
                ];

                $actions = [
                    [
                        'label' => __('Open'),
                        'route' => fn($row) => route('admin.support-tickets.show', $row),
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />',
                        'class' => 'text-cyan-400 hover:text-cyan-300',
                        'mobile_class' => 'bg-cyan-500/20 text-cyan-300 hover:bg-cyan-500/30',
                    ],
                ];
            @endphp

            <x-data-table
                :columns="$columns"
                :rows="$tickets"
                :actions="$actions"
            >
                <x-slot name="footer">
                    <div class="mt-6">{{ $tickets->links() }}</div>
                </x-slot>
            </x-data-table>
        </div>
    </div>
</x-admin-layout>


