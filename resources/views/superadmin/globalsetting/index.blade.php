@extends('layouts.user_type.auth')
@section('content')

    {{-- Static Laravel Session Alerts --}}
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

    {{-- Placeholder for AJAX Alerts --}}
    

    <div class="container-fluid py-4">
        <div id="ajax-alert-container"></div>
        
        
        <!-- API Key Settings -->
        <div class="card mb-4 px-3 py-4">
            <div class="mb-4">
                <span class="h5"><i class="fas fa-key me-2"></i>API Key Settings</span>
            </div>
            <form id="apiKeyForm" onsubmit="return false;">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label mb-1 fw-bold">NOWPayments API Key</label>
                        <input id="apiKeyInput" type="text" class="form-control" value="{{ $apiKey ?? '' }}">
                    </div>
                </div>
                <button id="saveApiKeyBtn" class="btn btn-primary" type="button">Update API Key</button>
            </form>
        </div>


        <!-- Logs & Error Tracking -->
<div class="card mb-4 px-3 py-4">
    <div class="mb-4">
        <span class="h5">
            <i class="fas fa-bug me-2"></i>Logs and Errors
        </span>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <label class="fw-bold">Enable Error Logging System</label>

        

        <div class="form-check form-switch">
            
            <input class="form-check-input bg-success border-success"
                   type="checkbox"
                   id="logToggleSwitch"
                   {{ ($logStatus == 1) ? 'checked' : '' }}>
        </div>
        
    </div>

    <small class="text-muted mt-2">
        If enabled, system errors will be saved in database and shown in admin dashboard.
    </small>
</div>

        
      

        <!-- Supported Cryptocurrencies -->
        <div class="card px-3 py-4">
            <div class="mb-4">
                <span class="h5"><i class="fas fa-coins me-2"></i>Supported Cryptocurrencies</span>
            </div>
            <form class="mb-3 row g-2" onsubmit="return false;">
                <div class="col-10">
                    <select id="coinsDropdown" class="form-select" name="coin">
                        <option selected>Select cryptocurrency to add</option>
                        @if(!empty($coins['selectedCurrencies']))
                            @foreach($coins['selectedCurrencies'] as $coinSymbol)
                                <option value="{{ $coinSymbol }}">{{ $coinSymbol }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-2">
                    <button onclick="addCoin()" class="btn btn-primary w-100" type="button">Add</button>
                </div>
            </form>
            <div id="supportedCoins" style="margin-left:1px;">
                <span class="fw-bold">Currently Supported :</span>
                <div id="coinsList" class="mt-2 d-flex flex-wrap gap-2"></div>
            </div>
            <button onclick="saveCoins()" class="btn btn-primary mt-4" type="button">Save Cryptocurrencies</button>
        </div>

    </div>

    <script>
        // ---------- ALERT HANDLER ----------
        function showAlert(type, message) {
            const container = document.getElementById('ajax-alert-container');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} text-white font-weight-bold px-4 py-3 mb-4 rounded`;
            alert.textContent = message;
            container.innerHTML = ''; // clear any existing alerts
            container.appendChild(alert);

            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }, 4000);
        }

      
       

        // ---------- CRYPTOCURRENCY HANDLER ----------
       let supportedCoins = new Set();

    // Initialize supportedCoins with savedCoins from backend if available
    @if(!empty($savedCoins))
        let savedCoinsArray = @json(json_decode($savedCoins));
        savedCoinsArray.forEach(coin => {
            supportedCoins.add(coin);
        });
    @endif

    function addCoin() {
        const dropdown = document.getElementById('coinsDropdown');
        const selectedCoin = dropdown.value;

        if (selectedCoin && !supportedCoins.has(selectedCoin) && selectedCoin !== 'Select cryptocurrency to add') {
            supportedCoins.add(selectedCoin);
            renderCoins();
        }
    }

    function removeCoin(coin) {
        supportedCoins.delete(coin);
        renderCoins();
    }

    function renderCoins() {
        const coinsList = document.getElementById('coinsList');
        coinsList.innerHTML = '';
        supportedCoins.forEach(coin => {
            const span = document.createElement('span');
            span.classList.add('me-3');
            span.innerHTML = `
                <span class="fw-bold">${getCoinSymbolIcon(coin)}</span> ${coin}
                <span onclick="removeCoin('${coin}')" class="text-danger ms-1" style="cursor:pointer;">&times;</span>
            `;
            coinsList.appendChild(span);
        });
    }

    function getCoinSymbolIcon(coin) {
        const map = { 'BTC': '₿', 'ETH': 'Ξ', 'USDT': '₮' };
        return map[coin] || coin.charAt(0).toUpperCase();
    }

    function saveCoins() {
        const coinsArray = Array.from(supportedCoins);
        if (coinsArray.length === 0) {
            showAlert('danger', 'Please select at least one coin.');
            return;
        }

        fetch('{{ route('save-coins') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ coins: coinsArray })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) showAlert('success', data.message);
            else showAlert('danger', 'Error saving coins');
        })
        .catch(() => showAlert('danger', 'Something went wrong while saving coins.'));
    }

    // Render coins on page load
    document.addEventListener('DOMContentLoaded', function () {
        renderCoins();
    });
    
    
    
    // ---------- API KEY HANDLER ----------
    document.getElementById('saveApiKeyBtn').addEventListener('click', () => {
        const apiKey = document.getElementById('apiKeyInput').value.trim();
        alert(apiKey);
        if (!apiKey) {
            showAlert('danger', 'API key cannot be empty.');
            return;
        }
    
        fetch('{{ route('update-api-key') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ api_key: apiKey })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) showAlert('success', data.message);
            else showAlert('danger', data.message || 'Error updating API key');
        })
        .catch(() => showAlert('danger', 'Something went wrong while updating API key.'));
    });


    // ---------- LOG TOGGLE HANDLER ----------
document.getElementById('logToggleSwitch').addEventListener('change', function () {

    let status = this.checked ? 1 : 0;

    fetch('{{ route("save-log-toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            log_status: status
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
        } else {
            showAlert('danger', 'Error updating log system');
        }
    })
    .catch(() => showAlert('danger', 'Something went wrong while saving toggle.'));
});



    </script>
@endsection

