<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{



    public function showLoginForm()
    {
        if (!Auth::check()) {
            return view('session.login-session'); // guest sees login
        }

        $user = Auth::user();

        // Super Admin → dashboard (role == 1)
        if ($user->role == 1) {
            return redirect()->route('dashboard');
        }

        // Normal user → website home
        if ($user->role == 0) {
            return redirect('/');
        }

        // ✅ Get all permissions of user (via roles or direct)
        $permissions = $user->getAllPermissions()->pluck('name');

        foreach ($permissions as $permission) {
            // Only redirect if a route exists with this permission name
            if (\Route::has($permission)) {
                return redirect()->route($permission);
            }
        }

        // fallback if no route found
        return redirect('/');
    }



    public function login(Request $request)
    {
        // First validate everything (including captcha)
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'Captcha verification failed. Please try again.',
        ]);

        // Only take email & password for login
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role == 1) {
                return redirect()->route('dashboard');
            }

            if ($user->role == 0) {
                return redirect('/');
            }

            $permissions = $user->getAllPermissions()->pluck('name');

            foreach ($permissions as $permission) {
                if (\Route::has($permission)) {
                    return redirect()->route($permission);
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
        return redirect()->route('login');
    }



    // comment

}
