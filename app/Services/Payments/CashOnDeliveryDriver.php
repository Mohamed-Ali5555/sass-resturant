<?php

namespace App\Services\Payments;

use App\Contracts\CheckoutPaymentDriver;
use App\Enums\PaymentProvider;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;

class CashOnDeliveryDriver implements CheckoutPaymentDriver
{
    public function supports(string $paymentMethod): bool
    {
        return $paymentMethod === PaymentProvider::Cod->value;
    }

    public function afterOrderCreated(Order $order): ?RedirectResponse
    {
        return null;
    }
}
