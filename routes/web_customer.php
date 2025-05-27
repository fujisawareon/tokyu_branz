<?php

declare(strict_types=1);

use App\Http\Controllers\Customer\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Customer\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('customer')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('customer_login');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('customer_login_store');
    });

    Route::middleware('auth:customers')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('manager_logout');

        Route::get('top', DashboardController::class)->name('customer_top');
    });
});
