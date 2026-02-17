@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    {{-- Success Message --}}
    @if(session('success'))
    <div id="success-message" class="alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3 z-index-3" style="width: auto;">
        {{ session('success') }}
    </div>
    @endif

    <div class="mb-2">
        <h4 class="mb-3">User Roles & Permissions</h4>
        <span class="text-muted">Manage users and their access permissions</span>
    </div>

    <div class="card shadow-sm">
        <div class="card-body px-0">
            <div class="d-flex justify-content-between align-items-center mb-3 px-4">
                <span style="font-weight:600; font-size:1.15rem;">
                    <svg width="22" height="22" viewBox="0 0 20 20" fill="none" style="margin-right:8px;">
                        <circle cx="10" cy="10" r="10" fill="#f0f1f7" />
                        <path d="M10 7a3 3 0 100 6 3 3 0 000-6zM10 16.5c-2.485 0-7 1.243-7-1.5V13a7 7 0 0114 0v2c0 2.743-4.515 1.5-7 1.5z" fill="#222" />
                    </svg>
                    User Management
                </span>

                <button type="button"
                    class="btn btn-primary"
                    style="border-radius:8px;min-width:108px;"
                    onclick="window.location.href='{{ route('user-role-permission.create') }}'">
                    + Add User
                </button>
            </div>

            <div class="table-responsive px-2">
                <table class="table mb-0" style="background:transparent; border-collapse:separate; border-spacing:0 10px;">
                    <thead>
                        <tr style="background:#fff;">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr style="background:#f8fafd; border-radius:14px;box-shadow:0 1px 4px 0 rgba(0,0,0,0.03);">
                            <td style="font-weight:600;">{{ $user->name }}</td>
                            <td class="text-muted">{{ $user->email }}</td>

                            {{-- Role Badge --}}
                            <td>
                                @php
                                $roleName = match($user->role){
                                1 => 'Admin',
                                2 => 'Subadmin',
                                3 => 'Support',
                                default => 'Unknown',
                                };
                                $roleColors = [
                                'Admin' => ['bg' => '#eedaff', 'text' => '#a24bcf'],
                                'Subadmin' => ['bg' => '#eedaff', 'text' => '#a24bcf'],
                                'Support' => ['bg' => '#e4f7ea', 'text' => '#37c978'],
                                ];
                                $colors = $roleColors[$roleName];
                                @endphp
                                <span style="background:{{ $colors['bg'] }}; color:{{ $colors['text'] }}; padding:4px 18px; border-radius:12px; font-size:14px;">
                                    {{ $roleName }}
                                </span>
                            </td>

                            {{-- Status Badge --}}
                            <td>
                                @if($user->status == 'Active')
                                <span style="background:#e4f7ea;color:#37c978;padding:4px 18px;border-radius:12px;font-size:14px;">Active</span>
                                @else
                                <span style="background:#ededed;color:#a6a6a6;padding:4px 18px;border-radius:12px;font-size:14px;">Inactive</span>
                                @endif
                            </td>

                            {{-- Action Buttons --}}
                            <td>
                                {{-- Edit --}}
                                <a href="{{ route('user-role-permission.edit', $user->id) }}" class="border-0 bg-white me-2 d-inline-block" style="padding:6px 9px;border-radius:8px;">
                                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                                        <path d="M4 17.25V20h2.75l8.065-8.064-2.75-2.75L4 17.25zm15.673-9.673a.996.996 0 000-1.41l-2.54-2.54a.996.996 0 00-1.41 0l-1.83 1.83 3.95 3.95 1.83-1.83z" fill="#299CDF" />
                                    </svg>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('user-role-permission.destroy', $user->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="border-0 bg-white" style="padding:6px 9px;border-radius:8px;">
                                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24">
                                            <path d="M5 6h14M9 6V4h6v2M10 11V17M14 11V17M4 6V20c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V6" stroke="#E45F68" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Auto hide success message --}}
<script>
    setTimeout(function() {
        const msg = document.getElementById('success-message');
        if (msg) {
            msg.style.display = 'none';
        }
    }, 5000); // 5 seconds
</script>
@endsection