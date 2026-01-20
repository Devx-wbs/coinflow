<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  
public function showLoginForm()
{
    if (Auth::check()) {
        $user = Auth::user();

        // 🔹 Super Admin (Role 1): always dashboard
        if ($user->role == 1) {
            return redirect()->route('dashboard');
        }

        // Other roles: redirect to their first accessible module
        $modules = [
            'Dashboard' => 'dashboard',
            'Subscribe Stores' => 'subscribe-store',
            'License Management' => 'license_managment',
            'User Roles & Permission' => 'user-role-permission',
            'Global Stats' => 'global-stats',
            'Store Earnings' => 'store-earning',
            'Plan Management' => 'plans-index',
            'Logs & Errors' => 'logs-error',
            'Merchant Contacts' => 'merchant-contact',
            'Support' => 'support',
            'Global Setting' => 'global-setting',
            'Update Tracker' => 'update-tracker',
            'Push Notices' => 'push-notice',
        ];

        foreach ($modules as $module => $route) {
            $viewPerm = strtolower(str_replace([' ', '&'], ['_', 'and'], $module)) . '_view';
            $editPerm = strtolower(str_replace([' ', '&'], ['_', 'and'], $module)) . '_edit';


            if ($user->hasPermissionTo($viewPerm) || $user->hasPermissionTo($editPerm)) {

                if (\Route::has($route)) {
                    return redirect()->route($route);
                }
            }
        }

        return redirect('/');
    }

    return view('session.login-session');
}




    // Handle login
   public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
        // 'g-recaptcha-response' => ['required', 'captcha'], // ✅ Add this line
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->role == 1) {
            return redirect()->route('dashboard');
        }

        if ($user->role == 0) {
            return redirect('/');
        }

        $modules = [
            'Dashboard' => 'dashboard',
            'Subscribe Stores' => 'subscribe-store',
            'License Management' => 'license_managment',
            'User Roles & Permission' => 'user-role-permission',
            'Global Stats' => 'global-stats',
            'Store Earnings' => 'store-earning',
            'Plan Management' => 'plans-index',
            'Logs & Errors' => 'logs-error',
            'Merchant Contacts' => 'merchant-contact',
            'Support' => 'support',
            'Global Setting' => 'global-setting',
            'Update Tracker' => 'update-tracker',
            'Push Notices' => 'push-notice',
        ];

        foreach ($modules as $module => $route) {
            $viewPerm = strtolower(str_replace([' ', '&'], ['_', 'and'], $module)) . '_view';
            $editPerm = strtolower(str_replace([' ', '&'], ['_', 'and'], $module)) . '_edit';

            if ($user->hasPermissionTo($viewPerm) || $user->hasPermissionTo($editPerm)) {
                if (\Route::has($route)) {
                    return redirect()->route($route);
                }
            }
        }

        return redirect('/');
    }

    return back()->withErrors([
        'email' => 'These credentials do not match our records.',
    ]);
}


 
  



    public function logout(Request $request)
    {
        Auth::logout();                     
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        return redirect('/login');          
    }



    // comment
    
} 
