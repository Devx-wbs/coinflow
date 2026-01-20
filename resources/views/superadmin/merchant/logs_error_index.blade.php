@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Logs & Errors</h4>
        <button class="btn btn-primary">
            <i class="fa fa-download me-2"></i> Export Logs Report
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-sm text-muted mb-1">Total Logs</p>
                    <h5 class="font-weight-bold mb-0">12,548</h5>
                    <p class="text-success text-sm mb-0"><i class="fa fa-arrow-up"></i> +8.5% since last week</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-sm text-muted mb-1">Critical Errors</p>
                    <h5 class="font-weight-bold mb-0 text-danger">128</h5>
                    <p class="text-danger text-sm mb-0"><i class="fa fa-exclamation-triangle"></i> Needs attention</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-sm text-muted mb-1">Warnings</p>
                    <h5 class="font-weight-bold mb-0 text-warning">432</h5>
                    <p class="text-warning text-sm mb-0"><i class="fa fa-exclamation-circle"></i> Slight increase</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-sm text-muted mb-1">Info Logs</p>
                    <h5 class="font-weight-bold mb-0 text-info">11,988</h5>
                    <p class="text-success text-sm mb-0"><i class="fa fa-check-circle"></i> Stable system</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Search logs by message or type...">
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option>All Levels</option>
                <option>Critical</option>
                <option>Warning</option>
                <option>Info</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option>Newest First</option>
                <option>Oldest First</option>
            </select>
        </div>
    </div>

    <!-- Logs Table -->
    <div class="card">
        <div class="card-header pb-0">
            <h6>Recent Logs</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Message</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Oct 8, 2025 - 09:30 AM</td>
                            <td><span class="badge bg-danger">Critical</span></td>
                            <td>Database connection failed on production.</td>
                            <td><span class="badge bg-secondary">Pending</span></td>
                        </tr>
                        <tr>
                            <td>Oct 8, 2025 - 08:50 AM</td>
                            <td><span class="badge bg-warning text-dark">Warning</span></td>
                            <td>Memory usage exceeded 85% threshold.</td>
                            <td><span class="badge bg-success">Resolved</span></td>
                        </tr>
                        <tr>
                            <td>Oct 8, 2025 - 07:15 AM</td>
                            <td><span class="badge bg-info">Info</span></td>
                            <td>Backup completed successfully.</td>
                            <td><span class="badge bg-success">Resolved</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
