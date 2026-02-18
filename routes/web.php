<?php

use App\Http\Controllers\Superadmin\SystemLogController;
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
use App\Http\Controllers\PluginController;
use App\Http\Controllers\PushNoticeController;
use App\Http\Controllers\Superadmin\SupportController;

Route::domain('coinflowspay.com')->group(function () {
    // all frontend routes
    Route::get('/', [FrontedController::class, 'index']);

    Route::get('/update-tracker/download/{id}', [MerchantController::class, 'download'])
        ->middleware('plugin.download.secure')
        ->name('update-tracker.download');

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

    Route::get('/contact-us', [SupportController::class, 'form'])
        ->name('contact.form');

    Route::post('/contact-us', [SupportController::class, 'saveform'])
        ->name('contact.store');

    Route::get('/privacy-policy', [FrontedController::class, 'privacyPolicy'])->name('privacy.policy');
    Route::get('/terms-conditions', [FrontedController::class, 'termsConditions'])->name('terms.conditions');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
        #Payment stripe buy
        Route::prefix('buyplan')->group(function () {
            Route::get('/', [BuyplanController::class, 'create'])->name('buyplan.create');
            Route::post('/store', [BuyplanController::class, 'store'])->name('buyplan.store');
            Route::get('/success', [BuyplanController::class, 'success'])->name('buyplan.success');
            Route::get('/cancel', [BuyplanController::class, 'cancel'])->name('buyplan.cancel');
        });

        Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile.show');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    });
});



// Pricing page
// Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');

// Routes protected by auth middleware

Route::domain('admincp.coinflowspay.com')->middleware(['auth', 'route.permission'])->group(function () {
    // Route::middleware('route.permission')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/login', [LoginController::class, 'showAdminLoginForm'])
        ->name('admin.login');

    Route::post('/login', [LoginController::class, 'adminLogin'])
        ->name('admin.login.post');
    Route::prefix('plans')->group(function () {
        Route::get('/', [PlanController::class, 'index'])->name('plans-index');
        Route::get('/create', [PlanController::class, 'create'])->name('plan-create');
        Route::post('/', [PlanController::class, 'store'])->name('plan-store');
        Route::get('/{plan}/edit', [PlanController::class, 'edit'])->name('plan-edit');
        Route::put('/{plan}', [PlanController::class, 'update'])->name('plan-update');
        Route::delete('/{plan}', [PlanController::class, 'destroy'])->name('plan-destroy');
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






    //update plugin

    Route::prefix('update-tracker')->group(function () {
        // Dashboard Page
        Route::get('/', action: [PluginController::class, 'update_tracker_index'])->name('update-tracker.index');
        // Add Plugin Version
        Route::post('/add', [PluginController::class, 'add_plugin'])->name('update-tracker.add');
        // Delete Plugin Version
        Route::delete('/delete/{id}', [PluginController::class, 'destroy'])->name('update-tracker.delete');
        // Export Plugin Report
        Route::get('/export', [PluginController::class, 'exportPluginReport'])->name('update-tracker.export');

        // Send Update Notice Emails
        Route::post('/send-notice/{pluginVersion}', [PluginController::class, 'sendUpdateNotice'])->name('update-tracker.sendNotice');
        // Download Plugin ZIP
        Route::get('/download/{id}', [PluginController::class, 'download'])->name('update-tracker.download');

        Route::put('/update/{id}', [PluginController::class, 'update'])
            ->name('update-tracker.update');
    });




    // support
    Route::prefix('support')->group(function () {
        Route::post('/{id}/reply', [SupportController::class, 'reply'])->name('support.reply');
        Route::get('/', [SupportController::class, 'index'])->name('support');
        Route::get('/create', [SupportController::class, 'create'])->name('support.create');
        Route::post('/store', [SupportController::class, 'store'])->name('support.store');
        Route::get('/view/{id}', [SupportController::class, 'show'])->name('support.show');
        Route::get('/delete/{id}', [SupportController::class, 'destroy'])->name('support.destroy');
        Route::post('/{id}/assign', [SupportController::class, 'assignTo'])->name('support.assign');
        Route::post('/{id}/status', [SupportController::class, 'updateStatus'])->name('support.updateStatus'); // ✅ added
    });

    // user Roles & permission
    // push Notices
    // Route::get('/push-notice', [MerchantController::class, 'push_notice_index'])->name('push-notice');

    Route::prefix('push-notice')->name('push.notice.')->group(function () {
        Route::get('/', [PushNoticeController::class, 'index'])->name('index');
        Route::post('/store', [PushNoticeController::class, 'store'])->name('store');
        Route::get('/view/{notification}', [PushNoticeController::class, 'show'])->name('show');
        Route::post('/{notification}/resend', [PushNoticeController::class, 'resend'])->name('send');
        // Update notification message
        Route::post('/{notification}/update', [PushNoticeController::class, 'update'])->name('update');
        Route::get('/{notification}/edit', [PushNoticeController::class, 'edit'])->name('edit');
    });


    //global setting

    Route::get('/global-setting', [GlobalSettingController::class, 'index'])->name('global-setting');
    Route::post('global-settings/save-fee', [GlobalSettingController::class, 'saveFee'])->name('save-fee');
    Route::post('global-settings/save-coins', [GlobalSettingController::class, 'saveCoins'])->name('save-coins');
    Route::post('/global-setting/api-key', [GlobalSettingController::class, 'updateApiKey'])->name('update-api-key');
    Route::post('/global-setting/log-toggle',  [GlobalSettingController::class, 'saveLogToggle'])->name('save-log-toggle');


    //Logs and Errors
    Route::prefix('logs-error')->group(function () {
        Route::delete('/delete-all', [SystemLogController::class, 'deleteAll'])->name('logs.deleteAll');
        Route::get('/', [SystemLogController::class, 'index'])->name('logs.index');
        Route::get('/{id}', [SystemLogController::class, 'show'])->name('logs.show');
        Route::delete('/{id}', [SystemLogController::class, 'destroy'])->name('logs.delete');
        Route::post('/export', [SystemLogController::class, 'export'])->name('logs.export');
    });
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


});
