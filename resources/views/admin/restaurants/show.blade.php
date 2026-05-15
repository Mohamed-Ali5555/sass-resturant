<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-semibold text-xl text-slate-100 leading-tight">{{ $restaurant->name }}</h2>
            <a href="{{ route('admin.restaurants.index') }}" class="text-sm text-cyan-300 hover:text-cyan-100 hover:underline">{{ __('Back to list') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl text-sm text-slate-200">
                <h3 class="font-semibold text-slate-50">{{ __('Summary') }}</h3>
                <dl class="mt-4 grid gap-3 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('Slug') }}</dt>
                        <dd class="font-medium">{{ $restaurant->slug }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('Restaurant status') }}</dt>
                        <dd class="font-medium">{{ $restaurant->status }}</dd>
                    </div>
                    @if ($restaurant->suspension_reason)
                        <div class="sm:col-span-2">
                            <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('Suspension reason') }}</dt>
                            <dd class="mt-1 whitespace-pre-wrap rounded-md bg-amber-50 p-3 text-gray-800 dark:bg-amber-950 dark:text-amber-100">{{ $restaurant->suspension_reason }}</dd>
                        </div>
                    @endif
                    <div class="sm:col-span-2">
                        <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('Owner') }}</dt>
                        <dd class="font-medium">{{ $restaurant->vendorOwner?->name }} ({{ $restaurant->vendorOwner?->email }})</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('Orders count') }}</dt>
                        <dd class="font-medium">{{ $restaurant->orders_count }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs uppercase tracking-wide text-slate-500">{{ __('Latest subscription') }}</dt>
                        <dd class="font-medium">
                            @if ($subscription)
                                <span>{{ $subscription->status->value }}</span>
                                @if ($subscription->subscriptionPlan)
                                    <span class="text-slate-500">· {{ $subscription->subscriptionPlan->name }}</span>
                                @endif
                            @else
                                <span class="text-slate-500">{{ __('None') }}</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="glass-panel overflow-hidden p-6 sm:rounded-2xl">
                <h3 class="font-semibold text-slate-50">{{ __('Subscription') }}</h3>
                @if ($plans->isEmpty())
                    <p class="mt-4 text-sm text-amber-700 dark:text-amber-300">{{ __('Create an active subscription plan first.') }}</p>
                @else
                    <form method="post" action="{{ route('admin.restaurants.subscription.update', $restaurant) }}" class="mt-4 space-y-4 text-sm">
                        @csrf
                        @method('PUT')
                        <div>
                            <x-input-label for="subscription_plan_id" :value="__('Plan')" />
                            <select id="subscription_plan_id" name="subscription_plan_id" class="mt-1 block w-full ui-field" required>
                                @foreach ($plans as $plan)
                                    <option value="{{ $plan->id }}" @selected(old('subscription_plan_id', $subscription?->subscription_plan_id) == $plan->id)>{{ $plan->name }} ({{ $plan->slug }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('subscription_plan_id')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select id="status" name="status" class="mt-1 block w-full ui-field" required>
                                @foreach (\App\Enums\SubscriptionStatus::cases() as $case)
                                    <option value="{{ $case->value }}" @selected(old('status', $subscription?->status?->value) === $case->value)>{{ $case->value }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="billing_cycle" :value="__('Billing cycle')" />
                            <select id="billing_cycle" name="billing_cycle" class="mt-1 block w-full ui-field">
                                <option value="">{{ __('— inherit / unset —') }}</option>
                                @foreach (\App\Enums\PlanInterval::cases() as $interval)
                                    <option value="{{ $interval->value }}" @selected(old('billing_cycle', $subscription?->billing_cycle) === $interval->value)>{{ $interval->value }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('billing_cycle')" class="mt-2" />
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <x-input-label for="trial_ends_at" :value="__('Trial ends at')" />
                                <x-text-input id="trial_ends_at" name="trial_ends_at" type="datetime-local" class="mt-1 block w-full" :value="old('trial_ends_at', $subscription?->trial_ends_at?->format('Y-m-d\TH:i'))" />
                                <x-input-error :messages="$errors->get('trial_ends_at')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="canceled_at" :value="__('Canceled at')" />
                                <x-text-input id="canceled_at" name="canceled_at" type="datetime-local" class="mt-1 block w-full" :value="old('canceled_at', $subscription?->canceled_at?->format('Y-m-d\TH:i'))" />
                                <x-input-error :messages="$errors->get('canceled_at')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="current_period_start" :value="__('Period start')" />
                                <x-text-input id="current_period_start" name="current_period_start" type="datetime-local" class="mt-1 block w-full" :value="old('current_period_start', $subscription?->current_period_start?->format('Y-m-d\TH:i'))" />
                                <x-input-error :messages="$errors->get('current_period_start')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="current_period_end" :value="__('Period end')" />
                                <x-text-input id="current_period_end" name="current_period_end" type="datetime-local" class="mt-1 block w-full" :value="old('current_period_end', $subscription?->current_period_end?->format('Y-m-d\TH:i'))" />
                                <x-input-error :messages="$errors->get('current_period_end')" class="mt-2" />
                            </div>
                        </div>
                        <div>
                            <x-input-label for="external_subscription_id" :value="__('External subscription id')" />
                            <x-text-input id="external_subscription_id" name="external_subscription_id" type="text" class="mt-1 block w-full" :value="old('external_subscription_id', $subscription?->external_subscription_id)" />
                            <x-input-error :messages="$errors->get('external_subscription_id')" class="mt-2" />
                        </div>
                        <x-primary-button type="submit">{{ __('Save subscription') }}</x-primary-button>
                    </form>
                @endif
            </div>

            <div class="flex flex-wrap gap-3">
                @if ($restaurant->status !== 'active')
                    <form method="post" action="{{ route('admin.restaurants.approve', $restaurant) }}">
                        @csrf
                        @method('PATCH')
                        <x-primary-button type="submit">{{ __('Approve') }}</x-primary-button>
                    </form>
                @endif
                @if ($restaurant->status !== 'suspended')
                    <form method="post" action="{{ route('admin.restaurants.suspend', $restaurant) }}" class="flex max-w-md flex-1 flex-col gap-2">
                        @csrf
                        @method('PATCH')
                        <label class="text-xs text-slate-400">{{ __('Suspension reason (optional)') }}</label>
                        <textarea name="suspension_reason" rows="2" class="ui-field text-sm"></textarea>
                        <x-secondary-button type="submit">{{ __('Suspend') }}</x-secondary-button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>


