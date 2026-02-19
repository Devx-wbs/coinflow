@extends('layouts.frontend')

@section('title','Sign Up')

@section('content')

<section class="register-section">
    <div class="register-bg-wrapper">

        <!-- 1440px Content Container -->
        <div class="register-content-container">

            <!-- Left Side: Form Card -->
            <div class="register-left">
                <div class="register-header">
                    <h1>Create your CoinFlow account</h1>
                    <p>Get started with crypto payments</p>
                </div>

                {!! NoCaptcha::renderJs() !!}

                <form method="POST" action="{{ route('register.post') }}">
                    @csrf
                    <!-- Full Name -->
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your full name" value="{{ old('name') }}">
                    </div>
                    @error('name')
                    <span class="field-error">{{ $message }}</span>
                    @enderror

                    <!-- Email -->
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}">
                    </div>

                    @error('email')
                    <span class="field-error">{{ $message }}</span>
                    @enderror


                    <!-- Password -->
                    <div class="form-group password-group">
                        <label class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" class="form-control password-input" placeholder="Create a Password">

                            <span class="toggle-password">
                                <!-- Eye Open -->
                                <svg class="eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5Z"
                                        stroke="#9CA3AF" stroke-width="2" />
                                    <circle cx="12" cy="12" r="3" stroke="#9CA3AF" stroke-width="2" />
                                </svg>

                                <!-- Eye Close -->
                                <svg class="eye-close" width="20" height="20" viewBox="0 0 24 24" fill="none" style="display:none;">
                                    <path d="M3 3L21 21" stroke="#9CA3AF" stroke-width="2" />
                                    <path d="M10.5 6.5C11 6.5 11.5 6.5 12 6.5C17 6.5 21.27 9.61 23 14"
                                        stroke="#9CA3AF" stroke-width="2" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    @error('password')
                    <span class="field-error">{{ $message }}</span>
                    @enderror

                    <!-- Confirm Password -->
                    <div class="form-group password-group">
                        <label class="form-label">Confirm Password</label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" class="form-control password-input" placeholder="Re-enter Password">

                            <span class="toggle-password">
                                <!-- Eye Open -->
                                <svg class="eye-open" width="20" height="20" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 4.5C7 4.5 2.73 7.61 1 12C2.73 16.39 7 19.5 12 19.5C17 19.5 21.27 16.39 23 12C21.27 7.61 17 4.5 12 4.5Z"
                                        stroke="#9CA3AF" stroke-width="2" />
                                    <circle cx="12" cy="12" r="3" stroke="#9CA3AF" stroke-width="2" />
                                </svg>

                                <!-- Eye Close -->
                                <svg class="eye-close" width="20" height="20" viewBox="0 0 24 24" fill="none" style="display:none;">
                                    <path d="M3 3L21 21" stroke="#9CA3AF" stroke-width="2" />
                                    <path d="M10.5 6.5C11 6.5 11.5 6.5 12 6.5C17 6.5 21.27 9.61 23 14"
                                        stroke="#9CA3AF" stroke-width="2" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    @error('password_confirmation')
                    <span class="field-error">{{ $message }}</span>
                    @enderror

                    <!-- Fake Recaptcha Section -->
                    <div class="captcha-box">
                        {!! NoCaptcha::display() !!}
                    </div>
                    @error('g-recaptcha-response')
                    <span class="field-error">{{ $message }}</span>
                    @enderror


                    <!-- Terms Checkbox -->


                    <div class="terms-row">
                        <input type="checkbox" id="terms" required>
                        <label for="terms">
                            I agree to the <a href="{{ route('terms.conditions') }}">Terms of Service</a> and <a href="{{ route('privacy.policy') }}">Privacy Policy</a>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">Create Account</button>

                    <!-- Footer -->
                    <div class="auth-footer">
                        <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                    </div>
                </form>
            </div>

            <!-- Right Side: Image -->
            <div class="register-right">
                <img src="{{ asset('images/regi_right.png') }}" alt="Crypto Registration Illustration" class="register-hero-img">
            </div>

        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.querySelectorAll(".toggle-password").forEach(function(toggle) {

                toggle.addEventListener("click", function() {

                    const wrapper = this.closest(".password-wrapper");
                    const input = wrapper.querySelector(".password-input");
                    const eyeOpen = wrapper.querySelector(".eye-open");
                    const eyeClose = wrapper.querySelector(".eye-close");

                    if (input.type === "password") {
                        input.type = "text";
                        eyeOpen.style.display = "none";
                        eyeClose.style.display = "block";
                    } else {
                        input.type = "password";
                        eyeOpen.style.display = "block";
                        eyeClose.style.display = "none";
                    }

                });

            });

        });
    </script>

