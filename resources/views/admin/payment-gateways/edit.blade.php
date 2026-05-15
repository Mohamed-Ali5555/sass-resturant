<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Edit gateway') }} · {{ $config->driver }}</h2>
            <a href="{{ route('admin.payment-gateways.index') }}" class="text-sm text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Back') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="glass-panel p-6">
                <dl class="mb-6 grid gap-2 text-sm text-slate-400">
                    <div><span class="font-medium text-slate-50">{{ __('Owner') }}:</span> {{ $config->owner_scope }} @if ($config->restaurant) / {{ $config->restaurant->name }} @endif</div>
                    <div><span class="font-medium text-slate-50">{{ __('Secret stored') }}:</span> {{ $config->secret_payload ? __('Yes (encrypted)') : __('No') }}</div>
                </dl>

                <form method="post" action="{{ route('admin.payment-gateways.update', $config) }}" class="space-y-4 text-sm">
                    @csrf
                    @method('PUT')
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="enabled" value="0" />
                        <input type="checkbox" id="enabled" name="enabled" value="1" class="rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500 dark:border-cyan-500/40" @checked(old('enabled', $config->enabled)) />
                        <label for="enabled" class="text-slate-300">{{ __('Enabled') }}</label>
                    </div>
                    <div>
                        <x-input-label for="public_key_masked" :value="__('Publishable key (masked display)')" />
                        <x-text-input id="public_key_masked" name="public_key_masked" type="text" class="mt-1 block w-full" :value="old('public_key_masked', $config->public_key_masked)" />
                        <x-input-error :messages="$errors->get('public_key_masked')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="secret_payload" :value="__('New secret / API key (optional)')" />
                        <x-text-input id="secret_payload" name="secret_payload" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                        <p class="mt-1 text-xs text-slate-500">{{ __('Leave blank to keep the existing encrypted value.') }}</p>
                        <x-input-error :messages="$errors->get('secret_payload')" class="mt-2" />
                    </div>
                    <x-primary-button type="submit">{{ __('Save') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>


