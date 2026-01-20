@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Title & Subtitle -->
    <div class="mb-2">
        <h4 class="mb-2">Push Notices</h4>
        <span class="text-muted">Send announcements and updates to your merchants</span>
    </div>

    <!-- Analytics Cards -->
    <div class="row g-3 mb-5">
        <div class="col-md-3 col-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-sm text-muted">Total Transactions</span>
                        <i class="fa fa-credit-card"></i>
                    </div>
                    <h5 class="font-weight-bold mb-1">4</h5>
                    <span class="text-sm text-muted">This month</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-sm text-muted">Total Delivered</span>
                        <i class="fa fa-envelope-open"></i>
                    </div>
                    <h5 class="font-weight-bold mb-1">296</h5>
                    <span class="text-sm text-muted">Across all notices</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-sm text-muted">Total Opened</span>
                        <i class="fa fa-user-check"></i>
                    </div>
                    <h5 class="font-weight-bold mb-1">245</h5>
                    <span class="text-sm text-muted">Email opens</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-sm text-muted">Average Open Rate</span>
                        <i class="fa fa-chart-line"></i>
                    </div>
                    <h5 class="font-weight-bold mb-1">82.8%</h5>
                    <span class="text-sm text-muted">Industry avg. 22%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mb-3">
        <button class="btn btn-outline-secondary me-2">Create Notice</button>
        <button class="btn btn-outline-secondary">Notice History</button>
    </div>

    <!-- Create New Announcement Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="mb-4">Create New Announcement</h5>
            <form>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="notice-title" class="form-label fw-bold">Notice Title</label>
                        <input type="text" class="form-control" id="notice-title" placeholder="Enter announcement title...">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="target-audience" class="form-label fw-bold">Target Audience</label>
                        <select class="form-select" id="target-audience">
                            <option selected>Select Target Audience</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="message-content" class="form-label fw-bold">Message Content</label>
                    <textarea class="form-control" id="message-content" rows="4" placeholder="Enter your announcement message....."></textarea>
                </div>
                <span class="text-muted text-sm d-block mb-3">
                    Tip: Keep your message clear and actionable. Include any relevant links or instructions
                </span>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="plan-active" checked>
                    <label class="form-check-label" for="plan-active">Plan is active</label>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-outline-secondary">Save Draft</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane me-1"></i> Send Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
