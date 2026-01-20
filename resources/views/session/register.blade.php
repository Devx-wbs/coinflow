@extends('layouts.user_type.guest')

@section('content')

  <main class="main-content mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">

            <!-- LEFT SIDE FORM -->
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Create Account</h3>
                  <p class="mb-0">Register below to get started 🚀</p>
                </div>
                <div class="card-body">
                  <form method="POST" action="{{ route('register') }}" role="form text-left">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-3">
                      <input type="text" name="name" class="form-control" placeholder="Full Name"
                             value="{{ old('name') }}" required autofocus>
                      @error('name')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                      <input type="email" name="email" class="form-control" placeholder="Email Address"
                             value="{{ old('email') }}" required>
                      @error('email')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                      <input type="text" name="phone" class="form-control" placeholder="Phone (optional)"
                             value="{{ old('phone') }}">
                      @error('phone')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>

                    <!-- Country -->
                    <!--<div class="mb-3">-->
                    <!--  <input type="text" name="country" class="form-control" placeholder="Country (optional)"-->
                    <!--         value="{{ old('country') }}">-->
                    <!--  @error('country')-->
                    <!--    <p class="text-danger text-xs mt-2">{{ $message }}</p>-->
                    <!--  @enderror-->
                    <!--</div>-->

                    <!-- Company Name -->
                    <div class="mb-3">
                      <input type="text" name="store_name" class="form-control" placeholder="Store Name"
                             value="{{ old('store_name') }}">
                      @error('store_name')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                      <input type="password" name="password" class="form-control" placeholder="Password" required>
                      @error('password')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                      @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                      <input type="password" name="password_confirmation" class="form-control"
                             placeholder="Confirm Password" required>
                    </div>

                    <!-- Terms -->
                    <div class="form-check form-check-info text-left mb-3">
                      <input class="form-check-input" type="checkbox" id="terms" required>
                      <label class="form-check-label" for="terms">
                        I agree to the <a href="#" class="text-dark font-weight-bolder">Terms and Conditions</a>
                      </label>
                    </div>

                    <!-- Submit -->
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign Up</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                  <p class="text-sm mt-3 mb-0">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-info text-gradient font-weight-bold">Sign in</a>
                  </p>
                </div>
              </div>
            </div>

            <!-- RIGHT SIDE IMAGE -->
            <div class="col-md-7 d-none d-md-block">
              <div class="oblique position-absolute top-0 h-100 end-0">
                <div class="oblique-image bg-cover position-absolute fixed-top h-100 z-index-0"
                     style="background-image: url('{{ asset('assets/img/curved-images/coinflow.png') }}')">
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </main>

@endsection
