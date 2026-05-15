@extends('layouts.landing')

@section('title', config('app.name') . ' — Restaurant Management Platform')

@section('content')

{{-- ── HERO ──────────────────────────────────────────────────── --}}
<section class="relative overflow-hidden pt-28 pb-20 lg:pt-40 lg:pb-28">
    {{-- Glow blobs --}}
    <div class="pointer-events-none absolute -top-40 left-1/2 h-[600px] w-[700px] -translate-x-1/2 rounded-full bg-brand-500/10 blur-[120px]"></div>
    <div class="pointer-events-none absolute -bottom-20 left-0 h-[400px] w-[400px] -translate-x-1/3 rounded-full bg-orange-600/8 blur-[100px]"></div>

    <div class="land-section text-center">
        <div class="inline-flex animate-fade-in">
            <span class="land-badge">🚀 Multi-Vendor SaaS Platform</span>
        </div>

        <h1 class="land-h1 mt-6 animate-slide-in-up">
            The <span class="text-gradient-orange">smarter way</span><br class="hidden sm:block"> to run your restaurant
        </h1>

        <p class="mx-auto mt-6 max-w-2xl animate-slide-in-up text-lg leading-relaxed text-slate-400" style="animation-delay:0.1s">
            QR digital menus · Kitchen Display · POS · Real-time analytics · Multi-branch management.
            Everything your restaurant needs — in one beautiful platform.
        </p>

        <div class="mt-10 flex flex-wrap items-center justify-center gap-4 animate-slide-in-up" style="animation-delay:0.2s">
            <a href="{{ route('register') }}" class="btn-orange rounded-2xl px-8 py-4 text-base font-extrabold shadow-glow-orange">
                Start free — no credit card
            </a>
            <a href="{{ url('/') }}#features" class="btn-ghost rounded-2xl px-8 py-4 text-base">
                See all features →
            </a>
        </div>

        {{-- Trust badges --}}
        <div class="mt-12 flex flex-wrap items-center justify-center gap-6 text-slate-600 text-xs font-medium">
            <span class="flex items-center gap-1.5">✓ <span>Free 14-day trial</span></span>
            <span class="flex items-center gap-1.5">✓ <span>No setup fee</span></span>
            <span class="flex items-center gap-1.5">✓ <span>Cancel anytime</span></span>
            <span class="flex items-center gap-1.5">✓ <span>Multi-branch ready</span></span>
        </div>
    </div>

    {{-- Hero mockup / dashboard preview --}}
    <div class="land-section mt-16 px-4">
        <div class="relative mx-auto max-w-5xl">
            <div class="rounded-3xl border border-white/10 bg-gradient-to-br from-slate-950 to-[#07080f] p-1 shadow-2xl ring-1 ring-white/5">
                {{-- Fake browser chrome --}}
                <div class="flex items-center gap-1.5 rounded-t-2xl border-b border-white/8 bg-slate-900/80 px-4 py-3">
                    <span class="h-3 w-3 rounded-full bg-red-500/70"></span>
                    <span class="h-3 w-3 rounded-full bg-amber-500/70"></span>
                    <span class="h-3 w-3 rounded-full bg-emerald-500/70"></span>
                    <span class="ml-3 flex-1 rounded-lg bg-slate-800/80 py-1 px-3 text-xs text-slate-500">app.{{ strtolower(config('app.name')) }}.io/vendor/dashboard</span>
                </div>
                {{-- Dashboard mockup --}}
                <div class="grid grid-cols-4 gap-3 rounded-b-2xl bg-[#07080f] p-4">
                    {{-- Sidebar mock --}}
                    <div class="col-span-1 space-y-2 rounded-2xl border border-white/8 bg-slate-950/80 p-3">
                        <div class="h-8 rounded-xl bg-brand-500/20"></div>
                        @foreach (range(1,6) as $i)
                            <div class="flex items-center gap-2 rounded-xl px-2 py-1.5 {{ $i === 2 ? 'bg-brand-500/15' : '' }}">
                                <div class="h-4 w-4 rounded bg-slate-800"></div>
                                <div class="h-2.5 flex-1 rounded bg-slate-800 {{ $i === 2 ? 'bg-brand-500/40' : '' }}"></div>
                            </div>
                        @endforeach
                    </div>
                    {{-- Main content mock --}}
                    <div class="col-span-3 space-y-3">
                        {{-- KPI row --}}
                        <div class="grid grid-cols-4 gap-3">
                            @foreach ([['brand-500', 'Today'], ['blue-500', '7 days'], ['emerald-500', 'Orders'], ['violet-500', 'Staff']] as [$color, $label])
                                <div class="rounded-2xl border border-{{ $color }}/20 bg-{{ $color }}/10 p-3">
                                    <div class="h-2 w-12 rounded bg-{{ $color }}/40"></div>
                                    <div class="mt-2 h-5 w-16 rounded bg-white/20"></div>
                                    <div class="mt-1 h-2 w-10 rounded bg-slate-700"></div>
                                </div>
                            @endforeach
                        </div>
                        {{-- Chart mock --}}
                        <div class="rounded-2xl border border-white/8 bg-slate-950/60 p-4">
                            <div class="h-2.5 w-32 rounded bg-slate-700 mb-4"></div>
                            <div class="flex items-end gap-2 h-20">
                                @foreach ([30, 55, 40, 75, 60, 85, 70] as $h)
                                    <div class="flex-1 rounded-t-lg bg-gradient-to-t from-brand-600/60 to-brand-400/80" style="height:{{ $h }}%"></div>
                                @endforeach
                            </div>
                        </div>
                        {{-- Order list mock --}}
                        <div class="rounded-2xl border border-white/8 bg-slate-950/60 p-3 space-y-2">
                            @foreach (range(1,3) as $i)
                                <div class="flex items-center gap-3 rounded-xl bg-white/[0.02] px-3 py-2">
                                    <div class="h-5 w-16 rounded bg-slate-800 font-mono"></div>
                                    <div class="h-5 w-12 rounded-full bg-amber-500/20"></div>
                                    <div class="ml-auto h-4 w-16 rounded bg-slate-800"></div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── FEATURES ──────────────────────────────────────────────── --}}
