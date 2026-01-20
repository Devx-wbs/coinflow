@extends('layouts.user_type.auth')

@section('content')
<div class="col-lg-8">
    <div class="row">
      <div class="col-xl-3 col-sm-6 mb-xl-2 mb-4">
        <!-- <div class="card"> -->
           <li class="nav-link mb-2">
            <a href="{{ route('plans-index') }}" class="btn btn-primary btn-md active px-5 text-white" target="_blank" role="button" aria-pressed="true">Show all Plans</a>
          </li>  
        <!-- </div> -->
      </div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Create New Plan') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('plan-store') }}" method="POST" role="form text-left">
                    @csrf

                    {{-- Error Handling --}}
                    @if($errors->any())
                        <div class="mt-3 alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">{{ $errors->first() }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="m-3 alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">{{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        {{-- Plan Name --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="plan-name" class="form-control-label">{{ __('Plan Name') }}</label>
                                <input class="form-control @error('name') is-invalid @enderror" 
                                       type="text" id="plan-name" name="name" value="{{ old('name') }}" placeholder="Enter Plan Name" required>
                                @error('name')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="plan-price" class="form-control-label">{{ __('Price') }}</label>
                                <input class="form-control @error('price') is-invalid @enderror" 
                                       type="number" step="0.01" id="plan-price" name="price" value="{{ old('price') }}" placeholder="0.00" required>
                                @error('price')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Duration --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="plan-duration" class="form-control-label">{{ __('Duration') }}</label>
                                <input class="form-control @error('duration') is-invalid @enderror" 
                                       type="number" id="plan-duration" name="duration" value="{{ old('duration') }}" placeholder="Enter duration" required>
                                <select name="duration_type" class="form-control mt-2">
                                    <option value="days" {{ old('duration_type')=='days' ? 'selected' : '' }}>Days</option>
                                    <option value="months" {{ old('duration_type')=='months' ? 'selected' : '' }}>Months</option>
                                    <option value="years" {{ old('duration_type')=='years' ? 'selected' : '' }}>Years</option>
                                </select>
                                @error('duration')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- License Type --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="license-type" class="form-control-label">{{ __('License Type') }}</label>
                                <select class="form-control @error('license_type') is-invalid @enderror" id="license-type" name="license_type">
                                    <option value="single_site" {{ old('license_type')=='single_site' ? 'selected' : '' }}>Single Site</option>
                                    <option value="multi_site" {{ old('license_type')=='multi_site' ? 'selected' : '' }}>Multi Site</option>
                                    <option value="unlimited" {{ old('license_type')=='unlimited' ? 'selected' : '' }}>Unlimited</option>
                                </select>
                                @error('license_type')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Max Activations --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="max-activations" class="form-control-label">{{ __('Max Activations') }}</label>
                                <input class="form-control @error('max_activations') is-invalid @enderror" 
                                       type="number" id="max-activations" name="max_activations" value="{{ old('max_activations', 1) }}">
                                @error('max_activations')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Trial Days --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="trial-days" class="form-control-label">{{ __('Trial Days (optional)') }}</label>
                                <input class="form-control @error('trial_days') is-invalid @enderror" 
                                       type="number" id="trial-days" name="trial_days" value="{{ old('trial_days') }}">
                                @error('trial_days')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" rows="3" placeholder="Write about this plan..." name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Active Checkbox --}}
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ __('Create Plan') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
