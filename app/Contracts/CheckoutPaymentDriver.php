<?php

namespace App\Contracts;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;

interface CheckoutPaymentDriver
{
    public function supports(string $paymentMethod): bool;

    /**
     * Begin remote checkout if needed (e.g. Stripe redirect).
     */
    public function afterOrderCreated(Order $order): ?RedirectResponse;
}
