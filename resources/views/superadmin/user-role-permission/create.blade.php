@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0">
            <h5 class="mb-0">Create New User</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('user-role-permission.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">Select Role</option>
                            <option value="2">Subadmin</option>
                            <option value="3">Support</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Permissions Table --}}
                <h6 class="mb-3">Assign Permissions</h6>
                <div class="table-responsive">
                    @php
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
                                <tr>
                                    <td>{{ $module }}</td>
                                    <td class="text-center">
                                        <input type="checkbox" 
                                            name="permissions[]" 
                                            value="{{ strtolower(str_replace([' ', '&'], ['_', 'and'], $module)).'_view' }}">
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" 
                                            name="permissions[]" 
                                            value="{{ strtolower(str_replace([' ', '&'], ['_', 'and'], $module)).'_edit' }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('user-role-permission') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save User</button>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
