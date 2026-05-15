@php
    use App\Models\PlatformCommission;
@endphp
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Edit commission rule') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="glass-panel p-6">
                <form method="post" action="{{ route('admin.platform-commissions.update', $commission) }}" class="space-y-4 text-sm">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="scope_type" :value="__('Scope type')" />
                        <select id="scope_type" name="scope_type" class="mt-1 block w-full ui-field" required>
                            <option value="{{ PlatformCommission::SCOPE_PLATFORM }}" @selected(old('scope_type', $commission->scope_type) === PlatformCommission::SCOPE_PLATFORM)>platform</option>
                            <option value="{{ PlatformCommission::SCOPE_PLAN }}" @selected(old('scope_type', $commission->scope_type) === PlatformCommission::SCOPE_PLAN)>plan</option>
                            <option value="{{ PlatformCommission::SCOPE_RESTAURANT }}" @selected(old('scope_type', $commission->scope_type) === PlatformCommission::SCOPE_RESTAURANT)>restaurant</option>
                        </select>
                        <x-input-error :messages="$errors->get('scope_type')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="scope_id" :value="__('Scope id')" />
                        <x-text-input id="scope_id" name="scope_id" type="number" min="0" class="mt-1 block w-full" :value="old('scope_id', $commission->scope_id)" required />
                        <x-input-error :messages="$errors->get('scope_id')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="commission_percent" :value="__('Commission %')" />
                        <x-text-input id="commission_percent" name="commission_percent" type="text" class="mt-1 block w-full" :value="old('commission_percent', $commission->commission_percent)" required />
                        <x-input-error :messages="$errors->get('commission_percent')" class="mt-2" />
                    </div>
                    <div class="flex gap-3">
                        <x-primary-button type="submit">{{ __('Save') }}</x-primary-button>
                        <a href="{{ route('admin.platform-commissions.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:underline dark:text-gray-300">{{ __('Cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>


