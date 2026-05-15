<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        try {
            $plans = SubscriptionPlan::query()
                ->where('is_active', true)
                ->orderBy('price_amount')
                ->limit(3)
                ->get();
        } catch (\Exception) {
            $plans = collect();
        }

        return view('public.home', compact('plans'));
    }
}
