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
    <form method="GET" action="{{ route('subscribe-store') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control" placeholder="Search store by name or domain..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>






    <div class="row mb-4">
        <!-- Total Licenses -->
        <div class="col-md-3 col-6">
            <div class="card border px-3 py-2 shadow-sm" style="border-left: 4px solid #27d6be;">
                <div class="d-flex align-items-center">
                    <span class="rounded-circle p-2 me-3 bg-light"><i class="fas fa-key text-info"></i></span>
                    <div>
                        <div class="fw-bold h2 mb-0">{{ $totalStores }}</div>
                        <div class="text-muted">Total Stores</div>
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
                        <div class="fw-bold h2 mb-0">{{ $activeStores }}</div>
                        <div class="text-muted">Active Stores</div>
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
                        <div class="fw-bold h2 mb-0">{{ $paidPlans }}</div>
                        <div class="text-muted">Paid Plain</div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-md-3 col-6">
            <div class="card border px-3 py-2 shadow-sm" style="border-left: 4px solid #4caf50;">
                <div class="d-flex align-items-center">
                    <span class="rounded-circle p-2 me-3 bg-light">
                        <i class="fas fa-credit-card text-success"></i>
                    </span>
                    <div>
                        <div class="fw-bold h2 mb-0"> ${{ number_format($totalAmount, 2) }} </div>
                        <div class="text-muted">Total Transactions</div>


                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Stores</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Store Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"> Domain</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Transactions</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Plan</th>


                                    <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subscribes as $subscribe)
                                <tr>



                                    <!-- Store Name -->
                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $subscribe->user->store_name ?? 'N/A' }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="text-secondary text-xs font-weight-bold">
                                            {{ $subscribe->activations->first()->store_url ?? 'N/A' }}

                                        </span>
                                    </td>




                                    <!-- Status -->
                                    <td class="align-middle text-center text-sm">
                                        @php
                                        $status = strtolower($subscribe->status);
                                        $statusClass = match($status) {
                                        'active' => 'bg-success text-white',
                                        'expired' => 'bg-danger text-white',
                                        'revoked' => 'bg-dark text-white',
                                        default => 'bg-secondary text-white'
                                        };
                                        @endphp
                                        <span class="badge rounded-pill px-3 py-2 {{ $statusClass }}">
                                            {{ ucfirst($subscribe->status) }}
                                        </span>
                                    </td>



                                    <!-- Transactioin -->
                                    <td class="align-middle text-center">
                                        {{ $subscribe->planInfo->price ? '$' . number_format($subscribe->planInfo->price, 2) : 'N/A' }}
                                    </td>



                                    <!-- Plan -->
                                    <td class="align-middle text-center text-sm">
                                        @php
                                        $plan = strtolower($subscribe->plan ?? '');
                                        $planClass = match($plan) {
                                        'pro' => 'bg-primary text-white',
                                        'agency' => 'bg-purple text-white',
                                        'free' => 'bg-info text-dark',
                                        default => 'bg-secondary text-white'
                                        };
                                        @endphp
                                        <span class="badge rounded-pill px-3 py-2 {{ $planClass }}">
                                            {{ ucfirst($subscribe->plan ?? 'N/A') }}
                                        </span>
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
                            {{ $subscribes->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>


@endsection