<?php

namespace App\Services\Payments;

use App\Contracts\CheckoutPaymentDriver;
use App\Enums\PaymentProvider;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Config;
use Stripe\StripeClient;

class StripeCheckoutDriver implements CheckoutPaymentDriver
{
    public function supports(string $paymentMethod): bool
    {
        return $paymentMethod === PaymentProvider::Stripe->value;
    }

    public function afterOrderCreated(Order $order): ?RedirectResponse
    {
        $secret = Config::get('services.stripe.secret');

        if (! $secret) {
            abort(500, 'Stripe is not configured.');
        }

        $stripe = new StripeClient($secret);

        $session = $stripe->checkout->sessions->create([
            'mode' => 'payment',
            'success_url' => route('public.order.show', [
                'restaurant' => $order->restaurant->slug,
                'publicRef' => $order->public_ref,
            ]).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('public.checkout.show', ['restaurant' => $order->restaurant->slug]),
            'client_reference_id' => (string) $order->getKey(),
            'metadata' => [
                'order_id' => (string) $order->getKey(),
                'public_ref' => $order->public_ref,
            ],
            'line_items' => $this->lineItems($order),
            'currency' => strtolower($order->restaurant->currency),
        ]);

        $payment = $order->orderPayments()->first();
        if ($payment) {
            $payment->update([
                'provider_reference' => $session->id,
                'meta' => array_merge($payment->meta ?? [], ['checkout_session_id' => $session->id]),
            ]);
        }

        return new RedirectResponse($session->url);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function lineItems(Order $order): array
    {
        $items = [];

        foreach ($order->orderItems as $line) {
            $items[] = [
                'quantity' => $line->qty,
                'price_data' => [
                    'currency' => strtolower($order->restaurant->currency),
                    'unit_amount' => (int) round(((float) $line->unit_price) * 100),
                    'product_data' => [
                        'name' => $line->item_name_snapshot,
                    ],
                ],
            ];
        }

        if ((float) $order->tax_total > 0) {
            $items[] = [
                'quantity' => 1,
                'price_data' => [
                    'currency' => strtolower($order->restaurant->currency),
                    'unit_amount' => (int) round(((float) $order->tax_total) * 100),
                    'product_data' => [
                        'name' => 'Tax',
                    ],
                ],
            ];
        }

        if ((float) $order->delivery_fee > 0) {
            $items[] = [
                'quantity' => 1,
                'price_data' => [
                    'currency' => strtolower($order->restaurant->currency),
                    'unit_amount' => (int) round(((float) $order->delivery_fee) * 100),
                    'product_data' => [
                        'name' => 'Delivery fee',
                    ],
                ],
            ];
        }

        return $items;
    }
}