<section id="features" class="py-20 lg:py-28">
    <div class="land-section">
        <div class="text-center">
            <span class="land-badge">Features</span>
            <h2 class="land-h2 mt-4">Everything your restaurant needs</h2>
            <p class="mx-auto mt-4 max-w-xl text-slate-400">From QR menus to real-time kitchen displays — all tightly integrated and ready to use from day one.</p>
        </div>

        <div class="mt-16 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['🔗', 'QR Digital Menu', 'Customers scan a QR code and browse your full menu — no app install needed. Real-time updates instantly.'],
                ['🍳', 'Kitchen Display System', 'Live order feed for your kitchen staff. Audio alerts, priority sorting, estimated prep time. Works on any screen.'],
                ['🖥️', 'Point of Sale (POS)', 'Fast, touch-friendly POS for your staff. Place orders in seconds, track in real time.'],
                ['📊', 'Smart Analytics', 'Revenue trends, top items, order volume charts. Make data-driven decisions every day.'],
                ['🏢', 'Multi-Branch Support', 'Manage multiple locations from one account. Per-branch staff, menus, and reporting.'],
                ['🎟️', 'Coupons & Promotions', 'Create discount codes and promotions. Percentage or fixed amount — with usage limits.'],
                ['👥', 'Staff Management', 'Invite staff, assign roles (cashier, kitchen, manager), control access per branch.'],
                ['🛵', 'Delivery Zones', 'Set delivery fee rules by zone and distance. Fully customizable for your city.'],
                ['📱', 'Mobile Ready', 'All dashboards are fully responsive. Manage from your phone, tablet, or large kitchen monitor.'],
            ] as [$icon, $title, $desc])
                <div class="land-feature-card">
                    <div class="mb-4 text-3xl">{{ $icon }}</div>
                    <h3 class="text-base font-bold text-white">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── HOW IT WORKS ──────────────────────────────────────────── --}}
