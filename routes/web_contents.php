<?php

declare(strict_types=1);

use App\Http\Controllers\Content\CustomerLimitedContentController;
use App\Http\Controllers\Content\LogController;
use App\Http\Controllers\Content\ManagerLimitedContentController;
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
            Route::post('log_update_stay_time/{building}/{app_log}',  [LogController::class, 'updateStayTime'])->name('contents_customer_log_update_stay_time');
            Route::post('log_create/{building}',  [LogController::class, 'createLog'])->name('contents_customer_log_update_stay_time');
        });
    });
});
