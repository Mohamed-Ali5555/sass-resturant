<?php

namespace App\Http\Requests\Vendor;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Order $order */
        $order = $this->route('order');

        return $this->user()?->can('updateStatus', $order) ?? false;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'status' => [
                'required',
                Rule::in([
                    OrderStatus::New->value,
                    OrderStatus::Preparing->value,
                    OrderStatus::Ready->value,
                    OrderStatus::Completed->value,
                    OrderStatus::Canceled->value,
                ]),
            ],
        ];
    }
}
