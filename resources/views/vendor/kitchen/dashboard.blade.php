<x-kitchen-layout :title="$restaurant->name . ' · Kitchen'">
<div class="flex h-screen flex-col bg-[#06070d]">
    {{-- ── Top bar ──────────────────────────────────────── --}}
    <header class="flex h-14 shrink-0 items-center justify-between gap-4 border-b border-white/10 bg-slate-950/90 px-5 backdrop-blur-md">
        <div class="flex items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-amber-500 to-orange-600">
                <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /></svg>
            </span>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-slate-400">{{ __('Kitchen Display') }}</p>
                <p class="text-sm font-bold leading-tight text-white">{{ $restaurant->name }}</p>
            </div>
        </div>

        <div class="flex items-center gap-5">
            {{-- Live clock --}}
            <span id="kds-clock" class="font-mono text-xl font-bold text-slate-200">--:--:--</span>

            {{-- Live indicator --}}
            <div class="flex items-center gap-2">
                <span id="kds-live-dot-on" class="flex h-2.5 w-2.5 animate-pulse rounded-full bg-emerald-400"></span>
                <span id="kds-live-dot-off" class="hidden flex h-2.5 w-2.5 rounded-full bg-red-500"></span>
                <span id="kds-live-label" class="text-xs font-semibold text-emerald-400">{{ __('Live') }}</span>
            </div>

            {{-- Audio toggle --}}
            <button
                type="button"
                id="kds-audio-toggle"
                class="flex items-center gap-1.5 rounded-lg border border-amber-400/40 px-3 py-1.5 text-xs font-medium text-amber-400 transition"
                title="{{ __('Sound on') }}"
            >
                <svg id="kds-audio-icon-on" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" /></svg>
                <svg id="kds-audio-icon-off" class="hidden h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 9.75L19.5 12m0 0l2.25 2.25M19.5 12l2.25-2.25M19.5 12l-2.25 2.25m-10.5-6l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" /></svg>
                <span id="kds-audio-label">{{ __('Sound on') }}</span>
            </button>

            {{-- Order summary pills --}}
            <div class="flex items-center gap-2">
                <span class="rounded-full bg-amber-500/20 px-3 py-1 text-xs font-bold text-amber-400">
                    <span id="kds-count-new">0</span> {{ __('New') }}
                </span>
                <span class="rounded-full bg-blue-500/20 px-3 py-1 text-xs font-bold text-blue-400">
                    <span id="kds-count-preparing">0</span> {{ __('Prep') }}
                </span>
                <span class="rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-bold text-emerald-400">
                    <span id="kds-count-ready">0</span> {{ __('Ready') }}
                </span>
            </div>

            <a href="{{ route('vendor.dashboard') }}" class="rounded-lg border border-white/10 px-3 py-1.5 text-xs text-slate-400 transition hover:border-white/25 hover:text-slate-200">
                ← {{ __('Back to panel') }}
            </a>
        </div>
    </header>

    {{-- ── Kanban columns ──────────────────────────────── --}}
    <div class="flex flex-1 gap-0 overflow-hidden">

        {{-- NEW column --}}
        <div class="kds-column-new flex w-1/3 flex-col border-r border-white/5">
            <div class="flex items-center gap-2 bg-amber-500/10 px-4 py-3">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-amber-500/30 text-amber-400">
                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="5"/></svg>
                </span>
                <h2 class="text-sm font-bold uppercase tracking-widest text-amber-400">{{ __('New Orders') }}</h2>
                <span id="kds-col-new-count" class="ml-auto rounded-full bg-amber-500/20 px-2 py-0.5 text-xs font-bold text-amber-400">0</span>
            </div>
            <div class="kitchen-scrollbar flex-1 space-y-3 overflow-y-auto p-3" id="col-new"></div>
        </div>

        {{-- PREPARING column --}}
        <div class="kds-column-preparing flex w-1/3 flex-col border-r border-white/5">
            <div class="flex items-center gap-2 bg-blue-500/10 px-4 py-3">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500/30 text-blue-400">
                    <svg class="h-3 w-3 animate-spin" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
                </span>
                <h2 class="text-sm font-bold uppercase tracking-widest text-blue-400">{{ __('Preparing') }}</h2>
                <span id="kds-col-preparing-count" class="ml-auto rounded-full bg-blue-500/20 px-2 py-0.5 text-xs font-bold text-blue-400">0</span>
            </div>
            <div class="kitchen-scrollbar flex-1 space-y-3 overflow-y-auto p-3" id="col-preparing"></div>
        </div>

        {{-- READY column --}}
        <div class="kds-column-ready flex w-1/3 flex-col">
            <div class="flex items-center gap-2 bg-emerald-500/10 px-4 py-3">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500/30 text-emerald-400">
                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                </span>
                <h2 class="text-sm font-bold uppercase tracking-widest text-emerald-400">{{ __('Ready') }}</h2>
                <span id="kds-col-ready-count" class="ml-auto rounded-full bg-emerald-500/20 px-2 py-0.5 text-xs font-bold text-emerald-400">0</span>
            </div>
            <div class="kitchen-scrollbar flex-1 space-y-3 overflow-y-auto p-3" id="col-ready"></div>
        </div>
    </div>

    {{-- ── New order notification overlay ─────────────── --}}
    <div id="kds-new-order-alert" style="display:none;" class="pointer-events-none fixed bottom-6 left-1/2 z-50 -translate-x-1/2">
        <div class="flex items-center gap-3 rounded-2xl border border-amber-400/50 bg-amber-500/20 px-6 py-4 shadow-glow-amber backdrop-blur-xl">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-500/30 text-amber-400 text-lg">🔔</span>
            <div>
                <p class="font-bold text-amber-300">{{ __('New Order!') }}</p>
                <p class="text-xs text-amber-400/80"><span id="kds-new-order-count"></span> {{ __('new order(s) received') }}</p>
            </div>
        </div>
    </div>
