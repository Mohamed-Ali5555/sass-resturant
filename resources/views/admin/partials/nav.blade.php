<nav class="glass-panel mb-6 flex flex-wrap gap-2 p-3 text-sm" aria-label="{{ __('Admin navigation') }}">
    @php
        $active = 'rounded-full px-4 py-2 font-semibold text-slate-950 shadow-glow bg-gradient-to-r from-cyan-400 to-teal-400';
        $idle = 'rounded-full px-4 py-2 font-medium text-slate-300 transition hover:bg-cyan-500/10 hover:text-cyan-100';
    @endphp
    <a href="{{ route('admin.dashboard') }}" @class([$active => request()->routeIs('admin.dashboard'), $idle => ! request()->routeIs('admin.dashboard')])>{{ __('Dashboard') }}</a>
    <a href="{{ route('admin.restaurants.index') }}" @class([$active => request()->routeIs('admin.restaurants.*'), $idle => ! request()->routeIs('admin.restaurants.*')])>{{ __('Restaurants') }}</a>
    <a href="{{ route('admin.users.index') }}" @class([$active => request()->routeIs('admin.users.*'), $idle => ! request()->routeIs('admin.users.*')])>{{ __('Users') }}</a>
    <a href="{{ route('admin.subscription-plans.index') }}" @class([$active => request()->routeIs('admin.subscription-plans.*'), $idle => ! request()->routeIs('admin.subscription-plans.*')])>{{ __('Plans') }}</a>
    <a href="{{ route('admin.platform-commissions.index') }}" @class([$active => request()->routeIs('admin.platform-commissions.*'), $idle => ! request()->routeIs('admin.platform-commissions.*')])>{{ __('Commissions') }}</a>
    <a href="{{ route('admin.payment-gateways.index') }}" @class([$active => request()->routeIs('admin.payment-gateways.*'), $idle => ! request()->routeIs('admin.payment-gateways.*')])>{{ __('Payment gateways') }}</a>
    <a href="{{ route('admin.support-tickets.index') }}" @class([$active => request()->routeIs('admin.support-tickets.*'), $idle => ! request()->routeIs('admin.support-tickets.*')])>{{ __('Tickets') }}</a>
</nav>
