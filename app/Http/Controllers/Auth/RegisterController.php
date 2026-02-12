<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect('/'); // logged in → redirect to pricing
        }
        return view('session.register'); // not logged in → show register page
    }
   
   public function store(Request $request)
    {
        // validate inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            // 'country' => 'nullable|string|max:100',
            // 'store_name' => 'required|string|max:255',
        ]);
    
        // create user
        $user = User::create([
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'] ?? null,
            'country'      => $validated['country'] ?? null,
            // 'store_name' => $validated['store_name'] ?? null,
            'password'     => bcrypt($validated['password']),
            'role'         => 0, // default merchant role
        ]);
        
        
         // Direct/raw mail:
        Mail::raw(
            "New user registered!\n\nName: {$user->name}\nEmail: {$user->email}\nStore Name: {$user->store_name}",
            function ($message) {
                $message->to('dev.webblazesofttech@gmail.com')  // admin email
                        ->subject('New User Registered');
            }
        );


    
        // auto-login after registration
        Auth::login($user);
    
        // redirect to pricing page
        return redirect('/')->with('success', 'Registration successful! Please choose a subscription plan.');
    }
}
