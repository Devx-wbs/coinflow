@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0">
            <h5 class="mb-0">Edit User</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user-role-permission.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Subadmin</option>
                            <option value="3" {{ $user->role == 3 ? 'selected' : '' }}>Support</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Active" {{ $user->status == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $user->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="mb-3">Module Permissions</h6>
                <div class="table-responsive">
                    @php
                        use Spatie\Permission\Models\Permission;
                        $modules = [
                            'Dashboard',
                            'Subscribe Stores',
                            'License Management',
                            'User Roles & Permission',
                         
                            'Store Earnings',
                            'Plan Management',
                            'Logs & Errors',
                            'Merchant Contacts',
                            'Support',
                            'Global Setting',
                            'Update Tracker',
                            'Push Notices'
                        ];
                    @endphp

                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Module Name</th>
                                <th class="text-center">View</th>
                                <th class="text-center">Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($modules as $module)
                                @php
                                    $viewPerm = strtolower(str_replace([' ', '&'], ['_', 'and'], $module)) . '_view';
                                    $editPerm = strtolower(str_replace([' ', '&'], ['_', 'and'], $module)) . '_edit';
                                @endphp
                                <tr>
                                    <td>{{ $module }}</td>
                                    <td class="text-center">
                                        <input type="checkbox" name="permissions[]" 
                                            value="{{ $viewPerm }}"
                                            {{ Permission::where('name', $viewPerm)->exists() && $user->hasPermissionTo($viewPerm) ? 'checked' : '' }}>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="permissions[]" 
                                            value="{{ $editPerm }}"
                                            {{ Permission::where('name', $editPerm)->exists() && $user->hasPermissionTo($editPerm) ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('user-role-permission') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
