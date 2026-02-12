@extends('layouts.frontend')

@section('title','My Subscription')

@section('content')

<section class="account-section">

  <div class="account-wrapper">

    {{-- Success Message --}}
    @if(session('success'))
    <div class="success-banner">
      ✔ {{ session('success') }}
    </div>
    @endif

    <div class="account-grid">

      <!-- LEFT CARD -->
      <div class="account-card">
        <h3>My Plan Details</h3>

        <div class="info-row">
          <span>Current Plan</span>
          <strong>{{ $subscription->plan->name }}</strong>
          <span class="status-badge">Active</span>
        </div>

        <div class="info-row">
          <span>Valid till</span>
          <strong>{{ \Carbon\Carbon::parse($subscription->end_date)->format('F d, Y') }}</strong>
        </div>

        @if($license)
        <div class="license-box">
          <label>License Key</label>
          <div class="license-input">
            <input type="text" value="{{ $license->license_key }}" readonly>
            <button onclick="copyLicense()">📋</button>
          </div>
        </div>

        <button class="primary-btn">
          Copy License Key
        </button>

        @if(isset($latestPlugin))
        <a href="{{ route('update-tracker.download', $latestPlugin->id) }}?license_key={{ $license->license_key }}"
          class="secondary-btn">
          Download Plugin
        </a>
        @endif
        @endif

        
      </div>

      <!-- RIGHT CARD -->
      <div class="account-card">
        <h3>Order History</h3>

        @foreach($orders as $order)
        <div class="order-row">
          <div>
            <strong>Order ID</strong>
            <p>#{{ $order->id }}</p>

            <strong>Date</strong>
            <p>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}</p>

            <strong>Plan</strong>
            <p>{{ $order->plan->name ?? 'N/A' }}</p>

            <strong>Price</strong>
            <p>${{ number_format($order->total_amount, 2) }}</p>

            <strong>Duration</strong>
            <p> {{ $subscription->plan['duration'] ?? '-' }} {{ ucfirst($subscription->plan['duration_type'] ?? '') }}</p>

            <strong>License Type</strong>
            <p>{{ $subscription->plan['license_type'] ?? 'N/A' }}</p>

            <strong>Payment Status</strong>

            <span>
              @if($order->payment_status == 'Pending')
              <p>Pending</p>
              @else
              <p>Completed</p>
              @endif
            </span>
          </div>

          <div class="order-status">
            <span class="completed">Completed</span>
          </div>
        </div>
        @endforeach

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
  .account-section {
    padding: 120px 0;
    background: linear-gradient(180deg, #eef4ff 0%, #f7faff 100%);
  }

  .account-wrapper {
    max-width: 1200px;
    margin: auto;
    background: #f2f6ff;
    padding: 60px;
    border-radius: 30px;
  }

  .account-grid {
    display: flex;
    gap: 40px;
  }

  .account-card {
    flex: 1;
    background: #fff;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(20, 148, 255, 0.08);
  }

  .account-card h3 {
    margin-bottom: 25px;
    font-size: 20px;
    font-weight: 600;
  }

  .info-row {
    margin-bottom: 20px;
  }

  .status-badge {
    background: #22c55e;
    color: #fff;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    margin-left: 10px;
  }

  .license-box {
    margin: 20px 0;
  }

  .license-input {
    display: flex;
    align-items: center;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
  }

  .license-input input {
    flex: 1;
    border: none;
    padding: 10px;
    outline: none;
  }

  .license-input button {
    border: none;
    background: transparent;
    padding: 0 10px;
    cursor: pointer;
  }

  .primary-btn {
    width: 100%;
    background: #1494FF;
    color: #fff;
    border: none;
    height: 45px;
    border-radius: 8px;
    margin-bottom: 10px;
    cursor: pointer;
  }

  .secondary-btn {
    display: block;
    text-align: center;
    background: #e5e7eb;
    padding: 12px;
    border-radius: 8px;
    text-decoration: none;
    color: #333;
  }

  .success-banner {
    background: #d1fae5;
    padding: 12px 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    color: #065f46;
    font-weight: 500;
  }

  .order-row {
    display: flex;
    justify-content: space-between;
    border-top: 1px solid #eee;
    padding-top: 15px;
    margin-top: 15px;
  }

  .completed {
    background: #dcfce7;
    padding: 5px 12px;
    border-radius: 10px;
    font-size: 12px;
    color: #15803d;
  }

  /* Responsive */
  @media (max-width: 992px) {
    .account-grid {
      flex-direction: column;
    }

    .account-wrapper {
      padding: 30px;
    }
  }
</style>