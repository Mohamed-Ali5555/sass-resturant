<?php

use App\Http\Controllers\Hub\HubFavoriteController;
use App\Http\Controllers\Hub\HubOrderController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('account')->name('account.')->group(function (): void {
    Route::get('/orders', [HubOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [HubOrderController::class, 'show'])->name('orders.show');
    Route::get('/favorites', [HubFavoriteController::class, 'index'])->name('favorites.index');
    Route::view('/help', 'account.help')->name('help');
});
