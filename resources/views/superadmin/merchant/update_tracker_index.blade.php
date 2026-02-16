@extends('layouts.user_type.auth')

@section('content')


@php
use App\Models\PluginVersion;
@endphp

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

                    @if($latestVersion)
                    <form method="POST"
                        action="{{ route('update-tracker.sendNotice', $latestVersion->id) }}">
                        @csrf

                        <button type="submit" class="btn btn-primary btn-md px-4">
                            Send Update Notice
                        </button>
                    </form>
                    @endif

                    <a href="{{ route('update-tracker.export') }}"
                        class="btn btn-outline-secondary btn-sm">
                        <i class="fa fa-file-export me-1"></i> Export Reports
                    </a>

                    <div class="mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPluginModal">
                            Add Plugin
                        </button>
                    </div>
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
                        <h2 class="font-weight-bolder text-dark">
                            {{ $totalStores }}
                        </h2>
                        <p class="text-sm text-secondary mb-0">Across all versions</p>
                        <i class="fa fa-store text-info text-2xl position-absolute end-0 me-3" style="top: 15px;"></i>
                    </div>
                </div>



                {{-- Card 2: Latest Stores --}}
                <div class="col-xl-3 col-md-6 mb-md-0 mb-3 border-end">
                    <div class="p-3">
                        <p class="text-secondary mb-1">Latest Version</p>
                        <h2 class="font-weight-bolder text-dark">
                            {{ $latestStores }}
                        </h2>


                        <p class="text-sm text-success mb-0">
                            {{ $totalStores > 0 ? number_format(($latestStores / $totalStores) * 100, 1) : 0 }}%
                            of stores
                        </p>
                        <i class="fa fa-store text-warning text-2xl position-absolute end-0 me-3" style="top: 15px;"></i>
                    </div>
                </div>

                {{-- Card 3: Outdated Stores --}}
                <div class="col-xl-3 col-md-6 mb-md-0 mb-3 border-end">
                    <div class="p-3">
                        <p class="text-secondary mb-1">Outdated Stores</p>
                        <h2 class="font-weight-bolder text-dark">
                            {{ $outdatedStores }}
                        </h2>

                        <p class="text-sm text-danger mb-0">
                            {{ $totalStores > 0 ? number_format(($outdatedStores / $totalStores) * 100, 1) : 0 }}%
                            need updates
                        </p>
                        <i class="fa fa-warehouse text-danger text-2xl position-absolute end-0 me-3" style="top: 15px;"></i>
                    </div>
                </div>

                {{-- Card 4: Current Version --}}
                <div class="col-xl-3 col-md-6">
                    <div class="p-3">
                        <p class="text-secondary mb-1">Current Version</p>
                        @if($latestVersion)
                        <h2 class="font-weight-bolder text-dark">
                            {{ $latestVersion->version }}
                        </h2>

                        <p class="text-sm text-secondary mb-0">
                            Released {{ $latestVersion->released_at->format('Y-m-d') }}
                        </p>
                        @endif

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

            @foreach($plugins as $plugin)

            @php

            // ✅ Unique Store Count per Version
            $count = $storeCounts[$plugin->id] ?? 0;

            // ✅ Percentage Calculation
            $percent = $totalStores > 0
            ? ($count / $totalStores) * 100
            : 0;
            @endphp

            <div class="mb-3">

                <!-- Header Row -->
                <div class="d-flex justify-content-between align-items-center mb-1">

                    <!-- Version Name -->
                    <p class="text-sm font-weight-bold mb-0">
                        {{ $plugin->version }}

                        <!-- ✅ Type Badge -->
                        <span class="badge {{ $plugin->category_badge_class }} ms-1">
                            {{ $plugin->category_name}}
                        </span>
                    </p>

                    <!-- Store Count + Percent -->
                    <p class="text-sm text-secondary mb-0">
                        {{ $count }} stores ({{ number_format($percent, 1) }}%)
                    </p>

                </div>

                <!-- Progress Bar -->
                <div class="progress" style="height: 10px;">
                    <div class="progress-bar"
                        role="progressbar"
                        style="width: {{ $percent }}%">
                    </div>
                </div>

            </div>

            @endforeach

        </div>
    </div>


    {{-- 4. DETAILED PLUGIN VERSION TABLE (THIRD MAIN CONTAINER) --}}
    <div class="card mb-4">
        <div class="card-header pb-0">
            <h6 class="d-flex align-items-center">Plugin Version <span class="badge bg-secondary ms-2">
                    {{ $plugins->count() }} versions
                </span></h6>
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
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Category</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Type</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">State</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Media</th>
                            <th class="text-secondary opacity-7">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($plugins as $plugin)

                        @php
                        // Store count per version
                        $storeCount = $storeCounts[$plugin->id] ?? 0;

                        // Percentage calculation
                        $percentage = $totalStores > 0
                        ? ($storeCount / $totalStores) * 100
                        : 0;
                        @endphp

                        <tr>
                            <!-- Version -->
                            <td>{{ $plugin->version }}</td>

                            <!-- Released -->
                            <td>{{ $plugin->released_at->format('Y-m-d') }}</td>

                            <!-- Store Count -->
                            <td>{{ $storeCount }}</td>

                            <!-- Percentage -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress w-75 me-2" style="height: 6px;">
                                        <div class="progress-bar bg-primary"
                                            role="progressbar"
                                            style="width: {{ $percentage }}%;"
                                            aria-valuenow="{{ $storeCount }}"
                                            aria-valuemin="0"
                                            aria-valuemax="{{ $totalStores }}">
                                        </div>
                                    </div>

                                    <span class="text-xs font-weight-bold">
                                        {{ number_format($percentage, 1) }}%
                                    </span>
                                </div>
                            </td>

                            <!-- Type -->
                            <td>
                                <span class="badge {{ $plugin->category_badge_class }}">
                                    {{ $plugin->category_name }}
                                </span>
                            </td>


                            <td>
                                <span class="badge {{ $plugin->type_badge_class }}">
                                    {{ $plugin->type_name }}
                                </span>
                            </td>
                            <!-- State -->
                            <td>
                                <span class="badge {{ $plugin->state_badge_class }}">
                                    {{ $plugin->state_name }}
                                </span>
                            </td>

                            <td>
                                @if($plugin->description)
                                {{ Str::limit($plugin->description, 50) }}

                                @if(strlen($plugin->description) > 50)
                                <a href="#"
                                    data-bs-toggle="modal"
                                    data-bs-target="#descModal{{ $plugin->id }}"
                                    class="text-primary">
                                    View
                                </a>
                                @endif
                                @endif
                            </td>

                            <td>
                                @if($plugin->screenshot)


                                <a href="{{ asset('storage/' . $plugin->screenshot->file_path) }}"
                                    download
                                    class="btn btn-sm btn-success">
                                    Download
                                </a>
                                @else
                                <span class="text-muted">No Image</span>
                                @endif
                            </td>


                            <!-- Actions -->
                            <td>
                                <!-- Download -->
                                <a href="{{ route('update-tracker.download', $plugin->id) }}"
                                    class="btn btn-success btn-sm">
                                    Download
                                </a>


                                <!-- Delete -->
                                <form action="{{ route('update-tracker.delete', $plugin->id) }}"
                                    method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn btn-danger btn-sm">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @endforeach

                        @foreach($plugins as $plugin)
                        <div class="modal fade" id="descModal{{ $plugin->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            Description - {{ $plugin->version }}
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        {!! nl2br(e($plugin->description)) !!}
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
s
                    </tbody>

                </table>
            </div>
        </div>
    </div>


