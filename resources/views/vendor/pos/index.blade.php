<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS — {{ $restaurant->name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:500,600,700&family=inter:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="page-kitchen font-hub antialiased h-screen overflow-hidden text-slate-100">

<div
    x-data="posScreen()"
    x-init="init()"
    class="flex h-screen flex-col bg-[#07080f]"
>
    {{-- ── Top bar ─────────────────────────────── --}}
    <header class="flex h-14 shrink-0 items-center justify-between gap-3 border-b border-white/10 bg-slate-950/90 px-5 backdrop-blur-md">
        <div class="flex items-center gap-3">
            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-gradient-to-br from-brand-500 to-orange-600">
                <svg class="h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
            </span>
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-slate-400">POS</p>
                <p class="text-sm font-bold leading-tight text-white">{{ $restaurant->name }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span x-text="clock" class="font-mono text-lg font-bold text-slate-300"></span>
            <a href="{{ route('vendor.kitchen') }}" class="rounded-lg border border-amber-500/30 bg-amber-500/10 px-3 py-1.5 text-xs font-medium text-amber-300 transition hover:bg-amber-500/20">
                🍳 {{ __('Kitchen') }}
            </a>
            <a href="{{ route('vendor.dashboard') }}" class="rounded-lg border border-white/10 px-3 py-1.5 text-xs text-slate-400 transition hover:text-slate-200">
                ← {{ __('Dashboard') }}
            </a>
        </div>
    </header>

    {{-- ── Main split ──────────────────────────── --}}
    <div class="flex flex-1 overflow-hidden">

        {{-- Left: Menu browser ──────────────────── --}}
        <div class="flex w-[58%] flex-col border-r border-white/5 overflow-hidden">

            {{-- Category tabs --}}
            <div class="flex items-center gap-1.5 overflow-x-auto border-b border-white/5 bg-slate-950/60 px-4 py-3" style="scrollbar-width:none">
                <button
                    @click="activeCategory = null"
                    :class="activeCategory === null ? 'bg-brand-500 text-white border-brand-500/60' : 'bg-white/5 text-slate-400 border-white/10 hover:border-brand-500/30 hover:text-slate-200'"
                    class="shrink-0 rounded-xl border px-4 py-2 text-xs font-bold uppercase tracking-wide transition"
                >{{ __('All') }}</button>
                @foreach ($categories as $cat)
                    <button
                        @click="activeCategory = {{ $cat->id }}"
                        :class="activeCategory === {{ $cat->id }} ? 'bg-brand-500 text-white border-brand-500/60' : 'bg-white/5 text-slate-400 border-white/10 hover:border-brand-500/30 hover:text-slate-200'"
                        class="shrink-0 rounded-xl border px-4 py-2 text-xs font-bold uppercase tracking-wide transition"
                    >{{ $cat->name }}</button>
                @endforeach
            </div>

            {{-- Search --}}
            <div class="border-b border-white/5 bg-slate-950/40 px-4 py-2">
                <input
                    x-model="search"
                    type="search"
                    placeholder="{{ __('Search items…') }}"
                    class="w-full rounded-xl border border-white/10 bg-black/30 px-4 py-2.5 text-sm text-slate-200 placeholder-slate-600 focus:border-brand-500/40 focus:outline-none focus:ring-1 focus:ring-brand-500/25"
                >
            </div>

            {{-- Items grid --}}
            <div class="kitchen-scrollbar flex-1 overflow-y-auto p-4">
                <div class="grid grid-cols-3 gap-3 xl:grid-cols-4">
                    @foreach ($categories as $cat)
                        @foreach ($cat->menuItems as $item)
                            <button
                                @click="addToCart({{ json_encode(['id' => $item->id, 'name' => $item->name, 'price' => (float)$item->price, 'category_id' => $item->category_id]) }})"
                                x-show="(activeCategory === null || activeCategory === {{ $cat->id }}) && matchesSearch('{{ addslashes($item->name) }}')"
                                class="pos-item-card {{ ! $item->is_available ? 'pos-item-card-unavailable' : '' }}"
                                {{ ! $item->is_available ? 'disabled' : '' }}
                            >
                                @if ($item->image)
                                    <img src="{{ $item->image }}" alt="{{ $item->name }}" class="h-16 w-full rounded-xl object-cover">
                                @else
                                    <div class="flex h-16 w-full items-center justify-center rounded-xl bg-brand-500/10 text-2xl">🍽️</div>
                                @endif
                                <div class="w-full">
                                    <p class="text-xs font-semibold leading-tight text-slate-200">{{ $item->name }}</p>
                                    <p class="mt-0.5 text-sm font-bold text-brand-400">{{ $restaurant->currency }} {{ number_format((float)$item->price, 2) }}</p>
                                </div>
                            </button>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Right: Cart & order ──────────────────── --}}
        <div class="flex w-[42%] flex-col overflow-hidden bg-slate-950/70">

            {{-- Cart items --}}
            <div class="kitchen-scrollbar flex-1 overflow-y-auto p-4 space-y-2">
                <div x-show="cart.length === 0" class="flex flex-col items-center justify-center gap-3 py-16 text-slate-700">
                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                    <p class="text-sm font-medium">{{ __('Cart is empty') }}</p>
                    <p class="text-xs text-slate-600">{{ __('Tap items on the left to add') }}</p>
                </div>

                <template x-for="(line, idx) in cart" :key="idx">
                    <div class="pos-cart-row">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-slate-200 truncate" x-text="line.name"></p>
                            <p class="text-xs text-brand-400 font-bold" x-text="'{{ $restaurant->currency }} ' + (line.price * line.qty).toFixed(2)"></p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button @click="decreaseQty(idx)" class="flex h-7 w-7 items-center justify-center rounded-lg bg-white/10 text-slate-300 hover:bg-red-500/20 hover:text-red-400 transition">−</button>
                            <span class="w-6 text-center text-sm font-bold text-white" x-text="line.qty"></span>
                            <button @click="increaseQty(idx)" class="flex h-7 w-7 items-center justify-center rounded-lg bg-white/10 text-slate-300 hover:bg-emerald-500/20 hover:text-emerald-400 transition">+</button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Order details & totals ─────────── --}}
            <div class="shrink-0 border-t border-white/10 bg-slate-950/90 p-4 space-y-4">

                {{-- Order type --}}
                <div class="grid grid-cols-3 gap-2">
                    @foreach (['dine_in' => ['🍽️', __('Dine In')], 'takeaway' => ['🥡', __('Takeaway')], 'delivery' => ['🛵', __('Delivery')]] as $type => [$icon, $label])
                        <button
                            @click="orderType = '{{ $type }}'"
                            :class="orderType === '{{ $type }}' ? 'border-brand-500/60 bg-brand-500/20 text-brand-300' : 'border-white/10 text-slate-500 hover:border-white/20 hover:text-slate-300'"
                            class="flex flex-col items-center gap-1 rounded-xl border py-2.5 text-xs font-semibold transition"
                        >
                            <span class="text-base">{{ $icon }}</span>
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                {{-- Customer info --}}
                <div class="grid grid-cols-2 gap-2">
                    <input x-model="customerName" type="text" placeholder="{{ __('Customer name') }}"
                        class="rounded-xl border border-white/10 bg-black/30 px-3 py-2 text-xs text-slate-200 placeholder-slate-600 focus:border-brand-500/40 focus:outline-none">
                    <input x-model="tableNumber" type="text" placeholder="{{ __('Table #') }}"
                        class="rounded-xl border border-white/10 bg-black/30 px-3 py-2 text-xs text-slate-200 placeholder-slate-600 focus:border-brand-500/40 focus:outline-none">
                </div>
                <input x-model="customerNotes" type="text" placeholder="{{ __('Notes for kitchen…') }}"
                    class="w-full rounded-xl border border-white/10 bg-black/30 px-3 py-2 text-xs text-slate-200 placeholder-slate-600 focus:border-brand-500/40 focus:outline-none">

                {{-- Totals --}}
                <div class="rounded-xl bg-black/20 px-4 py-3 space-y-1.5 text-sm">
                    <div class="flex justify-between text-slate-400">
                        <span>{{ __('Subtotal') }}</span>
                        <span class="font-mono" x-text="'{{ $restaurant->currency }} ' + subtotal().toFixed(2)"></span>
                    </div>
                    @if ((float)$restaurant->tax_rate_percent > 0)
                        <div class="flex justify-between text-slate-500 text-xs">
                            <span>{{ __('Tax') }} ({{ $restaurant->tax_rate_percent }}%)</span>
                            <span class="font-mono" x-text="'{{ $restaurant->currency }} ' + tax().toFixed(2)"></span>
                        </div>
                    @endif
                    <div class="flex justify-between border-t border-white/10 pt-2 font-bold text-white">
                        <span>{{ __('Total') }}</span>
                        <span class="font-mono text-brand-400 text-base" x-text="'{{ $restaurant->currency }} ' + grandTotal().toFixed(2)"></span>
                    </div>
                </div>

                {{-- Submit --}}
                <button
                    @click="placeOrder()"
                    :disabled="cart.length === 0 || isSubmitting"
                    class="btn-orange w-full rounded-2xl py-4 text-base font-extrabold tracking-wide disabled:cursor-not-allowed disabled:opacity-40"
                >
                    <span x-show="!isSubmitting">🧾 {{ __('Place Order') }}</span>
                    <span x-show="isSubmitting">{{ __('Placing…') }}</span>
                </button>

                {{-- Last order toast --}}
                <div
                    x-show="lastOrder"
                    x-transition
                    style="display:none"
                    class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-300"
                >
                    ✅ {{ __('Order') }} <span class="font-mono font-bold" x-text="'#' + lastOrder"></span> {{ __('placed!') }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function posScreen() {
    const TAX_RATE = {{ (float)($restaurant->tax_rate_percent ?? 0) }} / 100;
    const CSRF = document.querySelector('meta[name="csrf-token"]').content;

    return {
        cart: [],
        activeCategory: null,
        search: '',
        orderType: 'dine_in',
        customerName: '',
        customerNotes: '',
        tableNumber: '',
        isSubmitting: false,
        lastOrder: null,
        clock: '',

        init() {
            this.updateClock();
            setInterval(() => this.updateClock(), 1000);
        },

        updateClock() {
            this.clock = new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false });
        },

        matchesSearch(name) {
            if (!this.search) return true;
            return name.toLowerCase().includes(this.search.toLowerCase());
        },

        addToCart(item) {
            const existing = this.cart.find(l => l.id === item.id);
            if (existing) {
                existing.qty++;
            } else {
                this.cart.push({ ...item, qty: 1 });
            }
        },

        increaseQty(idx) {
            this.cart[idx].qty++;
        },

        decreaseQty(idx) {
            if (this.cart[idx].qty > 1) {
                this.cart[idx].qty--;
            } else {
                this.cart.splice(idx, 1);
            }
        },

        subtotal() {
            return this.cart.reduce((sum, l) => sum + l.price * l.qty, 0);
        },

        tax() {
            return Math.round(this.subtotal() * TAX_RATE * 100) / 100;
        },

        grandTotal() {
            return this.subtotal() + this.tax();
        },

        async placeOrder() {
            if (this.cart.length === 0 || this.isSubmitting) return;
            this.isSubmitting = true;
            this.lastOrder = null;

            try {
                const res = await fetch('{{ route('vendor.pos.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        order_type: this.orderType,
                        customer_name: this.customerName || null,
                        table_number: this.tableNumber || null,
                        customer_notes: this.customerNotes || null,
                        items: this.cart.map(l => ({ id: l.id, qty: l.qty })),
                    }),
                });
                const data = await res.json();
                if (res.ok && data.ok) {
                    this.lastOrder = data.order_ref;
                    this.cart = [];
                    this.customerName = '';
                    this.tableNumber = '';
                    this.customerNotes = '';
                    setTimeout(() => this.lastOrder = null, 5000);
                } else {
                    alert(data.message || 'Error placing order');
                }
            } catch {
                alert('Network error');
            } finally {
                this.isSubmitting = false;
            }
        },
    };
}
</script>
</body>
</html>
