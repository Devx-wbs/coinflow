@extends('layouts.user_type.auth')

@section('content')
@php
use App\Models\Support;
@endphp
<h4 class="mb-3">Customer Support</h4>

<a href="{{ route('support.create') }}" class="btn btn-primary">
    + Add Ticket
</a>

<form method="GET" class="row mb-3">
    <div class="col-md-8">
        <input type="text" name="search" value="{{ request('search') }}"
            class="form-control"
            placeholder="Search tickets by customer, email or subject">
    </div>
    <div class="col-md-3">
        <select name="status" class="form-control">
            <option value="">All Status</option>
            @foreach(['inactive','active','in_progress','closed'] as $status)
            <option value="{{ $status }}" @selected(request('status')==$status)>
                {{ ucfirst(str_replace('_',' ', $status)) }}
            </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-1">
        <button class="btn btn-primary w-100">Go</button>
    </div>
</form>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Ticket ID</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Category</th>
            <th>Status</th>
            <th>Date Created</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($supports as $support)
        <tr>
            <td>TK-{{ str_pad($support->id, 3, '0', STR_PAD_LEFT) }}</td>
            <td>{{ $support->full_name ?? '-' }}</td>
            <td>{{ $support->email ?? '-' }}</td>
            <td>{{ $support->subject }}</td>
            <td>{{ $support->category_name }}</td>
            <td>
                <span class="badge {{ $support->status_badge_class }}">
                    {{ $support->status_name }}
                </span>
            </td>
            <td>{{ $support->created_at->format('Y-m-d') }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('support.show', $support->id) }}">View</a>
                <a class="btn btn-danger" href="{{ route('support.destroy', $support->id) }}">Delete</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">No tickets found</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="card shadow-sm px-3 py-2">
    {{ $supports->withQueryString()->links('pagination::bootstrap-5') }}
</div>

@endsection