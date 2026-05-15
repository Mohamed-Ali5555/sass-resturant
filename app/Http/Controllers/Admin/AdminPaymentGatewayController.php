<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PaymentGateway\UpdatePaymentGatewayConfigRequest;
use App\Models\PaymentGatewayConfig;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminPaymentGatewayController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', PaymentGatewayConfig::class);

        $configs = PaymentGatewayConfig::query()
            ->with('restaurant')
            ->orderByDesc('owner_scope')
            ->orderBy('restaurant_id')
            ->paginate(25);

        return view('admin.payment-gateways.index', compact('configs'));
    }

    public function edit(PaymentGatewayConfig $payment_gateway_config): View
    {
        $this->authorize('update', $payment_gateway_config);

        return view('admin.payment-gateways.edit', ['config' => $payment_gateway_config]);
    }

    public function update(UpdatePaymentGatewayConfigRequest $request, PaymentGatewayConfig $payment_gateway_config): RedirectResponse
    {
        $data = $request->validated();
        $data['enabled'] = $request->boolean('enabled');

        if (empty($data['secret_payload'])) {
            unset($data['secret_payload']);
        }

        $payment_gateway_config->update($data);

        return redirect()
            ->route('admin.payment-gateways.index')
            ->with('status', __('Payment gateway settings saved.'));
    }
}
