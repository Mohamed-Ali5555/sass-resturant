@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'rounded-xl border border-cyan-400/20 bg-slate-950/50 text-slate-100 shadow-inner backdrop-blur-md placeholder:text-slate-500 focus:border-cyan-400/60 focus:ring-2 focus:ring-cyan-400/30']) }}>
