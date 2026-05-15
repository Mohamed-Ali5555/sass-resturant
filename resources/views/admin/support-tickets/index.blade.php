<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Support tickets') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="get" class="glass-panel mb-4 flex flex-wrap items-end gap-3 p-4">
                <div>
                    <label for="status" class="block text-xs font-medium text-slate-500">{{ __('Status') }}</label>
                    <select id="status" name="status" class="mt-1 ui-field text-sm">
                        <option value="all" @selected($status === 'all')>{{ __('All') }}</option>
                        <option value="open" @selected($status === 'open')>open</option>
                        <option value="pending" @selected($status === 'pending')>pending</option>
                        <option value="resolved" @selected($status === 'resolved')>resolved</option>
                        <option value="closed" @selected($status === 'closed')>closed</option>
                    </select>
                </div>
                <x-primary-button type="submit" class="h-10">{{ __('Filter') }}</x-primary-button>
            </form>

            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500">
                                <th class="py-2 pr-4">#</th>
                                <th class="py-2 pr-4">{{ __('Subject') }}</th>
                                <th class="py-2 pr-4">{{ __('User') }}</th>
                                <th class="py-2 pr-4">{{ __('Restaurant') }}</th>
                                <th class="py-2 pr-4">{{ __('Status') }}</th>
                                <th class="py-2 pr-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyan-500/15">
                            @foreach ($tickets as $t)
                                <tr>
                                    <td class="py-2 pr-4">{{ $t->id }}</td>
                                    <td class="py-2 pr-4 font-medium">{{ $t->subject }}</td>
                                    <td class="py-2 pr-4">{{ $t->user?->email }}</td>
                                    <td class="py-2 pr-4">{{ $t->restaurant?->name ?? '—' }}</td>
                                    <td class="py-2 pr-4">{{ $t->status }}</td>
                                    <td class="py-2 pr-4">
                                        <a href="{{ route('admin.support-tickets.show', $t) }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Open') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $tickets->links() }}</div>
            </div>
        </div>
    </div>
</x-admin-layout>


