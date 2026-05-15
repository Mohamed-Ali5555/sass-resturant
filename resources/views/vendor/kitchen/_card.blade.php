{{-- Kitchen order card (rendered via Alpine x-for template) --}}
<div class="p-4">

    {{-- Card header --}}
    <div class="mb-3 flex items-start justify-between gap-2">
        <div>
            <div class="flex items-center gap-2">
                <span class="font-mono text-base font-extrabold text-white" x-text="'#' + order.public_ref"></span>
                <span
                    x-show="order.table_number"
                    class="rounded-lg bg-slate-800 px-2 py-0.5 text-[11px] font-bold uppercase text-slate-300"
                    x-text="'T' + order.table_number"
                ></span>
            </div>
            <div class="mt-1 flex items-center gap-2">
                <span
                    class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase"
                    :class="{
                        'bg-amber-500/20 text-amber-300': order.order_type === 'dine_in',
                        'bg-blue-500/20 text-blue-300': order.order_type === 'delivery',
                        'bg-violet-500/20 text-violet-300': order.order_type === 'takeaway',
                        'bg-slate-500/20 text-slate-300': !order.order_type,
                    }"
                    x-text="order.order_type ? order.order_type.replace('_', ' ') : 'order'"
                ></span>
            </div>
        </div>

        {{-- Timer --}}
        <div class="text-right">
            <div :class="timerClass(order.created_at, order.est_prep_minutes)" class="text-lg font-extrabold tabular-nums" x-text="formatMinutes(order.created_at)"></div>
            <div class="text-[10px] text-slate-600">{{ __('est.') }} <span x-text="order.est_prep_minutes + ' min'"></span></div>
        </div>
    </div>

    {{-- Items list --}}
    <div class="mb-3 space-y-1.5 rounded-xl bg-black/30 p-3">
        <template x-for="(item, idx) in order.items" :key="idx">
            <div class="flex items-baseline gap-2">
                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-slate-800 text-xs font-bold text-slate-200" x-text="item.qty + 'x'"></span>
                <span class="text-sm font-semibold text-slate-100 leading-tight" x-text="item.name"></span>
            </div>
        </template>
        <template x-if="order.items.length === 0">
            <p class="text-xs text-slate-600">{{ __('No items') }}</p>
        </template>
    </div>

    {{-- Customer notes --}}
    <div x-show="order.customer_notes" class="mb-3 rounded-xl border border-amber-500/20 bg-amber-500/5 px-3 py-2">
        <p class="text-[11px] font-semibold uppercase tracking-wide text-amber-500/70">{{ __('Note') }}</p>
        <p class="text-xs text-amber-200/80" x-text="order.customer_notes"></p>
    </div>

    {{-- Action button --}}
    <template x-if="order.status === 'new'">
        <button
            @click="advance(order.id, 'preparing')"
            class="kds-btn-start"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /></svg>
            {{ __('Start Preparing') }}
        </button>
    </template>
    <template x-if="order.status === 'preparing'">
        <button
            @click="advance(order.id, 'ready')"
            class="kds-btn-ready"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ __('Mark as Ready') }}
        </button>
    </template>
    <template x-if="order.status === 'ready'">
        <button
            @click="advance(order.id, 'completed')"
            class="kds-btn-done"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" /></svg>
            {{ __('Delivered — Done!') }}
        </button>
    </template>
</div>