<section id="how-it-works" class="py-20 bg-white/[0.015] border-y border-white/8">
    <div class="land-section">
        <div class="text-center">
            <span class="land-badge">Process</span>
            <h2 class="land-h2 mt-4">Up and running in minutes</h2>
        </div>

        <div class="mt-14 grid gap-8 md:grid-cols-3">
            @foreach ([
                ['01', 'Create your restaurant', 'Sign up, add your restaurant name, upload your logo, set your currency. Takes less than 2 minutes.', 'brand-500'],
                ['02', 'Add your menu', 'Create categories, add items with images and prices. Go live with your QR menu immediately.', 'blue-500'],
                ['03', 'Start receiving orders', 'Customers scan your QR code and order. Your kitchen display lights up. That\'s it.', 'emerald-500'],
            ] as [$step, $title, $desc, $color])
                <div class="relative">
                    <div class="flex items-center gap-4 mb-4">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-{{ $color }}/15 text-{{ $color }} text-xl font-extrabold">{{ $step }}</span>
                        @if ($loop->index < 2)
                            <div class="hidden flex-1 h-px bg-gradient-to-r from-white/10 to-transparent md:block"></div>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-white">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-500">{{ $desc }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── KITCHEN KDS SPOTLIGHT ─────────────────────────────────── --}}
