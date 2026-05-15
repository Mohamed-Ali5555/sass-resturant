<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Platform commissions') }}</h2>
            <a href="{{ route('admin.platform-commissions.create') }}" class="btn-neon rounded-xl px-4 py-2 text-sm font-semibold">{{ __('New rule') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500">
                                <th class="py-2 pr-4">{{ __('Scope') }}</th>
                                <th class="py-2 pr-4">{{ __('Scope id') }}</th>
                                <th class="py-2 pr-4">{{ __('%') }}</th>
                                <th class="py-2 pr-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyan-500/15">
                            @foreach ($commissions as $row)
                                <tr>
                                    <td class="py-2 pr-4 font-medium">{{ $row->scope_type }}</td>
                                    <td class="py-2 pr-4">{{ $row->scope_id }}</td>
                                    <td class="py-2 pr-4">{{ number_format((float) $row->commission_percent, 2) }}</td>
                                    <td class="py-2 pr-4 whitespace-nowrap">
                                        <a href="{{ route('admin.platform-commissions.edit', $row) }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Edit') }}</a>
                                        @if (! ($row->scope_type === \App\Models\PlatformCommission::SCOPE_PLATFORM && (int) $row->scope_id === 0))
                                            <form method="post" action="{{ route('admin.platform-commissions.destroy', $row) }}" class="ms-3 inline" onsubmit="return confirm('{{ __('Delete this rule?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline">{{ __('Delete') }}</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $commissions->links() }}</div>
            </div>
        </div>
    </div>
</x-admin-layout>


