@extends('layouts.user_type.auth')

@section('content')
<div class="container-fluid">

    {{-- LICENSE / OWNER INFO --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="mb-3">License Details</h5>
            <div class="row">
                <div class="col-md-4"><strong>Owner Name:</strong> {{ $license->user->name }}</div>
                <div class="col-md-4"><strong>Store Name:</strong> {{ $license->user->store_name }}</div>
                <div class="col-md-4"><strong>License Key:</strong> {{ $license->license_key }}</div>

                <div class="col-md-4 mt-2"><strong>Plan:</strong> {{ optional($license->planInfo)->name }}</div>
                <div class="col-md-4 mt-2"><strong>Max Activations:</strong>
                    {{ $license->max_activations == 0 ? 'Unlimited' : $license->max_activations }}
                </div>
            </div>
        </div>
    </div>

    {{-- STORES GRID --}}
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Activated Domains</h5>

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>S.No#</th>
                        <th>Domain</th>
                        <th>Status</th>
                        <th>Activated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activations as $key => $activation)
                    <tr>
                        <td>{{ $activations->firstItem() + $key }}</td>
                        <td>{{ $activation->store_url }}</td>
                        <td>
                            <span class="badge bg-{{ $activation->status == 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($activation->status) }}
                            </span>
                        </td>
                        <td>
                            {{ $activation->activated_at   }}
                        </td>
                        <td>
                            <a href="{{ $activation->store_url }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-external-link-alt"></i> View Store
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No stores activated yet
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection