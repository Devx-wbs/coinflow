@extends('layouts.user_type.auth')

@section('content')
<section class="min-vh-100 mb-8">
  <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" 
       style="background-image: url('../assets/img/curved-images/curved14.jpg');">
    <span class="mask bg-gradient-dark opacity-6"></span>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 text-center mx-auto">
          <h1 class="text-white mb-2 mt-5">Welcome!</h1>
          <p class="text-lead text-white">Register below to get started 🚀</p>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="row mt-lg-n10 mt-md-n11 mt-n10">
      <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
        <div class="card z-index-0">
          <div class="card-header text-center pt-4">
            <h5>Create Account</h5>
          </div>

          <div class="card-body">
            {{-- Registration Form --}}
            <form method="POST" action="{{ route('register') }}" role="form text-left">
              @csrf

              {{-- Name --}}
              <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Full Name"
                       value="{{ old('name') }}" required autofocus>
                @error('name')
                  <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>

              {{-- Email --}}
              <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address"
                       value="{{ old('email') }}" required>
                @error('email')
                  <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>

              {{-- Phone --}}
              <div class="mb-3">
                <input type="text" name="phone" class="form-control" placeholder="Phone (optional)"
                       value="{{ old('phone') }}">
                @error('phone')
                  <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>

              {{-- Country --}}
              <div class="mb-3">
                <input type="text" name="country" class="form-control" placeholder="Country (optional)"
                       value="{{ old('country') }}">
                @error('country')
                  <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>

              {{-- Company Name --}}
              <div class="mb-3">
                <input type="text" name="company_name" class="form-control" placeholder="Company Name (optional)"
                       value="{{ old('company_name') }}">
                @error('company_name')
                  <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>

              {{-- Password --}}
              <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                @error('password')
                  <p class="text-danger text-xs mt-2">{{ $message }}</p>
                @enderror
              </div>

              {{-- Password Confirmation --}}
              <div class="mb-3">
                <input type="password" name="password_confirmation" class="form-control" 
                       placeholder="Confirm Password" required>
              </div>

              {{-- Terms --}}
              <div class="form-check form-check-info text-left">
                <input class="form-check-input" type="checkbox" id="terms" required>
                <label class="form-check-label" for="terms">
                  I agree to the <a href="#" class="text-dark font-weight-bolder">Terms and Conditions</a>
                </label>
              </div>

              {{-- Submit --}}
              <div class="text-center">
                <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Sign up</button>
              </div>

              <p class="text-sm mt-3 mb-0">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-dark font-weight-bolder">Sign in</a>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
