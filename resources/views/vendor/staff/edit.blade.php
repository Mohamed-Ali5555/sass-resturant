<x-vendor-layout :title="__('Edit Staff — ') . $restaurant->name" :mobile-title="__('Edit Staff')">
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('vendor.staff.index') }}" class="flex h-8 w-8 items-center justify-center rounded-xl border border-white/10 text-slate-400 transition hover:border-cyan-400/30 hover:text-cyan-200">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
            </a>
            <div>
                <h1 class="text-xl font-bold text-slate-100">{{ $staff->name }}</h1>
                <p class="mt-0.5 text-sm text-slate-400">{{ $staff->email }}</p>
            </div>
        </div>
    </x-slot>

    @include('vendor.partials.flash')

    <div class="mx-auto max-w-xl">
        <div class="glass-panel rounded-2xl p-6">
            <form method="post" action="{{ route('vendor.staff.update', $staff) }}" class="space-y-5">
                @csrf @method('PATCH')

                <div>
                    <label for="staff_role" class="block text-sm font-medium text-slate-300">{{ __('Role') }}</label>
                    <select id="staff_role" name="staff_role" class="ui-field mt-2 w-full">
                        <option value="">{{ __('— No specific role —') }}</option>
                        @foreach ($staffRoles as $role)
                            <option value="{{ $role->value }}" @selected((old('staff_role') ?? $pivot?->staff_role) === $role->value)>
                                {{ $role->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('staff_role') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>

                @if ($branches->isNotEmpty())
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-slate-300">{{ __('Branch') }}</label>
                        <select id="branch_id" name="branch_id" class="ui-field mt-2 w-full">
                            <option value="">{{ __('All branches') }}</option>
                            @foreach ($branches as $b)
                                <option value="{{ $b->id }}" @selected((old('branch_id') ?? $pivot?->branch_id) == $b->id)>{{ $b->name }}</option>
                            @endforeach
                        </select>
                        @error('branch_id') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                @endif

                <div class="flex items-center gap-3">
                    <input type="hidden" name="is_active" value="0">
                    <input id="is_active" type="checkbox" name="is_active" value="1"
                        class="rounded border-cyan-400/35 bg-slate-950/40 accent-cyan-500"
                        @checked(old('is_active', $pivot?->is_active ?? true))>
                    <label for="is_active" class="text-sm text-slate-300">{{ __('Active (can log in to vendor panel)') }}</label>
                </div>

                <div class="flex items-center justify-between gap-3 border-t border-white/10 pt-4">
                    <form method="post" action="{{ route('vendor.staff.destroy', $staff) }}" onsubmit="return confirm('{{ __('Remove this staff member?') }}')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-sm font-medium text-red-400 hover:text-red-200">{{ __('Remove from staff') }}</button>
                    </form>
                    <div class="flex gap-3">
                        <a href="{{ route('vendor.staff.index') }}" class="text-sm text-slate-400 hover:text-slate-200">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn-neon rounded-xl px-5 py-2 text-sm font-semibold">{{ __('Save changes') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-vendor-layout>