<section class="py-20 lg:py-28">
    <div class="land-section">
        <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
            <div>
                <span class="land-badge">Kitchen Display System</span>
                <h2 class="land-h2 mt-4">Real-time kitchen management</h2>
                <p class="mt-4 text-slate-400 leading-relaxed">Your kitchen staff sees every order the moment it's placed. Orders are organized by status, color-coded for urgency, and come with audio alerts — so nothing gets missed.</p>
                <ul class="mt-6 space-y-3">
                    @foreach (['🔔 Instant audio notifications on new orders', '🎨 Color-coded priority (New → Preparing → Ready)', '⏱️ Per-order timer and estimated prep time', '📂 Grouped by category and order type', '📱 Works on tablets, TVs, and kitchen monitors'] as $feature)
                        <li class="flex items-center gap-3 text-sm text-slate-300">
                            <span class="h-1.5 w-1.5 rounded-full bg-brand-500 shrink-0"></span>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
                <a href="{{ route('register') }}" class="btn-orange mt-8 inline-flex rounded-2xl px-6 py-3 font-bold">
                    Try Kitchen Display →
                </a>
            </div>
            {{-- KDS mockup --}}
            <div class="relative">
                <div class="rounded-3xl border border-white/10 bg-[#06070d] p-5 shadow-2xl">
                    <div class="mb-3 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 animate-pulse rounded-full bg-emerald-400"></span>
                            <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest">KITCHEN DISPLAY</span>
                        </div>
                        <span class="font-mono text-xs text-slate-500">14:32:07</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2 text-xs">
                        {{-- NEW column --}}
                        <div class="rounded-2xl border-t-4 border-amber-500 bg-amber-500/5 p-2">
                            <p class="font-bold uppercase tracking-wide text-amber-400 text-[10px] mb-2">● New (2)</p>
                            <div class="space-y-2">
                                <div class="rounded-xl border border-amber-500/30 bg-slate-950/60 p-2.5">
                                    <div class="flex justify-between items-start">
                                        <span class="font-mono font-extrabold text-white">#A1F3</span>
                                        <span class="text-red-400 font-bold text-xs animate-pulse">8 min</span>
                                    </div>
                                    <p class="text-slate-400 mt-1">2x Burger, 1x Fries</p>
                                    <div class="mt-2 h-6 w-full rounded-lg bg-gradient-to-r from-amber-600 to-orange-500 text-center text-[10px] font-bold text-white leading-6">START →</div>
                                </div>
                                <div class="rounded-xl border border-amber-500/20 bg-slate-950/60 p-2.5">
                                    <div class="flex justify-between items-start">
                                        <span class="font-mono font-extrabold text-white">#B2G7</span>
                                        <span class="text-amber-400 font-bold text-xs">3 min</span>
                                    </div>
                                    <p class="text-slate-400 mt-1">1x Pizza Margherita</p>
                                </div>
                            </div>
                        </div>
                        {{-- PREPARING column --}}
                        <div class="rounded-2xl border-t-4 border-blue-500 bg-blue-500/5 p-2">
                            <p class="font-bold uppercase tracking-wide text-blue-400 text-[10px] mb-2">⟳ Preparing (1)</p>
                            <div class="rounded-xl border border-blue-500/30 bg-slate-950/60 p-2.5">
                                <div class="flex justify-between items-start">
                                    <span class="font-mono font-extrabold text-white">#C9K2</span>
                                    <span class="text-blue-400 font-bold text-xs">5 min</span>
                                </div>
                                <p class="text-slate-400 mt-1">3x Shawarma</p>
                                <div class="mt-2 h-6 w-full rounded-lg bg-gradient-to-r from-blue-600 to-indigo-600 text-center text-[10px] font-bold text-white leading-6">MARK READY</div>
                            </div>
                        </div>
                        {{-- READY column --}}
                        <div class="rounded-2xl border-t-4 border-emerald-500 bg-emerald-500/5 p-2">
                            <p class="font-bold uppercase tracking-wide text-emerald-400 text-[10px] mb-2">✓ Ready (1)</p>
                            <div class="rounded-xl border border-emerald-500/40 bg-slate-950/60 p-2.5 shadow-glow-green">
                                <div class="flex justify-between items-start">
                                    <span class="font-mono font-extrabold text-white">#D4M5</span>
                                    <span class="text-emerald-400 font-bold text-xs">12 min</span>
                                </div>
                                <p class="text-slate-400 mt-1">1x Salad, 2x Juice</p>
                                <div class="mt-2 h-6 w-full rounded-lg bg-gradient-to-r from-emerald-600 to-teal-600 text-center text-[10px] font-bold text-white leading-6">DONE ✓</div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Floating alert --}}
                <div class="absolute -top-3 -right-3 flex items-center gap-2 rounded-2xl border border-amber-400/40 bg-amber-500/20 px-4 py-2.5 shadow-glow-amber backdrop-blur-xl">
                    <span class="text-lg">🔔</span>
                    <div>
                        <p class="text-xs font-bold text-amber-300">New Order!</p>
                        <p class="text-[10px] text-amber-400/70">Table 5 · Dine-in</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── PRICING TEASER ────────────────────────────────────────── --}}
