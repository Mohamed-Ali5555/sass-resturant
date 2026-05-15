<?php

namespace App\Http\Controllers\Webhooks;

use App\Enums\OrderStatus;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\WebhookEvent;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $secret = config('services.stripe.webhook_secret');

        if (! $secret) {
            return response('Webhook not configured', 500);
        }

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature', '');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Throwable) {
            return response('Invalid payload', 400);
        }

        $eventId = $event->id;

        $record = WebhookEvent::query()->firstOrCreate(
            ['provider' => 'stripe', 'event_id' => $eventId],
            ['processed_at' => null],
        );

        if ($record->processed_at !== null) {
            return response('OK', 200);
        }

        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $orderId = $session->metadata->order_id ?? null;

            if ($orderId) {
                DB::transaction(function () use ($orderId, $session): void {
                    /** @var Order|null $order */
                    $order = Order::query()->whereKey($orderId)->lockForUpdate()->first();

                    if (! $order) {
                        return;
                    }

                    $payment = $order->orderPayments()
                        ->where('type', PaymentProvider::Stripe->value)
                        ->orderBy('id')
                        ->first();
                    if ($payment && $payment->status === PaymentStatus::Pending) {
                        $payment->update([
                            'status' => PaymentStatus::Succeeded,
                            'provider_reference' => $session->payment_intent ?? $session->id,
                            'meta' => array_merge($payment->meta ?? [], ['checkout_session_id' => $session->id]),
                        ]);
                    }

                    if ($order->status === OrderStatus::PendingPayment) {
                        $order->update(['status' => OrderStatus::New]);
                    }
                });
            }
        }

        $record->forceFill(['processed_at' => now()])->save();

        return response('OK', 200);
    }
}
