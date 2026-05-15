<x-vendor-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Delivery settings') }}</h2>
            <a href="{{ route('vendor.dashboard') }}" class="text-sm text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Home') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <section class="glass-panel p-6">
                <h3 class="font-semibold text-slate-50">{{ __('Delivery zones') }}</h3>
                <form method="post" action="{{ route('vendor.delivery.zones.store') }}" class="mt-4 flex flex-wrap items-end gap-3">
                    @csrf
                    <div>
                        <x-input-label for="z_name" :value="__('Name')" />
                        <x-text-input id="z_name" name="name" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="z_fee" :value="__('Fee')" />
                        <x-text-input id="z_fee" name="fee_amount" type="number" step="0.01" min="0" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="z_min" :value="__('Min order')" />
                        <x-text-input id="z_min" name="minimum_order_amount" type="number" step="0.01" min="0" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="z_sort" :value="__('Sort')" />
                        <x-text-input id="z_sort" name="sort_order" type="number" class="mt-1 block w-full" value="0" />
                    </div>
                    <div class="flex items-center gap-2 pb-1 text-sm">
                        <input type="hidden" name="is_active" value="0" />
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500 dark:border-cyan-500/40" />
                        {{ __('Active') }}
                    </div>
                    <x-primary-button type="submit">{{ __('Add zone') }}</x-primary-button>
                </form>

                <ul class="mt-6 space-y-4">
                    @foreach ($zones as $zone)
                        <li class="rounded-xl border border-cyan-500/10 bg-slate-950/30 p-4 backdrop-blur-sm">
                            <form method="post" action="{{ route('vendor.delivery.zones.update', $zone) }}" class="flex flex-wrap items-end gap-3">
                                @csrf
                                @method('PATCH')
                                <x-text-input name="name" class="w-48 text-sm" :value="$zone->name" required />
                                <x-text-input name="fee_amount" type="number" step="0.01" class="w-28 text-sm" :value="$zone->fee_amount" required />
                                <x-text-input name="minimum_order_amount" type="number" step="0.01" class="w-28 text-sm" :value="$zone->minimum_order_amount" required />
                                <x-text-input name="sort_order" type="number" class="w-20 text-sm" :value="$zone->sort_order" />
                                <input type="hidden" name="is_active" value="0" />
                                <label class="flex items-center gap-1 text-sm"><input type="checkbox" name="is_active" value="1" @checked($zone->is_active) class="rounded" /> {{ __('Active') }}</label>
                                <x-secondary-button type="submit">{{ __('Save') }}</x-secondary-button>
                            </form>
                            <form method="post" action="{{ route('vendor.delivery.zones.destroy', $zone) }}" class="mt-2" onsubmit="return confirm('{{ __('Delete zone?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:underline">{{ __('Delete') }}</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </section>

            <section class="glass-panel p-6">
                <h3 class="font-semibold text-slate-50">{{ __('Flat fee rules (by subtotal)') }}</h3>
                <form method="post" action="{{ route('vendor.delivery.fee-rules.store') }}" class="mt-4 flex flex-wrap items-end gap-3">
                    @csrf
                    <div>
                        <x-input-label for="r_min" :value="__('Min subtotal')" />
                        <x-text-input id="r_min" name="min_subtotal" type="number" step="0.01" min="0" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="r_fee" :value="__('Fee')" />
                        <x-text-input id="r_fee" name="fee_amount" type="number" step="0.01" min="0" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="r_sort" :value="__('Sort')" />
                        <x-text-input id="r_sort" name="sort_order" type="number" class="mt-1 block w-full" value="0" />
                    </div>
                    <x-primary-button type="submit">{{ __('Add rule') }}</x-primary-button>
                </form>

                <ul class="mt-6 space-y-3">
                    @foreach ($rules as $rule)
                        <li class="flex flex-wrap items-end gap-3 rounded-xl border border-cyan-500/10 bg-slate-950/30 p-3 backdrop-blur-sm">
                            <form method="post" action="{{ route('vendor.delivery.fee-rules.update', $rule) }}" class="flex flex-wrap items-end gap-2">
                                @csrf
                                @method('PATCH')
                                <x-text-input name="min_subtotal" type="number" step="0.01" class="w-28 text-sm" :value="$rule->min_subtotal" required />
                                <x-text-input name="fee_amount" type="number" step="0.01" class="w-28 text-sm" :value="$rule->fee_amount" required />
                                <x-text-input name="sort_order" type="number" class="w-20 text-sm" :value="$rule->sort_order" />
                                <x-secondary-button type="submit">{{ __('Save') }}</x-secondary-button>
                            </form>
                            <form method="post" action="{{ route('vendor.delivery.fee-rules.destroy', $rule) }}" onsubmit="return confirm('{{ __('Delete rule?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:underline">{{ __('Delete') }}</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>
    </div>
</x-vendor-layout>


