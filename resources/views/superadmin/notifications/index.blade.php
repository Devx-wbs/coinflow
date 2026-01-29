@extends('layouts.user_type.auth')

@section('content')

@php
use App\Models\Notification;
@endphp

<div class="container-fluid py-4">
    <!-- Page Title & Subtitle -->
    <div class="mb-2">
        <h4 class="mb-2">Push Notices</h4>
        <span class="text-muted">Send announcements and updates to your merchants</span>
    </div>

    <!-- Analytics Cards -->
 

    <div class="row g-3 mb-5">

    {{-- Total Notices --}}
    <div class="col-md-3 col-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-sm text-muted">Total Notices</span>
                    <i class="fa fa-bell"></i>
                </div>

                <h5 class="fw-bold mb-1">{{ $stats['total_notices'] }}</h5>
                <span class="text-sm text-muted">Created overall</span>
            </div>
        </div>
    </div>

    {{-- Total Delivered --}}
    <div class="col-md-3 col-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-sm text-muted">Total Emails Delivered</span>
                    <i class="fa fa-envelope-open"></i>
                </div>

                <h5 class="fw-bold mb-1">{{ $stats['total_delivered'] }}</h5>
                <span class="text-sm text-muted">Across all notices</span>
            </div>
        </div>
    </div>

    {{-- Delivered This Month --}}
    <div class="col-md-3 col-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-sm text-muted">Delivered This Month</span>
                    <i class="fa fa-calendar-check"></i>
                </div>

                <h5 class="fw-bold mb-1">{{ $stats['delivered_this_month'] }}</h5>
                <span class="text-sm text-muted">Current month</span>
            </div>
        </div>
    </div>

    {{-- Draft Notices --}}
    <div class="col-md-3 col-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span class="text-sm text-muted">Draft Notices</span>
                    <i class="fa fa-file-alt"></i>
                </div>

                <h5 class="fw-bold mb-1">{{ $stats['draft_notices'] }}</h5>
                <span class="text-sm text-muted">Saved drafts</span>
            </div>
        </div>
    </div>

</div>


    <!-- Action Buttons -->
    <div class="mb-3">
        <a href="{{ route('push.notice.index', ['tab' => 'create']) }}"
            class="btn btn-outline-secondary me-2 {{ $tab == 'create' ? 'active' : '' }}">
            Create Notice
        </a>

        <a href="{{ route('push.notice.index', ['tab' => 'history']) }}"
            class="btn btn-outline-secondary {{ $tab == 'history' ? 'active' : '' }}">
            Notice History
        </a>
    </div>


    <!-- Create New Announcement Card -->


    @if($tab == 'create')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-4">Create New Announcement</h5>

            <form method="POST" action="{{ route('push.notice.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Notice Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Target Audience</label>
                        <select name="role_id" class="form-select">
                            @foreach($targetAudiences as $id => $label)
                            <option value="{{ $id }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Message</label>
                    <textarea name="message" class="form-control" rows="4"></textarea>
                </div>


                <div class="text-end">

                    <button type="submit" name="action" value="draft"
                        class="btn btn-outline-secondary me-2">
                        <i class="fa fa-file me-1"></i> Save Draft
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-paper-plane me-1"></i> Send Now
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif



    @if($tab == 'history')
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-4">Notice History</h5>

            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Audience</th>
                        <th>Sent Date</th>
                        <th>Status</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($notifications as $notice)
                    <tr>
                        <td>
                            <strong>{{ $notice->title }}</strong><br>
                            <small class="text-muted">
                                {{ Str::limit($notice->message, 50) }}
                            </small>
                        </td>


                        <td>
                            <span class="badge bg-light text-dark">
                                {{ Notification::getTargetLabel($notice->role_id) }}
                            </span>
                        </td>


                        <td>
                            {{ $notice->created_at->format('d M Y, h:i A') }}
                        </td>

                        <td>
                            <span class="badge bg-success">
                                {{ ucfirst($notice->status) }}
                            </span>
                        </td>

                        <td>
                            <a href="{{ route('push.notice.show', $notice->id) }}" class="btn btn-sm btn-outline-primary">
                                View Details
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No notices found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            

            <div class="d-flex justify-content-center mt-4">
                        <div class="card shadow-sm px-3 py-2">
                            {{ $notifications->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
        </div>
    </div>
    @endif







</div>
@endsection