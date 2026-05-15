<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Payment gateways') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="text-left text-slate-500">
                                <th class="py-2 pr-4">{{ __('Scope') }}</th>
                                <th class="py-2 pr-4">{{ __('Restaurant') }}</th>
                                <th class="py-2 pr-4">{{ __('Driver') }}</th>
                                <th class="py-2 pr-4">{{ __('Enabled') }}</th>
                                <th class="py-2 pr-4">{{ __('Public key (masked)') }}</th>
                                <th class="py-2 pr-4"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-cyan-500/15">
                            @foreach ($configs as $cfg)
                                <tr>
                                    <td class="py-2 pr-4">{{ $cfg->owner_scope }}</td>
                                    <td class="py-2 pr-4">{{ $cfg->restaurant?->name ?? '—' }}</td>
                                    <td class="py-2 pr-4">{{ $cfg->driver }}</td>
                                    <td class="py-2 pr-4">{{ $cfg->enabled ? __('Yes') : __('No') }}</td>
                                    <td class="py-2 pr-4 font-mono text-xs">{{ $cfg->public_key_masked ?? '—' }}</td>
                                    <td class="py-2 pr-4">
                                        <a href="{{ route('admin.payment-gateways.edit', $cfg) }}" class="text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Edit') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">{{ $configs->links() }}</div>
            </div>
        </div>
    </div>
</x-admin-layout>


