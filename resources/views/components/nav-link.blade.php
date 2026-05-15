@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-full px-4 py-2 text-sm font-semibold text-slate-950 shadow-glow bg-gradient-to-r from-cyan-400 to-teal-400 transition'
            : 'inline-flex items-center rounded-full px-4 py-2 text-sm font-medium text-slate-300 transition hover:bg-cyan-500/10 hover:text-cyan-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
