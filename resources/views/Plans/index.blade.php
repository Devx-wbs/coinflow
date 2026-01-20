@extends('layouts.user_type.auth')

@section('content')
<div class="col-lg-12">
    <div class="row">
      <div class="col-xl-3 col-sm-6 mb-xl-2 mb-4">
        <!-- <div class="card"> --> 
          <li class="nav-link mb-2 ">
            <a href="{{ route('plan-create') }}" class="btn btn-primary btn-md active px-5 text-white" target="_blank" role="button" aria-pressed="true">Add New Plan</a>
          </li>  
        <!-- </div> -->
      </div>
    </div>
    @if(session('success'))
        <div id="alert-message" class="alert alert-success text-white font-weight-bold px-4 py-3 mb-4 rounded" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div id="alert-message" class="alert alert-danger text-white font-weight-bold px-4 py-3 mb-4 rounded" role="alert">
            {{ session('error') }}
        </div>
    @endif
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Plans table</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Plan Name</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Duration</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-secondary opacity-7">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="mb-0 text-sm">{{ $plan->name }}</h6>
                                        <p class="text-xs text-secondary mb-0">{{ $plan->description }}</p>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-xs font-weight-bold mb-0">${{ number_format($plan->price, 2) }}</p>
                                </td>
                                <td class="align-middle text-center">
                                    <span class="text-secondary text-xs font-weight-bold">
                                        {{ $plan->duration }} {{ ucfirst($plan->duration_type) }}
                                    </span>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    @if($plan->is_active)
                                        <span class="badge badge-sm bg-gradient-success">Active</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('plan-edit', $plan->id) }}" class="font-weight-bold text-xs" style="color: #cb0c9f; margin-right: 10px;">
                                        Edit
                                    </a>
                                    <form action="{{ route('plan-destroy', $plan->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-weight-bold text-xs" style="color: #fd006c; background:none; border:none; cursor:pointer;">
                                            Delete
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No plans found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
  <script>
      document.addEventListener("DOMContentLoaded", function () {
          let alertBox = document.getElementById("alert-message");
          if (alertBox) {
              setTimeout(() => {
                  alertBox.style.transition = "opacity 0.5s ease";
                  alertBox.style.opacity = "0";
                  setTimeout(() => alertBox.remove(), 500); // fade-out ke baad remove
              }, 5000); // 5 sec
          }
      });
  </script>
@endsection
