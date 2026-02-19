@extends('layouts.frontend')

@section('content')

<section class="contact-wrapper">
    <div class="contact-container">

        <div class="contact-left">
            <div class="contact-header">
                <h1>Contact Support</h1>
                <p>Need help? Our support team is here to assist you with any questions or issues you may have. We
                    typically respond within 24 hours.</p>
            </div>

            {{-- ✅ Success Message --}}
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}

            </div>
            @endif


            <form action="{{ route('contact.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text"
                        name="full_name"
                        placeholder="sam"
                        class="form-control @error('full_name') is-invalid @enderror"
                        value="{{ old('full_name', auth()->user()->name ?? '') }}">

                    @error('full_name')
                    <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>


                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email"
                        name="email"
                        placeholder="xyz@gmail.com"
                        class="form-control  @error('email') is-invalid @enderror"
                        value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}">

                    @error('email')
                    <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Subject (Select) -->
                <div class="form-group">
                    <label class="form-label">Subject</label>
                    <input type="text"
                        name="subject"
                        class="form-control @error('subject') is-invalid @enderror"
                        value="{{ old('subject') }}">

                    @error('subject')
                    <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Message -->

                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea name="message"
                        rows="4"
                        class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>

                    @error('message')
                    <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>



                <!-- Submit Button -->
                <button type="submit" class="btn-submit">Send Request</button>

            </form>
        </div>

        <!-- Right Side: Image -->
        <div class="contact-right">
            <img src="{{ asset('images/contact.png') }}" alt="Contact Support Illustration" class="contact-hero-img">
        </div>

    </div>
</section>

@endsection




<!-- END -->
<style>
    .contact-wrapper {
        background: linear-gradient(180deg, #eef4fb 0%, #f7f9fc 100%);
        padding: 80px 0;
    }

    .contact-container {
        max-width: 1200px;
        margin: auto;
        background: #f3f7fb;
        border-radius: 20px;
        padding: 60px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .contact-left {
        width: 50%;
    }

    /* 1920px Background Wrapper */
    .contact-bg-wrapper {
        width: 100%;
        max-width: 1920px;
        background: url("public/hero_bg.png") no-repeat center center;
        background-size: cover;
        border-radius: 40px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
        margin: 0 auto;
        overflow: hidden;
        display: flex;
        justify-content: center;
        min-height: 800px;
        position: relative;
    }

    /* 1440px Content Container */
    .contact-content-container {
        width: 100%;
        max-width: 1440px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 60px 80px;
        position: relative;
        z-index: 2;
    }

    /* Left Side - Contact Form Card */
    .contact-left {
        flex: 1;
        max-width: 540px;
        /* Slightly wider for form */
        background: #ffffff;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
        z-index: 2;
        border: 1px solid #1494FF21;
    }

    /* Right Side - Illustration */
    .contact-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 1;
        padding-left: 60px;
        max-width: 650px;
    }

    .contact-hero-img {
        max-width: 100%;
        height: auto;
        max-height: 700px;
        object-fit: contain;
        filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.1));
    }

    /* Form Header */
    .contact-header {
        margin-bottom: 24px;
    }

    .contact-header h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 12px;
        color: #191D23;
    }

    .contact-header p {
        color: #666666;
        font-size: 14px;
        line-height: 1.6;
    }

    /* Form Inputs */
    .form-group {
        margin-bottom: 20px;
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
        height: 48px;
        padding: 0 16px;
        border: 1px solid #E5E7EB;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        color: #333;
        outline: none;
        transition: all 0.2s;
        background: #ffffff;
    }

    .form-control:focus {
        border-color: #1494FF;
        box-shadow: 0 0 0 4px rgba(20, 148, 255, 0.1);
    }

    /* Select Dropdown styling */
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1em;
        color: #666;
    }

    /* Textarea specific */
    textarea.form-control {
        height: 120px;
        padding: 12px 16px;
        resize: none;
    }

    /* Submit Button */
    .btn-submit {
        width: 100%;
        height: 48px;
        background: #1494FF;
        /* Solid blue as per screenshot, or gradient if preferred. Screenshot looks solid blue */
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        font-family: 'Poppins', sans-serif;
    }

    .btn-submit:hover {
        background: #0077E5;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(20, 148, 255, 0.2);
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .contact-content-container {
            padding: 40px;
            flex-direction: column;
            justify-content: center;
            gap: 40px;
        }

        .contact-left {
            width: 100%;
            max-width: 500px;
        }

        

        .contact-bg-wrapper {
            height: auto;
            min-height: auto;
        }
    }

    @media (max-width: 768px) {
        .contact-bg-wrapper {
            border-radius: 20px;
        }

        .contact-left {
            padding: 24px 20px;
        }

        .contact-container {
            padding: 30px;
            flex-direction: column-reverse;
            gap: 30px;
        }

        .contact-right {
            padding-left: 0px;
            width: 50%;
        }

    }
</style>