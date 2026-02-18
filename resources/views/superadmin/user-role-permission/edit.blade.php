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
                        <select name="role_id" class="form-select" required>
                            <option value="">Select Role</option>

                            @foreach ($roles as $role)
                            <option value="{{ $role->id }}"
                                {{ $user->role == $role->id ? 'selected' : '' }}>
                                {{ $role->name}}
                            </option>
                            @endforeach
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

                

               

                <div id="permission-section">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 fw-semibold">Assign Permissions</h6>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="select-all">
                            <label class="form-check-label fw-medium" for="select-all">
                                Select All
                            </label>
                        </div>
                    </div>

                    <div class="permission-box p-3 rounded">
                        <div class="row">
                            @foreach($permissions as $permission)
                            <div class="col-md-4 mb-2">
                                <div class="form-check permission-item">
                                    <input class="form-check-input permission-checkbox"
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->name }}"
                                        id="perm_{{ $loop->index }}"
                                        {{ in_array($permission->name, $userPermissions) ? 'checked' : '' }}>

                                    <label class="form-check-label" for="perm_{{ $loop->index }}">
                                        {{ ucfirst(str_replace('-', ' ', $permission->name)) }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

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

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const roleSelect = document.querySelector("select[name='role_id']");
        const permissionSection = document.getElementById("permission-section");
        const selectAll = document.getElementById("select-all");
        const checkboxes = document.querySelectorAll(".permission-checkbox");

        function togglePermissionSection() {
            const selectedText = roleSelect.options[roleSelect.selectedIndex].text.toLowerCase();

            if (selectedText === 'admin') {
                permissionSection.style.display = "none";
                checkboxes.forEach(cb => cb.checked = false);
                if (selectAll) selectAll.checked = false;
            } else {
                permissionSection.style.display = "block";
            }
        }

        // Run on change
        roleSelect.addEventListener("change", togglePermissionSection);

        // Run on page load
        togglePermissionSection();

        // Select All logic
        if (selectAll) {
            selectAll.addEventListener("change", function() {
                checkboxes.forEach(cb => cb.checked = this.checked);
            });
        }

    });
</script>