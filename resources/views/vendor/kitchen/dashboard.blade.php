<x-kitchen-layout :title="$restaurant->name . ' · Kitchen'">
<div
    x-data="kitchenDisplay()"
    x-init="init()"
    class="flex h-screen flex-col bg-[#06070d]"
>
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
            <span x-text="clock" class="font-mono text-xl font-bold text-slate-200"></span>

            {{-- Live indicator --}}
            <div class="flex items-center gap-2">
                <span x-show="isLive" class="flex h-2.5 w-2.5 animate-pulse rounded-full bg-emerald-400"></span>
                <span x-show="!isLive" class="flex h-2.5 w-2.5 rounded-full bg-red-500"></span>
                <span x-text="isLive ? '{{ __('Live') }}' : '{{ __('Reconnecting...') }}'" class="text-xs font-semibold" :class="isLive ? 'text-emerald-400' : 'text-red-400'"></span>
            </div>

            {{-- Audio toggle --}}
            <button
                @click="audioEnabled = !audioEnabled"
                :class="audioEnabled ? 'text-amber-400 border-amber-400/40' : 'text-slate-500 border-white/10'"
                class="flex items-center gap-1.5 rounded-lg border px-3 py-1.5 text-xs font-medium transition"
                :title="audioEnabled ? '{{ __('Sound on') }}' : '{{ __('Sound off') }}'"
            >
                <svg x-show="audioEnabled" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.114 5.636a9 9 0 010 12.728M16.463 8.288a5.25 5.25 0 010 7.424M6.75 8.25l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" /></svg>
                <svg x-show="!audioEnabled" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.25 9.75L19.5 12m0 0l2.25 2.25M19.5 12l2.25-2.25M19.5 12l-2.25 2.25m-10.5-6l4.72-4.72a.75.75 0 011.28.53v15.88a.75.75 0 01-1.28.53l-4.72-4.72H4.51c-.88 0-1.704-.507-1.938-1.354A9.01 9.01 0 012.25 12c0-.83.112-1.633.322-2.396C2.806 8.756 3.63 8.25 4.51 8.25H6.75z" /></svg>
                <span x-text="audioEnabled ? '{{ __('Sound on') }}' : '{{ __('Sound off') }}'"></span>
            </button>

            {{-- Order summary pills --}}
            <div class="flex items-center gap-2">
                <span class="rounded-full bg-amber-500/20 px-3 py-1 text-xs font-bold text-amber-400">
                    <span x-text="countByStatus('new')"></span> {{ __('New') }}
                </span>
                <span class="rounded-full bg-blue-500/20 px-3 py-1 text-xs font-bold text-blue-400">
                    <span x-text="countByStatus('preparing')"></span> {{ __('Prep') }}
                </span>
                <span class="rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-bold text-emerald-400">
                    <span x-text="countByStatus('ready')"></span> {{ __('Ready') }}
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
                <span class="ml-auto rounded-full bg-amber-500/20 px-2 py-0.5 text-xs font-bold text-amber-400" x-text="countByStatus('new')"></span>
            </div>
            <div class="kitchen-scrollbar flex-1 space-y-3 overflow-y-auto p-3" id="col-new">
                <template x-for="order in ordersByStatus('new')" :key="order.id">
                    <div class="kds-card kds-card-new animate-slide-in-up" :id="'order-' + order.id">
                        @include('vendor.kitchen._card', ['statusClass' => 'new'])
                    </div>
                </template>
                <div x-show="countByStatus('new') === 0" class="flex flex-col items-center justify-center gap-2 py-16 text-slate-700">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-sm font-medium">{{ __('All clear') }}</p>
                </div>
            </div>
        </div>

        {{-- PREPARING column --}}
        <div class="kds-column-preparing flex w-1/3 flex-col border-r border-white/5">
            <div class="flex items-center gap-2 bg-blue-500/10 px-4 py-3">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-blue-500/30 text-blue-400">
                    <svg class="h-3 w-3 animate-spin" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" /></svg>
                </span>
                <h2 class="text-sm font-bold uppercase tracking-widest text-blue-400">{{ __('Preparing') }}</h2>
                <span class="ml-auto rounded-full bg-blue-500/20 px-2 py-0.5 text-xs font-bold text-blue-400" x-text="countByStatus('preparing')"></span>
            </div>
            <div class="kitchen-scrollbar flex-1 space-y-3 overflow-y-auto p-3">
                <template x-for="order in ordersByStatus('preparing')" :key="order.id">
                    <div class="kds-card kds-card-preparing animate-slide-in-up" :id="'order-' + order.id">
                        @include('vendor.kitchen._card', ['statusClass' => 'preparing'])
                    </div>
                </template>
                <div x-show="countByStatus('preparing') === 0" class="flex flex-col items-center justify-center gap-2 py-16 text-slate-700">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <p class="text-sm font-medium">{{ __('Nothing preparing') }}</p>
                </div>
            </div>
        </div>

        {{-- READY column --}}
        <div class="kds-column-ready flex w-1/3 flex-col">
            <div class="flex items-center gap-2 bg-emerald-500/10 px-4 py-3">
                <span class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500/30 text-emerald-400">
                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                </span>
                <h2 class="text-sm font-bold uppercase tracking-widest text-emerald-400">{{ __('Ready') }}</h2>
                <span class="ml-auto rounded-full bg-emerald-500/20 px-2 py-0.5 text-xs font-bold text-emerald-400" x-text="countByStatus('ready')"></span>
            </div>
            <div class="kitchen-scrollbar flex-1 space-y-3 overflow-y-auto p-3">
                <template x-for="order in ordersByStatus('ready')" :key="order.id">
                    <div class="kds-card kds-card-ready animate-slide-in-up" :id="'order-' + order.id">
                        @include('vendor.kitchen._card', ['statusClass' => 'ready'])
                    </div>
                </template>
                <div x-show="countByStatus('ready') === 0" class="flex flex-col items-center justify-center gap-2 py-16 text-slate-700">
                    <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" /></svg>
                    <p class="text-sm font-medium">{{ __('No ready orders') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- ── New order notification overlay ─────────────── --}}
    <div
        x-show="showNewOrderAlert"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        style="display:none;"
        class="pointer-events-none fixed bottom-6 left-1/2 z-50 -translate-x-1/2"
    >
        <div class="flex items-center gap-3 rounded-2xl border border-amber-400/50 bg-amber-500/20 px-6 py-4 shadow-glow-amber backdrop-blur-xl">
            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-500/30 text-amber-400 text-lg">🔔</span>
            <div>
                <p class="font-bold text-amber-300">{{ __('New Order!') }}</p>
                <p class="text-xs text-amber-400/80" x-text="newOrderCount + ' {{ __('new order(s) received') }}'"></p>
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
function kitchenDisplay() {
    return {
        orders: @json($kitchenOrders),

        clock: '',
        isLive: true,
        audioEnabled: true,
        audioUnlocked: false,

        showNewOrderAlert: false,
        newOrderCount: 0,

        knownIds: new Set(),
        pollInterval: null,
        clockInterval: null,

        init() {
            this.orders.forEach(o => this.knownIds.add(o.id));

            this.updateClock();
            this.clockInterval = setInterval(() => this.updateClock(), 1000);

            this.pollInterval = setInterval(() => this.poll(), 8000);

            // unlock audio on first interaction
            document.addEventListener('click', () => {
                this.audioUnlocked = true;
            }, { once: true });
        },

        updateClock() {
            const now = new Date();
            this.clock = now.toLocaleTimeString('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            });
        },

        async poll() {
            try {
                const res = await fetch('{{ route('vendor.kitchen.feed') }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!res.ok) throw new Error('Feed error');

                const data = await res.json();
                const incoming = data.orders || [];

                const newOnes = incoming.filter(o => !this.knownIds.has(o.id));

                if (newOnes.length > 0) {
                    this.newOrderCount = newOnes.length;

                    newOnes.forEach(o => this.knownIds.add(o.id));

                    this.triggerNewOrderAlert();

                    if (this.audioEnabled && this.audioUnlocked) {
                        this.playBeep();
                    }
                }

                this.orders = incoming;
                this.isLive = true;

                // prevent Set from growing infinitely
                if (this.knownIds.size > 200) {
                    this.knownIds = new Set(
                        Array.from(this.knownIds).slice(-100)
                    );
                }

            } catch (e) {
                this.isLive = false;
            }
        },

        triggerNewOrderAlert() {
            this.showNewOrderAlert = true;

            setTimeout(() => {
                this.showNewOrderAlert = false;
            }, 4000);
        },

        playBeep() {
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
                    gain.gain.exponentialRampToValueAtTime(
                        0.001,
                        ctx.currentTime + delay + 0.25
                    );

                    osc.start(ctx.currentTime + delay);
                    osc.stop(ctx.currentTime + delay + 0.25);
                });

            } catch (e) {}
        },

        ordersByStatus(status) {
            return this.orders
                .filter(o => o.status === status)
                .sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        },

        countByStatus(status) {
            return this.orders.filter(o => o.status === status).length;
        },

        minutesAgo(isoStr) {
            return Math.floor((Date.now() - new Date(isoStr).getTime()) / 60000);
        },

        timerClass(isoStr, estPrep) {
            const diff = this.minutesAgo(isoStr);

            if (diff > estPrep + 5) return 'kds-timer-urgent';
            if (diff > estPrep) return 'kds-timer-warning';

            return 'kds-timer-ok';
        },

        formatMinutes(isoStr) {
            const diff = this.minutesAgo(isoStr);

            return diff < 1 ? '< 1 min' : diff + ' min';
        },

        async advance(orderId, nextStatus) {
            try {
                const token = document.querySelector('meta[name="csrf-token"]').content;

                const res = await fetch(
                    `{{ url('/vendor/kitchen/orders') }}/${orderId}/status`,
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ status: nextStatus }),
                    }
                );

                if (res.ok) {
                    if (nextStatus === 'completed') {
                        // Remove from the board entirely
                        this.orders = this.orders.filter(o => o.id !== orderId);
                    } else {
                        // Replace the object so Alpine's proxy detects the change
                        // and re-evaluates ordersByStatus() for each column
                        const idx = this.orders.findIndex(o => o.id === orderId);
                        if (idx !== -1) {
                            this.orders[idx] = { ...this.orders[idx], status: nextStatus };
                        }
                    }
                } else {
                    const body = await res.json().catch(() => ({}));
                    console.error('KDS status update failed', res.status, body);
                }

            } catch (e) {
                console.error('KDS advance error', e);
            }
        }
    };
}
</script>
</x-kitchen-layout>
