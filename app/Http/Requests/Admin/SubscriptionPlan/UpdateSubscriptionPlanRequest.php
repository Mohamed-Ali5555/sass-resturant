<?php

namespace App\Http\Requests\Admin\SubscriptionPlan;

use App\Enums\PlanInterval;
use App\Models\SubscriptionPlan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubscriptionPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var SubscriptionPlan $subscription_plan */
        $plan = $this->route('subscription_plan');

        return $this->user()->can('update', $plan);
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('features') && is_array($this->features)) {
            $this->merge([
                'features' => array_values(array_filter(
                    $this->features,
                    static fn ($v) => $v !== null && $v !== ''
                )),
            ]);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        /** @var SubscriptionPlan $plan */
        $plan = $this->route('subscription_plan');

        return [
            'name' => ['required', 'string', 'max:120'],
            'slug' => [
                'required',
                'string',
                'max:120',
                'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('subscription_plans', 'slug')->ignore($plan->getKey()),
            ],
            'interval' => ['required', 'string', Rule::enum(PlanInterval::class)],
            'price_amount' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'max:200'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'slug.regex' => 'The slug may only contain lowercase letters, numbers, and hyphens.',
        ];
    }
}
