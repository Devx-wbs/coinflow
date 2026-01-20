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
    <div class="col-lg-12">
        <!--    <div class="row">-->
        <!--    <div class="col-12 d-flex justify-content-end">-->
        <!--        <a href="{{ route('plan-create') }}" -->
        <!--           class="btn btn-primary btn-md active px-5 text-white" -->
        <!--           target="_blank" -->
        <!--           role="button" -->
        <!--           aria-pressed="true">-->
        <!--            Add Contacts-->
        <!--        </a>-->
        <!--    </div>-->
        <!--</div>-->
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Merchant Directory</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Owner</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Store Name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contact Info</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Join Date</th>

                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <!-- Owner -->
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                            </div>
                                        </td>

                                        <!-- Store Name -->
                                        <td>
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $user->store_name ?? 'N/A' }}
                                            </span>
                                        </td>


                                        <!-- Contact Info -->
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">
                                                {{ $user->email }}
                                            </span>
                                        </td>

                                      

                                       

                                        <!-- Status -->
                                        <td class="align-middle text-center text-sm">
                                            @php
                                            $status = $user->license->status ?? null;
                                            $statusMap = [
                                            'active' => ['label' => 'Active', 'class' => 'bg-gradient-success'],
                                            'inactive' => ['label' => 'Inactive', 'class' => 'bg-gradient-secondary'],
                                            'expired' => ['label' => 'Expired', 'class' => 'bg-gradient-danger'],
                                            'revoked' => ['label' => 'Revoked', 'class' => 'bg-gradient-dark'],
                                            ];
                                            $badge = $statusMap[$status] ?? ['label' => 'N/A', 'class' => 'bg-gradient-warning'];
                                            @endphp

                                            <span class="badge badge-sm {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                                        </td>



                                        <!-- Join Date -->
                                        <td class="align-middle text-center">
                                            {{ $user->created_at->format('d M, Y') }}
                                        </td>




                                        <!-- Actions -->
                                        <td class="align-middle text-center">

                                            @if($user->license)
                                            <a href="{{ route('merchant.store.view', $user->license->id) }}"
                                                class="btn btn-sm btn-primary">
                                                View
                                            </a>
                                            @else
                                            <span class="text-muted">N/A</span>
                                            @endif

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
                            {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
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