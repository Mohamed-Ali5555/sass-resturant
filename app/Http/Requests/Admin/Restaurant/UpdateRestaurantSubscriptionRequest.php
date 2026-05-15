<?php

namespace App\Http\Requests\Admin\Restaurant;

use App\Enums\PlanInterval;
use App\Enums\SubscriptionStatus;
use App\Models\Restaurant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRestaurantSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Restaurant $restaurant */
        $restaurant = $this->route('restaurant');

        return $this->user()->can('manageSubscription', $restaurant);
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('billing_cycle') === '') {
            $this->merge(['billing_cycle' => null]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'subscription_plan_id' => ['required', 'integer', 'exists:subscription_plans,id'],
            'status' => ['required', 'string', Rule::enum(SubscriptionStatus::class)],
            'billing_cycle' => ['nullable', 'string', Rule::enum(PlanInterval::class)],
            'trial_ends_at' => ['nullable', 'date'],
            'current_period_start' => ['nullable', 'date'],
            'current_period_end' => ['nullable', 'date', 'after_or_equal:current_period_start'],
            'canceled_at' => ['nullable', 'date'],
            'external_subscription_id' => ['nullable', 'string', 'max:191'],
        ];
    }
}
