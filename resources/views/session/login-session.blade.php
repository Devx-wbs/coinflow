@extends('layouts.frontend')

@section('title','Login')

@section('content')


@section('content')
<main class="main-content mt-0">
    <section class="login-section login-bg-wrapper">
        <div class="container login-wrapper ">

            <div class="login-left">
                <div class="login-header">
                    <h1>Welcome Back</h1>
                    <p>Log in to your CoinFlow account</p>
                </div>

                {{-- ✅ reCAPTCHA script ko yahan load karo --}}
                {!! NoCaptcha::renderJs() !!}
                <form method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="xyz@gmail.com">
                    </div>

                    <div class="form-group password-group">
                        <label class="form-label">Password</label>
                        <div style="position: relative;">
                            <input type="password" id="password" class="form-control" name="password" placeholder="Create a Password">

                            <span class="toggle-password" id="togglePassword">
                                <!-- Eye Open -->
                                <svg id="eyeOpen" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5Z"
                                        stroke="#9CA3AF" stroke-width="2" />
                                    <circle cx="12" cy="12" r="3" stroke="#9CA3AF" stroke-width="2" />
                                </svg>

                                <!-- Eye Closed -->
                                <svg id="eyeClose" width="20" height="20" viewBox="0 0 24 24" fill="none" style="display:none;">
                                    <path d="M3 3L21 21" stroke="#9CA3AF" stroke-width="2" />
                                    <path d="M10.5 6.5C11 6.5 11.5 6.5 12 6.5C17 6.5 21.27 9.61 23 14C22.29 15.77 21.25 17.31 19.96 18.56"
                                        stroke="#9CA3AF" stroke-width="2" />
                                    <path d="M1 14C2.73 9.61 7 6.5 12 6.5"
                                        stroke="#9CA3AF" stroke-width="2" />
                                </svg>
                            </span>

                        </div>
                    </div>

                    {{-- ✅ reCAPTCHA widget --}}
                    <div class="form-group mt-3">
                        {!! NoCaptcha::display() !!}
                        @error('g-recaptcha-response')
                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Remember Me -->
                    <label class="remember-me">
                        <input type="checkbox" class="custom-checkbox" checked>
                        <span class="remember-label">Remember me</span>
                    </label>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">Sign In</button>

                    <!-- Footer -->
                    <div class="auth-footer">
                        <p>Don't have an account? <a href="{{ route('register') }}">Create an account</a></p>
                        <p style="margin-top: 10px; color: #999; font-size: 11px;">
                            By signing in, you agree to our <a href="{{ route('terms.conditions') }}"
                                style="color:#999; text-decoration: underline;">Terms of Service</a> and <a href="{{ route('privacy.policy') }}"
                                style="color:#999; text-decoration: underline;">Privacy Policy</a>
                        </p>
                    </div>
                </form>
            </div>

            <!-- Right Side: Image -->
            <div class="login-right">
                <img src="{{ asset('images/login_r.png') }}" alt="Crypto Illustration" class="login-hero-img">
            </div>

        </div>
        <script>
            const togglePassword = document.getElementById('togglePassword');
            const password = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClose = document.getElementById('eyeClose');

            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                if (type === 'text') {
                    eyeOpen.style.display = "none";
                    eyeClose.style.display = "block";
                } else {
                    eyeOpen.style.display = "block";
                    eyeClose.style.display = "none";
                }
            });
        </script>

    </section>

