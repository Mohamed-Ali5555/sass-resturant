<?php

namespace App\Http\Requests\Admin\PaymentGateway;

use App\Models\PaymentGatewayConfig;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentGatewayConfigRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var PaymentGatewayConfig $payment_gateway_config */
        $config = $this->route('payment_gateway_config');

        return $this->user()->can('update', $config);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'enabled' => ['sometimes', 'boolean'],
            'public_key_masked' => ['nullable', 'string', 'max:255'],
            'secret_payload' => ['nullable', 'string', 'max:5000'],
            'metadata' => ['nullable', 'array'],
        ];
    }
}
