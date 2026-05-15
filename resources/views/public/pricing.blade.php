@extends('layouts.landing')

@section('title', 'Pricing — ' . config('app.name'))
@section('meta_description', 'Simple, transparent pricing for restaurants of all sizes. Start free, no credit card required.')

@section('content')

<section class="relative overflow-hidden pt-28 pb-16 lg:pt-36">
    <div class="pointer-events-none absolute -top-40 right-0 h-[500px] w-[500px] rounded-full bg-brand-500/8 blur-[120px]"></div>

    <div class="land-section text-center">
        <span class="land-badge">Pricing</span>
        <h1 class="land-h1 mt-4">Pay for what you need.<br><span class="text-gradient-orange">Nothing more.</span></h1>
        <p class="mx-auto mt-6 max-w-xl text-lg text-slate-400">Start with a 14-day free trial. No credit card required. Cancel anytime.</p>

        {{-- Billing toggle --}}
        <div id="billingToggle" class="mt-10">
            <div class="inline-flex items-center gap-3 rounded-2xl border border-white/10 bg-white/[0.03] p-1.5">
                <button
                    data-billing="monthly"
                    class="rounded-xl px-5 py-2 text-sm font-bold transition bg-brand-500 text-white shadow-glow-orange-sm"
                >Monthly</button>
                <button
                    data-billing="annual"
                    class="rounded-xl px-5 py-2 text-sm font-bold transition text-slate-400 hover:text-slate-200"
                >
                    Annual
                    <span class="ml-1.5 rounded-full bg-emerald-500/20 px-2 py-0.5 text-[10px] font-bold text-emerald-400">-20%</span>
                </button>
            </div>

            {{-- Plan cards --}}
            <div class="mt-12 grid gap-6 md:grid-cols-3 max-w-5xl mx-auto">
                @if ($plans->isNotEmpty())
                    @foreach ($plans as $i => $plan)
                        @php $popular = $i === 1; @endphp
                        <div class="price-card {{ $popular ? 'price-card-popular relative' : '' }}">
                            @if ($popular)
                                <span class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full border border-brand-500/50 bg-[#07080f] px-4 py-1 text-xs font-bold text-brand-300">⭐ Most popular</span>
                            @endif
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-bold text-white">{{ $plan->name }}</h3>
                                <span class="rounded-xl {{ $popular ? 'bg-brand-500/20 text-brand-300' : 'bg-white/10 text-slate-400' }} px-2.5 py-1 text-xs font-bold">{{ ucfirst($plan->interval?->value ?? 'monthly') }}</span>
                            </div>
                            <div class="mt-5">
                                <div class="flex items-baseline gap-1 price-monthly">
                                    <span class="text-5xl font-extrabold {{ $popular ? 'text-gradient-orange' : 'text-white' }}">{{ $plan->currency }} {{ number_format((float)$plan->price_amount, 0) }}</span>
                                    <span class="text-slate-500">/mo</span>
                                </div>
                                <div class="flex items-baseline gap-1 price-annual" style="display:none">
                                    <span class="text-5xl font-extrabold {{ $popular ? 'text-gradient-orange' : 'text-white' }}">{{ $plan->currency }} {{ number_format((float)$plan->price_amount * 0.8, 0) }}</span>
                                    <span class="text-slate-500">/mo</span>
                                </div>
                                <p class="mt-1 text-xs text-slate-600 price-annual-note" style="display:none">Billed annually ({{ $plan->currency }} {{ number_format((float)$plan->price_amount * 0.8 * 12, 0) }}/yr)</p>
                            </div>

                            @if ($plan->features)
                                <ul class="mt-6 space-y-3 text-sm text-left">
                                    @foreach ((array)$plan->features as $feature)
                                        <li class="flex items-start gap-2.5 {{ $popular ? 'text-slate-200' : 'text-slate-400' }}">
                                            <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                            {{ $feature }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                            <a href="{{ route('register') }}" class="mt-8 block {{ $popular ? 'btn-orange' : 'btn-ghost' }} w-full rounded-2xl py-3.5 text-sm font-extrabold text-center">
                                Start free trial →
                            </a>
                            <p class="mt-2 text-center text-xs text-slate-600">14-day free trial · No credit card</p>
                        </div>
                    @endforeach
                @else
                    {{-- Static fallback plans --}}
                    @foreach ([
                        ['Starter', 49, ['1 restaurant', 'Up to 3 staff', 'QR Digital Menu', 'Order management', 'Basic analytics'], false, 'SAR'],
                        ['Growth', 99, ['3 restaurants', 'Up to 10 staff', 'Kitchen Display (KDS)', 'POS system', 'Coupons & promotions', 'Advanced analytics', 'Multi-branch support'], true, 'SAR'],
                        ['Enterprise', 249, ['Unlimited restaurants', 'Unlimited staff', 'All Growth features', 'Delivery zone management', 'Priority support', 'Custom branding', 'API access'], false, 'SAR'],
                    ] as [$name, $price, $features, $popular, $currency])
                        <div class="price-card {{ $popular ? 'price-card-popular relative' : '' }}">
                            @if ($popular)
                                <span class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 rounded-full border border-brand-500/50 bg-[#07080f] px-4 py-1 text-xs font-bold text-brand-300">⭐ Most popular</span>
                            @endif
                            <h3 class="text-xl font-bold text-white">{{ $name }}</h3>
                            <div class="mt-5">
                                <div class="flex items-baseline gap-1 price-monthly">
                                    <span class="text-5xl font-extrabold {{ $popular ? 'text-gradient-orange' : 'text-white' }}">${{ $price }}</span>
                                    <span class="text-slate-500">/mo</span>
                                </div>
                                <div class="flex items-baseline gap-1 price-annual" style="display:none">
                                    <span class="text-5xl font-extrabold {{ $popular ? 'text-gradient-orange' : 'text-white' }}">${{ round($price * 0.8) }}</span>
                                    <span class="text-slate-500">/mo</span>
                                </div>
                            </div>
                            <ul class="mt-6 space-y-3 text-sm text-left">
                                @foreach ($features as $f)
                                    <li class="flex items-start gap-2.5 {{ $popular ? 'text-slate-200' : 'text-slate-400' }}">
                                        <svg class="mt-0.5 h-4 w-4 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg>
                                        {{ $f }}
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('register') }}" class="mt-8 block {{ $popular ? 'btn-orange' : 'btn-ghost' }} w-full rounded-2xl py-3.5 text-sm font-extrabold text-center">
                                Start free trial →
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Features comparison table --}}
<section class="py-16 border-t border-white/8">
    <div class="land-section">
        <h2 class="text-2xl font-bold text-white text-center mb-10">Compare all features</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-left pb-4 text-slate-500 font-medium w-1/2">Feature</th>
                        <th class="text-center pb-4 text-slate-300 font-bold">Starter</th>
                        <th class="text-center pb-4 text-brand-400 font-bold">Growth</th>
                        <th class="text-center pb-4 text-slate-300 font-bold">Enterprise</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @foreach ([
                        ['QR Digital menu', '✓', '✓', '✓'],
                        ['Order management', '✓', '✓', '✓'],
                        ['Kitchen Display (KDS)', '—', '✓', '✓'],
                        ['Point of Sale (POS)', '—', '✓', '✓'],
                        ['Coupons & promotions', '—', '✓', '✓'],
                        ['Staff management', 'Up to 3', 'Up to 10', 'Unlimited'],
                        ['Restaurants', '1', 'Up to 3', 'Unlimited'],
                        ['Branches per restaurant', '1', '3', 'Unlimited'],
                        ['Analytics dashboard', 'Basic', 'Advanced', 'Advanced'],
                        ['Delivery zones', '—', '✓', '✓'],
                        ['Multi-branch support', '—', '✓', '✓'],
                        ['Priority support', '—', '—', '✓'],
                        ['API access', '—', '—', '✓'],
                    ] as [$feature, $starter, $growth, $enterprise])
                        <tr>
                            <td class="py-3.5 text-slate-400">{{ $feature }}</td>
                            <td class="py-3.5 text-center {{ $starter === '✓' ? 'text-emerald-400' : ($starter === '—' ? 'text-slate-700' : 'text-slate-400') }}">{{ $starter }}</td>
                            <td class="py-3.5 text-center {{ $growth === '✓' ? 'text-emerald-400' : ($growth === '—' ? 'text-slate-700' : 'text-brand-400 font-semibold') }}">{{ $growth }}</td>
                            <td class="py-3.5 text-center {{ $enterprise === '✓' ? 'text-emerald-400' : ($enterprise === '—' ? 'text-slate-700' : 'text-slate-300 font-semibold') }}">{{ $enterprise }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="py-16 border-t border-white/8 bg-white/[0.015]">
    <div class="land-section max-w-3xl">
        <h2 class="text-2xl font-bold text-white text-center mb-10">Frequently asked questions</h2>
        <div id="faqAccordion" class="space-y-3">
            @foreach ([
                ['Can I try before I pay?', 'Yes! Every plan includes a 14-day free trial — no credit card required. You get full access to all features in your chosen plan.'],
                ['How many restaurants can I manage?', 'The Starter plan supports 1 restaurant, Growth supports 3, and Enterprise has no limit. Each restaurant can have multiple branches.'],
                ['Can I upgrade or downgrade?', 'Absolutely. You can change your plan at any time. Upgrades take effect immediately, downgrades at the next billing cycle.'],
                ['Is there a setup fee?', 'Never. There are no setup fees, no hidden charges, and no long-term contracts.'],
                ['What payment methods are accepted?', 'We accept all major credit cards via Stripe. Bank transfers available for Enterprise plans.'],
            ] as $idx => [$q, $a])
                <div class="rounded-2xl border border-white/10 bg-white/[0.02] overflow-hidden faq-item" data-faq-index="{{ $idx }}">
                    <button
                        class="faq-toggle flex w-full items-center justify-between px-6 py-4 text-left text-sm font-semibold text-white"
                        data-faq-index="{{ $idx }}"
                    >
                        {{ $q }}
                        <svg class="faq-icon h-4 w-4 shrink-0 text-slate-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                    </button>
                    <div
                        class="faq-content px-6 pb-5 text-sm text-slate-400 leading-relaxed"
                        style="display: none;"
                        data-faq-index="{{ $idx }}"
                    >
                        {{ $a }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20">
    <div class="land-section text-center max-w-2xl">
        <h2 class="land-h2">Start your free trial today</h2>
        <p class="mt-4 text-slate-400">14 days free. No credit card. No commitments.</p>
        <a href="{{ route('register') }}" class="btn-orange mt-8 inline-flex rounded-2xl px-8 py-4 text-base font-extrabold shadow-glow-orange">
            Create free account →
        </a>
    </div>
</section>

<script>
    // Billing toggle functionality
    document.addEventListener('DOMContentLoaded', () => {
        const billingToggle = document.getElementById('billingToggle');
        let isAnnual = false;

        // Setup billing buttons
        const monthlyBtn = billingToggle.querySelector('[data-billing="monthly"]');
        const annualBtn = billingToggle.querySelector('[data-billing="annual"]');

        monthlyBtn.addEventListener('click', () => {
            isAnnual = false;
            updateBillingDisplay();
        });

        annualBtn.addEventListener('click', () => {
            isAnnual = true;
            updateBillingDisplay();
        });

        function updateBillingDisplay() {
            // Update button styles
            if (isAnnual) {
                monthlyBtn.classList.remove('bg-brand-500', 'text-white', 'shadow-glow-orange-sm');
                monthlyBtn.classList.add('text-slate-400', 'hover:text-slate-200');
                annualBtn.classList.remove('text-slate-400', 'hover:text-slate-200');
                annualBtn.classList.add('bg-brand-500', 'text-white', 'shadow-glow-orange-sm');
            } else {
                monthlyBtn.classList.remove('text-slate-400', 'hover:text-slate-200');
                monthlyBtn.classList.add('bg-brand-500', 'text-white', 'shadow-glow-orange-sm');
                annualBtn.classList.remove('bg-brand-500', 'text-white', 'shadow-glow-orange-sm');
                annualBtn.classList.add('text-slate-400', 'hover:text-slate-200');
            }

            // Update prices
            document.querySelectorAll('.price-monthly').forEach(el => {
                el.style.display = isAnnual ? 'none' : 'flex';
            });
            document.querySelectorAll('.price-annual').forEach(el => {
                el.style.display = isAnnual ? 'flex' : 'none';
            });
            document.querySelectorAll('.price-annual-note').forEach(el => {
                el.style.display = isAnnual ? 'block' : 'none';
            });
        }
    });

    // FAQ accordion functionality
    document.addEventListener('DOMContentLoaded', () => {
        let activeIndex = null;

        document.querySelectorAll('.faq-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const index = parseInt(button.dataset.faqIndex);
                const isActive = activeIndex === index;

                // Close all items
                document.querySelectorAll('.faq-content').forEach(content => {
                    content.style.display = 'none';
                });
                document.querySelectorAll('.faq-icon').forEach(icon => {
                    icon.classList.remove('rotate-180');
                });

                // Open clicked item
                if (!isActive) {
                    const content = document.querySelector(`[data-faq-index="${index}"].faq-content`);
                    const icon = button.querySelector('.faq-icon');
                    if (content) {
                        content.style.display = 'block';
                    }
                    if (icon) {
                        icon.classList.add('rotate-180');
                    }
                    activeIndex = index;
                } else {
                    activeIndex = null;
                }
            });
        });
    });
</script>

@endsection
