<x-hub-layout :title="__('Account · Help')" :mobile-title="__('Help')">
    <x-slot name="header">
        <h1>{{ __('Help & support') }}</h1>
        <p>{{ __('Answers to common questions and how to reach the platform team.') }}</p>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="glass-panel p-6 shadow-glow">
            <h2 class="text-lg font-semibold text-white">{{ __('Ordering') }}</h2>
            <ul class="mt-4 list-inside list-disc space-y-2 text-sm text-slate-400">
                <li>{{ __('Use Discover to open a restaurant menu, then add items to your cart.') }}</li>
                <li>{{ __('Signed-in orders appear under My orders with full history and totals.') }}</li>
                <li>{{ __('Guest checkouts may not appear here unless the same account was used.') }}</li>
            </ul>
        </div>
        <div class="glass-panel p-6 shadow-glow">
            <h2 class="text-lg font-semibold text-white">{{ __('Account') }}</h2>
            <ul class="mt-4 list-inside list-disc space-y-2 text-sm text-slate-400">
                <li>{{ __('Update your name, email, and password under Profile & security.') }}</li>
                <li>{{ __('Saved items sync to your account for quick reordering.') }}</li>
            </ul>
        </div>
    </div>

    <div class="mt-6 glass-panel p-6 shadow-glow">
        <h2 class="text-lg font-semibold text-white">{{ __('Still stuck?') }}</h2>
        <p class="mt-2 text-sm text-slate-400">{{ __('Contact your restaurant for order-specific issues. For platform access or billing, reach your administrator or support channel.') }}</p>
    </div>
</x-hub-layout>
