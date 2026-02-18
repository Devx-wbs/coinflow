@extends('layouts.user_type.auth')

@section('content')
@php
use App\Models\Notification;
@endphp

<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Notification Details</h4>
            <p class="text-muted mb-0">
                View complete information about this push notice.
            </p>
        </div>

        {{-- Status Badge --}}
        <span class="badge 
            {{ $notification->status === 'draft' ? 'bg-warning' : 'bg-success' }}">
            {{ strtoupper($notification->status) }}
        </span>
    </div>


    {{-- Main Notification Card --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            {{-- Title --}}
            <h5 class="fw-bold mb-3">
                {{ $notification->title }}
            </h5>

            {{-- Message Box --}}
            <div class="bg-light rounded-3 p-3 mb-4">
                <label class="form-label fw-semibold text-muted mb-1">
                    Message Content
                </label>

                <p class="mb-0" style="white-space: pre-line;">
                    {{ $notification->message }}
                </p>
            </div>

            {{-- Meta Info Row --}}
            <div class="row g-3 mb-4">

                {{-- Target Audience --}}
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-white">
                        <small class="text-muted fw-semibold d-block mb-1">
                            Target Audience
                        </small>
                        <span class="fw-bold">
                            {{ Notification::getTargetLabel($notification->role_id) }}
                        </span>
                    </div>
                </div>

                {{-- Created At --}}
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-white">
                        <small class="text-muted fw-semibold d-block mb-1">
                            Created At
                        </small>
                        <span class="fw-bold">
                            {{ $notification->created_at->format('d M Y, h:i A') }}
                        </span>
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-white">
                        <small class="text-muted fw-semibold d-block mb-1">
                            Current Status
                        </small>

                        <span class="badge 
                            {{ $notification->status === 'draft' ? 'bg-warning' : 'bg-success' }}">
                            {{ ucfirst($notification->status) }}
                        </span>
                    </div>
                </div>

            </div>


            {{-- Action Buttons --}}
            @if($notification->status === 'draft')
            <div class="d-flex gap-2">

                {{-- Edit Draft --}}
                <a href="{{ route('push.notice.edit', $notification->id) }}"
                    class="btn btn-outline-success px-4">
                    <i class="fa fa-edit me-1"></i> Edit Draft
                </a>

                {{-- Send Now --}}
                <form method="POST"
                    action="{{ route('push.notice.send', $notification->id) }}">
                    @csrf
                    <button class="btn btn-primary px-4">
                        <i class="fa fa-paper-plane me-1"></i> Send Now
                    </button>
                </form>

            </div>

            @endif

        </div>
    </div>

</div>



<!-- Notification Logs -->
<div class="card shadow-sm">
    <div class="card-body">
        <h5 class="mb-3">Notification Logs</h5>
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Sent At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->user->name ?? 'N/A' }}</td>
                    <td>{{ $log->user->email ?? 'N/A' }}</td>
                    <td>
                        @if($log->status)
                        <span class="badge {{ $log->status_badge_class }}">
                            {{ ucfirst($log->status) }}
                        </span>
                        @else
                        <span class="badge bg-secondary">N/A</span>
                        @endif
                    </td>
                    <td>{{ $log->created_at ? $log->created_at->format('d M Y, h:i:s A') : 'Pending' }}</td>
                    <td>{{ $log->updated_at ? $log->updated_at->format('d M Y, h:i:s A') : 'Pending' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">No logs found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection