@props(['href', 'active' => false])

@php
    $base = 'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition';
    $idle = 'text-slate-400 hover:bg-white/5 hover:text-slate-100';
    $on = 'bg-gradient-to-r from-cyan-500/20 to-teal-500/10 text-cyan-50 shadow-glow-sm ring-1 ring-cyan-400/25';
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $base.' '.($active ? $on : $idle)]) }}>
    {{ $slot }}
</a>
