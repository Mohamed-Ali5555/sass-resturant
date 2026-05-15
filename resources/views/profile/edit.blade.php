<x-hub-layout :title="__('Account · Profile')" :mobile-title="__('Profile')">
    <x-slot name="header">
        <h1>{{ __('Profile & security') }}</h1>
        <p>{{ __('Manage how you sign in and how your name appears across the platform.') }}</p>
    </x-slot>

    <div class="mx-auto max-w-2xl space-y-6">
        <div class="glass-panel p-4 shadow-glow sm:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="glass-panel p-4 shadow-glow sm:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="glass-panel p-4 shadow-glow sm:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-hub-layout>
