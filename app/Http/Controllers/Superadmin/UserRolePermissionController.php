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
    public function index()
    {
        // $users = User::whereIn('role', [2, 3])->get(); // Only Subadmin/Admin & Support
        $users = User::whereIn('role', [ 2, 3])->get();
        return view('superadmin.user-role-permission.index', compact('users'));
    }

    public function create()
    {
        // Fetch roles dynamically
        $roles = Role::whereIn('name', ['sub_admin', 'support'])->get();

        // Fetch all permissions as-is
        $permissions = Permission::orderBy('name')->get();

        return view(
            'superadmin.user-role-permission.create',
            compact('roles', 'permissions')
        );
    }


    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'status' => 'required|in:Active,Inactive',
        ]);

        if ($validated['role'] == 1) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Admin cannot be created from this panel!');
        }

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->status = $validated['status'];

        // Generate random password
        $randomPassword = Str::random(10);
        $user->password = bcrypt($randomPassword);
        // $user->password = bcrypt('Admin@123');
        $user->save();


        $roleName = $user->role == "2" ? 'sub_admin' : 'support';

        // Assign Role
        $user->assignRole($roleName);

        // ✅ If NOT admin, then assign permissions
        if ($request->has('permissions')) {
            foreach ($request->input('permissions') as $permName) {
                $permission = Permission::firstOrCreate(
                    ['name' => $permName, 'guard_name' => 'web']
                );
                $user->givePermissionTo($permission);
            }
        }

        // Send Email


        Mail::send('emails.user-created', [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $roleName,
            'password' => $randomPassword,
        ], function ($mail) use ($user) {

            $mail->to($user->email)
                ->subject('Your Account Has Been Created - Coin Flow');
        });

        return redirect()->route('user-role-permission')
            ->with('success', 'User created successfully with assigned role and email sent!');
    }



    public function edit($id)
    {

        $roles = Role::whereIn('name', ['sub_admin', 'support'])->get();

        // Fetch all permissions as-is
        $permissions = Permission::orderBy('name')->get();
        $user = User::findOrFail($id);
        if ($user->hasRole('admin')) {
            return redirect()->route('user-role-permission')
                ->with('error', 'Admin cannot be edited!');
        }
        $userPermissions = $user->getPermissionNames()->toArray();
        return view('superadmin.user-role-permission.edit', compact('user', 'roles', 'permissions', 'userPermissions'));
    }



    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:Active,Inactive',
        ]);

        // Check if user was admin before update
        $wasAdmin = $user->hasRole('admin');

        // Update basic fields
        $user->update([
            'name'   => $validated['name'],
            'email'  => $validated['email'],
            'role'   => $validated['role_id'],
            'status' => $validated['status'],
        ]);




        // Get selected role
        $role = Role::findOrFail($validated['role_id']);

        // Sync new role
        $user->syncRoles([$role->name]);


        // If not admin → sync selected permissions
        $permissions = $request->input('permissions', []);
        $user->syncPermissions($permissions);


        return redirect()->route('user-role-permission')
            ->with('success', 'User updated successfully!');
    }




    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // ❌ Prevent deleting Admin
        if ($user->hasRole('admin')) {
            return redirect()->back()
                ->with('error', 'Admin user cannot be deleted!');
        }
        $user->delete();

        return redirect()->route('user-role-permission')
            ->with('success', 'User deleted successfully!');
    }
}
