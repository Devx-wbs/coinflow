@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <!-- Card 1 -->
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="numbers">
                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Volume Processed</p>
                        <h5 class="font-weight-bolder">$871,939.92</h5>
                        <p class="mb-0 text-success"><i class="fa fa-arrow-up"></i> +15.2% from last month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="numbers">
                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Fees Collected</p>
                        <h5 class="font-weight-bolder">$20,022.44</h5>
                        <p class="mb-0 text-success"><i class="fa fa-arrow-up"></i> +18.7% from last month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="numbers">
                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Transactions</p>
                        <h5 class="font-weight-bolder">7,461</h5>
                        <p class="mb-0 text-success"><i class="fa fa-arrow-up"></i> +12.3% from last month</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="numbers">
                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Average Fee Rate</p>
                        <h5 class="font-weight-bolder">2.6%</h5>
                        <p class="mb-0 text-success"><i class="fa fa-arrow-up"></i> Across all merchants</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search + Filter Section -->
    <div class="row mb-3">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Search merchants...">
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option>All Plans</option>
                <option>Free</option>
                <option>Pro</option>
                <option>Agency</option>
            </select>
        </div>
        <div class="col-md-3">
            <select class="form-select">
                <option>Fee Collected</option>
                <option>Total Volume</option>
                <option>Transactions</option>
            </select>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card">
        <div class="card-header pb-0">
            <h6>Store Earnings</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th>Merchant</th>
                            <th>Plan</th>
                            <th>Total Volume</th>
                            <th>Fee Rate</th>
                            <th>Fee Collected</th>
                            <th>Transactions</th>
                            <th>Last Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Home & Garden</td>
                            <td><span class="badge bg-primary">Pro</span></td>
                            <td>$345,678.90</td>
                            <td>2.2%</td>
                            <td>$4,222.22</td>
                            <td>3,421</td>
                            <td>Jan 16, 2024</td>
                        </tr>
                        <tr>
                            <td>Fashion Hub</td>
                            <td><span class="badge bg-pink">Agency</span></td>
                            <td>$234,567.89</td>
                            <td>1.8%</td>
                            <td>$4,222.22</td>
                            <td>2,103</td>
                            <td>Jan 14, 2024</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
