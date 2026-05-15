<x-vendor-layout :title="__('New Coupon — ') . $restaurant->name" :mobile-title="__('New Coupon')">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('vendor.promotions.index') }}" class="flex h-8 w-8 items-center justify-center rounded-xl border border-white/10 text-slate-400 transition hover:border-cyan-400/30 hover:text-cyan-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            </a>
            <h1 class="text-xl font-bold text-slate-100">{{ __('New Coupon') }}</h1>
        </div>
    </x-slot>

    <div class="mx-auto max-w-xl">
        <div class="glass-panel rounded-2xl p-6">
            <form method="post" action="{{ route('vendor.promotions.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="code" class="block text-sm font-medium text-slate-300">{{ __('Coupon code') }} <span class="text-red-400">*</span></label>
                    <div class="relative mt-2">
                        <input id="code" type="text" name="code" value="{{ old('code') }}"
                            class="ui-field w-full font-mono uppercase tracking-widest @error('code') border-red-500/60 @enderror"
                            placeholder="SAVE20" required>
                    </div>
                    @error('code') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div id="discountTypeContainer">
                    <label class="block text-sm font-medium text-slate-300">{{ __('Discount type') }} <span class="text-red-400">*</span></label>
                    <div class="mt-2 flex gap-3">
                        <label class="flex flex-1 cursor-pointer items-center gap-2 rounded-xl border border-white/10 p-3 transition hover:border-cyan-400/30 discount-type-label" data-type="percent">
                            <input type="radio" name="discount_type" value="percent" class="accent-cyan-500" checked>
                            <span class="text-sm font-medium">{{ __('Percentage') }}</span>
                        </label>
                        <label class="flex flex-1 cursor-pointer items-center gap-2 rounded-xl border border-white/10 p-3 transition hover:border-cyan-400/30 discount-type-label" data-type="fixed">
                            <input type="radio" name="discount_type" value="fixed" class="accent-cyan-500">
                            <span class="text-sm font-medium">{{ __('Fixed amount') }}</span>
                        </label>
                    </div>

                    <div class="discount-section discount-section-percent mt-3" style="display: {{ old('discount_type', 'percent') === 'percent' ? 'block' : 'none' }}">
                        <label for="percent_off" class="block text-sm font-medium text-slate-300">{{ __('Percent off (0–100)') }}</label>
                        <input id="percent_off" type="number" name="percent_off" value="{{ old('percent_off') }}"
                            min="0" max="100" step="0.01"
                            class="ui-field mt-2 w-full @error('percent_off') border-red-500/60 @enderror"
                            placeholder="20">
                        @error('percent_off') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>

                    <div class="discount-section discount-section-fixed mt-3" style="display: {{ old('discount_type', 'percent') === 'fixed' ? 'block' : 'none' }}">
                        <label for="amount_off" class="block text-sm font-medium text-slate-300">{{ __('Amount off') }} ({{ $restaurant->currency }})</label>
                        <input id="amount_off" type="number" name="amount_off" value="{{ old('amount_off') }}"
                            min="0" step="0.01"
                            class="ui-field mt-2 w-full @error('amount_off') border-red-500/60 @enderror"
                            placeholder="5.00">
                        @error('amount_off') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="max_redemptions" class="block text-sm font-medium text-slate-300">{{ __('Max redemptions') }}</label>
                    <input id="max_redemptions" type="number" name="max_redemptions" value="{{ old('max_redemptions') }}"
                        min="1" class="ui-field mt-2 w-full" placeholder="{{ __('Unlimited') }}">
                    @error('max_redemptions') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="starts_at" class="block text-sm font-medium text-slate-300">{{ __('Starts at') }}</label>
                        <input id="starts_at" type="date" name="starts_at" value="{{ old('starts_at') }}"
                            class="ui-field mt-2 w-full">
                        @error('starts_at') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="ends_at" class="block text-sm font-medium text-slate-300">{{ __('Ends at') }}</label>
                        <input id="ends_at" type="date" name="ends_at" value="{{ old('ends_at') }}"
                            class="ui-field mt-2 w-full">
                        @error('ends_at') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input id="is_active" type="checkbox" name="is_active" value="1"
                        class="rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500" @checked(old('is_active', true))>
                    <label for="is_active" class="text-sm text-slate-300">{{ __('Active') }}</label>
                </div>

                <div class="flex items-center justify-between gap-3 border-t border-white/10 pt-4">
                    <a href="{{ route('vendor.promotions.index') }}" class="text-sm text-slate-400 hover:text-slate-200">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn-neon rounded-xl px-5 py-2 text-sm font-semibold">{{ __('Create coupon') }}</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('discountTypeContainer');
            if (!container) return;

            const labels = container.querySelectorAll('.discount-type-label');
            const sections = container.querySelectorAll('.discount-section');
            const radios = container.querySelectorAll('input[name="discount_type"]');

            function updateDisplay() {
                const checked = container.querySelector('input[name="discount_type"]:checked');
                const selectedType = checked?.value || 'percent';

                labels.forEach(label => {
                    const type = label.dataset.type;
                    if (type === selectedType) {
                        label.classList.add('border-cyan-400/50', 'bg-cyan-500/10');
                    } else {
                        label.classList.remove('border-cyan-400/50', 'bg-cyan-500/10');
                    }
                });

                sections.forEach(section => {
                    if (section.classList.contains(`discount-section-${selectedType}`)) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            }

            radios.forEach(radio => {
                radio.addEventListener('change', updateDisplay);
            });

            updateDisplay();
        });
    </script>
</x-vendor-layout>
