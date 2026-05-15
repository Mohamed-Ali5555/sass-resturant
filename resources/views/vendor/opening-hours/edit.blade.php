@php
    $dayLabels = [__('Sunday'), __('Monday'), __('Tuesday'), __('Wednesday'), __('Thursday'), __('Friday'), __('Saturday')];
@endphp
<x-vendor-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ __('Opening hours') }}</h2>
            <a href="{{ route('vendor.dashboard') }}" class="text-sm text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Home') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex flex-wrap gap-2 text-sm">
                <span class="text-slate-500">{{ __('Location') }}:</span>
                <a href="{{ route('vendor.opening-hours.edit') }}" @class(['rounded-full px-3 py-1 transition', 'bg-cyan-500/25 text-cyan-50 shadow-glow-sm ring-1 ring-cyan-400/30' => $branchId === null, 'text-slate-400 hover:text-cyan-200' => $branchId !== null])>{{ __('Main (HQ)') }}</a>
                @foreach ($branches as $b)
                    <a href="{{ route('vendor.opening-hours.edit', ['branch_id' => $b->id]) }}" @class(['rounded-full px-3 py-1 transition', 'bg-cyan-500/25 text-cyan-50 shadow-glow-sm ring-1 ring-cyan-400/30' => (int) $branchId === (int) $b->id, 'text-slate-400 hover:text-cyan-200' => (int) $branchId !== (int) $b->id])>{{ $b->name }}</a>
                @endforeach
            </div>

            <form method="post" action="{{ route('vendor.opening-hours.update') }}" class="glass-panel space-y-3 p-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="branch_id" value="{{ $branchId ?? '' }}" />

                @foreach ($rows as $i => $row)
                    <div class="grid gap-3 rounded-xl border border-cyan-500/10 bg-slate-950/30 p-3 backdrop-blur-sm sm:grid-cols-12">
                        <div class="sm:col-span-3 text-sm font-medium text-slate-100">
                            {{ $dayLabels[$row['day_of_week']] }}
                            <input type="hidden" name="hours[{{ $i }}][day_of_week]" value="{{ $row['day_of_week'] }}" />
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-xs text-slate-500">{{ __('Closed') }}</label>
                            <select name="hours[{{ $i }}][is_closed]" class="mt-1 block w-full ui-field text-sm">
                                <option value="0" @selected(! $row['is_closed'])>{{ __('No') }}</option>
                                <option value="1" @selected($row['is_closed'])>{{ __('Yes') }}</option>
                            </select>
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-xs text-slate-500">{{ __('Open') }}</label>
                            <input type="time" name="hours[{{ $i }}][open_time]" value="{{ $row['open_time'] }}" class="mt-1 block w-full ui-field text-sm" />
                        </div>
                        <div class="sm:col-span-3">
                            <label class="block text-xs text-slate-500">{{ __('Close') }}</label>
                            <input type="time" name="hours[{{ $i }}][close_time]" value="{{ $row['close_time'] }}" class="mt-1 block w-full ui-field text-sm" />
                        </div>
                    </div>
                @endforeach

                <x-primary-button class="mt-4">{{ __('Save hours') }}</x-primary-button>
            </form>
        </div>
    </div>
</x-vendor-layout>