</div>

@php
$kitchenOrders = $orders->map(function ($o) {
    return [
        'id' => $o->id,
        'public_ref' => $o->public_ref,
        'status' => $o->status->value,
        'order_type' => $o->order_type?->value,
        'table_number' => $o->table_number,
        'customer_notes' => $o->customer_notes,
        'created_at' => $o->created_at?->toIso8601String(),
        'minutes_ago' => (int) $o->created_at?->diffInMinutes(now()),
        'est_prep_minutes' => 5 + (int) ceil($o->orderItems->sum('qty') * 1.5),
        'items' => $o->orderItems->map(function ($i) {
            return [
                'name' => $i->item_name_snapshot,
                'qty' => $i->qty,
            ];
        })->values(),
    ];
})->values();
@endphp

<script>
document.addEventListener('DOMContentLoaded', () => {
    const orderData = @json($kitchenOrders);
    const state = {
        orders: orderData,
        isLive: true,
        audioEnabled: true,
        audioUnlocked: false,
        newOrderCount: 0,
        knownIds: new Set(orderData.map(o => o.id)),
    };

    const elements = {
        clock: document.getElementById('kds-clock'),
        liveDotOn: document.getElementById('kds-live-dot-on'),
        liveDotOff: document.getElementById('kds-live-dot-off'),
        liveLabel: document.getElementById('kds-live-label'),
        audioToggle: document.getElementById('kds-audio-toggle'),
        audioLabel: document.getElementById('kds-audio-label'),
        audioOnIcon: document.getElementById('kds-audio-icon-on'),
        audioOffIcon: document.getElementById('kds-audio-icon-off'),
        countNew: document.getElementById('kds-count-new'),
        countPreparing: document.getElementById('kds-count-preparing'),
        countReady: document.getElementById('kds-count-ready'),
        colNew: document.getElementById('col-new'),
        colPreparing: document.getElementById('col-preparing'),
        colReady: document.getElementById('col-ready'),
        colNewCount: document.getElementById('kds-col-new-count'),
        colPreparingCount: document.getElementById('kds-col-preparing-count'),
        colReadyCount: document.getElementById('kds-col-ready-count'),
        orderAlert: document.getElementById('kds-new-order-alert'),
        orderAlertCount: document.getElementById('kds-new-order-count'),
    };

    function escapeHtml(value) {
        if (value === null || value === undefined) {
            return '';
        }
        return String(value)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function updateClock() {
        const now = new Date();
        elements.clock.textContent = now.toLocaleTimeString('en-US', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
        });
    }

    function ordersByStatus(status) {
        return state.orders
            .filter(order => order.status === status)
            .sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
    }

    function countByStatus(status) {
        return ordersByStatus(status).length;
    }

    function minutesAgo(isoStr) {
        return Math.floor((Date.now() - new Date(isoStr).getTime()) / 60000);
    }

    function timerClass(isoStr, estPrep) {
        const diff = minutesAgo(isoStr);
        if (diff > estPrep + 5) return 'kds-timer-urgent';
        if (diff > estPrep) return 'kds-timer-warning';
        return 'kds-timer-ok';
    }

    function formatMinutes(isoStr) {
        const diff = minutesAgo(isoStr);
        return diff < 1 ? '< 1 min' : diff + ' min';
    }

    function orderTypeClasses(orderType) {
        switch (orderType) {
            case 'dine_in': return 'bg-amber-500/20 text-amber-300';
            case 'delivery': return 'bg-blue-500/20 text-blue-300';
            case 'takeaway': return 'bg-violet-500/20 text-violet-300';
            default: return 'bg-slate-500/20 text-slate-300';
        }
    }

    function orderTypeLabel(orderType) {
        return orderType ? String(orderType).replace('_', ' ') : '{{ __('order') }}';
    }

    function createOrderCard(order) {
        const card = document.createElement('div');
        card.id = `order-${order.id}`;
        card.className = `kds-card kds-card-${order.status} animate-slide-in-up`;

        const tableBadge = order.table_number
            ? `<span class="rounded-lg bg-slate-800 px-2 py-0.5 text-[11px] font-bold uppercase text-slate-300">T${escapeHtml(order.table_number)}</span>`
            : '';

        const badgeClass = orderTypeClasses(order.order_type);
        const badgeLabel = escapeHtml(orderTypeLabel(order.order_type));

        const itemsHtml = order.items && order.items.length > 0
            ? order.items.map(item => `
                <div class="flex items-baseline gap-2">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg bg-slate-800 text-xs font-bold text-slate-200">${escapeHtml(item.qty)}x</span>
                    <span class="text-sm font-semibold text-slate-100 leading-tight">${escapeHtml(item.name)}</span>
                </div>
            `).join('')
            : `<p class="text-xs text-slate-600">{{ __('No items') }}</p>`;

        const notesHtml = order.customer_notes
            ? `<div class="mb-3 rounded-xl border border-amber-500/20 bg-amber-500/5 px-3 py-2">
                    <p class="text-[11px] font-semibold uppercase tracking-wide text-amber-500/70">{{ __('Note') }}</p>
                    <p class="text-xs text-amber-200/80">${escapeHtml(order.customer_notes)}</p>
               </div>`
            : '';

        let actionHtml = '';
        if (order.status === 'new') {
            actionHtml = `<button type="button" data-kds-action="prepare" class="kds-btn-start">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /></svg>
                {{ __('Start Preparing') }}
            </button>`;
        } else if (order.status === 'preparing') {
            actionHtml = `<button type="button" data-kds-action="ready" class="kds-btn-ready">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ __('Mark as Ready') }}
            </button>`;
        } else if (order.status === 'ready') {
            actionHtml = `<button type="button" data-kds-action="complete" class="kds-btn-done">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" /></svg>
                {{ __('Delivered — Done!') }}
            </button>`;
        }

        card.innerHTML = `
            <div class="p-4">
                <div class="mb-3 flex items-start justify-between gap-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-base font-extrabold text-white">#${escapeHtml(order.public_ref)}</span>
                            ${tableBadge}
                        </div>
                        <div class="mt-1 flex items-center gap-2">
                            <span class="inline-flex items-center gap-1 rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase ${badgeClass}">${badgeLabel}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="${timerClass(order.created_at, order.est_prep_minutes)} text-lg font-extrabold tabular-nums">${escapeHtml(formatMinutes(order.created_at))}</div>
                        <div class="text-[10px] text-slate-600">{{ __('est.') }} ${escapeHtml(order.est_prep_minutes)} {{ __('min') }}</div>
                    </div>
                </div>
                <div class="mb-3 space-y-1.5 rounded-xl bg-black/30 p-3">
                    ${itemsHtml}
                </div>
                ${notesHtml}
                ${actionHtml}
            </div>
        `;

        const actionButton = card.querySelector('[data-kds-action]');
        if (actionButton) {
            actionButton.addEventListener('click', () => {
                const action = actionButton.getAttribute('data-kds-action');
                if (action === 'prepare') {
                    advanceOrder(order.id, 'preparing');
                } else if (action === 'ready') {
                    advanceOrder(order.id, 'ready');
                } else if (action === 'complete') {
                    advanceOrder(order.id, 'completed');
                }
            });
        }

        return card;
    }

    function updateLiveState() {
        if (state.isLive) {
            elements.liveDotOn.classList.remove('hidden');
            elements.liveDotOff.classList.add('hidden');
            elements.liveLabel.textContent = '{{ __('Live') }}';
            elements.liveLabel.classList.remove('text-red-400');
            elements.liveLabel.classList.add('text-emerald-400');
        } else {
            elements.liveDotOn.classList.add('hidden');
            elements.liveDotOff.classList.remove('hidden');
            elements.liveLabel.textContent = '{{ __('Reconnecting...') }}';
            elements.liveLabel.classList.remove('text-emerald-400');
            elements.liveLabel.classList.add('text-red-400');
        }
    }

    function showNewOrderAlert(count) {
        elements.orderAlertCount.textContent = count;
        elements.orderAlert.style.display = 'block';
        setTimeout(() => {
            elements.orderAlert.style.display = 'none';
        }, 4000);
    }

    function setAudioEnabled(enabled) {
        state.audioEnabled = enabled;
        elements.audioLabel.textContent = enabled ? '{{ __('Sound on') }}' : '{{ __('Sound off') }}';
        elements.audioToggle.title = enabled ? '{{ __('Sound on') }}' : '{{ __('Sound off') }}';
        elements.audioToggle.classList.toggle('text-amber-400', enabled);
        elements.audioToggle.classList.toggle('text-slate-500', !enabled);
        elements.audioOnIcon.classList.toggle('hidden', !enabled);
        elements.audioOffIcon.classList.toggle('hidden', enabled);
        elements.audioToggle.classList.toggle('border-amber-400/40', enabled);
        elements.audioToggle.classList.toggle('border-white/10', !enabled);
    }

    function renderEmptyState(message) {
        const wrapper = document.createElement('div');
        wrapper.className = 'flex flex-col items-center justify-center gap-2 py-16 text-slate-700';
        wrapper.innerHTML = `
            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <p class="text-sm font-medium">${escapeHtml(message)}</p>
        `;
        return wrapper;
    }

    function renderColumn(status, container, emptyMessage) {
        container.innerHTML = '';
        const orders = ordersByStatus(status);
        if (orders.length === 0) {
            container.appendChild(renderEmptyState(emptyMessage));
            return;
        }
        orders.forEach(order => container.appendChild(createOrderCard(order)));
    }

    function refreshBoard() {
        elements.countNew.textContent = countByStatus('new');
        elements.countPreparing.textContent = countByStatus('preparing');
        elements.countReady.textContent = countByStatus('ready');
        elements.colNewCount.textContent = countByStatus('new');
        elements.colPreparingCount.textContent = countByStatus('preparing');
        elements.colReadyCount.textContent = countByStatus('ready');

        renderColumn('new', elements.colNew, '{{ __('All clear') }}');
        renderColumn('preparing', elements.colPreparing, '{{ __('Nothing preparing') }}');
        renderColumn('ready', elements.colReady, '{{ __('No ready orders') }}');
    }

    function advanceOrder(orderId, nextStatus) {
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        const token = tokenMeta ? tokenMeta.content : '';

        fetch(`{{ url('/vendor/kitchen/orders') }}/${orderId}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ status: nextStatus }),
        }).then(async res => {
            if (res.ok) {
                if (nextStatus === 'completed') {
                    state.orders = state.orders.filter(o => o.id !== orderId);
                } else {
                    state.orders = state.orders.map(o => o.id === orderId ? { ...o, status: nextStatus } : o);
                }
                refreshBoard();
            } else {
                const body = await res.json().catch(() => ({}));
                console.error('KDS status update failed', res.status, body);
            }
        }).catch(error => {
            console.error('KDS advance error', error);
        });
    }

    function pollFeed() {
        fetch('{{ route('vendor.kitchen.feed') }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        }).then(async res => {
            if (!res.ok) throw new Error('Feed error');
            const data = await res.json();
            const incoming = data.orders || [];
            const newOnes = incoming.filter(o => !state.knownIds.has(o.id));
            if (newOnes.length > 0) {
                state.newOrderCount = newOnes.length;
                newOnes.forEach(o => state.knownIds.add(o.id));
                if (state.audioEnabled && state.audioUnlocked) {
                    playBeep();
                }
                showNewOrderAlert(state.newOrderCount);
            }
            state.orders = incoming;
            state.isLive = true;
            if (state.knownIds.size > 200) {
                state.knownIds = new Set(Array.from(state.knownIds).slice(-100));
            }
            refreshBoard();
            updateLiveState();
        }).catch(() => {
            state.isLive = false;
            updateLiveState();
        });
    }

    function playBeep() {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            [0, 0.18, 0.36].forEach(delay => {
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value = delay === 0 ? 880 : 1100;
                osc.type = 'sine';
                gain.gain.setValueAtTime(0.3, ctx.currentTime + delay);
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + delay + 0.25);
                osc.start(ctx.currentTime + delay);
                osc.stop(ctx.currentTime + delay + 0.25);
            });
        } catch (e) {}
    }

    elements.audioToggle.addEventListener('click', () => {
        setAudioEnabled(!state.audioEnabled);
    });

    document.addEventListener('click', () => {
        state.audioUnlocked = true;
    }, { once: true });

    updateClock();
    refreshBoard();
    updateLiveState();
    setAudioEnabled(true);

    setInterval(updateClock, 1000);
    setInterval(pollFeed, 8000);
});
</script>
</x-kitchen-layout>
