<?php

namespace App\Http\Controllers;

use App\Enums\RoleName;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): RedirectResponse|View
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasAnyRoleName(RoleName::VendorOwner, RoleName::BranchManager)) {
            return redirect()->route('vendor.dashboard');
        }

        $recentOrders = $user->orders()
            ->with('restaurant')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        $ordersCount = $user->orders()->count();
        $favoritesCount = $user->favorites()->count();

        return view('public.dashboard', compact('recentOrders', 'ordersCount', 'favoritesCount'));
    }
}
