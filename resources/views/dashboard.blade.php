@extends('layouts.user_type.auth')

@section('content')

<div class="row">
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Earnings</p>
              <h5 class="font-weight-bolder mb-0">
                ${{ number_format($totalAmount, 2) }}
                <p class="text-success text-sm font-weight-bolder">+12 From last month</p>
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
              <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-capitalize font-weight-bold">Today’s Transactions</p>
              <h5 class="font-weight-bolder mb-0">
                {{ $todayTransactions}}
                <p class="text-success text-sm font-weight-bolder">+12 From last month</p>
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
              <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Stores</p>
              <h5 class="font-weight-bolder mb-0">
                {{ $stores->count() }}
                <p class="text-success text-sm font-weight-bolder">+12 From last month</p>
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
              <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
    <div class="card">
      <div class="card-body p-3">
        <div class="row">
          <div class="col-8">
            <div class="numbers">
              <p class="text-sm mb-0 text-capitalize font-weight-bold">Active Licenses</p>
              <h5 class="font-weight-bolder mb-0">
                {{ $licenses->where('status', 'active')->count() }}
                <p class="text-success text-sm font-weight-bolder">+12 From last month</p>
              </h5>
            </div>
          </div>
          <div class="col-4 text-end">
            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
              <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



</div>

<div class="row mt-2">
  <!-- Line Chart -->
  <div class="col-lg-6">
    <div class="card z-index-2">
      <div class="card-header pb-0">
        <h6>Transaction Volume & Earnings</h6>
        <p class="text-sm">
          <i class="fa fa-arrow-up text-success"></i>
          <span class="font-weight-bold">Daily transaction count and revenue</span>
        </p>
      </div>
      <div class="card-body">
        <div class="chart-container" style="height:300px;">
          <canvas id="lineChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Donut Chart -->
  <div class="col-lg-6">
    <div class="card z-index-2">
      <div class="card-header pb-0">
        <h6>Plan Distribution</h6>
        <p class="text-sm">Current distribution of subscription plans across stores</p>
      </div>
      <div class="card-body">
        <div class="d-flex justify-content-center align-items-center" style="height:300px;">
          <canvas id="donutChart"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
@if(Auth::check() && Auth::user()->role == 1)
<div class="card mt-4" style="border-radius:14px; background:#fff; border:none;box-shadow:0 4px 24px rgba(0,0,0,0.03);">
  <div class="card-body px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <span style="font-size:20px;font-weight:600;color:#23272e;">Recent Stores</span>
      <a href="{{ route('subscribe-store') }}" style="background:#f8fafc;color:#23272e;border:1px solid #f0f1f3;border-radius:8px;font-size:15px;padding:7px 18px;font-weight:500;text-decoration:none;">
        View all Stores <span style="font-size:17px;">&#8599;</span>
      </a>
    </div>

    <div>
      @php $count = 0; @endphp

      @forelse($stores->take(10) as $license)
      @php
      $count++;
      $activation = $license->activations->sortByDesc('activated_at')->first();
      $isVisible = $count <= 4 ? '' : 'hidden-store' ;

        $active=strtolower($license->status) == 'active';
        $color = $active ? '#45a97e' : '#e94560';
        $badgeBg = $active ? '#e9f7ef' : '#fde4ea';
        $badgeColor = $active ? '#45a97e' : '#e94560';
        @endphp

        <div class="store-item {{ $isVisible }} d-flex align-items-center justify-content-between mb-3 rounded" style="background:#fafbfc;padding:16px 12px;">
          <div class="d-flex align-items-center" style="min-width:250px;">
            <span style="height:12px;width:12px;background:{{ $color }};border-radius:50%;margin-right:15px;"></span>
            <div>
              <div style="font-size:15px;font-weight:600;color:#222;">
                {{ $license->user->store_name ?? 'N/A' }}
              </div>
              <div style="font-size:13px;color:#8b949e;">
                {{ $activation->store_url ?? 'N/A' }}
              </div>
            </div>
          </div>

          <div class="text-center" style="width:120px;">
            <span class="badge" style="background:{{ $badgeBg }};color:{{ $badgeColor }};font-size:13px;padding:4px 16px;border-radius:7px;">
              {{ ucfirst($license->status) }}
            </span>
          </div>

          <div class="text-end" style="min-width:120px;">
            <span style="font-size:13px;color:#91939a;">
              {{ $activation && $activation->activated_at ? \Carbon\Carbon::parse($activation->activated_at)->format('M d, Y') : 'N/A' }}
            </span>
          </div>
        </div>
        @empty
        <p class="text-center text-muted mb-0">No recent stores found.</p>
        @endforelse

    </div>
  </div>
</div>
@endif

@endsection
@push('dashboard')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('lineChart').getContext('2d');
  const chartData = @json($chartData);

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: chartData.labels,
      datasets: [
        // 🟡 Earnings (LEFT axis)
        {
          label: 'Earnings ($)',
          data: chartData.earnings,
          yAxisID: 'yEarnings',
          borderColor: '#facc15',
          backgroundColor: 'rgba(250,204,21,0.2)',
          borderWidth: 3,
          fill: false,
          tension: 0.4,
          pointRadius: 5
        },

        // 🟢 Transactions (RIGHT axis)
        {
          label: 'Transactions',
          data: chartData.transactions,
          yAxisID: 'yTransactions',
          borderColor: '#22c55e',
          backgroundColor: '#22c55e',
          borderWidth: 3,
          fill: false,
          tension: 0.4,
          pointRadius: 6
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: {
        mode: 'index',
        intersect: false
      },
      plugins: {
        legend: {
          position: 'bottom'
        }
      },
      scales: {
        // 💰 LEFT Y-AXIS → Earnings
        yEarnings: {
          position: 'left',
          beginAtZero: true,
          min: 0,
          max: 2000,
          ticks: {
            stepSize: 200,
            callback: value => `$${value}`
          },
          title: {
            display: true,
            text: 'Earnings ($)'
          }
        },

        // 🔢 RIGHT Y-AXIS → Transactions
        yTransactions: {
          position: 'right',
          beginAtZero: true,
          min: 0,
          max: 20,
          ticks: {
            stepSize: 2,
            precision: 0
          },
          title: {
            display: true,
            text: 'Transactions'
          },
          grid: {
            drawOnChartArea: false
          }
        },

        x: {
          grid: {
            display: false
          }
        }
      }
    }
  });

  // Donut Chart
  const ctxDonut = document.getElementById('donutChart').getContext('2d');
  new Chart(ctxDonut, {
    type: 'doughnut',
    data: {
      labels: ['Free', 'Agency', 'Pro'],
      datasets: [{
        data: [58, 23, 33],
        backgroundColor: ['#fca5a5', '#f59e0b', '#3b82f6'],
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'bottom'
        },
        tooltip: {
          callbacks: {
            label: (context) => `${context.label}: ${context.parsed}%`
          }
        }
      },
      cutout: '70%'
    }
  });
</script>



@endpush
<style>
  .hidden-store {
    display: none;
  }
</style>