<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Show Profile Page
    public function showProfile()
    {
        // ✅ Remove extra space in view name and ensure correct folder path
        return view('profile');
    }

    // Update Profile (Name)
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->update(['name' => $request->name]);

        return back()->with('success', 'Profile updated successfully.');


    }

    // Change Password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        // Check current password match
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update new password
        Auth::user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('password_success', 'Password changed successfully.');

    }



    
}
