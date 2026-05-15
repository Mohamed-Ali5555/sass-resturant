<?php

namespace App\Http\Requests\Public\Checkout;

use App\Enums\OrderMode;
use App\Enums\PaymentProvider;
use App\Models\RestaurantTable;
use App\Services\CartService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->input('order_mode') !== OrderMode::DineIn->value) {
            return;
        }

        /** @var \App\Models\Restaurant|null $restaurant */
        $restaurant = $this->route('restaurant');
        if (! $restaurant || $this->filled('table_number')) {
            return;
        }

        $cart = app(CartService::class);
        $cart->setRestaurant($restaurant);
        $tid = $cart->getRestaurantTableId();
        if (! $tid) {
            return;
        }

        $table = RestaurantTable::query()
            ->where('restaurant_id', $restaurant->getKey())
            ->whereKey($tid)
            ->first();

        if ($table) {
            $this->merge(['table_number' => $table->label]);
        }
    }

    public function rules(): array
    {
        /** @var \App\Models\Restaurant $restaurant */
        $restaurant = $this->route('restaurant');

        return [
            'order_mode' => ['required', Rule::enum(OrderMode::class)],
            'customer_name' => ['required', 'string', 'max:120'],
            'customer_phone' => ['required', 'string', 'max:64'],
            'customer_notes' => ['nullable', 'string', 'max:2000'],
            'delivery_address' => [
                Rule::requiredIf(fn () => $this->input('order_mode') === OrderMode::Delivery->value),
                'nullable',
                'string',
                'max:2000',
            ],
            'table_number' => [
                Rule::requiredIf(fn () => $this->input('order_mode') === OrderMode::DineIn->value),
                'nullable',
                'string',
                'max:32',
            ],
            'payment_method' => ['required', Rule::in([PaymentProvider::Cod->value, PaymentProvider::Stripe->value])],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator): void {
            /** @var \App\Models\Restaurant|null $restaurant */
            $restaurant = $this->route('restaurant');
            if (! $restaurant) {
                return;
            }

            $mode = $this->input('order_mode');

            if ($mode === OrderMode::DineIn->value && ! $restaurant->enable_dine_in) {
                $validator->errors()->add('order_mode', 'Dine-in is not available.');
            }

            if ($mode === OrderMode::Takeaway->value && ! $restaurant->enable_takeaway) {
                $validator->errors()->add('order_mode', 'Takeaway is not available.');
            }

            if ($mode === OrderMode::Delivery->value && ! $restaurant->enable_delivery) {
                $validator->errors()->add('order_mode', 'Delivery is not available.');
            }
        });
    }
}
