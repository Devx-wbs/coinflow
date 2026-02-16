@extends('layouts.frontend')

@section('title','My Subscription')

@section('content')

<section class="account-section">
  <div class="account-bg-wrapper">

    <div class=" account-content-container">

      {{-- Success Message --}}
      @if(session('success'))
      <div class="success-banner">
        ✔ {{ session('success') }}
      </div>
      @endif

      <div class="dashboard-grid">

        <!-- LEFT CARD -->
        <div class="card plan-card">
          <h2 class="card-title">My Plan Details</h2>

          <!-- Current Plan Row -->
          <div class="plan-row" style="border:none; padding-bottom:0;">
            <div>
              <div class="plan-info-label">Current Plan</div>
              <div class="plan-name">{{ $subscription->plan->name }}</div>
            </div>
            <span class="active-badge">Active</span>
          </div>

          <!-- Valid Till Row -->
          <div style="margin-top: -10px;">
            <div class="plan-info-label">Valid Till</div>
            <div class="valid-till">{{ \Carbon\Carbon::parse($subscription->end_date)->format('F d, Y') }}</div>
          </div>

          <!-- Divider (Visual fix for spacing) -->
          <div style="height: 1px; background: #F2F4F7; width: 100%; margin: 8px 0;"></div>

          @php
    $key = $license->license_key;
    $masked = substr($key, 0, 5) . str_repeat('*', strlen($key) - 9) . substr($key, -4);
