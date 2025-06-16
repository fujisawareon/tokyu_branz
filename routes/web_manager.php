<?php

declare(strict_types=1);

use App\Http\Controllers\Manager\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Manager\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Manager\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Manager\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Manager\Auth\NewPasswordController;
use App\Http\Controllers\Manager\Auth\PasswordController;
use App\Http\Controllers\Manager\Auth\PasswordResetLinkController;
use App\Http\Controllers\Manager\Auth\VerifyEmailController;
use App\Http\Controllers\Manager\DashboardController;
use App\Http\Controllers\Manager\TestController;
use App\Http\Controllers\Manager\BuildingController;
use App\Http\Controllers\Manager\ManagerController;
use App\Http\Controllers\Manager\ProjectCustomerController;
use App\Http\Controllers\Manager\ProjectContentsController;
use App\Http\Controllers\Manager\LimitedContents\ImageGalleryController;
use App\Http\Controllers\Manager\LimitedContents\BuildingMovieController;
use App\Http\Controllers\Manager\ProjectHomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('manager')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('sara_login');
        Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('sara_login_store');
        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('manager_password_request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('manager_password_email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('manager_password_reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('manager_password_store');
    });

    Route::middleware('auth:managers')->group(function () {
        Route::get('verify-email', EmailVerificationPromptController::class)->name('manager_verification_notice');
        Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
            ->middleware(['signed', 'throttle:6,1'])->name('manager_verification_verify');
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
            ->middleware('throttle:6,1')->name('manager_verification_send');
        Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('manager_password_confirm');
        Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
        Route::put('password', [PasswordController::class, 'update'])->name('manager_password');
        Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('manager_logout');

        Route::get('dashboard', DashboardController::class)->name('manager_dashboard');
        Route::post('dashboard', DashboardController::class)->name('manager_dashboard');

        Route::get('test', TestController::class)->name('manager_test');

        Route::prefix('building')->middleware('auth.building')->group(function () {
            Route::get('list', [BuildingController::class, 'index'])->name('manager_building_list');
            Route::get('get-building-list', [BuildingController::class, 'getBuildingList'])->name('manager_get_building_list');
            Route::get('create', [BuildingController::class, 'create'])->name('manager_building_create');
            Route::post('create', [BuildingController::class, 'createConfirm'])->name('manager_building_create_confirm');
            Route::post('register', [BuildingController::class, 'register'])->name('manager_building_register');
            Route::get('basic-setting/{building}', [BuildingController::class, 'basicSetting'])->name('manager_building_basic_setting');
            Route::post('basic-setting-update/{building}', [BuildingController::class, 'basicSettingUpdate'])->name('manager_building_update');
        });

        Route::prefix('user')->group(function () {
            Route::get('list', [ManagerController::class, 'list'])->name('manager_user_list');
            Route::get('show/{manager}', [ManagerController::class, 'show'])->name('manager_user_show');
            Route::post('show/{manager}', [ManagerController::class, 'update'])->name('manager_user_update');
            Route::post('building-invitation/{manager}', [ManagerController::class, 'invitation'])->name('manager_user_building_invitation');
        });

        Route::get('customer/list', DashboardController::class)->name('manager_customer_list');
        Route::get('download', DashboardController::class)->name('manager_download');

        // 物件選択後
        Route::prefix('building/{building}')->middleware('auth.building')->group(function () {
            // プロジェクトホーム
            Route::get('home', ProjectHomeController::class)->name('manager_project_home');

            // 顧客一覧
            Route::get('customer-analysis', [ProjectCustomerController::class, 'index'])->name('manager_project_customer');
            Route::post('customer-list-show-column', [ProjectCustomerController::class, 'updateDisplayColumn'])->name('manager_project_customer_show_column');

            Route::get('get-customer-list', [ProjectCustomerController::class, 'getCustomerList'])
                ->name('manager_project_get_customer_list');
            Route::get('customer-list/{customer}/toggle-pin', [ProjectCustomerController::class, 'test']);
            Route::get('get-customer-access-analysis-list', [ProjectCustomerController::class, 'getCustomerAccessAnalysisList'])
                ->name('manager_project_get_customer_access_analysis_list');

            Route::get('customer-create', [ProjectCustomerController::class, 'create'])->name('manager_project_customer_create');
            Route::post('customer-register', [ProjectCustomerController::class, 'register'])->name('manager_project_customer_register');
            Route::get('customer-show/{customer}', [ProjectCustomerController::class, 'show'])->name('manager_project_customer_show');

            // コンテンツ管理
            Route::get('contents', [ProjectContentsController::class, 'index'])->name('manager_project_contents');
            // 物件設定
            Route::get('sales-status', [ProjectContentsController::class, 'salesStatus'])->name('manager_project_sales_status');
            Route::post('sales-status', [ProjectContentsController::class, 'salesStatusUpdate']);
            Route::get('sales-schedule', [ProjectContentsController::class, 'salesSchedule'])->name('manager_project_sales_schedule');
            Route::post('sales-schedule', [ProjectContentsController::class, 'salesScheduleUpdate']);
            Route::get('action-btn', [ProjectContentsController::class, 'actionBtn'])->name('manager_project_action_btn');
            Route::post('action-btn', [ProjectContentsController::class, 'actionBtnUpdate']);

            // コンテンツ機能管理
            Route::get('limited-content', [ProjectContentsController::class, 'limitedContent'])->name('manager_project_limited_content');
            Route::post('limited-content', [ProjectContentsController::class, 'limitedContentUpdate']);
            Route::get('share-content', [ProjectContentsController::class, 'shareContent'])->name('manager_project_share_content');
            Route::post('share-content', [ProjectContentsController::class, 'shareContentUpdate']);
            Route::get('information', [ProjectContentsController::class, 'information'])->name('manager_project_information');

            // 各種コンテンツ管理
            Route::get('building_movie/{movie_type}', [BuildingMovieController::class, 'index'])->name('manager_project_building_movie');
            Route::post('building_movie_category_update/{movie_type}', [BuildingMovieController::class, 'categoryUpdate'])->name('building_movie_category_update');
            Route::post('building_movie_add/{movie_type}', [BuildingMovieController::class, 'addMovie'])->name('manager_project_building_movie_add');

            Route::prefix('image_gallery')->group(function () {
                Route::get('', [ImageGalleryController::class, 'index'])->name('manager_project_image_gallery');
                Route::post('add', [ImageGalleryController::class, 'addImage'])->name('manager_project_image_gallery_add');
                Route::post('update', [ImageGalleryController::class, 'update'])->name('manager_project_image_gallery_update');
                Route::delete('{image_gallery}/delete', [ImageGalleryController::class, 'delete'])->name('manager_project_image_gallery_delete');
            });
        });

    });
});
