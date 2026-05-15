@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-xl border border-cyan-400/35 bg-cyan-500/15 ps-3 pe-4 py-3 text-start text-base font-semibold text-cyan-50 shadow-glow-sm transition'
            : 'block w-full rounded-xl border border-transparent ps-3 pe-4 py-3 text-start text-base font-medium text-slate-300 transition hover:border-cyan-400/20 hover:bg-slate-900/50 hover:text-cyan-100';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
