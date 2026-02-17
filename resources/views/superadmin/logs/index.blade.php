@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Logs & Errors</h4>
        <form action="{{ route('logs.export') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download me-2"></i> Export Logs Report
            </button>
        </form>
    </div>


    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-sm text-muted mb-1">Total Logs</p>
                    <h5 class="font-weight-bold mb-0">{{ $stats['total_logs'] }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-sm text-muted mb-1">Critical Errors</p>
                    <h5 class="font-weight-bold mb-0 text-danger">{{ $stats['critical_errors'] }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-sm text-muted mb-1">Warnings</p>
                    <h5 class="font-weight-bold mb-0 text-warning">{{ $stats['warnings'] }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <p class="text-sm text-muted mb-1">Info Logs</p>
                    <h5 class="font-weight-bold mb-0 text-info">{{ $stats['info_logs'] }}</h5>
                </div>
            </div>
        </div>
    </div>


    {{-- Filters --}}
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Search message..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="level" class="form-select">
                <option value="all" {{ request('level') == 'all' ? 'selected' : '' }}>All Levels</option>
                <option value="error" {{ request('level') == 'error' ? 'selected' : '' }}>Error</option>
                <option value="warning" {{ request('level') == 'warning' ? 'selected' : '' }}>Warning</option>
                <option value="info" {{ request('level') == 'info' ? 'selected' : '' }}>Info</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="" {{ request('status') == '' ? 'selected' : '' }}>All Status</option>
                <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                <option value="unresolved" {{ request('status') == 'unresolved' ? 'selected' : '' }}>Unresolved</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>

    {{-- Top Actions --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Recent System Logs</h4>
        <form action="{{ route('logs.deleteAll') }}" method="POST" onsubmit="return confirm('Are you sure to delete ALL logs?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Delete All Logs</button>
        </form>
    </div>

    <!-- Logs Table -->
    <div class="card">

        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Message</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">IP</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                        </tr>
                    </thead>


                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->id }}</td>
                            <td>
                                <span class="badge 
                                {{ $log->level == 'error' ? 'bg-danger' : ($log->level == 'warning' ? 'bg-warning text-dark' : 'bg-info') }}">
                                    {{ ucfirst($log->level) }}
                                </span>
                            </td>
                            <td>{{ Str::limit($log->message, 50) }}</td>
                            <td>{{ $log->user?->name ?? 'N/A' }}</td>
                            <td>{{ $log->ip }}</td>
                            <td>
                                @if($log->is_resolved)
                                <span class="badge bg-success">Resolved</span>
                                @else
                                <span class="badge bg-secondary">Unresolved</span>
                                @endif
                            </td>
                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            <td class="text-center">
                                <a href="{{ route('logs.show', $log->id) }}" class="btn btn-sm btn-info">View</a>
                                <form action="{{ route('logs.delete', $log->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure to delete this log?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">No logs found</td>
                        </tr>
                        @endforelse
                    </tbody>



                </table>
            </div>

            {{-- Pagination --}}


            <div class="card shadow-sm px-3 py-2">
                {{ $logs->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@endsection