@endphp
          <!-- License Key Section -->
          @if($license)
            <div class="plan-info-label" style="margin-bottom: 8px;">License Key</div>
            <div class="license-input-wrapper license-input">
              <input type="text" class="license-input" value="{{$masked}}" readonly>
              <div class="copy-icon-btn" onclick="copyLicense()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M20 9H11C9.89543 9 9 9.89543 9 11V20C9 21.1046 9.89543 22 11 22H20C21.1046 22 22 21.1046 22 20V11C22 9.89543 21.1046 9 20 9Z"
                    stroke="#667085" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                  <path
                    d="M5 15H4C3.46957 15 2.96086 14.7893 2.58579 14.4142C2.21071 14.0391 2 13.5304 2 13V4C2 3.46957 2.21071 2.96086 2.58579 2.58579C2.96086 2.21071 3.46957 2 4 2H13C13.5304 2 14.0391 2.21071 14.4142 2.58579C14.7893 2.96086 15 3.46957 15 4V5"
                    stroke="#667085" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
                </svg>
              </div>
            </div>

          <!-- Buttons -->
          <div>
            <button class="btn-primary" onclick="copyLicense()">Copy License key</button>
            @if(isset($latestPlugin))
            <a href="{{ route('update-tracker.download', $latestPlugin->id) }}?license_key={{ $license->license_key }}"
              class="btn-secondary">
              Download Plugin
            </a>
            @endif
            @endif
          </div>

          <!-- Place holder for bottom link if needed, screenshot says 'Current Plan' in red? Used as per visual -->
        </div>

        <!-- RIGHT CARD -->
        <div class="card history-card">
          <h2 class="card-title">Order History</h2>
          @foreach($orders as $order)
          <!-- Order ID -->
          <div class="order-id-row">
            <div>
              <div class="order-label">Order ID</div>
              <div class="order-id-val">#{{ $order->id }}</div>
            </div>
            <span class="completed-badge">Completed</span>
          </div>

          <!-- Date & Plan Grid -->
          <div class="history-grid-row">
            <div>
              <div class="history-item-label">Date</div>
              <div class="history-item-val">{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</div>
            </div>
            <div style="text-align: right;">
              <div class="history-item-label">Plan</div>
              <div class="history-item-val" style="text-align: right;">{{ $order->plan->name ?? 'N/A' }}</div>
              <!-- Aligning right to match visual potentially, or keep left -->
            </div>
          </div>

          <!-- Price Details -->
          <div class="price-list">
            <div class="price-row">
              <span class="price-label">Price</span>
              <span class="price-val">${{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="price-row">
              <span class="price-label">Duration</span>
              <span class="price-val">{{ $subscription->plan['duration'] ?? '-' }} {{ ucfirst($subscription->plan['duration_type'] ?? '') }}</span>
            </div>
            <div class="price-row">
              <span class="price-label">License Type</span>
              <span class="price-val">{{ $subscription->plan['license_type'] ?? 'N/A' }}</span>
            </div>
            <div class="price-row">
              <span class="price-label">Payment Status</span>
              <span class="status-completed-text">
                @if($order->payment_status == 'Pending')
                <p>Pending</p>
                @else
                <p>Completed</p>
                @endif
              </span>

            </div>
          </div>

          @endforeach
        </div>

      </div>

    </div>
  </div>

</section>

<script>
  function copyLicense() {
    const input = document.querySelector(".license-input input");
    navigator.clipboard.writeText(input.value);
    alert("License copied!");
  }
</script>

@endsection

<style>
  /* 1920px Background Wrapper */
  .account-bg-wrapper {
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
    min-height: 900px;
    position: relative;
    padding: 60px;
  }


  /* 1440px Content Container */
  .account-content-container {
    width: 100%;
    max-width: 1440px;
    display: flex;
    flex-direction: column;
    padding: 60px 80px;
    position: relative;
    z-index: 2;
  }

  /* Success Banner */
  .success-banner {
    background-color: #ECFDF3;
    border: 1px solid #A6F4C5;
    color: #027A48;
    padding: 16px 24px;
    border-radius: 8px;
    font-weight: 500;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 40px;
  }

  .success-banner svg {
    width: 24px;
    height: 24px;
    stroke-width: 2;
  }

  /* Dashboard Grid Layout (Two Columns) */
  .dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    /* align-items: flex-start;  <-- Removed to let grid items stretch */
  }

  /* Card Styles */
  .card {
    background: #ffffff;
    border-radius: 12px;
    padding: 32px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid #EAEAEA;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  /* Specific Card: My Plan Details */
  .plan-card {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  h2.card-title {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 8px;
    color: #191D23;
  }

  /* Plan Row */
  .plan-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #F2F4F7;
    padding-bottom: 16px;
  }

  .plan-info-label {
    font-size: 12px;
    color: #667085;
    margin-bottom: 4px;
    font-weight: 500;
  }

  .plan-name {
    font-size: 24px;
    font-weight: 600;
    color: #101828;
  }

  .active-badge {
    background: #ECFDF3;
    color: #027A48;
    padding: 4px 12px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 600;
  }

  .valid-till {
    font-size: 16px;
    font-weight: 500;
    color: #101828;
  }

  /* License Key Input */
  .license-group {
    position: relative;
  }

  .license-input-wrapper {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .license-input {
    flex: 1;
    height: 48px;
    background: #F9FAFB;
    border: 1px solid #EAECF0;
    border-radius: 8px;
    padding: 0 16px;
    font-family: 'Poppins', sans-serif;
    color: #667085;
    font-size: 14px;
    outline: none;
  }

  .copy-icon-btn {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    border: 1px solid #EAECF0;
    border-radius: 8px;
    background: #fff;
    transition: all 0.2s;
  }

  .copy-icon-btn:hover {
    background-color: #F9FAFB;
  }

  /* Action Buttons */
  .btn-primary {
    width: 100%;
    height: 48px;
    background: #1494FF;
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
  }

  .btn-primary:hover {
    background: #0077E5;
  }

  .btn-secondary {
    width: 100%;
    height: 48px;
    background: #F2F4F7;
    color: #344054;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
    margin-top: 12px;
  }

  .btn-secondary:hover {
    background: #EAECF0;
  }

  .cancel-plan-link {
    color: #D92D20;
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
    margin-top: 16px;
    display: inline-block;
  }

  .cancel-plan-link:hover {
    text-decoration: underline;
  }


  /* Order History Card */
  .history-card {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  .order-id-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #F2F4F7;
    padding-bottom: 16px;
  }

  .order-label {
    font-size: 12px;
    color: #667085;
    margin-bottom: 4px;
  }

  .order-id-val {
    font-size: 16px;
    font-weight: 600;
    color: #101828;
  }

  .completed-badge {
    background: #ECFDF3;
    color: #027A48;
    padding: 4px 12px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 600;
  }

  /* Info Grid for History */
  .history-grid-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    /* Two columns for Date/Plan */
    gap: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid #F2F4F7;
  }

  .history-item-label {
    font-size: 12px;
    color: #667085;
    margin-bottom: 4px;
  }

  .history-item-val {
    font-size: 14px;
    font-weight: 500;
    color: #101828;
  }

  /* Price Breakdown List */
  .price-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding-bottom: 16px;
    border-bottom: 1px solid #F2F4F7;
  }

  .price-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
  }

  .price-label {
    color: #344054;
  }

  .price-val {
    font-weight: 600;
    color: #101828;
  }

  .status-completed-text {
    color: #027A48;
    font-weight: 600;
    font-size: 12px;
  }

  .view-all-link {
    color: #1494FF;
    font-size: 12px;
    text-decoration: none;
    font-weight: 500;
    margin-top: 8px;
    display: inline-block;
  }

  .view-all-link:hover {
    text-decoration: underline;
  }


  /* Responsive */
  @media (max-width: 992px) {
    .dashboard-grid {
      grid-template-columns: 1fr;
      /* Stack cards */
    }

    .account-content-container {
      padding: 40px;
    }

    .account-bg-wrapper {
      min-height: auto;
      height: auto;
      padding-bottom: 60px;
    }
  }

  @media (max-width: 768px) {
    .account-content-container {
      padding: 24px;
    }

    .success-banner {
      font-size: 14px;
      padding: 12px 16px;
    }
  }
</style>