</main>
@endsection
<style>
    .remember-custom {
        appearance: none !important;
        -webkit-appearance: none !important;
        background-color: #fff !important;
        border: 2px solid #000 !important;
        /* 🖤 Default black border */
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
        border-color: #007bff !important;
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





    /* start */

    /* 1920px Background Wrapper */
    .login-bg-wrapper {
        width: 100%;
        max-width: 1920px;
        background: url("{{ asset('images/hero_bg.png') }}") no-repeat center center;
        background-size: cover;
        border-radius: 40px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
        margin: 0 auto;
        overflow: hidden;
        display: flex;
        justify-content: center;
        min-height: 800px;
        /* Use min-height to allow content to grow */
        position: relative;
    }

    /* 1440px Content Container */
    .login-content-container {
        width: 100%;
        max-width: 1440px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 60px 80px;
        position: relative;
        z-index: 2;
    }

    /* Left Side - Login Card */
    .login-left {
        flex: 1;
        max-width: 480px;
        /* Constrain width of the form card */
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        z-index: 2;
        border: 1px solid #1494FF21;
    }

    /* Right Side - Illustration */
    .login-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 1;
        padding-left: 40px;
        max-width: 600px;
    }

    .login-hero-img {
        max-width: 100%;
        height: auto;
        max-height: 700px;
        /* Prevent overly large image */
        object-fit: contain;
        /* Optional animation or transform for "floating" effect */
        filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.1));
    }

    /* LOGO */
    .brand-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 40px;
        font-size: 24px;
        font-weight: 700;
        color: #1C1C1C;
    }

    .brand-logo img {
        height: 32px;
        width: auto;
    }

    /* Form Header */
    .login-header {
        margin-bottom: 20px;
    }

    .login-header h1 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #191D23;
    }

    .login-header p {
        color: #666666;
        font-size: 18px;
    }

    /* Form Inputs */
    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        font-size: 16px;
        color: #191D23;
    }

    .form-control {
        width: 100%;
        height: 52px;
        padding: 0 16px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        color: #333;
        outline: none;
        transition: all 0.2s;
        background: #FAFAFA;
        /* Slightly distinct input background */
    }

    .form-control:focus {
        border-color: #1494FF;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(20, 148, 255, 0.1);
    }

    .password-group {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
        font-size: 18px;
    }

    /* Recaptcha Placeholder */
    .recaptcha-box {
        background: #F9FAFB;
        border: 1px solid #D1D5DB;
        border-radius: 6px;
        padding: 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        /* Full width inside card */
        margin-bottom: 32px;
    }

    .recaptcha-check {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 500;
        color: #333;
    }

    .recaptcha-logo {
        text-align: center;
        font-size: 9px;
        color: #555;
        line-height: 1.2;
    }

    /* Remember Me */
    .remember-me {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 30px;
        cursor: pointer;
    }

    /* Custom Checkbox Style */
    .custom-checkbox {
        appearance: none;
        width: 20px;
        height: 20px;
        background: #fff;
        border: 2px solid #ddd;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
    }

    .custom-checkbox:checked {
        background-color: #1494FF;
        border-color: #1494FF;
    }

    .custom-checkbox:checked::after {
        content: "✓";
        color: white;
        font-size: 12px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-weight: bold;
    }

    .custom-checkbox:hover {
        border-color: #1494FF;
    }

    .remember-label {
        font-size: 14px;
        color: #555;
        user-select: none;
        font-weight: 500;
    }

    /* Submit Button */
    .btn-submit {
        width: 100%;
        height: 52px;
        background: linear-gradient(90deg, #1394FF 0%, #35A3FF 100%);
        /* Gradient button */
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
    }

    .btn-submit:hover {
        background: #0077E5;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(20, 148, 255, 0.3);
    }

    /* Footer Links */
    .auth-footer {
        margin-top: 30px;
        font-size: 14px;
        color: #666;
        line-height: 1.6;
        text-align: left;
        /* Keep aligned left */
    }

    .auth-footer a {
        color: #1494FF;
        text-decoration: none;
        font-weight: 500;
    }

    .auth-footer a:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .login-content-container {
            padding: 40px;
            flex-direction: column;
            justify-content: center;
            gap: 40px;
        }

        .login-left {
            width: 100%;
            max-width: 450px;
        }

        .login-right {
            display: none;
            /* Hide image on smaller screens to keep focus on form */
        }

        .login-bg-wrapper {
            height: auto;
            min-height: auto;
        }
    }

    @media (max-width: 768px) {
        .login-bg-wrapper {
            border-radius: 20px;
        }

        .login-left {
            padding: 30px 20px;
        }
    }
</style>