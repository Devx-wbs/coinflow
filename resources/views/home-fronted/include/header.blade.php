<header class="navbar">
  <div class="container navbar-container">
    <a href="{{ url('/') }}" class="logo">
      <img src="{{ asset('images/coinflow.png') }}" alt="CoinFlow Logo">
    </a>
    <nav>
      <ul class="nav-links">
        <ul class="nav-links">

          <li>
            <a href="{{ url('/') }}" id="nav-home">Home</a>
          </li>

          <li>
            <a href="{{ url('/#pricing') }}" id="nav-pricing">Pricing</a>
          </li>

          <li>
            <a href="{{ url('/#features') }}" id="nav-features">Features</a>
          </li>

          <li>
            <a href="{{ route('contact.form') }}"
              class="{{ request()->routeIs('contact.form') ? 'active' : '' }}">
              Contact
            </a>
          </li>

        </ul>


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
            My Plan
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

      @if(Auth::check())

      @php
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
      @endphp

      <!-- 🔹 Logged In Mobile View -->
      @if(Auth::check())

      <div class="mobile-user-section">

        <!-- Dropdown Header -->
        <div class="mobile-user-toggle" id="mobileUserToggle">
          <div class="user-left">
            <img src="{{ Auth::user()->profile_image_url }}"
              width="32"
              height="32"
              style="border-radius:50%; object-fit:cover;">
            <span>{{ Auth::user()->name }}</span>
          </div>
          <i class="fas fa-chevron-down mobile-arrow"></i>
        </div>

        <!-- Dropdown Body -->
        <div class="mobile-user-dropdown" id="mobileUserDropdown">

          <a href="/profile" class="mobile-dropdown-item">
            Profile Setting
          </a>

          @if($hasActiveSubscription)
          <a href="{{ route('plan-detail') }}" class="mobile-dropdown-item">
            Account Preferences
          </a>
          @endif

          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="mobile-dropdown-item logout-btn">
              Sign Out
            </button>
          </form>

        </div>

      </div>

      @endif


      @else

      <!-- 🔹 Guest Mobile View -->
      <div class="mobile-auth">
        <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-primary">Sign up</a>
      </div>

      @endif

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
  document.addEventListener("DOMContentLoaded", function() {

    const toggle = document.getElementById("mobileUserToggle");
    const dropdown = document.getElementById("mobileUserDropdown");

    if (toggle) {
      toggle.addEventListener("click", function() {
        dropdown.classList.toggle("active");
        toggle.classList.toggle("open");
      });
    }

  });



  document.addEventListener("DOMContentLoaded", function() {

    const home = document.getElementById("nav-home");
    const pricing = document.getElementById("nav-pricing");
    const features = document.getElementById("nav-features");

    // 🔥 IMPORTANT: Only apply active logic on homepage
    if (window.location.pathname !== "/") {
      return; // stop here if not homepage
    }

    function setActive() {
      home.classList.remove("active");
      pricing.classList.remove("active");
      features.classList.remove("active");

      const hash = window.location.hash;

      if (hash === "#pricing") {
        pricing.classList.add("active");
      } else if (hash === "#features") {
        features.classList.add("active");
      } else {
        home.classList.add("active");
      }
    }

    setActive();
    window.addEventListener("hashchange", setActive);
  });
</script>

<style>
  header.navbar.scrolled .container {
    padding: 10px 20px;
  }

  /* button.mobile-menu-toggle.active {
    margin: 25px 20px 0 0;
  }*/

  button.mobile-menu-toggle {
    margin: 25px 20px 0 0;
  }

  header.navbar {
    flex-direction: column;
  }

  button.mobile-dropdown-item.logout-btn {
    background: transparent;
    border: 1px solid red;
    color: red;
    width: 100%;
}


  @media screen and (max-width:922px) {

 .container.navbar-container {
    width: 90%;
    padding: 10px 20px;
}

.mobile-user-dropdown {
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.mobile-user-dropdown a {
    background: #fefefe;
    border: 1px solid #4b4b4b;
}
.mobile-user-section {
    width: 100%;
}

    header.navbar {
      height: 80px;
    }

    .user-name:hover {
      background: none;
    }

  }


  @media (max-width: 768px) {
    #userDropdown {
      display: none !important;
    }
  }

  /* Hide mobile user section on desktop */
  @media (min-width: 769px) {
    .mobile-user-section {
      display: none !important;
    }
  }


  .mobile-user-section {
    margin-top: 15px;
    border-top: 1px solid #eee;
    padding-top: 10px;
  }

  .mobile-user-toggle {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    cursor: pointer;
    font-weight: 500;
  }

  .user-left {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .mobile-user-dropdown {
    max-height: 0;
    overflow: hidden;
    transition: all 0.3s ease;
  }

  .mobile-user-dropdown.active {
    max-height: 300px;
    margin-top: 8px;
  }

  .mobile-dropdown-item {
    display: block;
    padding: 8px 10px;
    font-size: 14px;
    color: #333;
    text-decoration: none;
    border-radius: 6px;
  }

  .mobile-dropdown-item:hover {
    background: #f5f5f5;
  }

  .mobile-arrow {
    transition: transform 0.3s ease;
  }

  .mobile-user-toggle.open .mobile-arrow {
    transform: rotate(180deg);
  }
</style>