</div>

<!-- Add Plugin Modal -->
<div class="modal fade" id="addPluginModal" tabindex="-1" aria-labelledby="addPluginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('update-tracker.add') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addPluginModalLabel">
                        Add New Plugin Version
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">

                    <!-- Version -->
                    <div class="mb-3">
                        <label class="form-label">Version</label>
                        <input type="text"
                            name="version"
                            class="form-control"
                            placeholder="e.g. 2.1.4"
                            required>
                    </div>

                    <!-- Plugin ZIP -->
                    <div class="mb-3">
                        <label class="form-label">Plugin ZIP File</label>
                        <input type="file"
                            name="zip"
                            class="form-control"
                            accept=".zip"
                            required>
                    </div>

                    <!-- Release Date -->
                    <div class="mb-3">
                        <label class="form-label">Release Date</label>
                        <input type="date"
                            name="released_at"
                            class="form-control"
                            value="{{ date('Y-m-d') }}"
                            required>
                    </div>


                    <!-- Category Dropdown -->
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            @foreach(PluginVersion::categories() as $id => $name)
                            <option value="{{ $id }}">
                                {{ $name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                            class="form-control"
                            rows="4"></textarea>
                    </div>

                    <!-- Screenshot -->
                    <div class="mb-3">
                        <label class="form-label">Plugin Screenshot</label>
                        <input type="file"
                            name="screenshot"
                            class="form-control"
                            accept="image/*">
                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Upload Plugin
                    </button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection