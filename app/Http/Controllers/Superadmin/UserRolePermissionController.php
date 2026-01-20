<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use App\Models\LicenseActivation;
use App\Models\License;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Mail;





class UserRolePermissionController extends Controller
{
    public function index(){
        $users = User::whereIn('role', [2,3])->get(); // Only Subadmin/Admin & Support
        return view('superadmin.user-role-permission.index', compact('users'));
    }

    
    
    public function create(){
        return view('superadmin.user-role-permission.create');
    }
    
    
   public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'role' => 'required|in:2,3',
        'status' => 'required|in:Active,Inactive',
    ]);

    $user = new User();
    $user->name = $validated['name'];
    $user->email = $validated['email'];
    $user->role = $validated['role'];
    $user->status = $validated['status'];

    // Generate random password
    $randomPassword = Str::random(10);
    $user->password = bcrypt($randomPassword);
    $user->save();

    // Assign Role
    $roleName = $user->role == 2 ? 'Subadmin' : 'Support';
    Role::findOrCreate($roleName, 'web');
    $user->assignRole($roleName);

    // Assign Permissions (if any)
    if ($request->has('permissions')) {
        foreach ($request->input('permissions') as $permName) {
            $permission = Permission::firstOrCreate(
                ['name' => $permName, 'guard_name' => 'web']
            );
            $user->givePermissionTo($permission);
        }
    }

    // ✅ Send Email directly
    $subject = "Your Account Has Been Created - Coin Flow";
    $message = "
        Hello {$user->name},\n\n
        Your account has been created successfully!\n\n
        Role: {$roleName}\n
        Email: {$user->email}\n
        Password: {$randomPassword}\n\n
        Please login and change your password after first login.\n\n
        Regards,\nCoin Flow Team
    ";

    Mail::raw($message, function ($mail) use ($user, $subject) {
        $mail->to($user->email)
             ->subject($subject);
    });

    return redirect()->route('user-role-permission')
        ->with('success', 'User created successfully with assigned role and email sent!');
}


  public function edit($id)
{
    $user = User::findOrFail($id);

    // ✅ Ensure all permissions exist (auto-create missing ones)
    $modules = [
        'Dashboard',
        'Subscribe Stores',
        'License Management',
        'User Roles & Permission',
        'Global Stats',
        'Store Earnings',
        'Plan Management',
        'Logs & Errors',
        'Merchant Contacts',
        'Support',
        'Global Setting',
        'Update Tracker',
        'Push Notices'
    ];

    foreach ($modules as $module) {
        $viewPerm = strtolower(str_replace([' ', '&'], ['_', 'and'], $module)) . '_view';
        $editPerm = strtolower(str_replace([' ', '&'], ['_', 'and'], $module)) . '_edit';

        Permission::findOrCreate($viewPerm, 'web');
        Permission::findOrCreate($editPerm, 'web');
    }

    return view('superadmin.user-role-permission.edit', compact('user'));
}
    
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|in:2,3',
        'status' => 'required|in:Active,Inactive',
    ]);

    $user->update($validated);

    // ✅ Sync permissions safely
    $permissions = $request->input('permissions', []);
    $user->syncPermissions($permissions);

    return redirect()->route('user-role-permission')
                     ->with('success', 'User updated successfully with updated permissions!');
}

    
    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->route('user-role-permission')
                         ->with('success', 'User deleted successfully!');
    }

    
    
    
}