</section>

@endsection

<style>
    .password-wrapper {
        position: relative;
    }

    .password-wrapper .toggle-password {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .terms-row {
        padding: 20px 0;
    }


    .terms-row label {
        margin-left: 10px !important;
    }

    /* 1920px Background Wrapper */
    .register-bg-wrapper {
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
        min-height: 900px;
        /* Taller for registration form */
        position: relative;
    }

    /* 1440px Content Container */
    .register-content-container {
        width: 100%;
        max-width: 1440px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 130px 80px;
        position: relative;
        z-index: 2;
    }

    /* Left Side - Register Card */
    .register-left {
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
    .register-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 1;
        padding-left: 40px;
        max-width: 600px;
    }

    .register-hero-img {
        max-width: 100%;
        height: auto;
        max-height: 700px;
        object-fit: contain;
        filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.1));
    }

    /* Form Header */
    .register-header {
        margin-bottom: 20px;
    }

    .register-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 8px;
        color: #191D23;
    }

    .register-header p {
        color: #666666;
        font-size: 14px;
    }

    /* Form Inputs */
    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        display: block;
        margin-bottom: 6px;
        font-weight: 500;
        font-size: 14px;
        color: #191D23;
    }

    .form-control {
        width: 100%;
        height: 48px;
        padding: 0 16px;
        border: 1px solid #E5E7EB;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        color: #333;
        outline: none;
        transition: all 0.2s;
        background: #FAFAFA;
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
        z-index: 10;
    }

    /* Recaptcha Placeholder */
    .recaptcha-box {
        background: #F9FAFB;
        border: 1px solid #D1D5DB;
        border-radius: 6px;
        padding: 8px 12px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        margin-bottom: 20px;
    }

    .recaptcha-check {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        font-weight: 500;
        color: #333;
    }

    .recaptcha-logo {
        text-align: center;
        font-size: 9px;
        color: #555;
        line-height: 1.2;
    }

    /* Terms Checkbox */
    .terms-check {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 24px;
        cursor: pointer;
    }

    .custom-checkbox {
        appearance: none;
        min-width: 20px;
        height: 20px;
        background: #fff;
        border: 2px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
        margin-top: 2px;
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

    .terms-label {
        font-size: 12px;
        color: #555;
        user-select: none;
        line-height: 1.4;
    }

    .terms-label a {
        color: #1494FF;
        text-decoration: none;
    }

    .terms-label a:hover {
        text-decoration: underline;
    }

    /* Submit Button */
    .btn-submit {
        width: 100%;
        height: 50px;
        background: linear-gradient(90deg, #1394FF 0%, #35A3FF 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 4px 12px rgba(20, 148, 255, 0.2);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(20, 148, 255, 0.3);
    }

    /* Footer Links */
    .auth-footer {
        margin-top: 20px;
        font-size: 13px;
        color: #666;
        text-align: left;
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
        .register-content-container {
            padding: 40px;
            flex-direction: column;
            justify-content: center;
            gap: 40px;
        }

        .register-left {
            width: 100%;
            max-width: 450px;
        }

        .register-right {
            display: none;
        }

        .register-bg-wrapper {
            height: auto;
            min-height: auto;
        }
    }

    @media (max-width: 768px) {
        .register-bg-wrapper {
            border-radius: 20px;
        }

        .register-left {
            padding: 24px 20px;
        }
    

     
.captcha-box .g-recaptcha div iframe {
    width: 100%;
}

.captcha-box .g-recaptcha div {
    width: 100% !important;
}

    .terms-row label {
      font-size: 12px;
    }

    .terms-row {
      display: inline-flex;
    }
}
</style>