@extends('layouts.user_type.guest')

@section('content')
<main class="main-content mt-0">
    <section>
        <div class="page-header min-vh-75">
            <div class="container">
                <div class="row">
                    <!-- Login Form Section -->
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card card-plain mt-8">
                            <!-- Card Header -->
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">Coin Flow</h3>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body">
                                {{-- ✅ reCAPTCHA script ko yahan load karo --}}
                                {!! NoCaptcha::renderJs() !!}
                                
                                <!-- Login Form -->
                                <form role="form" method="POST" action="{{ route('login.post') }}">
                                    @csrf
                                    
                                    <!-- Email Field -->
                                    <label for="email">Email</label>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" aria-label="Email">
                                        @error('email')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Password Field -->
                                    <label for="password">Password</label>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-label="Password">
                                        @error('password')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- ✅ reCAPTCHA widget --}}
                                    <div class="form-group mt-3">
                                        {!! NoCaptcha::display() !!}
                                        @error('g-recaptcha-response')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>

                                  <!-- Remember me Checkbox -->
                                    <div class="d-flex align-items-center mb-3">
                                        <input type="checkbox" id="remember" name="remember" class="remember-custom me-2">
                                        <label for="remember" class="text-sm mb-0" style="color: #344767;">Remember me</label>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Card Footer -->
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Don't have an account? 
                                    <a href="{{ route('register') }}" class="text-info text-gradient font-weight-bold">Sign up</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Image Section -->
                    <div class="col-md-6">
                        <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                            <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image: url('{{ asset('assets/img/curved-images/coinflow.png') }}')">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
<style>
/* Custom Coinflow Remember Me Checkbox */
.remember-custom {
    appearance: none !important;
    -webkit-appearance: none !important;
    background-color: #fff !important;
    border: 2px solid #000 !important; /* 🖤 Default black border */
    border-radius: 5px !important;
    width: 20px !important;
    
    height: 20px !important;
    position: relative !important;
    cursor: pointer !important;
    outline: none !important;
    transition: all 0.2s ease-in-out !important;
}

/* When checked — blue box + white checkmark */
.remember-custom:checked {
    background-color: #007bff !important;
    border-color:#007bff !important;
}

/* White ✓ tick inside */
.remember-custom:checked::after {
    content: "✓";
    position: absolute;
    top: 0;
    left: 4px;
    color: #fff;
    font-size: 14px;
    font-weight: bold;
}

/* Optional hover glow */
.remember-custom:hover {
    box-shadow: 0 0 3px #007bff !important;
}
</style>
<link href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />


