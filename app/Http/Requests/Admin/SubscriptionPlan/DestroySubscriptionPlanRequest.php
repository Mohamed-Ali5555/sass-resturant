<?php

namespace App\Http\Requests\Admin\SubscriptionPlan;

use App\Models\SubscriptionPlan;
use Illuminate\Foundation\Http\FormRequest;

class DestroySubscriptionPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var SubscriptionPlan $subscription_plan */
        $plan = $this->route('subscription_plan');

        return $this->user()->can('delete', $plan);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
