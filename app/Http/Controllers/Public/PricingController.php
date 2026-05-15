<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\View\View;

class PricingController extends Controller
{
    public function index(): View
    {
        try {
            $plans = SubscriptionPlan::query()
                ->where('is_active', true)
                ->orderBy('price_amount')
                ->get();
        } catch (\Exception) {
            $plans = collect();
        }

        return view('public.pricing', compact('plans'));
    }
}