<section class="py-20 bg-white/[0.015] border-y border-white/8">
    <div class="land-section text-center">
        <span class="land-badge">Pricing</span>
        <h2 class="land-h2 mt-4">Simple, transparent pricing</h2>
        <p class="mx-auto mt-4 max-w-xl text-slate-400">Start free, scale as you grow. No hidden fees, no setup costs.</p>

        @if ($plans->isNotEmpty())
            <div class="mt-14 grid gap-6 md:grid-cols-{{ min(3, $plans->count()) }} max-w-4xl mx-auto">
                @foreach ($plans->take(3) as $i => $plan)
                    <div class="price-card {{ $i === 1 ? 'price-card-popular' : '' }}">
                        @if ($i === 1)
                            <span class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full border border-brand-500/50 bg-brand-500/20 px-4 py-1 text-xs font-bold text-brand-300 backdrop-blur-sm">Most popular</span>
                        @endif
                        <h3 class="text-lg font-bold text-white">{{ $plan->name }}</h3>
                        <div class="mt-4 flex items-baseline gap-1">
                            <span class="text-4xl font-extrabold {{ $i === 1 ? 'text-gradient-orange' : 'text-white' }}">
                                {{ $plan->currency }} {{ number_format((float) $plan->price_amount, 0) }}
                            </span>
                            <span class="text-slate-500 text-sm">/ {{ $plan->interval?->value }}</span>
                        </div>
                        @if ($plan->features)
                            <ul class="mt-5 space-y-2 text-sm text-left text-slate-400">
                                @foreach (array_slice((array)$plan->features, 0, 5) as $feature)
                                    <li class="flex items-center gap-2">
                                        <svg class="h-4 w-4 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{ route('register') }}" class="mt-6 block {{ $i === 1 ? 'btn-orange' : 'btn-ghost' }} w-full rounded-xl py-2.5 text-sm font-bold text-center">
                            Get started
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="mt-14 grid gap-6 md:grid-cols-3 max-w-4xl mx-auto">
                @foreach ([['Starter', '49', ['1 restaurant', '3 staff accounts', 'QR Menu', 'Basic analytics'], false], ['Growth', '99', ['3 restaurants', '10 staff accounts', 'Kitchen Display', 'POS system', 'Coupons & promos'], true], ['Enterprise', '249', ['Unlimited restaurants', 'Unlimited staff', 'All features', 'Priority support', 'Custom branding'], false]] as [$name, $price, $features, $popular])
                    <div class="price-card {{ $popular ? 'price-card-popular' : '' }}">
                        @if ($popular)
                            <span class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full border border-brand-500/50 bg-brand-500/20 px-4 py-1 text-xs font-bold text-brand-300 backdrop-blur-sm">Most popular</span>
                        @endif
                        <h3 class="text-lg font-bold text-white">{{ $name }}</h3>
                        <div class="mt-4 flex items-baseline gap-1">
                            <span class="text-4xl font-extrabold {{ $popular ? 'text-gradient-orange' : 'text-white' }}">${{ $price }}</span>
                            <span class="text-slate-500 text-sm">/ month</span>
                        </div>
                        <ul class="mt-5 space-y-2 text-sm text-left text-slate-400">
                            @foreach ($features as $f)
                                <li class="flex items-center gap-2">
                                    <svg class="h-4 w-4 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                    {{ $f }}
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('register') }}" class="mt-6 block {{ $popular ? 'btn-orange' : 'btn-ghost' }} w-full rounded-xl py-2.5 text-sm font-bold text-center">
                            Get started
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <p class="mt-8 text-sm text-slate-600">
            <a href="{{ route('pricing') }}" class="text-brand-400 hover:text-brand-300 hover:underline transition">See full pricing details →</a>
        </p>
    </div>
</section>

{{-- ── CTA ──────────────────────────────────────────────────── --}}
<section class="py-20 lg:py-28">
    <div class="land-section text-center">
        <div class="relative mx-auto max-w-3xl overflow-hidden rounded-3xl border border-brand-500/30 bg-gradient-to-br from-brand-500/15 to-orange-600/5 p-12 shadow-glow-orange">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_center,_rgba(249,115,22,0.15),_transparent_70%)]"></div>
            <span class="land-badge relative">Get started today</span>
            <h2 class="land-h2 relative mt-4">Ready to grow your restaurant?</h2>
            <p class="relative mx-auto mt-4 max-w-md text-slate-400">Join thousands of restaurant owners using {{ config('app.name') }} to delight their customers and run their operations smoothly.</p>
            <div class="relative mt-8 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="btn-orange rounded-2xl px-8 py-4 text-base font-extrabold shadow-glow-orange">
                    Create free account →
                </a>
                <a href="{{ url('/') }}#features" class="btn-ghost rounded-2xl px-8 py-4 text-base">
                    Explore features
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
