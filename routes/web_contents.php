<?php

declare(strict_types=1);

use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Content\ManagerLimitedContentController;
use App\Http\Controllers\Content\CustomerLimitedContentController;
use Illuminate\Support\Facades\Route;

Route::prefix('contents')->group(function () {
    Route::middleware('auth:managers')->group(function () {
        Route::prefix('manager')->group(function () {
            Route::get('{building}/{page_name}', ManagerLimitedContentController::class)->name('contents_manager');
        });
    });

    Route::middleware('auth:customers')->group(function () {
        Route::prefix('customer')->group(function () {

            Route::get('{building}/{page_name}', CustomerLimitedContentController::class)->name('contents_customer');
        });
    });
});
