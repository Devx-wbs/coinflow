@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid py-4">

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Log Details (ID: {{ $log->id }})</h4>
        <a href="{{ route('logs.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-1"></i> Back to Logs
        </a>
    </div>

    <!-- Log Info Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="mb-3">Basic Information</h5>
            <div class="row mb-2">
                <div class="col-md-3 text-muted fw-bold">Level:</div>
                <div class="col-md-9">
                    <span class="badge 
                    {{ $log->level == 'error' ? 'bg-danger' : ($log->level == 'warning' ? 'bg-warning text-dark' : 'bg-info') }}">
                        {{ ucfirst($log->level) }}
                    </span>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 text-muted fw-bold">Status:</div>
                <div class="col-md-9">
                    @if($log->is_resolved)
                        <span class="badge bg-success">Resolved</span>
                    @else
                        <span class="badge bg-secondary">Unresolved</span>
                    @endif
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 text-muted fw-bold">User:</div>
                <div class="col-md-9">{{ $log->user?->name ?? 'N/A' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 text-muted fw-bold">IP Address:</div>
                <div class="col-md-9">{{ $log->ip ?? 'N/A' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 text-muted fw-bold">URL:</div>
                <div class="col-md-9">{{ $log->url ?? 'N/A' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 text-muted fw-bold">Method:</div>
                <div class="col-md-9">{{ $log->method ?? 'N/A' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 text-muted fw-bold">File & Line:</div>
                <div class="col-md-9">{{ $log->file ?? 'N/A' }} : {{ $log->line ?? '-' }}</div>
            </div>

            <div class="row mb-2">
                <div class="col-md-3 text-muted fw-bold">Created At:</div>
                <div class="col-md-9">{{ $log->created_at->format('Y-m-d H:i:s') }}</div>
            </div>
        </div>
    </div>

    <!-- Message & Trace Card -->
    <div class="row g-3">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Message</h5>
                    <pre class="p-3 bg-light rounded" style="white-space: pre-wrap;">{{ $log->message }}</pre>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Stack Trace</h5>
                    <pre class="p-3 bg-light rounded" style="white-space: pre-wrap;">{{ $log->trace }}</pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-4 d-flex justify-content-end">
        <form action="{{ route('logs.delete', $log->id) }}" method="POST" onsubmit="return confirm('Are you sure to delete this log?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger me-2">
                <i class="fa fa-trash me-1"></i> Delete Log
            </button>
        </form>

        <a href="{{ route('logs.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left me-1"></i> Back
        </a>
    </div>

</div>
@endsection
