<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Users') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="get" class="glass-panel mb-4 flex flex-wrap items-end gap-3 p-4">
                <div>
                    <label for="q" class="block text-xs font-medium text-slate-500">{{ __('Search') }}</label>
                    <input type="search" id="q" name="q" value="{{ $q }}" class="mt-1 block w-64 ui-field text-sm" />
                </div>
                <x-primary-button type="submit" class="h-10">{{ __('Search') }}</x-primary-button>
            </form>

            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500">
                                <th class="py-2 pr-4">{{ __('Name') }}</th>
                                <th class="py-2 pr-4">{{ __('Email') }}</th>
                                <th class="py-2 pr-4">{{ __('Roles') }}</th>
                                <th class="py-2 pr-4">{{ __('Status') }}</th>
                                <th class="py-2 pr-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyan-500/15">
                            @foreach ($users as $u)
                                <tr>
                                    <td class="py-2 pr-4 font-medium">{{ $u->name }}</td>
                                    <td class="py-2 pr-4">{{ $u->email }}</td>
                                    <td class="py-2 pr-4">{{ $u->roles->pluck('name')->join(', ') }}</td>
                                    <td class="py-2 pr-4">{{ $u->is_disabled ? __('Disabled') : __('Active') }}</td>
                                    <td class="py-2 pr-4">
                                        <a href="{{ route('admin.users.show', $u) }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Manage') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $users->links() }}</div>
            </div>
        </div>
    </div>
</x-admin-layout>


