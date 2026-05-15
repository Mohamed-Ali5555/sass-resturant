<?php

use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Public\CheckoutController;
use App\Http\Controllers\Public\OrderController;
use App\Http\Controllers\Public\PublicMenuItemController;
use App\Http\Controllers\Public\RestaurantMenuController;
use App\Http\Controllers\Public\RestaurantTableQrController;
use App\Http\Middleware\EnsurePublicRestaurantMenu;
use App\Http\Middleware\EnsureRestaurantAcceptsOrders;
use Illuminate\Support\Facades\Route;

Route::prefix('r/{restaurant:slug}')->group(function () {
    Route::get('/t/{qr_token}', [RestaurantTableQrController::class, 'visit'])
        ->middleware([EnsurePublicRestaurantMenu::class])
        ->where('qr_token', '[a-z0-9]{32,64}')
        ->name('public.restaurant.table');

    Route::get('/session/clear-table', [RestaurantTableQrController::class, 'clear'])
        ->middleware([EnsurePublicRestaurantMenu::class])
        ->name('public.restaurant.table.clear');

    Route::get('/i/{item}', [PublicMenuItemController::class, 'show'])
        ->middleware([EnsurePublicRestaurantMenu::class])
        ->whereNumber('item')
        ->name('public.menu.item');

    Route::get('/', [RestaurantMenuController::class, 'show'])
        ->middleware([EnsurePublicRestaurantMenu::class])
        ->name('public.restaurant.show');

    Route::middleware([EnsurePublicRestaurantMenu::class])->group(function () {
        Route::get('/cart', [CartController::class, 'index'])->name('public.cart.index');
    });

    Route::middleware([EnsurePublicRestaurantMenu::class, EnsureRestaurantAcceptsOrders::class])->group(function () {
        Route::post('/cart', [CartController::class, 'store'])->name('public.cart.store');
        Route::patch('/cart', [CartController::class, 'update'])->name('public.cart.update');
        Route::delete('/cart/{menuItem}', [CartController::class, 'destroy'])->name('public.cart.destroy');

        Route::get('/checkout', [CheckoutController::class, 'create'])->name('public.checkout.show');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('public.checkout.store');
    });

    Route::middleware([EnsurePublicRestaurantMenu::class])->group(function () {
        Route::get('/order/{publicRef}', [OrderController::class, 'show'])->name('public.order.show');
    });
});
