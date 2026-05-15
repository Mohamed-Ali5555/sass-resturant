<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn-neon inline-flex items-center rounded-xl border border-transparent px-4 py-2 text-xs font-semibold uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-cyan-400/50 focus:ring-offset-2 focus:ring-offset-slate-950 disabled:opacity-40']) }}>
    {{ $slot }}
</button>
