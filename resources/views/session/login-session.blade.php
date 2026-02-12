@extends('layouts.frontend')

@section('title','Login')

@section('content')


@section('content')
<main class="main-content mt-0">
    <section class="login-section">
        <div class="container login-wrapper">

            <!-- Left Side -->
            <div class="login-card">
                <h2>Welcome Back</h2>
                <p>Log in to your CoinFlow account</p>
{{-- ✅ reCAPTCHA script ko yahan load karo --}}
                                {!! NoCaptcha::renderJs() !!}
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="xyz@gmail.com">

                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter Password">

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

                    <button type="submit" class="login-btn">Sign In</button>

                    <p class="small-text">
                        Don't have an account?
                        <a href="{{ route('register') }}">Create account</a>
                    </p>

                     <p class="small-text">
                       By signing in, you agree to our
                        <a href="{{ route('register') }}">Terms of Service</a> and <a href="{{ route('register') }}">Privacy Policy</a>
                    </p>
                </form>
            </div>

            <!-- Right Side -->
            <div class="login-image">
                <img src="{{ asset('images/login.png') }}">
            </div>

        </div>
    </section>

</main>
@endsection
<style>
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
    .login-section {
        padding: 100px 0;
        background: #f5f8ff;
    }

    .login-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 60px;
    }

    .login-card {
        background: #fff;
        padding: 40px;
        border-radius: 16px;
        width: 420px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
    }

    .login-card h2 {
        font-size: 28px;
        font-weight: 600;
    }

    .login-card p {
        margin-bottom: 25px;
        color: #666;
    }

    .login-card input {
        width: 100%;
        height: 45px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 0 15px;
        margin-bottom: 15px;
    }

    .login-btn {
        width: 100%;
        height: 45px;
        background: #1494FF;
        border: none;
        color: white;
        border-radius: 8px;
        margin-top: 10px;
        transition: 0.3s;
    }

    .login-btn:hover {
        background: #0f7be0;
    }

    .login-image img {
        width: 100%;
        max-width: 500px;
    }

    /* Responsive */

    @media (max-width: 992px) {
        .login-wrapper {
            flex-direction: column;
            text-align: center;
        }

        .login-card {
            width: 100%;
        }

        .login-image {
            display: none;
        }
    }
</style>
