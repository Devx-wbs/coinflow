@extends('layouts.user_type.auth')

@section('content')

<div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100 p-4">
  <div class="container-fluid">

    {{-- Profile Update Card --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
      <div class="card-header bg-white border-0 pb-0">
        <h4 class="fw-bold"><i class="fa fa-user me-2 text-primary"></i> Profile Settings</h4>
        <p class="text-muted mb-0">Manage your profile information</p>
      </div>
      <div class="card-body">
        <form id="profileForm" action="{{ route('profile.update') }}" method="POST">
          @csrf
          @method('PUT')
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label fw-semibold">Name</label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', Auth::user()->name) }}" required>
              @error('name')
                <span class="text-danger d-block mt-1">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-6">
              <label class="form-label fw-semibold">Email</label>
              <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
            </div>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">
              <i class="fa fa-save me-1"></i> Update Profile
            </button>
          </div>
        </form>
        @if(session('success'))
          <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
      </div>
    </div>

    {{-- Change Password Card --}}
    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-header bg-white border-0 pb-0">
        <h4 class="fw-bold"><i class="fa fa-lock me-2 text-primary"></i> Change Password</h4>
        <p class="text-muted mb-0">Update your password securely</p>
      </div>
      <div class="card-body">
        <form id="changePasswordForm" action="{{ route('profile.changePassword') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
            @error('current_password')
              <span class="text-danger d-block mt-1">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" id="new_password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" required>
            @error('new_password')
              <span class="text-danger d-block mt-1">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control" required>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">
              <i class="fa fa-key me-1"></i> Update Password
            </button>
          </div>
        </form>

        @if(session('password_success'))
          <div class="alert alert-success mt-3">{{ session('password_success') }}</div>
        @endif

      </div>
    </div>

  </div>
</div>

{{-- jQuery + Validation (no AJAX) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<script>
$(function () {
  $("#changePasswordForm").validate({
    rules: {
      current_password: { required: true },
      new_password: { required: true, minlength: 6 },
      new_password_confirmation: { required: true, equalTo: "#new_password" }
    },
    messages: {
      current_password: { required: "Please enter your current password" },
      new_password: { required: "Please enter a new password", minlength: "Password must be at least 6 characters" },
      new_password_confirmation: { required: "Please confirm your new password", equalTo: "Passwords do not match" }
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
      error.addClass("text-danger d-block mt-1");
      error.insertAfter(element);
    },
    highlight: function (element) {
      $(element).addClass("is-invalid");
    },
    unhighlight: function (element) {
      $(element).removeClass("is-invalid");
    }
  });
});


setTimeout(() => {
  $('.alert-success').fadeOut('slow');
}, 10000); // 10 seconds


</script>

@endsection
