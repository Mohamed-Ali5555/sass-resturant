<x-vendor-layout :title="__('Add Staff — ') . $restaurant->name" :mobile-title="__('Add Staff')">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('vendor.staff.index') }}" class="flex h-8 w-8 items-center justify-center rounded-xl border border-white/10 text-slate-400 transition hover:border-cyan-400/30 hover:text-cyan-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-100">{{ __('Add Staff Member') }}</h1>
                <p class="mt-0.5 text-sm text-slate-400">{{ __('Grant access to an existing user account.') }}</p>
            </div>
        </div>
    </x-slot>

    @include('vendor.partials.flash')

    <div class="mx-auto max-w-xl">
        <div class="glass-panel rounded-2xl p-6">
            <form method="post" action="{{ route('vendor.staff.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300">{{ __('User email address') }} <span class="text-red-400">*</span></label>
                    <p class="mt-0.5 text-xs text-slate-500">{{ __('The user must already have an account on this platform.') }}</p>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="ui-field mt-2 w-full @error('email') border-red-500/60 @enderror"
                        placeholder="staff@example.com" required>
                    @error('email') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="staff_role" class="block text-sm font-medium text-slate-300">{{ __('Role') }}</label>
                    <select id="staff_role" name="staff_role" class="ui-field mt-2 w-full">
                        <option value="">{{ __('— Select role —') }}</option>
                        @foreach ($staffRoles as $role)
                            <option value="{{ $role->value }}" @selected(old('staff_role') === $role->value)>
                                {{ $role->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('staff_role') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                @if ($branches->isNotEmpty())
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-slate-300">{{ __('Assign to branch') }}</label>
                        <select id="branch_id" name="branch_id" class="ui-field mt-2 w-full">
                            <option value="">{{ __('All branches') }}</option>
                            @foreach ($branches as $b)
                                <option value="{{ $b->id }}" @selected(old('branch_id') == $b->id)>{{ $b->name }}</option>
                            @endforeach
                        </select>
                        @error('branch_id') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                @endif

                <div class="flex items-center justify-between gap-3 border-t border-white/10 pt-4">
                    <a href="{{ route('vendor.staff.index') }}" class="text-sm text-slate-400 hover:text-slate-200">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn-neon rounded-xl px-5 py-2 text-sm font-semibold">{{ __('Add member') }}</button>
                </div>
            </form>
        </div>
    </div>
</x-vendor-layout>
