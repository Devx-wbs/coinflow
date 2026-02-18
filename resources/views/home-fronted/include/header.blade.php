<header class="navbar">
  <div class="container navbar-container">
    <a href="{{ url('/') }}" class="logo">
      <img src="{{ asset('images/coinflow.png') }}" alt="CoinFlow Logo">
    </a>
    <nav>
      <ul class="nav-links">
        <li><a href="{{ url('/') }}" class="active">Home</a></li>
        <li><a href="#pricing">Pricing</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="{{ route('contact.form') }}">Contact</a></li>
      </ul>
    </nav>








    @if(Auth::check())
    <!-- 🔹 Logged in view -->
    <div class="button" style="display:flex; align-items:center; gap:16px;">
      <form method="GET" action="#" style="display:inline;">
        @csrf
        <!-- <button type="submit" class="btn-download">
              Download Plugin
            </button> -->
      </form>

      <div class="user-dropdown" id="userDropdown">
        <div class="user-name">
          <img src="{{ Auth::user()->profile_image_url }}"
            class="rounded-circle"
            width="35"
            height="35"
            style="object-fit: cover;">
          {{ Auth::user()->name }}

          <i class="fas fa-chevron-down"></i>
        </div>
        <div class="dropdown-menu">

          <a href="/profile" class="dropdown-item">
            Profile Setting
          </a>

          @php
          $hasActiveSubscription = false;

          if(Auth::check()) {
          $user = Auth::user();

          $activeSubscription = \App\Models\Subscription::where('user_id', $user->id)
          ->where('status', 'active')
          ->whereDate('end_date', '>=', now())
          ->first();

          $activeLicense = \App\Models\License::where('user_id', $user->id)
          ->where('status', 'active')
          ->whereDate('expiration_date', '>=', now())
          ->first();

          $hasActiveSubscription = $activeSubscription && $activeLicense;
          }
          @endphp

          @if($hasActiveSubscription)
          <a href="{{ route('plan-detail') }}" class="dropdown-item">
            Account Preferences
          </a>
          @endif


          
          <div class="dropdown-divider"></div>

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item logout-btn">
              Sign Out
            </button>
          </form>

        </div>

      </div>






      @else
      <!-- 🔹 Logged out view -->

      <div class="auth-buttons">
        <a href="{{ route('login') }}" class="login_btn">Login</a>
        <a href="{{ route('register') }}" class="signup_btn">Sign up</a>
      </div>
      @endif




    </div>

    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" aria-label="Toggle navigation">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
      <a href="{{ url('/') }}" class="mobile-link">Home</a>
      <a href="#features" class="mobile-link">Features</a>
      <a href="#pricing" class="mobile-link">Pricing</a>
      <a href="{{ route('contact.form') }}" class="mobile-link">Contact</a>
      <div class="mobile-auth">
        <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-primary">Sign up</a>
      </div>
    </div>
  </div>
</header>

<script>
  document.querySelector('#userDropdown .user-name').addEventListener('click', function() {
    document.querySelector('#userDropdown .dropdown-menu').classList.toggle('active');
  });

  // close dropdown if clicked outside
  document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('userDropdown');
    if (!dropdown.contains(e.target)) {
      dropdown.querySelector('.dropdown-menu').classList.remove('active');
    }
  });
</script>