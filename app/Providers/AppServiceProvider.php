<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\License;
use Carbon\Carbon;

use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   
    
    
    
    
    public function boot(): void
    
    
    {
        
         // Fix for MySQL "Specified key was too long" error
        Schema::defaultStringLength(191);
        
        View::composer('layouts.navbars.auth.nav', function ($view) {
        $licenseKey = null;

        if (Auth::check()) {
            $license = License::where('user_id', Auth::id())
                ->where('status', 'active')
                ->where(function($q){
                    $q->whereNull('expiration_date')
                      ->orWhere('expiration_date', '>', Carbon::now());
                })
                ->orderBy('created_at','desc')
                ->first();

            if ($license) {
                $licenseKey = $license->license_key;
            }
        }

        $view->with('licenseKey', $licenseKey);
    });
    }
}
