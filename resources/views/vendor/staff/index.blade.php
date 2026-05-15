<x-vendor-layout :title="__('Staff — ') . $restaurant->name" :mobile-title="__('Staff')">
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-slate-100">{{ __('Staff Members') }}</h1>
                <p class="mt-0.5 text-sm text-slate-400">{{ __('Manage who can access the :name vendor panel.', ['name' => $restaurant->name]) }}</p>
            </div>
            <a href="{{ route('vendor.staff.create') }}" class="btn-neon inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-semibold">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                {{ __('Add staff member') }}
            </a>
        </div>
    </x-slot>

    @include('vendor.partials.flash')

    <div class="mx-auto max-w-5xl">
        @if ($staff->isEmpty())
            <div class="glass-panel flex flex-col items-center justify-center gap-3 rounded-2xl p-16 text-center">
                <svg class="h-12 w-12 text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                <p class="text-slate-400">{{ __('No staff members yet.') }}</p>
                <a href="{{ route('vendor.staff.create') }}" class="btn-neon rounded-xl px-4 py-2 text-sm font-semibold">{{ __('Add first member') }}</a>
            </div>
        @else
            <div class="glass-panel overflow-hidden rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/10 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500">
                                <th class="px-5 py-3">{{ __('Name') }}</th>
                                <th class="px-5 py-3">{{ __('Email') }}</th>
                                <th class="px-5 py-3">{{ __('Role') }}</th>
                                <th class="px-5 py-3">{{ __('Branch') }}</th>
                                <th class="px-5 py-3">{{ __('Status') }}</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach ($staff as $member)
                                <tr class="transition hover:bg-white/[0.02]">
                                    <td class="px-5 py-3 font-medium text-slate-100">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-cyan-500/30 to-teal-600/30 text-xs font-bold text-cyan-300">
                                                {{ strtoupper(substr($member->name, 0, 1)) }}
                                            </span>
                                            {{ $member->name }}
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-slate-400">{{ $member->email }}</td>
                                    <td class="px-5 py-3">
                                        @if ($member->pivot->staff_role)
                                            <span class="inline-flex items-center rounded-full bg-cyan-500/15 px-2.5 py-0.5 text-xs font-medium text-cyan-300">
                                                {{ str_replace('_', ' ', ucfirst($member->pivot->staff_role)) }}
                                            </span>
                                        @else
                                            <span class="text-slate-600">—</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-slate-400">
                                        {{ $branches->firstWhere('id', $member->pivot->branch_id)?->name ?? __('All branches') }}
                                    </td>
                                    <td class="px-5 py-3">
                                        @if ($member->pivot->is_active)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-500/15 px-2.5 py-0.5 text-xs font-medium text-emerald-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>{{ __('Active') }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 rounded-full bg-slate-500/20 px-2.5 py-0.5 text-xs font-medium text-slate-400">
                                                <span class="h-1.5 w-1.5 rounded-full bg-slate-500"></span>{{ __('Inactive') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 whitespace-nowrap text-right">
                                        <a href="{{ route('vendor.staff.edit', $member) }}" class="text-xs font-medium text-cyan-400 hover:text-cyan-200 hover:underline">{{ __('Edit') }}</a>
                                        <form method="post" action="{{ route('vendor.staff.destroy', $member) }}" class="ml-3 inline" onsubmit="return confirm('{{ __('Remove this staff member?') }}')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs font-medium text-red-400 hover:text-red-200 hover:underline">{{ __('Remove') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</x-vendor-layout>
