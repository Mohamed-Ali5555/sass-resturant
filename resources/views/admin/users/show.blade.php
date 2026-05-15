<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ $user->name }}</h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Back') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="glass-panel p-6 text-sm text-slate-200">
                <dl class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs uppercase text-slate-500">{{ __('Email') }}</dt>
                        <dd class="font-medium">{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase text-slate-500">{{ __('Account') }}</dt>
                        <dd class="font-medium">{{ $user->is_disabled ? __('Disabled') : __('Active') }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-xs uppercase text-slate-500">{{ __('Roles') }}</dt>
                        <dd class="font-medium">{{ $user->roles->pluck('name')->join(', ') ?: '—' }}</dd>
                    </div>
                </dl>
            </div>

            @if ($user->hasRole(\App\Enums\RoleName::SuperAdmin->value))
                <div class="rounded-md border border-amber-400/30 bg-amber-500/10 p-4 text-sm text-amber-900 border-amber-400/25 bg-amber-950/40 text-amber-100">
                    {{ __('Super admin accounts cannot be edited from this screen.') }}
                </div>
            @else
                <div class="glass-panel p-6">
                    <h3 class="font-semibold text-slate-50">{{ __('Assign role') }}</h3>
                    <p class="mt-1 text-xs text-slate-500">{{ __('Only vendor owner or customer can be assigned from the admin panel.') }}</p>
                    <form method="post" action="{{ route('admin.users.roles.update', $user) }}" class="mt-4 space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label for="role" class="block text-sm font-medium text-slate-300">{{ __('Role') }}</label>
                            <select id="role" name="role" class="mt-1 block w-full ui-field" required>
                                @foreach ($assignableRoles as $value => $label)
                                    <option value="{{ $value }}" @selected($user->hasRole($value))>{{ $label }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>
                        <x-primary-button type="submit">{{ __('Save role') }}</x-primary-button>
                    </form>
                </div>

                <div class="glass-panel p-6">
                    <h3 class="font-semibold text-slate-50">{{ __('Account status') }}</h3>
                    <div class="mt-4 flex flex-wrap gap-3">
                        <form method="post" action="{{ route('admin.users.disabled', $user) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="is_disabled" value="1" />
                            <x-secondary-button type="submit">{{ __('Disable account') }}</x-secondary-button>
                        </form>
                        <form method="post" action="{{ route('admin.users.disabled', $user) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="is_disabled" value="0" />
                            <x-primary-button type="submit">{{ __('Enable account') }}</x-primary-button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>


