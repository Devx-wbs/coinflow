@extends('layouts.frontend')

@section('content')

<section class="contact-wrapper">
    <div class="contact-container">

        <div class="contact-left">
            <div class="contact-card">

                <h3>Contact Support</h3>
                <p class="sub-text">
                    Need help? Our support team is here to assist you with any
                    questions or issues you may have. We typically respond within 24 hours.
                </p>

                {{-- ✅ Success Message --}}
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                 
                </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}">
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}">
                    </div>

                    {{-- ✅ Category Added --}}
                    <div class="form-group">
                        <label>Category</label>
                        <select name="category_id">
                            <option value="">-- Select Category --</option>
                            @foreach(\App\Models\Support::categories() as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="subject" value="{{ old('subject') }}">
                    </div>

                    <div class="form-group">
                        <label>Message</label>
                        <textarea name="message" rows="4">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="submit-btn">
                        Send Request
                    </button>
                </form>

            </div>
        </div>

        <div class="contact-right">
            <div class="image-circle"></div>
            <img src="{{ asset('images/contact.png') }}" alt="Support">
        </div>

    </div>
</section>

@endsection

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

    .contact-card {
        background: #ffffff;
        padding: 35px;
        border-radius: 12px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
    }

    .contact-card h3 {
        font-weight: 600;
        margin-bottom: 10px;
    }

    .sub-text {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: 500;
        display: block;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #2f80ed;
    }

    .submit-btn {
        width: 100%;
        padding: 12px;
        background: linear-gradient(90deg, #2f80ed, #1c64f2);
        border: none;
        color: #fff;
        font-weight: 500;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s;
    }

    .submit-btn:hover {
        opacity: 0.9;
    }

    .contact-right {
        width: 45%;
        position: relative;
        text-align: center;
    }

    .contact-right img {
        width: 85%;
        position: relative;
        z-index: 2;
    }

    .image-circle {
        position: absolute;
        width: 400px;
        height: 400px;
        background: #e3eefc;
        border-radius: 50%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }

    /* Responsive */
    @media(max-width: 992px) {
        .contact-container {
            flex-direction: column;
            padding: 30px;
        }

        .contact-left,
        .contact-right {
            width: 100%;
        }

        .contact-right {
            margin-top: 40px;
        }
    }
</style>