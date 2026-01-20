@extends('layouts.user_type.auth')

@section('content')

<div class="container-fluid py-4">
    {{-- 1. HEADER AND ACTION BUTTONS --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Update Tracker</h5>
                    <p class="text-sm mb-0 text-secondary">Monitor plugin versions across all stores</p>
                </div>
               <div class="d-flex gap-2">
    <a href="{{ route('plan-create') }}" 
       class="btn btn-primary btn-md active px-5 text-white" 
       target="_blank" 
       role="button" 
       aria-pressed="true">
        Send Update Notice
    </a>

    <button class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-file-export me-1"></i> Export Reports
    </button>
</div>

            </div>
        </div>
    </div>

    {{-- 2. STATISTIC CARDS (FIRST MAIN CONTAINER) --}}
    <div class="card mb-4">
        <div class="card-body px-4 py-3">
            <div class="row text-center">
                {{-- Card 1: Total Stores (Use a custom class if needed for the style) --}}
                <div class="col-xl-3 col-md-6 mb-md-0 mb-3 border-end">
                    <div class="p-3">
                        <p class="text-secondary mb-1">Total Stores</p>
                        <h2 class="font-weight-bolder text-dark">100</h2>
                        <p class="text-sm text-secondary mb-0">Across all versions</p>
                        <i class="fa fa-store text-info text-2xl position-absolute end-0 me-3" style="top: 15px;"></i>
                    </div>
                </div>

                {{-- Card 2: Latest Stores --}}
                <div class="col-xl-3 col-md-6 mb-md-0 mb-3 border-end">
                    <div class="p-3">
                        <p class="text-secondary mb-1">Latest Version</p>
                        <h2 class="font-weight-bolder text-dark">45</h2>
                        <p class="text-sm text-success mb-0">45.0% of stores</p>
                        <i class="fa fa-store text-warning text-2xl position-absolute end-0 me-3" style="top: 15px;"></i>
                    </div>
                </div>

                {{-- Card 3: Outdated Stores --}}
                <div class="col-xl-3 col-md-6 mb-md-0 mb-3 border-end">
                    <div class="p-3">
                        <p class="text-secondary mb-1">Outdated Stores</p>
                        <h2 class="font-weight-bolder text-dark">23</h2>
                        <p class="text-sm text-danger mb-0">23.0% need updates</p>
                        <i class="fa fa-warehouse text-danger text-2xl position-absolute end-0 me-3" style="top: 15px;"></i>
                    </div>
                </div>

                {{-- Card 4: Current Version --}}
                <div class="col-xl-3 col-md-6">
                    <div class="p-3">
                        <p class="text-secondary mb-1">Current Version</p>
                        <h2 class="font-weight-bolder text-dark">v2.1.4</h2>
                        <p class="text-sm text-secondary mb-0">Released 2024-01-15</p>
                        <i class="fa fa-user-circle text-primary text-2xl position-absolute end-0 me-3" style="top: 15px;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. VERSION DISTRIBUTION (SECOND MAIN CONTAINER) --}}
    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6>Version Distribution</h6>
        </div>
        <div class="card-body pt-2 pb-2 px-4">
            {{-- Distribution Bar 1 --}}
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <p class="text-sm font-weight-bold mb-0">v2.1.4 <span class="badge bg-success ms-1">Latest</span></p>
                    <p class="text-sm text-secondary mb-0">45 stores (45.0%)</p>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            
            {{-- Distribution Bar 2 --}}
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <p class="text-sm font-weight-bold mb-0">v2.1.3 <span class="badge bg-info ms-1">Supported</span></p>
                    <p class="text-sm text-secondary mb-0">32 stores (32.0%)</p>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 32%" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            {{-- Distribution Bar 3 (Security Update) --}}
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <p class="text-sm font-weight-bold mb-0">v2.1.2 <span class="badge bg-warning ms-1">Security Update</span> <i class="fa fa-exclamation-triangle text-danger"></i></p>
                    <p class="text-sm text-secondary mb-0">15 stores (15.0%)</p>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>

            {{-- Distribution Bar 4 (Unsupported) --}}
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <p class="text-sm font-weight-bold mb-0">v2.0.8 <span class="badge bg-danger ms-1">Unsupported</span> <i class="fa fa-exclamation-triangle text-danger"></i></p>
                    <p class="text-sm text-secondary mb-0">6 stores (6.0%)</p>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 6%" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            
            {{-- Distribution Bar 5 (Unsupported) --}}
            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <p class="text-sm font-weight-bold mb-0">v2.0.7 <span class="badge bg-danger ms-1">Unsupported</span> <i class="fa fa-exclamation-triangle text-danger"></i></p>
                    <p class="text-sm text-secondary mb-0">2 stores (2.0%)</p>
                </div>
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 2%" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. DETAILED PLUGIN VERSION TABLE (THIRD MAIN CONTAINER) --}}
    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6 class="d-flex align-items-center">Plugin Version <span class="badge bg-secondary ms-2">5 versions</span></h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Version</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Released</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Store Count</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Percentage</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                            <th class="text-secondary opacity-7">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Table Row 1 (v2.1.4) --}}
                        <tr>
                            <td class="align-middle ps-3"><h6 class="mb-0 text-sm">v2.1.4</h6></td>
                            <td class="align-middle"><p class="text-xs font-weight-bold mb-0">2024-01-15</p></td>
                            <td class="align-middle"><p class="text-xs font-weight-bold mb-0">45</p></td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="progress w-75 me-2" style="height: 6px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 45%;" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="text-xs font-weight-bold">45.0%</span>
                                </div>
                            </td>
                            <td class="align-middle"><span class="badge bg-success">Latest</span></td>
                            <td class="align-middle"><a href="javascript:;" class="text-info font-weight-bold text-xs">View Store</a></td>
                        </tr>
                        {{-- Table Row 2 (v2.1.3) --}}
                        <tr>
                            <td class="align-middle ps-3"><h6 class="mb-0 text-sm">v2.1.3</h6></td>
                            <td class="align-middle"><p class="text-xs font-weight-bold mb-0">2024-01-08</p></td>
                            <td class="align-middle"><p class="text-xs font-weight-bold mb-0">32</p></td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="progress w-75 me-2" style="height: 6px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 32%;" aria-valuenow="32" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="text-xs font-weight-bold">32.0%</span>
                                </div>
                            </td>
                            <td class="align-middle"><span class="badge bg-info">Supported</span></td>
                            <td class="align-middle"><a href="javascript:;" class="text-info font-weight-bold text-xs">View Store</a></td>
                        </tr>
                        {{-- Table Row 3 (v2.1.2) --}}
                        <tr>
                            <td class="align-middle ps-3"><h6 class="mb-0 text-sm">v2.1.2</h6></td>
                            <td class="align-middle"><p class="text-xs font-weight-bold mb-0">2024-01-20</p></td>
                            <td class="align-middle"><p class="text-xs font-weight-bold mb-0">15</p></td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="progress w-75 me-2" style="height: 6px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 15%;" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="text-xs font-weight-bold">15.0%</span>
                                </div>
                            </td>
                            <td class="align-middle"><span class="badge bg-warning">Security Update</span></td>
                            <td class="align-middle"><a href="javascript:;" class="text-info font-weight-bold text-xs">View Store</a></td>
                        </tr>
                        {{-- Table Row 4 (v2.0.8) --}}
                        <tr>
                            <td class="align-middle ps-3"><h6 class="mb-0 text-sm">v2.0.8</h6></td>
                            <td class="align-middle"><p class="text-xs font-weight-bold mb-0">2024-01-15</p></td>
                            <td class="align-middle"><p class="text-xs font-weight-bold mb-0">6</p></td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="progress w-75 me-2" style="height: 6px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 6%;" aria-valuenow="6" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="text-xs font-weight-bold">6.0%</span>
                                </div>
                            </td>
                            <td class="align-middle"><span class="badge bg-danger">Unsupported</span></td>
                            <td class="align-middle"><a href="javascript:;" class="text-info font-weight-bold text-xs">View Store</a></td>
                        </tr>
                        {{-- Table Row 5 (v2.0.7) --}}
                        <tr>
                            <td class="align-middle ps-3"><h6 class="mb-0 text-sm">v2.0.7</h6></td>
                            <td class="align-middle"><p class="text-xs font-weight-bold mb-0">2024-01-22</p></td>
                            <td class="align-middle"><p class="text-xs font-weight-bold mb-0">2</p></td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="progress w-75 me-2" style="height: 6px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 2%;" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="text-xs font-weight-bold">2.0%</span>
                                </div>
                            </td>
                            <td class="align-middle"><span class="badge bg-danger">Unsupported</span></td>
                            <td class="align-middle"><a href="javascript:;" class="text-info font-weight-bold text-xs">View Store</a></td>
                        </tr>
                        {{-- Use a Blade @foreach loop here for dynamic data --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection