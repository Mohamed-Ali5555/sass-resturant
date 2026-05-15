<x-vendor-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Branches') }}</h2>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('vendor.branches.create') }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('New branch') }}</a>
                <a href="{{ route('vendor.dashboard') }}" class="text-gray-600 hover:underline dark:text-gray-300">{{ __('Home') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-panel overflow-hidden p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500">
                                <th class="py-2 pr-4">{{ __('Name') }}</th>
                                <th class="py-2 pr-4">{{ __('Slug') }}</th>
                                <th class="py-2 pr-4">{{ __('Status') }}</th>
                                <th class="py-2 pr-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyan-500/15">
                            @foreach ($branches as $b)
                                <tr>
                                    <td class="py-2 pr-4 font-medium">{{ $b->name }}</td>
                                    <td class="py-2 pr-4">{{ $b->slug }}</td>
                                    <td class="py-2 pr-4">{{ $b->status }}</td>
                                    <td class="py-2 pr-4 whitespace-nowrap">
                                        <a href="{{ route('vendor.branches.edit', $b) }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Edit') }}</a>
                                        <form method="post" action="{{ route('vendor.branches.destroy', $b) }}" class="ms-3 inline" onsubmit="return confirm('{{ __('Delete this branch?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">{{ __('Delete') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $branches->links() }}</div>
            </div>
        </div>
    </div>
</x-vendor-layout>


