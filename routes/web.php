<?php

use App\Http\Controllers\Api\HealthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PricingController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class . '@index')->name('home');
Route::get('/pricing', PricingController::class . '@index')->name('pricing');

Route::get('/api/health', HealthController::class)->name('api.health');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/account.php';
require __DIR__.'/auth.php';
require __DIR__.'/public.php';
require __DIR__.'/vendor.php';
require __DIR__.'/admin.php';
require __DIR__.'/payments.php';
