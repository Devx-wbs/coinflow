@extends('layouts.user_type.auth')

@section('content')
<div class="col-lg-8">
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Edit Plan') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('plan-update', $plan->id) }}" method="POST" role="form text-left">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Plan Name --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="plan-name" class="form-control-label">{{ __('Plan Name') }}</label>
                                <input class="form-control"
                                    type="text" id="plan-name" name="name"
                                    value="{{ old('name', $plan->name) }}" required>
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="plan-price" class="form-control-label">{{ __('Price') }}</label>
                                <input class="form-control"
                                    type="number" step="0.01" id="plan-price" name="price"
                                    value="{{ old('price', $plan->price) }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        {{-- Duration --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="plan-duration" class="form-control-label">{{ __('Duration') }}</label>
                                <input class="form-control"
                                    type="number" id="plan-duration" name="duration"
                                    value="{{ old('duration', $plan->duration) }}" required>
                                <select name="duration_type" class="form-control mt-2">
                                    <option value="days" {{ old('duration_type', $plan->duration_type) == 'days' ? 'selected' : '' }}>Days</option>
                                    <option value="months" {{ old('duration_type', $plan->duration_type) == 'months' ? 'selected' : '' }}>Months</option>
                                    <option value="years" {{ old('duration_type', $plan->duration_type) == 'years' ? 'selected' : '' }}>Years</option>
                                </select>
                            </div>
                        </div>

                        {{-- Trial Days --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="trial-days" class="form-control-label">{{ __('Trial Days') }}</label>
                                <input class="form-control @error('trial_days') is-invalid @enderror"
                                    type="number"
                                    id="trial-days"
                                    name="trial_days"
                                    value="{{ old('trial_days', $plan->trial_days) }}">

                                @error('trial_days')
                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        
                    </div>

                    <div class="row">

                        {{-- License Type --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="license-type" class="form-control-label">{{ __('License Type') }}</label>
                                <select class="form-control" id="license-type" name="license_type">
                                    <option value="single_site" {{ old('license_type', $plan->license_type) == 'single_site' ? 'selected' : '' }}>Single Site</option>
                                    <option value="multi_site" {{ old('license_type', $plan->license_type) == 'multi_site' ? 'selected' : '' }}>Multi Site</option>
                                    <option value="unlimited" {{ old('license_type', $plan->license_type) == 'unlimited' ? 'selected' : '' }}>Unlimited</option>
                                </select>
                            </div>
                        </div>
                        {{-- Max Activations --}}
                            <div class="col-md-6" id="max-activation-wrapper">
                                <div class="form-group">
                                    <label for="max-activations" class="form-control-label">
                                        {{ __('Max Activations') }}
                                    </label>
                                    <input class="form-control @error('max_activations') is-invalid @enderror"
                                        type="number"
                                        id="max-activations"
                                        name="max_activations"
                                        value="{{ old('max_activations') }}"
                                        min="1">
                                    @error('max_activations')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        

                    </div>

                    {{-- Description --}}
                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea class="form-control"
                            id="description" rows="3" name="description">{{ old('description', $plan->description) }}</textarea>
                    </div>

                    {{-- Active Checkbox --}}
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', $plan->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ __('Update Plan') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const licenseType = document.getElementById('license-type');
        const maxWrapper = document.getElementById('max-activation-wrapper');
        const maxInput = document.getElementById('max-activations');

        function toggleMaxActivation() {
            if (licenseType.value === 'multi_site') {
                maxWrapper.style.display = 'block';
                maxInput.required = true;
            } else {
                maxWrapper.style.display = 'none';
                maxInput.required = false;
                maxInput.value = '';
            }
        }

        toggleMaxActivation();
        licenseType.addEventListener('change', toggleMaxActivation);
    });
</script>