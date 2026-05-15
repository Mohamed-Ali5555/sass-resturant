@php
    use App\Enums\PlanInterval;
@endphp
<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-100 leading-tight">Edit subscription plan</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <form method="post" action="{{ route('admin.subscription-plans.update', $plan) }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <x-input-label for="name" value="Name" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $plan->name)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    <div>
                        <x-input-label for="slug" value="Slug" />
                        <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug', $plan->slug)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                    </div>
                    <div>
                        <x-input-label for="interval" value="Interval" />
                        <select id="interval" name="interval" class="mt-1 block w-full ui-field" required>
                            @foreach (PlanInterval::cases() as $case)
                                <option value="{{ $case->value }}" @selected(old('interval', $plan->interval->value) === $case->value)>{{ $case->value }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('interval')" />
                    </div>
                    <div>
                        <x-input-label for="price_amount" value="Price" />
                        <x-text-input id="price_amount" name="price_amount" type="text" class="mt-1 block w-full" :value="old('price_amount', $plan->price_amount)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('price_amount')" />
                    </div>
                    <div>
                        <x-input-label for="currency" value="Currency (ISO 3)" />
                        <x-text-input id="currency" name="currency" type="text" class="mt-1 block w-full" :value="old('currency', $plan->currency)" required maxlength="3" />
                        <x-input-error class="mt-2" :messages="$errors->get('currency')" />
                    </div>
                    @php
                        $oldFeatures = old('features', $plan->features ?? []);
                    @endphp
                    @for ($i = 0; $i < 5; $i++)
                        <div>
                            @if ($i === 0)
                                <x-input-label :for="'feature_'.$i" value="Feature labels (optional)" />
                            @endif
                            <x-text-input :id="'feature_'.$i" name="features[]" type="text" class="mt-1 block w-full" :value="$oldFeatures[$i] ?? ''" />
                        </div>
                    @endfor
                    <x-input-error class="mt-2" :messages="$errors->get('features')" />
                    <div class="flex items-center gap-2">
                        <input type="hidden" name="is_active" value="0">
                        <input id="is_active" type="checkbox" name="is_active" value="1" class="rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500" @checked(old('is_active', $plan->is_active))>
                        <x-input-label for="is_active" value="Active" />
                    </div>
                    <div class="flex gap-3">
                        <x-primary-button type="submit">Update</x-primary-button>
                        <a href="{{ route('admin.subscription-plans.index') }}" class="inline-flex items-center rounded-xl border border-cyan-400/30 px-4 py-2 text-sm text-cyan-100 transition hover:border-cyan-300/50 hover:bg-cyan-500/15">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>


