<?php

use App\Http\Controllers\Admin\AdminAnalyticsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPaymentGatewayController;
use App\Http\Controllers\Admin\AdminPlatformCommissionController;
use App\Http\Controllers\Admin\AdminRestaurantController;
use App\Http\Controllers\Admin\AdminSubscriptionPlanController;
use App\Http\Controllers\Admin\AdminSupportTicketController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'active', 'permission:admin.access,web'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', [AdminAnalyticsController::class, 'index'])->name('analytics');

        Route::resource('subscription-plans', AdminSubscriptionPlanController::class)->except(['show']);

        Route::get('/restaurants', [AdminRestaurantController::class, 'index'])->name('restaurants.index');
        Route::get('/restaurants/{restaurant}', [AdminRestaurantController::class, 'show'])->name('restaurants.show');
        Route::patch('/restaurants/{restaurant}/approve', [AdminRestaurantController::class, 'approve'])->name('restaurants.approve');
        Route::patch('/restaurants/{restaurant}/suspend', [AdminRestaurantController::class, 'suspend'])->name('restaurants.suspend');
        Route::put('/restaurants/{restaurant}/subscription', [AdminRestaurantController::class, 'updateSubscription'])->name('restaurants.subscription.update');

        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
        Route::patch('/users/{user}/roles', [AdminUserController::class, 'updateRoles'])->name('users.roles.update');
        Route::patch('/users/{user}/disabled', [AdminUserController::class, 'toggleDisabled'])->name('users.disabled');

        Route::resource('platform-commissions', AdminPlatformCommissionController::class)->except(['show']);

        Route::get('/payment-gateways', [AdminPaymentGatewayController::class, 'index'])->name('payment-gateways.index');
        Route::get('/payment-gateways/{payment_gateway_config}/edit', [AdminPaymentGatewayController::class, 'edit'])->name('payment-gateways.edit');
        Route::put('/payment-gateways/{payment_gateway_config}', [AdminPaymentGatewayController::class, 'update'])->name('payment-gateways.update');

        Route::get('/support-tickets', [AdminSupportTicketController::class, 'index'])->name('support-tickets.index');
        Route::get('/support-tickets/{support_ticket}', [AdminSupportTicketController::class, 'show'])->name('support-tickets.show');
        Route::patch('/support-tickets/{support_ticket}/status', [AdminSupportTicketController::class, 'updateStatus'])->name('support-tickets.status');
        Route::post('/support-tickets/{support_ticket}/reply', [AdminSupportTicketController::class, 'reply'])->name('support-tickets.reply');
    });
