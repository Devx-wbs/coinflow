<!-- Navbar -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">{{ str_replace('-', ' ', Request::path()) }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0 text-capitalize">{{ str_replace('-', ' ', Request::path()) }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4 d-flex justify-content-end" id="navbar">
            @auth
            @if(Auth::user()->role == 0)
              <div class="nav-item d-flex align-self-end gap-2">
                    <!-- License key input -->
                    <input type="text" 
                           id="licenseKey" 
                           class="form-control" 
                           value="{{ $licenseKey ?? 'No Active License' }}" 
                           readonly>
                
                    <!-- Copy button -->
                    <button type="button" 
                            class="btn btn-outline-primary btn-primary active mb-0 text-white" 
                            onclick="copyLicenseKey()">
                        Copy Licence
                    </button>
               
                    <!-- Download button -->
                    <a href="{{ route('download.zip') }}" 
                       class="btn btn-primary active mb-0 text-white" 
                       role="button">
                        Download Zip
                    </a>
                </div>
                
                <script>
                function copyLicenseKey() {
                    const input = document.getElementById("licenseKey");
                    input.select();
                    input.setSelectionRange(0, 99999); // mobile support
                    navigator.clipboard.writeText(input.value)
                        .then(() => {
                            alert("✅ License key copied: " + input.value);
                        })
                        .catch(err => {
                            alert("❌ Failed to copy: " + err);
                        });
                }
                </script>
           @endif
        @endauth
            <!-- <div class="ms-md-3 pe-md-3 d-flex align-items-center">
            <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="Type here...">
            </div>
            </div> -->
            <ul class="navbar-nav  justify-content-end">
        <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" href="#" id="navbarDropdown" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
                <!-- <img src="{{ asset('path-to-avatar.jpg') }}" alt="Profile" class="rounded-circle me-2" width="35" height="35"> -->
                <div class="d-flex flex-column">
                    <span class="fw-bold">{{ Auth::user()->name ?? 'superadmin' }}</span>
                    <!-- <small class="text-muted">{{ Auth::user()->email ?? 'superadmin@gmail.com' }}</small> -->
                </div>
                <i class="fa fa-chevron-down ms-2 text-muted"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile Setting</a></li>
                <li><a class="dropdown-item" href="#">Account Preferences</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">Sign Out</button>
                    </form>
                </li>
            </ul>
        </li>



            
            
        </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->