<div class="flex h-full min-h-0 flex-col border-r border-white/10 bg-slate-950/70 backdrop-blur-2xl">
    <div class="flex h-16 shrink-0 items-center gap-2 border-b border-white/10 px-4">
        <a href="{{ route('admin.dashboard') }}" class="flex min-w-0 flex-1 items-center gap-2.5 rounded-xl px-2 py-1.5 transition hover:bg-white/5">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-amber-400 to-orange-600 shadow-glow-sm ring-1 ring-white/20">
                <x-application-logo class="h-5 w-5 fill-current text-slate-950" />
            </span>
            <div class="min-w-0 leading-tight">
                <div class="truncate text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __('Admin') }}</div>
                <div class="truncate text-sm font-semibold text-slate-100">{{ config('app.name') }}</div>
            </div>
        </a>
    </div>

    <nav class="hub-scrollbar flex-1 space-y-5 overflow-y-auto px-3 py-5">
        <div>
            <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Overview') }}</p>
            <div class="space-y-0.5">
                <x-hub-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25A2.25 2.25 0 0113.5 8.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                    <span>{{ __('Dashboard') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('admin.analytics')" :active="request()->routeIs('admin.analytics')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                    <span>{{ __('Analytics') }}</span>
                </x-hub-nav-link>
            </div>
        </div>

        <div>
            <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Platform') }}</p>
            <div class="space-y-0.5">
                <x-hub-nav-link :href="route('admin.restaurants.index')" :active="request()->routeIs('admin.restaurants.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-16.5 0V9.75m11.25 11.25v-9m-9 0V9.75m0 0h3.375c.621 0 1.125.504 1.125 1.125V15" /></svg>
                    <span>{{ __('Restaurants') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    <span>{{ __('Users') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('admin.support-tickets.index')" :active="request()->routeIs('admin.support-tickets.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-3.89-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a23.922 23.922 0 015.556 5.337l.008.009A24.08 24.08 0 015.541 20.25M12 21a9 9 0 01-9-9m9 9c2.25 0 4.286-.684 6-1.853m0-2.136A8.965 8.965 0 0112 3c1.929 0 3.716.607 5.18 1.64" /></svg>
                    <span>{{ __('Support tickets') }}</span>
                </x-hub-nav-link>
            </div>
        </div>

        <div>
            <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Billing & revenue') }}</p>
            <div class="space-y-0.5">
                <x-hub-nav-link :href="route('admin.subscription-plans.index')" :active="request()->routeIs('admin.subscription-plans.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 15h19.5m-16.5-5.25v6.01m12.75-6.01v6.01m-9-3v3.75m9-3v3.75m-9-3h9.75m-9.75 0h9m-9.75 0H9m12 0h-.75M9 12h.008v.008H9V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm3.75 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                    <span>{{ __('Subscription plans') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('admin.platform-commissions.index')" :active="request()->routeIs('admin.platform-commissions.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 11.444 12 11 12c-.441 0-1.536.22-2.121.879-.586.658-.879 1.303-.879 2.121v4.5c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V15c0-1.017-.293-1.463-.879-2.121-.586-.659-1.68-.879-2.121-.879-.444 0-2.536.219-3.182.879-.646.66-.879 1.165-.879 2.121v4.5" /></svg>
                    <span>{{ __('Commissions') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('admin.payment-gateways.index')" :active="request()->routeIs('admin.payment-gateways.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75a.75.75 0 01-.75.75H3.75a.75.75 0 01-.75-.75V5.25m0 0H21" /></svg>
                    <span>{{ __('Payment gateways') }}</span>
                </x-hub-nav-link>
            </div>
        </div>
    </nav>

    <div class="mt-auto shrink-0 space-y-2 border-t border-white/10 p-3">
        <a href="{{ url('/') }}" class="flex items-center gap-2 rounded-xl border border-white/10 px-3 py-2 text-xs font-medium text-slate-300 transition hover:border-cyan-400/30 hover:bg-cyan-500/10 hover:text-cyan-100">
            {{ __('Homepage') }}
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 px-3 py-2 text-xs font-medium text-slate-300 transition hover:border-red-400/30 hover:bg-red-500/10 hover:text-red-200">
                {{ __('Log out') }}
            </button>
        </form>
    </div>
</div>
