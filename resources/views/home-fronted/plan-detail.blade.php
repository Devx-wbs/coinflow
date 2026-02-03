@include('home-fronted.include.header')

@if(session('success'))
<div id="alert-message" class="alert alert-success custom-alert">
  {{ session('success') }}
</div>
@endif

@if(session('error'))
<div id="alert-message" class="alert alert-danger custom-alert">
  {{ session('error') }}
</div>
@endif

<style>
  body {
    background: #f6f7fb;
    font-family: 'Poppins', Arial, sans-serif;
  }

  /* MAIN CONTAINER SIDE-BY-SIDE */
  .main-container {
    max-width: 1200px;
    margin: 36px auto;
    display: flex;
    gap: 24px;
    align-items: flex-start;
    flex-wrap: wrap;
    /* Keeps it responsive */
  }

  .card-box {
    flex: 1 1 48%;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.09);
    padding: 34px 36px;
    margin-bottom: 34px;
  }

  .plan-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 11px;
    letter-spacing: 1px;
  }

  .plan-details,
  .info-label {
    margin-bottom: 8px;
  }

  .badge-active {
    background: #38d993;
    color: #fff;
    padding: 5px 18px;
    border-radius: 12px;
    font-size: 14px;
  }

  .license-row {
    display: flex;
    gap: 10px;
    align-items: center;
    margin: 18px 0 16px 0;
  }

  .copy-btn,
  .download-btn {
    border-radius: 7px;
    font-size: 14px;
    margin-right: 7px;
    padding: 7px 14px;
  }

  .copy-btn {
    background: #6366f1;
    color: #fff;
    border: none;
    transition: background 0.2s;
  }

  .copy-btn:hover {
    background: #4338ca;
  }

  .download-btn {
    background: #0ea5e9;
    color: #fff;
    border: none;
    transition: background 0.2s;
  }

  .download-btn:hover {
    background: #0369a1;
  }

  .cancel-btn {
    background: #ef4444;
    color: #fff;
    border-radius: 7px;
    border: none;
    padding: 9px 22px;
    margin-top: 11px;
    font-size: 16px;
    font-weight: 600;
    transition: background 0.2s;
  }

  .cancel-btn:hover {
    background: #dc2626;
  }

  .order-section {
    padding-top: 17px;
  }

  .order-card {
    background: #f3f5fa;
    border-radius: 13px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.035);
    margin-bottom: 26px;
    padding: 17px 28px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
  }

  .order-info {
    display: flex;
    flex-direction: column;
    gap: 7px;
  }

  .order-pro {
    color: #f59e42;
    font-size: 16px;
    font-weight: 500;
  }

  .order-free {
    color: #06b6d4;
    font-size: 16px;
    font-weight: 500;
  }

  .order-paid {
    font-weight: bold;
    color: #0e7490;
  }

  .order-status {
    font-size: 15px;
    margin-left: 8px;
  }

  .text-warning {
    color: #f59e42;
    font-weight: 700;
  }

  .status-active {
    color: #22c55e;
    font-weight: 700;
  }

  .custom-alert {
    font-weight: bold;
    border-radius: 11px;
    margin-bottom: 24px;
  }

  @media (max-width: 900px) {
    .main-container {
      flex-direction: column;
      padding: 0 10px;
    }

    .card-box {
      flex: 1 1 100%;
    }

    .order-card {
      padding: 12px 8px;
    }
  }
</style>

<div class="main-container">

  <!-- My Plan Details -->
  <div class="card-box">
    <div class="plan-title">My Plan Details</div>
    @if($subscription)
    <div class="plan-details">
      <strong class="info-label">Current Plan:</strong> {{ $subscription->plan->name ?? 'N/A' }}
      <span class="badge-active">{{ ucfirst($subscription->status) }}</span>
    </div>
    <div class="plan-details">
      <strong class="info-label">Valid till:</strong> {{ $subscription->end_date }}
    </div>
    @if($license)
    <div class="license-row">
      <input type="text" id="licenseKey" class="form-control" value="{{ $license->license_key ?? 'No Active License' }}" readonly style="max-width:205px;">
      <button type="button" class="copy-btn" onclick="copyLicenseKey()">Copy</button>
      @if(isset($latestPlugin))
      <a href="{{ route('update-tracker.download', $latestPlugin->id) }}?license_key={{ $license->license_key }}"
        class="download-btn">
        Download Latest Plugin Zip
      </a>
      @endif


    </div>
    <script>
      function copyLicenseKey() {
        const input = document.getElementById("licenseKey");
        input.select();
        input.setSelectionRange(0, 99999);
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
    <form action="#" method="POST">
      @csrf
      <button type="submit" class="cancel-btn">Cancel Plan</button>
    </form>
    @else
    <p>No active plan found. <a href="{{ url('/') }}">Buy a plan</a></p>
    @endif
  </div>

  <!-- Order History -->
  <div class="card-box order-section">
    <div class="plan-title">Order History</div>
    @forelse($orders as $order)
    <div class="order-card">
      <div class="order-info">
        <span><strong>Order ID:</strong> #{{ $order->id }}</span>
        <span><strong>Date:</strong> {{ $order->purchase_date }}</span>
        @php
        $plan = is_string($order->plan) ? json_decode($order->plan, true) : $order->plan;
        @endphp
        <span><strong>Plan:</strong> {{ $plan['name'] ?? 'N/A' }}</span>
        <span><strong>Description:</strong> {{ $plan['description'] ?? 'N/A' }}</span>
        <span><strong>Price:</strong> ${{ $plan['price'] ?? '0.00' }}</span>
        <span><strong>Duration:</strong>
          {{ $plan['duration'] ?? '-' }} {{ ucfirst($plan['duration_type'] ?? '') }}
        </span>
        <span><strong>License Type:</strong> {{ $plan['license_type'] ?? 'N/A' }}</span>
      </div>
      <div class="order-info">
        <span class="order-paid">${{ number_format($order->total_amount, 2) }}</span>
        <span>
          @if($order->payment_status == 'Pending')
          <span class="text-warning">Pending</span>
          @else
          <span class="status-active">Completed</span>
          @endif
        </span>
        <span><strong>Renewal:</strong> {{ $order->next_renewal_date }}</span>
      </div>
    </div>
    @empty
    <p>No order found.</p>
    @endforelse
  </div>

</div>

@include('home-fronted.include.footer')