<?php

use App\Http\Controllers\Vendor\VendorAnalyticsController;
use App\Http\Controllers\Vendor\VendorKitchenController;
use App\Http\Controllers\Vendor\VendorPosController;
use App\Http\Controllers\Vendor\VendorBranchController;
use App\Http\Controllers\Vendor\VendorDashboardController;
use App\Http\Controllers\Vendor\VendorDeliveryController;
use App\Http\Controllers\Vendor\VendorMenuCategoryController;
use App\Http\Controllers\Vendor\VendorMenuItemController;
use App\Http\Controllers\Vendor\VendorOpeningHoursController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\Vendor\VendorPromotionController;
use App\Http\Controllers\Vendor\VendorRestaurantController;
use App\Http\Controllers\Vendor\VendorRestaurantTableController;
use App\Http\Controllers\Vendor\VendorStaffController;
use App\Http\Middleware\EnsureVendorCanManageRestaurant;
use App\Http\Middleware\EnsureVendorRestaurantSession;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'active', 'vendor.panel', EnsureVendorRestaurantSession::class, EnsureVendorCanManageRestaurant::class])
    ->prefix('vendor')
    ->name('vendor.')
    ->group(function () {
        Route::get('/', [VendorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', [VendorAnalyticsController::class, 'index'])->name('analytics');
        Route::post('/switch-restaurant', [VendorDashboardController::class, 'switch'])->name('restaurant.switch');

        // Kitchen Display System
        Route::get('/kitchen', [VendorKitchenController::class, 'index'])->name('kitchen');
        Route::get('/kitchen/feed', [VendorKitchenController::class, 'feed'])->name('kitchen.feed');
        Route::post('/kitchen/orders/{order:id}/status', [VendorKitchenController::class, 'updateStatus'])->name('kitchen.orders.status');

        // Point of Sale
        Route::get('/pos', [VendorPosController::class, 'index'])->name('pos');
        Route::post('/pos/orders', [VendorPosController::class, 'storeOrder'])->name('pos.store');

        Route::get('/restaurants/{restaurant}/qr-print-menu', [VendorRestaurantController::class, 'printMenuQr'])->name('restaurants.qr-print-menu');
        Route::get('/restaurants/{restaurant}/edit', [VendorRestaurantController::class, 'edit'])->name('restaurants.edit');
        Route::patch('/restaurants/{restaurant}', [VendorRestaurantController::class, 'update'])->name('restaurants.update');

        Route::resource('branches', VendorBranchController::class)->except(['show']);

        Route::resource('tables', VendorRestaurantTableController::class)
            ->except(['show'])
            ->parameters(['tables' => 'restaurant_table']);
        Route::post('/tables/{restaurant_table}/regenerate-qr', [VendorRestaurantTableController::class, 'regenerateQr'])->name('tables.regenerate-qr');
        Route::get('/tables/{restaurant_table}/qr-print', [VendorRestaurantTableController::class, 'printQr'])->name('tables.qr-print');

        Route::get('/opening-hours', [VendorOpeningHoursController::class, 'edit'])->name('opening-hours.edit');
        Route::put('/opening-hours', [VendorOpeningHoursController::class, 'update'])->name('opening-hours.update');

        Route::get('/delivery', [VendorDeliveryController::class, 'index'])->name('delivery.index');
        Route::post('/delivery/zones', [VendorDeliveryController::class, 'storeZone'])->name('delivery.zones.store');
        Route::patch('/delivery/zones/{delivery_zone}', [VendorDeliveryController::class, 'updateZone'])->name('delivery.zones.update');
        Route::delete('/delivery/zones/{delivery_zone}', [VendorDeliveryController::class, 'destroyZone'])->name('delivery.zones.destroy');
        Route::post('/delivery/fee-rules', [VendorDeliveryController::class, 'storeRule'])->name('delivery.fee-rules.store');
        Route::patch('/delivery/fee-rules/{delivery_fee_rule}', [VendorDeliveryController::class, 'updateRule'])->name('delivery.fee-rules.update');
        Route::delete('/delivery/fee-rules/{delivery_fee_rule}', [VendorDeliveryController::class, 'destroyRule'])->name('delivery.fee-rules.destroy');

        Route::get('/orders', [VendorOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [VendorOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [VendorOrderController::class, 'updateStatus'])->name('orders.update-status');

        Route::get('/menu/categories', [VendorMenuCategoryController::class, 'index'])->name('menu.categories.index');
        Route::get('/menu/categories/create', [VendorMenuCategoryController::class, 'create'])->name('menu.categories.create');
        Route::post('/menu/categories', [VendorMenuCategoryController::class, 'store'])->name('menu.categories.store');
        Route::get('/menu/categories/{category}/edit', [VendorMenuCategoryController::class, 'edit'])->name('menu.categories.edit');
        Route::patch('/menu/categories/{category}', [VendorMenuCategoryController::class, 'update'])->name('menu.categories.update');
        Route::delete('/menu/categories/{category}', [VendorMenuCategoryController::class, 'destroy'])->name('menu.categories.destroy');

        Route::resource('staff', VendorStaffController::class)->except(['show'])
            ->parameters(['staff' => 'staff']);
        Route::delete('/staff/{staff}/remove', [VendorStaffController::class, 'destroy'])->name('staff.remove');

        Route::resource('promotions', VendorPromotionController::class)->except(['show']);

        Route::get('/menu/items/{menuItem}/qr-print', [VendorMenuItemController::class, 'printQrCard'])->name('menu.items.qr-print');
        Route::get('/menu/items', [VendorMenuItemController::class, 'index'])->name('menu.items.index');
        Route::get('/menu/items/create', [VendorMenuItemController::class, 'create'])->name('menu.items.create');
        Route::post('/menu/items', [VendorMenuItemController::class, 'store'])->name('menu.items.store');
        Route::get('/menu/items/{menuItem}/edit', [VendorMenuItemController::class, 'edit'])->name('menu.items.edit');
        Route::patch('/menu/items/{menuItem}', [VendorMenuItemController::class, 'update'])->name('menu.items.update');
        Route::delete('/menu/items/{menuItem}', [VendorMenuItemController::class, 'destroy'])->name('menu.items.destroy');
    });
