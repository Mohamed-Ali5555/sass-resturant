@if (session('status'))
    <div class="mb-4 rounded-md border border-emerald-400/30 bg-emerald-500/10 px-4 py-3 text-sm text-green-800 border-emerald-400/25 bg-emerald-950/40 text-emerald-100" role="status">
        {{ session('status') }}
    </div>
@endif
@if (session('error'))
    <div class="mb-4 rounded-md border border-rose-400/30 bg-rose-500/10 px-4 py-3 text-sm text-red-800 border-rose-400/25 bg-rose-950/40 text-rose-100" role="alert">
        {{ session('error') }}
    </div>
@endif
