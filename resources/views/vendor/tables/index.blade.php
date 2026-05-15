<x-vendor-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Tables') }}</h2>
            <div class="flex gap-3 text-sm">
                <a href="{{ route('vendor.tables.create') }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('New table') }}</a>
                <a href="{{ route('vendor.dashboard') }}" class="text-gray-600 hover:underline dark:text-gray-300">{{ __('Home') }}</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-panel overflow-hidden p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500">
                                <th class="py-2 pr-4">{{ __('Label') }}</th>
                                <th class="py-2 pr-4">{{ __('Code') }}</th>
                                <th class="py-2 pr-4">{{ __('Branch') }}</th>
                                <th class="py-2 pr-4">{{ __('QR token') }}</th>
                                <th class="py-2 pr-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyan-500/15">
                            @foreach ($tables as $t)
                                <tr>
                                    <td class="py-2 pr-4 font-medium">{{ $t->label }}</td>
                                    <td class="py-2 pr-4">{{ $t->table_code ?? '—' }}</td>
                                    <td class="py-2 pr-4">{{ $t->branch?->name ?? '—' }}</td>
                                    <td class="py-2 pr-4 font-mono text-xs break-all">{{ Str::limit($t->qr_token, 24) }}</td>
                                    <td class="py-2 pr-4 whitespace-nowrap">
                                        <a href="{{ route('vendor.tables.qr-print', $t) }}" target="_blank" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Print QR') }}</a>
                                        <a href="{{ route('vendor.tables.edit', $t) }}" class="ms-2 text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Edit') }}</a>
                                        <form method="post" action="{{ route('vendor.tables.regenerate-qr', $t) }}" class="ms-2 inline" onsubmit="return confirm('{{ __('Regenerate the table QR token? Old printed codes will stop working.') }}');">
                                            @csrf
                                            <button type="submit" class="text-amber-700 hover:underline dark:text-amber-300">{{ __('New token') }}</button>
                                        </form>
                                        <form method="post" action="{{ route('vendor.tables.destroy', $t) }}" class="ms-2 inline" onsubmit="return confirm('{{ __('Delete table?') }}');">
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
                <div class="mt-4">{{ $tables->links() }}</div>
            </div>
        </div>
    </div>
</x-vendor-layout>


