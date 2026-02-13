<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\StorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // Show Profile Page
    public function showProfile()
    {
        return view('profile');
    }

  


    public function update(Request $request, StorageService $storageService)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        $user->update([
            'name' => $request->name
        ]);

        if ($request->hasFile('image')) {

            // ✅ Delete old image (DB + file)
            if ($user->image) {

                $oldStorage = \App\Models\Storage::find($user->image);

                if ($oldStorage) {
                    $storageService->delete($oldStorage);
                }

                // IMPORTANT: clear old id before new upload
                $user->update(['image' => null]);
            }

            // ✅ Upload new file
            $storage = $storageService->upload(
                $request->file('image'),
                $user,
                'profile_images'
            );

            // ✅ Save storage id in user table
            $user->image = $storage->id;
            $user->save();
        }

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
