@props([
    'title' => null,
    'columns' => [],
    'rows' => [],
    'actions' => [],
    'responsive' => true,
])

<div class="space-y-4">
    @if ($title)
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-semibold text-slate-100">{{ $title }}</h3>
            {{ $headerAction ?? null }}
        </div>
    @endif

    {{-- Desktop Table View --}}
    <div class="glass-panel hidden overflow-hidden sm:block">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-white/10 bg-slate-900/50">
                    <tr>
                        @foreach ($columns as $col)
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                                {{ $col['label'] ?? $col }}
                            </th>
                        @endforeach
                        @if (count($actions) > 0)
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wide text-slate-400">
                                {{ __('Actions') }}
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($rows as $index => $row)
                        <tr class="group transition-colors duration-200 hover:bg-white/[0.02]">
                            @foreach ($columns as $col)
                                @php
                                    $key = is_array($col) ? $col['key'] : $col;
                                    $value = data_get($row, $key);
                                    if (is_array($col) && isset($col['format'])) {
                                        $value = call_user_func($col['format'], $value, $row);
                                    }
                                @endphp
                                @if (is_array($col) && isset($col['format']))
                                    <td class="px-6 py-4 text-slate-300">{!! $value ?? '—' !!}</td>
                                @else
                                    <td class="px-6 py-4 text-slate-300">{{ $value ?? '—' }}</td>
                                @endif
                            @endforeach
                            @if (count($actions) > 0)
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        @foreach ($actions as $action)
                                            @php
                                                $route = call_user_func($action['route'] ?? fn() => '#', $row);
                                                $confirm = $action['confirm'] ?? null;
                                                $method = $action['method'] ?? 'GET';
                                                $class = $action['class'] ?? 'text-cyan-400 hover:text-cyan-300';
                                                $label = $action['label'] ?? 'Action';
                                                $icon = $action['icon'] ?? null;
                                            @endphp

                                            @if ($method === 'GET' || $method === 'POST')
                                                @if ($method === 'GET')
                                                    <a href="{{ $route }}" class="group/btn flex items-center gap-1.5 rounded-lg px-3 py-2 text-xs font-medium transition-all duration-200 {{ $class }} opacity-0 transition-opacity duration-200 group-hover:opacity-100 hover:bg-white/5">
                                                        @if ($icon)
                                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                                {!! $icon !!}
                                                            </svg>
                                                        @endif
                                                        <span>{{ $label }}</span>
                                                    </a>
                                                @else
                                                    <form method="POST" action="{{ $route }}" class="inline" @if($confirm) onsubmit="return confirm('{{ $confirm }}')" @endif>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="group/btn flex items-center gap-1.5 rounded-lg px-3 py-2 text-xs font-medium transition-all duration-200 {{ $class }} opacity-0 transition-opacity duration-200 group-hover:opacity-100 hover:bg-white/5">
                                                            @if ($icon)
                                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                                    {!! $icon !!}
                                                                </svg>
                                                            @endif
                                                            <span>{{ $label }}</span>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) + (count($actions) > 0 ? 1 : 0) }}" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center gap-2 text-slate-600">
                                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m33-2.625v11.25c0 2.278-3.69 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V3.75m0 0A9.375 9.375 0 0112 0c4.556 0 8.25 2.235 8.25 5" />
                                    </svg>
                                    <p class="text-sm font-medium">{{ __('No data') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Mobile Card View --}}
    <div class="space-y-3 sm:hidden">
        @forelse ($rows as $index => $row)
            <div class="group animate-slide-in-up rounded-xl border border-white/10 bg-gradient-to-br from-white/5 to-white/[0.02] p-4 shadow-lg transition-all duration-300 hover:border-cyan-400/30 hover:shadow-cyan-500/10">
                <div class="space-y-3">
                    @foreach ($columns as $col)
                        @php
                            $key = is_array($col) ? $col['key'] : $col;
                            $label = is_array($col) ? $col['label'] : $col;
                            $value = data_get($row, $key);
                            if (is_array($col) && isset($col['format'])) {
                                $value = call_user_func($col['format'], $value, $row);
                            }
                        @endphp
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ $label }}</span>
                            @if (is_array($col) && isset($col['format']))
                                <span class="text-sm text-slate-200">{!! $value ?? '—' !!}</span>
                            @else
                                <span class="text-sm text-slate-200">{{ $value ?? '—' }}</span>
                            @endif
                        </div>
                    @endforeach
                </div>

                @if (count($actions) > 0)
                    <div class="mt-4 flex flex-wrap gap-2 border-t border-white/10 pt-3">
                        @foreach ($actions as $action)
                            @php
                                $route = call_user_func($action['route'] ?? fn() => '#', $row);
                                $confirm = $action['confirm'] ?? null;
                                $method = $action['method'] ?? 'GET';
                                $class = $action['mobile_class'] ?? 'bg-cyan-500/20 text-cyan-300 hover:bg-cyan-500/30';
                                $label = $action['label'] ?? 'Action';
                                $icon = $action['icon'] ?? null;
                            @endphp

                            @if ($method === 'GET')
                                <a href="{{ $route }}" class="flex flex-1 items-center justify-center gap-2 rounded-lg px-3 py-2 text-xs font-medium transition-all duration-200 {{ $class }}">
                                    @if ($icon)
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            {!! $icon !!}
                                        </svg>
                                    @endif
                                    <span>{{ $label }}</span>
                                </a>
                            @else
                                <form method="POST" action="{{ $route }}" class="flex flex-1" @if($confirm) onsubmit="return confirm('{{ $confirm }}')" @endif>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex flex-1 items-center justify-center gap-2 rounded-lg px-3 py-2 text-xs font-medium transition-all duration-200 {{ $class }}">
                                        @if ($icon)
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                {!! $icon !!}
                                            </svg>
                                        @endif
                                        <span>{{ $label }}</span>
                                    </button>
                                </form>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @empty
            <div class="flex flex-col items-center justify-center gap-3 rounded-xl border border-white/10 bg-white/5 py-12 text-center">
                <svg class="h-12 w-12 text-slate-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m33-2.625v11.25c0 2.278-3.69 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V3.75m0 0A9.375 9.375 0 0112 0c4.556 0 8.25 2.235 8.25 5" />
                </svg>
                <p class="text-sm font-medium text-slate-600">{{ __('No data') }}</p>
            </div>
        @endforelse
    </div>

    {{ $footer ?? null }}
</div>

<style>
    @keyframes slide-in-up {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-in-up {
        animation: slide-in-up 0.3s ease-out;
    }
</style>
