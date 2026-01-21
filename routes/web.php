<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FrontedController;
use App\Http\Controllers\Superadmin\PlanController;
use App\Http\Controllers\Superadmin\DashboardController;
use App\Http\Controllers\Superadmin\MerchantController;
use App\Http\Controllers\Superadmin\GlobalSettingController;
use App\Http\Controllers\Superadmin\UserRolePermissionController;
use App\Http\Controllers\ResetController;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\BuyplanController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\DownloadZipController;






Route::get('/', [FrontedController::class, 'index']);
Route::get('/download-zip', [DownloadZipController::class, 'download'])->name('download.zip');
Route::get('/plan-detail', [FrontedController::class, 'plan_detail'])->name('plan-detail');

// Login form
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Handle login
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

//reset password
Route::get('/resetpassword', [ResetController::class, 'create'])->name('reset.password');
Route::post('/forgot-password', [ResetController::class, 'sendEmail'])->name('forgot.password');
Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

// Registrations
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.post');

// Pricing page
// Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

// Routes protected by auth middleware
Route::middleware(['auth', 'route.permission'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('plans')->group(function () {
        Route::get('/', [PlanController::class, 'index'])->name('plans-index');
        Route::get('/create', [PlanController::class, 'create'])->name('plan-create');
        Route::post('/', [PlanController::class, 'store'])->name('plan-store');
        Route::get('/{plan}/edit', [PlanController::class, 'edit'])->name('plan-edit');
        Route::put('/{plan}', [PlanController::class, 'update'])->name('plan-update');
        Route::delete('/{plan}', [PlanController::class, 'destroy'])->name('plan-destroy');
    });

    #Payment stripe buy
    Route::prefix('buyplan')->group(function () {
        Route::get('/', [BuyplanController::class, 'create'])->name('buyplan.create');
        Route::post('/store', [BuyplanController::class, 'store'])->name('buyplan.store');
        Route::get('/success', [BuyplanController::class, 'success'])->name('buyplan.success');
        Route::get('/cancel', [BuyplanController::class, 'cancel'])->name('buyplan.cancel');
    });

    //merchant contact

    Route::get('/merchant-contact', [MerchantController::class, 'index'])->name('merchant-contact');
    Route::get('merchant-store/{license}', [MerchantController::class, 'viewStores'])->name('merchant.store.view');


    //subscribe store
    Route::get('/subscribe-store', [MerchantController::class, 'subscribe_store_index'])->name('subscribe-store');

    //license management
    Route::get('/license', [MerchantController::class, 'license_managment_index'])->name('license-managment');


    // global stats
    Route::get('/global-stats', [MerchantController::class, 'global_stats_index'])->name('global-stats');


    // store earning 

    // Route::get('/store-earning', [MerchantController::class, 'store_earning_index'])->name('store-earning');


    // logs & errors
    Route::get('/logs-error', [MerchantController::class, 'logs_error_index'])->name('logs-error');


    // update tracker
    Route::get('/update-tracker', [MerchantController::class, 'update_tracker_index'])->name('update-tracker');




    // support
    Route::get('/support', [MerchantController::class, 'support_index'])->name('support');


    // user Roles & permission



    // push Notices
    Route::get('/push-notice', [MerchantController::class, 'push_notice_index'])->name('push-notice');




    //global setting

    Route::get('/global-setting', [GlobalSettingController::class, 'index'])->name('global-setting');
    Route::post('global-settings/save-fee', [GlobalSettingController::class, 'saveFee'])->name('save-fee');
    Route::post('global-settings/save-coins', [GlobalSettingController::class, 'saveCoins'])->name('save-coins');
    Route::post('/global-setting/api-key', [GlobalSettingController::class, 'updateApiKey'])->name('update-api-key');



    // user role permission
    Route::prefix('user-role-permission')->group(function () {
        Route::get('/', [UserRolePermissionController::class, 'index'])->name('user-role-permission');
        Route::get('/create', [UserRolePermissionController::class, 'create'])->name('user-role-permission.create');
        Route::post('/store', [UserRolePermissionController::class, 'store'])->name('user-role-permission.store');
        Route::get('/edit/{id}', [UserRolePermissionController::class, 'edit'])->name('user-role-permission.edit');
        Route::put('/edit/{id}', [UserRolePermissionController::class, 'update'])->name('user-role-permission.update');
        Route::delete('delete/{id}', [UserRolePermissionController::class, 'destroy'])->name('user-role-permission.destroy');
    });

    // update profile

    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
});
