<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Restaurants') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form method="get" action="{{ route('admin.restaurants.index') }}" class="glass-panel mb-4 flex flex-wrap items-end gap-3 p-4">
                <div>
                    <label for="q" class="block text-xs font-medium text-slate-500">{{ __('Search') }}</label>
                    <input type="search" id="q" name="q" value="{{ $q }}" placeholder="{{ __('Name, slug, owner…') }}" class="mt-1 block w-64 ui-field text-sm" />
                </div>
                <div>
                    <label for="status" class="block text-xs font-medium text-slate-500">{{ __('Status') }}</label>
                    <select id="status" name="status" class="mt-1 block ui-field text-sm">
                        <option value="all" @selected($status === 'all')>{{ __('All') }}</option>
                        <option value="active" @selected($status === 'active')>{{ __('Active') }}</option>
                        <option value="suspended" @selected($status === 'suspended')>{{ __('Suspended') }}</option>
                    </select>
                </div>
                <x-primary-button type="submit" class="h-10">{{ __('Apply') }}</x-primary-button>
                <a href="{{ route('admin.restaurants.index') }}" class="inline-flex h-10 items-center text-sm text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Reset') }}</a>
            </form>

            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500">
                                <th class="py-2 pr-4">{{ __('Name') }}</th>
                                <th class="py-2 pr-4">{{ __('Slug') }}</th>
                                <th class="py-2 pr-4">{{ __('Owner') }}</th>
                                <th class="py-2 pr-4">{{ __('Orders') }}</th>
                                <th class="py-2 pr-4">{{ __('Status') }}</th>
                                <th class="py-2 pr-4">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyan-500/15">
                            @foreach ($restaurants as $r)
                                <tr>
                                    <td class="py-2 pr-4 font-medium">
                                        <a href="{{ route('admin.restaurants.show', $r) }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ $r->name }}</a>
                                    </td>
                                    <td class="py-2 pr-4">{{ $r->slug }}</td>
                                    <td class="py-2 pr-4">{{ $r->vendorOwner?->email }}</td>
                                    <td class="py-2 pr-4">{{ $r->orders_count }}</td>
                                    <td class="py-2 pr-4">{{ $r->status }}</td>
                                    <td class="py-2 pr-4 align-top">
                                        <div class="flex max-w-xs flex-col gap-2">
                                            @if ($r->status !== 'active')
                                                <form method="post" action="{{ route('admin.restaurants.approve', $r) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="text-left text-green-700 hover:underline dark:text-green-400">{{ __('Approve') }}</button>
                                                </form>
                                            @endif
                                            @if ($r->status !== 'suspended')
                                                <form method="post" action="{{ route('admin.restaurants.suspend', $r) }}" class="space-y-1">
                                                    @csrf
                                                    @method('PATCH')
                                                    <label class="block text-xs text-slate-500">{{ __('Suspension reason (optional)') }}</label>
                                                    <textarea name="suspension_reason" rows="2" class="w-full ui-field text-xs"></textarea>
                                                    <button type="submit" class="text-amber-700 hover:underline dark:text-amber-400">{{ __('Suspend') }}</button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $restaurants->links() }}</div>
            </div>
        </div>
    </div>
</x-admin-layout>


