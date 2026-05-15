<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center rounded-xl border border-cyan-400/30 bg-slate-950/40 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-cyan-100 shadow-glow-sm backdrop-blur-md transition hover:border-cyan-300/50 hover:bg-cyan-500/10 focus:outline-none focus:ring-2 focus:ring-cyan-400/40 focus:ring-offset-2 focus:ring-offset-slate-950 disabled:opacity-40']) }}>
    {{ $slot }}
</button>
