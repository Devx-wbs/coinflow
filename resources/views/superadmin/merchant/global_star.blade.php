@extends('layouts.user_type.auth')

@section('content')
  
  <div class="row">
    
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Transactions</p>
                <h5 class="font-weight-bolder mb-0">
                  266
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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Total Earnings</p>
                <h5 class="font-weight-bolder mb-0">
                  265
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
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Active Stores</p>
                <h5 class="font-weight-bolder mb-0">
                  265
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
                <p class="text-sm mb-0 text-capitalize font-weight-bold">Avg Transaction Value</p>
                <h5 class="font-weight-bolder mb-0">
                  265
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
  </div>
  
  <div class="row mt-2">
    <!-- Line Chart -->
    <div class="col-lg-12">
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

    
</div>
 
@endsection
@push('dashboard')
 
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctxLine = document.getElementById('lineChart').getContext('2d');

new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        datasets: [
            {
                label: 'Transaction',
                data: [1100,1200,1650,1700,1400,1600,1350,1800,2000,1700,1300,900],
                borderColor: '#10b981', // green
                backgroundColor: 'rgba(16,185,129,0.1)',
                fill: true,
                tension: 0.4
            },
            {
                label: 'Earnings($)',
                data: [500,600,850,1200,1500,1100,950,1250,1400,1200,800,200],
                borderColor: '#facc15', // yellow
                backgroundColor: 'rgba(250,204,21,0.1)',
                fill: true,
                tension: 0.4
            },
            {
                label: 'Active Store',
                data: [100,150,120,90,130,100,80,140,160,110,90,60],
                borderColor: '#ef4444', // red
                backgroundColor: 'rgba(239,68,68,0.1)',
                fill: true,
                tension: 0.4
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { position: 'bottom' } 
        },
        scales: { 
            y: { 
                beginAtZero: false,
                ticks: {
                    stepSize: 550  
                },
                grid: {
                    display: true,   
                    drawBorder: true 
                }
            },
            x: {
                grid: {
                    display: false,  
                    drawBorder: true 
                }
            }
        }
    }
});
</script>

@endpush

