@php
$layout = Auth::user()->role == 1
? 'layouts.user_type.auth'
: 'layouts.frontend';
@endphp

@extends($layout)

@section('content')

<div class="container py-5">

  <div class="row justify-content-center">
    <div class="col-lg-8">

      {{-- PROFILE CARD --}}
      <div class="card shadow-lg border-0 rounded-4 p-4">

        <div class="text-center mb-4">

          <div class="position-relative d-inline-block">

            @if(Auth::user()->imageFile)
              <img src="{{ asset('storage/' . Auth::user()->imageFile->file_path) }}"
                class="rounded-circle border"
                width="120"
                height="120"
                style="object-fit: cover;">
              @else
              <img src="{{ asset('images/default-user.png') }}"
                class="rounded-circle border"
                width="120"
                height="120"
                style="object-fit: cover;">
              @endif

          </div>

          <h4 class="mt-3 mb-0 fw-bold">{{ Auth::user()->name }}</h4>
          <p class="text-muted small">{{ Auth::user()->email }}</p>

        </div>

        <hr>

        <form action="{{ route('profile.update') }}" 
              method="POST" 
              enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label class="form-label fw-semibold">Full Name</label>
            <input type="text"
                   name="name"
                   class="form-control rounded-3"
                   value="{{ old('name', Auth::user()->name) }}"
                   required>
          </div>

          <div class="mb-4">
            <label class="form-label fw-semibold">Change Profile Image</label>
            <input type="file"
                   name="image"
                   class="form-control rounded-3"
                   accept="image/*">
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm">
              Update Profile
            </button>
          </div>

        </form>

        @if(session('success'))
          <div class="alert alert-success mt-3 text-center">
            {{ session('success') }}
          </div>
        @endif

      </div>

      {{-- PASSWORD CARD --}}
      <div class="card shadow-lg border-0 rounded-4 p-4 mt-4">

        <h5 class="fw-bold mb-3">Change Password</h5>

        <form action="{{ route('profile.changePassword') }}" method="POST">
          @csrf

          <div class="mb-3">
            <input type="password"
                   name="current_password"
                   class="form-control rounded-3"
                   placeholder="Current Password"
                   required>
          </div>

          <div class="mb-3">
            <input type="password"
                   name="new_password"
                   class="form-control rounded-3"
                   placeholder="New Password"
                   required>
          </div>

          <div class="mb-3">
            <input type="password"
                   name="new_password_confirmation"
                   class="form-control rounded-3"
                   placeholder="Confirm New Password"
                   required>
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-dark px-5 rounded-pill shadow-sm">
              Update Password
            </button>
          </div>

        </form>

      </div>

    </div>
  </div>

</div>


{{-- jQuery + Validation (no AJAX) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
  $(function() {
    $("#changePasswordForm").validate({
      rules: {
        current_password: {
          required: true
        },
        new_password: {
          required: true,
          minlength: 6
        },
        new_password_confirmation: {
          required: true,
          equalTo: "#new_password"
        }
      },
      messages: {
        current_password: {
          required: "Please enter your current password"
        },
        new_password: {
          required: "Please enter a new password",
          minlength: "Password must be at least 6 characters"
        },
        new_password_confirmation: {
          required: "Please confirm your new password",
          equalTo: "Passwords do not match"
        }
      },
      errorElement: "span",
      errorPlacement: function(error, element) {
        error.addClass("text-danger d-block mt-1");
        error.insertAfter(element);
      },
      highlight: function(element) {
        $(element).addClass("is-invalid");
      },
      unhighlight: function(element) {
        $(element).removeClass("is-invalid");
      }
    });
  });


  setTimeout(() => {
    $('.alert-success').fadeOut('slow');
  }, 10000); // 10 seconds
</script>

@endsection