@extends('layouts.user_type.auth')

@section('content')

@if(session('success'))
<div id="alert-message" class="alert alert-success text-white font-weight-bold px-4 py-3 mb-4 rounded" role="alert">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div id="alert-message" class="alert alert-danger text-white font-weight-bold px-4 py-3 mb-4 rounded" role="alert">
    {{ session('error') }}
</div>
@endif




<div class="container-fluid py-4">

    <div class="row mb-4">
        <!-- Total Licenses -->
        <div class="col-md-3 col-6">
            <div class="card border px-3 py-2 shadow-sm" style="border-left: 4px solid #27d6be;">
                <div class="d-flex align-items-center">
                    <span class="rounded-circle p-2 me-3 bg-light"><i class="fas fa-key text-info"></i></span>
                    <div>
                        <div class="fw-bold h2 mb-0">{{ $licenses->count() }}</div>
                        <div class="text-muted">Total Licenses</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Active Licenses -->
        <div class="col-md-3 col-6">
            <div class="card border px-3 py-2 shadow-sm" style="border-left: 4px solid #ea93bd;">
                <div class="d-flex align-items-center">
                    <span class="rounded-circle p-2 me-3 bg-light"><i class="fas fa-check text-success"></i></span>
                    <div>
                        <div class="fw-bold h2 mb-0">{{ $licenses->where('status', 'active')->count() }}</div>
                        <div class="text-muted">Active Licenses</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Expiring Soon -->
        @php
        use Carbon\Carbon;

        $expiringSoonCount = $licenses->filter(function($license){
        $expiry = Carbon::parse($license->expiration_date);
        return $expiry->lte(Carbon::now()->addDays(30)) && strtolower($license->status) == 'active';
        })->count();
        @endphp

        <div class="col-md-3 col-6">
            <div class="card border px-3 py-2 shadow-sm" style="border-left: 4px solid #56b6f7;">
                <div class="d-flex align-items-center">
                    <span class="rounded-circle p-2 me-3 bg-light"><i class="fas fa-hourglass-half text-primary"></i></span>
                    <div>
                        <div class="fw-bold h2 mb-0">
                            {{ $expiringSoonCount }}
                        </div>
                        <div class="text-muted">Expiring Soon</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expired/Revoked -->
        <div class="col-md-3 col-6">
            <div class="card border px-3 py-2 shadow-sm" style="border-left: 4px solid #f25048;">
                <div class="d-flex align-items-center">
                    <span class="rounded-circle p-2 me-3 bg-light"><i class="fas fa-times text-danger"></i></span>
                    <div>
                        <div class="fw-bold h2 mb-0">{{ $licenses->whereIn('status', ['expired', 'revoked'])->count() }}</div>
                        <div class="text-muted">Expired/Revoked</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('license_managment') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search_license_key" value="{{ request('search_license_key') }}" class="form-control" placeholder="Search License Key">
            </div>
            <div class="col-md-3">
                <input type="text" name="search_store_name" value="{{ request('search_store_name') }}" class="form-control" placeholder="Search Assigned Store">
            </div>
            <div class="col-md-2">
                <select name="search_status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="active" {{ request('search_status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ request('search_status') == 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="revoked" {{ request('search_status') == 'revoked' ? 'selected' : '' }}>Revoked</option>
                </select>
            </div>
            <!-- <div class="col-md-2">
                    <select name="search_plan" class="form-control">
                        <option value="">Select Plan</option>
                        <option value="pro" {{ request('search_plan') == 'Pro' ? 'selected' : '' }}>Pro</option>
                        <option value="agency" {{ request('search_plan') == 'Agency' ? 'selected' : '' }}>Agency</option>
                        <option value="free" {{ request('search_plan') == 'Free' ? 'selected' : '' }}>Free</option>
                    </select>
                </div> -->
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>License</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">License key</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> Assigned Store</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Expiry Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Plan</th>


                                    <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($licensesPerPage as $license)
                                <tr>
                                    <!-- Owner -->
                                    <td>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $license->license_key  }}</h6>
                                        </div>
                                    </td>

                                    <!-- Store Name -->
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $license->user->store_name ?? 'N/A' }}
                                        </span>
                                    </td>



                                    <!-- Status -->
                                    <td class="align-middle text-center text-sm">
                                        @php
                                        $status = strtolower($license->status);
                                        $statusClass = match($status) {
                                        'active' => 'bg-success text-white',
                                        'expired' => 'bg-danger text-white',
                                        'revoked' => 'bg-dark text-white',
                                        default => 'bg-secondary text-white'
                                        };
                                        @endphp
                                        <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                                            {{ ucfirst($license->status) }}
                                        </span>
                                    </td>



                                    <!-- Join Date -->
                                    <td class="align-middle text-center">
                                        {{ $license->expiration_date->format('d M, Y') }}
                                    </td>




                                    <!-- Status -->
                                    <td class="align-middle text-center text-sm">
                                        @php
                                        $plan = strtolower($license->plan ?? '');
                                        $planClass = match($plan) {
                                        'pro' => 'bg-primary text-white',
                                        'agency' => 'bg-purple text-white',
                                        'free' => 'bg-info text-dark',
                                        default => 'bg-secondary text-white'
                                        };
                                        $planClassNA = 'bg-primary text-white';
                                        @endphp
                                        <span class="badge rounded-pill px-3 py-2 {{ $planClassNA }}">
                                            {{ ucfirst($license->plan ?? 'Pro') }}
                                        </span>
                                        <!-- <span class="badge rounded-pill px-3 py-2 {{ $planClass }}">
                                                    {{ ucfirst($license->plan ?? 'Pro') }}
                                                </span> -->
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">No merchants found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <div class="card shadow-sm px-3 py-2">
                            {{ $licensesPerPage->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let alertBox = document.getElementById("alert-message");
        if (alertBox) {
            setTimeout(() => {
                alertBox.style.transition = "opacity 0.5s ease";
                alertBox.style.opacity = "0";
                setTimeout(() => alertBox.remove(), 500);
            }, 5000);
        }
    });
</script>

@endsection