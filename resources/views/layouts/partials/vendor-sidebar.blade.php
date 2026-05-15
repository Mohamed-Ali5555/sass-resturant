@php
    /** @var \App\Models\Restaurant|null $restaurant */
    $restaurant = request()->attributes->get('vendorRestaurant');
    $ownedRestaurants = auth()->user()->ownedRestaurants()->orderBy('name')->get();
@endphp

<div class="flex h-full min-h-0 flex-col border-r border-white/10 bg-slate-950/70 backdrop-blur-2xl">
    <div class="flex h-16 shrink-0 items-center gap-2 border-b border-white/10 px-4">
        <a href="{{ route('vendor.dashboard') }}" class="flex min-w-0 flex-1 items-center gap-2.5 rounded-xl px-2 py-1.5 transition hover:bg-white/5">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gradient-to-br from-cyan-400 to-teal-600 shadow-glow-sm ring-1 ring-white/20">
                <x-application-logo class="h-5 w-5 fill-current text-slate-950" />
            </span>
            <div class="min-w-0 leading-tight">
                <div class="truncate text-xs font-semibold uppercase tracking-wider text-slate-500">{{ __('Vendor') }}</div>
                <div class="truncate text-sm font-semibold text-slate-100">{{ $restaurant?->name ?? config('app.name') }}</div>
            </div>
        </a>
    </div>

    <nav class="hub-scrollbar flex-1 space-y-5 overflow-y-auto px-3 py-5">
        <div>
            <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Overview') }}</p>
            <div class="space-y-0.5">
                <x-hub-nav-link :href="route('vendor.dashboard')" :active="request()->routeIs('vendor.dashboard')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25A2.25 2.25 0 0113.5 8.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                    <span>{{ __('Dashboard') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('vendor.analytics')" :active="request()->routeIs('vendor.analytics')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                    <span>{{ __('Analytics') }}</span>
                </x-hub-nav-link>
            </div>
        </div>

        <div>
            <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Live Operations') }}</p>
            <div class="space-y-0.5">
                <x-hub-nav-link :href="route('vendor.kitchen')" :active="request()->routeIs('vendor.kitchen*')">
                    <svg class="h-5 w-5 shrink-0 text-amber-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" /></svg>
                    <span>{{ __('Kitchen Display') }}</span>
                    <span class="ml-auto rounded-full bg-amber-500/20 px-1.5 py-0.5 text-[9px] font-bold text-amber-400 uppercase">KDS</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('vendor.pos')" :active="request()->routeIs('vendor.pos*')">
                    <svg class="h-5 w-5 shrink-0 text-brand-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                    <span>{{ __('Point of Sale') }}</span>
                    <span class="ml-auto rounded-full bg-brand-500/20 px-1.5 py-0.5 text-[9px] font-bold text-brand-400 uppercase">POS</span>
                </x-hub-nav-link>
            </div>
        </div>

        <div>
            <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Restaurant') }}</p>
            <div class="space-y-0.5">
                @if ($restaurant)
                    <x-hub-nav-link :href="route('vendor.restaurants.edit', $restaurant)" :active="request()->routeIs('vendor.restaurants.edit')">
                        <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.37.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                        <span>{{ __('Settings & media') }}</span>
                    </x-hub-nav-link>
                    <x-hub-nav-link :href="route('public.restaurant.show', $restaurant)" :active="false">
                        <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" /></svg>
                        <span>{{ __('Public menu') }}</span>
                    </x-hub-nav-link>
                    <x-hub-nav-link :href="route('vendor.restaurants.qr-print-menu', $restaurant)" :active="false">
                        <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 7.72l.53 6.53a.75.75 0 001.06.53l6.53-.53a.75.75 0 00.53-1.06L13.06 6.2a.75.75 0 00-1.06-.53L5.47 6.2a.75.75 0 00-.53 1.06l1.78 1.78z" /></svg>
                        <span>{{ __('Print menu QR') }}</span>
                    </x-hub-nav-link>
                @endif
                <x-hub-nav-link :href="route('vendor.branches.index')" :active="request()->routeIs('vendor.branches.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008H17.25v-.008zm0 3h.008v.008H17.25v-.008zm0 3h.008v.008H17.25v-.008z" /></svg>
                    <span>{{ __('Branches') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('vendor.tables.index')" :active="request()->routeIs('vendor.tables.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>
                    <span>{{ __('Tables & QR') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('vendor.opening-hours.edit')" :active="request()->routeIs('vendor.opening-hours.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ __('Opening hours') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('vendor.delivery.index')" :active="request()->routeIs('vendor.delivery.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                    <span>{{ __('Delivery') }}</span>
                </x-hub-nav-link>
            </div>
        </div>

        <div>
            <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Menu') }}</p>
            <div class="space-y-0.5">
                <x-hub-nav-link :href="route('vendor.menu.categories.index')" :active="request()->routeIs('vendor.menu.categories.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                    <span>{{ __('Categories') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('vendor.menu.items.index')" :active="request()->routeIs('vendor.menu.items.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.87c1.355 0 2.697.055 4.024.165C17.155 8.51 18 9.473 18 10.608v2.513m-3 4.65v-1.5m-6 1.5v-1.5m12 0a3 3 0 01-3 3H9a3 3 0 01-3-3z" /></svg>
                    <span>{{ __('Menu items') }}</span>
                </x-hub-nav-link>
            </div>
        </div>

        <div>
            <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Operations') }}</p>
            <div class="space-y-0.5">
                <x-hub-nav-link :href="route('vendor.orders.index')" :active="request()->routeIs('vendor.orders.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" /></svg>
                    <span>{{ __('Orders') }}</span>
                </x-hub-nav-link>
                <x-hub-nav-link :href="route('vendor.promotions.index')" :active="request()->routeIs('vendor.promotions.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L9.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
                    <span>{{ __('Promotions') }}</span>
                </x-hub-nav-link>
            </div>
        </div>

        <div>
            <p class="mb-2 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Team') }}</p>
            <div class="space-y-0.5">
                <x-hub-nav-link :href="route('vendor.staff.index')" :active="request()->routeIs('vendor.staff.*')">
                    <svg class="h-5 w-5 shrink-0 text-cyan-400/90" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
                    <span>{{ __('Staff') }}</span>
                </x-hub-nav-link>
            </div>
        </div>
    </nav>

    <div class="mt-auto shrink-0 space-y-3 border-t border-white/10 p-3">
        @if ($ownedRestaurants->count() > 1)
            <form method="post" action="{{ route('vendor.restaurant.switch') }}" class="space-y-2">
                @csrf
                <label for="vendor_restaurant_id" class="block text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('Switch restaurant') }}</label>
                <select id="vendor_restaurant_id" name="restaurant_id" class="ui-field w-full border px-2 py-2 text-xs" onchange="this.form.submit()">
                    @foreach ($ownedRestaurants as $or)
                        <option value="{{ $or->getKey() }}" @selected($restaurant && (int) $or->getKey() === (int) $restaurant->getKey())>{{ $or->name }}</option>
                    @endforeach
                </select>
            </form>
        @endif

        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 rounded-xl border border-white/10 px-3 py-2 text-xs font-medium text-slate-300 transition hover:border-cyan-400/30 hover:bg-cyan-500/10 hover:text-cyan-100">
            {{ __('Account hub') }}
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl border border-white/10 px-3 py-2 text-xs font-medium text-slate-300 transition hover:border-red-400/30 hover:bg-red-500/10 hover:text-red-200">
                {{ __('Log out') }}
            </button>
        </form>
    </div>
</div>
