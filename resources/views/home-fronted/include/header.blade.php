<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="{{ asset('style.css') }}">
  <title>Coin Flow</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <!-- Header start -->
  <div class="full-header">
    <header class="full-header">
      <div class="container">
        <div class="header_contains">
          <!-- Logo -->
          <div class="logo">
            <a href="{{ url('/') }}" class="dropdown-item">
              <img src="{{ asset('images/coinflow_logo.png') }}" alt="Coinflow Logo">
            </a>
          </div>
          <div class="links">
            <ul>
              <li><a href="{{ url('/') }}">Home</a></li>
              <li><a href="#">Pricing</a></li>
              <li><a href="#">Features</a></li>
              <li><a href="{{ route('contact.form') }}">Contact</a></li>
            </ul>
          </div>

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

                <a href="{{ route('profile.show') }}" class="dropdown-item">
                  Profile Setting
                </a>

                <a href="{{ route(name: 'plan-detail') }}" class="dropdown-item">
                  Account Preferences
                </a>

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

            <div class="button" style="display:flex; align-items:center; gap:12px;">
              <a href="{{ route('login') }}" class="login">Login</a>
              <a href="{{ route('register') }}" class="signup">Sign Up</a>
            </div>
            @endif
          </div>
        </div>
    </header>

  </div>


  <!-- Mobile Drawer -->
  <div id="mobile-drawer" class="mobile-drawer" aria-hidden="true">
    <div class="drawer-header container">
      <div class="logo">
        <img src="images/coinflow_logo.png" alt="" />
      </div>
    </div>
    <nav class="drawer-nav">
      <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Pricing</a></li>
        <li><a href="#">Features</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
      <div class="drawer-actions">
        <a href="#" class="login">Login</a>
        <a href="#" class="signup">Sign Up</a>
      </div>
    </nav>
  </div>
  <div class="drawer-backdrop" hidden></div>
  </div>
  <style>
    .user-dropdown {
      position: relative;
      display: inline-block;
    }

    .user-name {

      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: background 0.2s ease;
    }

    .user-name:hover {
      background: #f5f5f5;
    }

    .user-name i {
      font-size: 16px;
      color: #555;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      top: 110%;
      right: 0;
      background: white;
      min-width: 150px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      z-index: 100;
    }

    .dropdown-menu.active {
      display: block;
    }

    .dropdown-menu button {
      width: 100%;
      border: none;
      background: transparent;
      padding: 10px;
      text-align: left;
      cursor: pointer;
      font-size: 14px;
      border-radius: 6px;
    }

    .dropdown-menu button:hover {
      background-color: #f3f3f3;
    }


    .btn-download {
      background: #1d9bf0;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 8px 18px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.2s;
    }

    .btn-download:hover {
      background: #0a84d0;
    }

    .user-dropdown {
      position: relative;
    }

    .user-name {
      display: flex;
      align-items: center;
      cursor: pointer;
      font-weight: 600;
    }

    .user-name .avatar {
      width: 32px;
      height: 32px;
      border-radius: 50%;
      margin-right: 8px;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      top: 45px;
      right: 0;
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
      padding: 8px 0;
    }

    .user-dropdown:hover .dropdown-menu {
      display: block;
    }

    .dropdown-menu button {
      background: none;
      border: none;
      width: 100%;
      text-align: left;
      padding: 8px 20px;
      cursor: pointer;
    }

    .dropdown-menu button:hover {
      background: #f3f4f6;
    }
  </style>

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