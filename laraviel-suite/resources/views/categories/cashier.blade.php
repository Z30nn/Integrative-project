<?php use App\Models\AvailedService; use App\Models\IncomeTracker; use App\Models\Service; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Dashboard | Laraviel Suites</title>
    <!-- Core Admin Layout -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    
    <!-- External Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Kanit:wght@300;400;500;600&family=Karla:wght@300;400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
      /* ── Luxury Cashier Terminal: Premium Stabilization Fixes ── */
      :root {
        --glass-bg: rgba(32, 22, 14, 0.9); /* Deepest Luxury Brown Background */
        --glass-border: rgba(191, 167, 93, 0.35);
        --brand-gold: #BFA75D;
        --brand-cream: #FEF3E2;
        --bg-deep: #160e08;
      }

      body {
        background-color: var(--bg-deep) !important;
        color: var(--brand-cream) !important;
        overflow-x: hidden;
      }

      /* Content Container Layout */
      .content {
        margin-left: 260px !important;
        padding: 40px !important;
        background-color: var(--bg-deep) !important;
        min-height: 100vh;
        width: calc(100% - 260px) !important;
      }

      /* UNIFIED CARD DESIGN (REMOVING WHITE BACKGROUNDS) */
      .card.stat-card, .card {
        background: var(--glass-bg) !important;
        backdrop-filter: blur(20px) !important;
        border: 1px solid var(--glass-border) !important;
        border-radius: 15px !important;
        padding: 24px !important;
        box-shadow: 0 10px 40px rgba(0,0,0,0.6) !important;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        color: var(--brand-cream) !important;
      }

      .card.stat-card:hover {
        transform: translateY(-8px);
        border-color: var(--brand-gold) !important;
        box-shadow: 0 15px 50px rgba(191, 167, 93, 0.15) !important;
      }

      .card.stat-card h3 {
        color: var(--brand-gold) !important;
        font-family: 'Kanit', sans-serif !important;
        font-size: 0.85rem !important;
        text-transform: uppercase;
        letter-spacing: 2px;
        opacity: 0.9;
        margin-bottom: 12px;
      }

      .card.stat-card p {
        font-family: 'Aboreto', cursive;
        font-size: 2.3rem !important;
        font-weight: 700;
        margin: 0;
        color: var(--brand-cream) !important;
      }

      .card.stat-card.highlight {
        background: linear-gradient(145deg, rgba(191, 167, 93, 0.12), rgba(32, 22, 14, 0.95)) !important;
        border-bottom: 4px solid var(--brand-gold) !important;
      }

      /* SECTION & CHART HEADERS (MAX CONTRAST) */
      .section-title, .chart-title {
        color: var(--brand-cream) !important;
        font-family: 'Aboreto', cursive !important;
        letter-spacing: 3px;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 2rem !important;
        text-shadow: 0 2px 4px rgba(0,0,0,0.8);
        opacity: 1 !important;
      }

      .chart-container {
        background: var(--glass-bg) !important;
        border: 1px solid var(--glass-border) !important;
        padding: 35px !important;
        border-radius: 20px !important;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
      }

      /* SEARCH & FILTER AREA (HIGH VISIBILITY) */
      .filter-bar {
        background: rgba(30, 20, 12, 0.75) !important;
        border: 1px solid var(--glass-border) !important;
        padding: 24px !important;
        border-radius: 12px !important;
        backdrop-filter: blur(10px);
      }

      .luxury-input-group .input-group-text {
        background: rgba(191, 167, 93, 0.15) !important;
        border: 1px solid var(--brand-gold) !important;
        color: var(--brand-gold) !important;
      }

      .luxury-input-group .form-control {
        background: rgba(0, 0, 0, 0.5) !important;
        border: 1px solid var(--brand-gold) !important;
        color: var(--brand-cream) !important;
        padding: 12px 18px !important;
        font-size: 0.95rem;
      }

      .luxury-input-group .form-control::placeholder {
        color: rgba(254, 243, 226, 0.45);
      }

      .luxury-input-group .form-control:focus {
        background: rgba(0, 0, 0, 0.7) !important;
        box-shadow: 0 0 15px rgba(191, 167, 93, 0.4) !important;
        outline: none !important;
      }

      .filter-label {
        color: var(--brand-gold) !important;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
      }

      .form-check-label {
        color: var(--brand-cream) !important;
        font-size: 0.9rem;
        cursor: pointer;
        opacity: 0.9;
        margin-left: 8px;
        transition: color 0.2s ease;
      }

      .form-check-label:hover { color: var(--brand-gold) !important; }

      /* LOGOUT COMPONENT FIX (REMOVING PAGE EXPIRED) */
      .sidebar footer {
        padding: 25px;
        border-top: 1px solid var(--glass-border);
        background: rgba(0,0,0,0.3);
      }

      .btn-logout {
        color: #e74c3c !important;
        border: 1px solid rgba(231, 76, 60, 0.5) !important;
        border-radius: 8px !important;
        padding: 12px !important;
        transition: all 0.3s ease;
        text-decoration: none !important;
        font-family: 'Kanit', sans-serif !important;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
      }

      .btn-logout:hover {
        background: rgba(231, 76, 60, 0.1) !important;
        border-color: #e74c3c !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(231, 76, 60, 0.2);
      }

      /* CUSTOM TABLE REFINEMENT */
      .custom-table thead th {
        color: var(--brand-gold) !important;
        border-bottom: 2px solid var(--glass-border) !important;
        padding: 22px 10px !important;
        font-family: 'Aboreto', cursive;
        font-size: 0.75rem;
        letter-spacing: 1.5px;
        background: rgba(0,0,0,0.1);
      }

      .custom-table tbody tr {
        background: rgba(42, 29, 18, 0.2) !important;
        border-bottom: 1px solid rgba(191, 167, 93, 0.1) !important;
        transition: all 0.25s ease;
      }

      .custom-table tbody tr:hover {
        background: rgba(191, 167, 93, 0.08) !important;
        transform: translateX(4px);
      }

      /* NO RECORD STATE */
      .empty-state {
        padding: 60px !important;
        color: rgba(254, 243, 226, 0.3) !important;
        text-align: center;
        width: 100%;
      }

      /* PAGINATION DARK THEME */
      .pagination .page-link {
        background: rgba(30,20,12,0.8);
        border-color: var(--glass-border);
        color: var(--brand-gold);
      }
      .pagination .page-item.active .page-link {
        background: var(--brand-gold);
        border-color: var(--brand-gold);
        color: var(--bg-deep);
      }

      /* SIDEBAR STYLING */
      .sidebar .active {
        background: rgba(191,167,93,0.15) !important;
        border-left: 4px solid var(--brand-gold) !important;
        color: var(--brand-gold) !important;
      }

      @media (max-width: 991px) {
        .content { margin-left: 0 !important; width: 100% !important; padding: 20px !important; }
        .sidebar { transform: translateX(-100%); }
        .sidebar.active { transform: translateX(0); }
      }
    </style>
</head>
<body>

  <!-- Sidebar Recovery -->
  <div class="sidebar d-flex flex-column" id="mySidebar">
    <div>
      <div class="text-center py-5">
        <img src="{{ asset('images/logo.png') }}" alt="LARAVEIL Logo" style="width: 140px; filter: drop-shadow(0 0 15px rgba(191,167,93,0.25));">
      </div>
      <a href="{{ route('cashier') }}" class="{{ request()->routeIs('cashier') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2-fill me-3"></i>Dashboard
      </a>
      <a href="#transactions"><i class="bi bi-layers-half me-3"></i>Transactions</a>
      <a href="#income-tracker"><i class="bi bi-journal-text me-3"></i>Financial Logs</a>
    </div>

    <footer class="mt-auto">
      <p class="mb-3 text-muted small opacity-50" style="letter-spacing: 2px;">CASHIER TERMINAL PRO</p>
      <form method="POST" action="{{ route('logout') }}" id="logout-form">
        @csrf
        <button type="submit" class="btn-logout">
          <i class="bi bi-box-arrow-right me-2"></i> Terminate Session
        </button>
      </form>
      <div class="text-center mt-3 opacity-25 small" style="font-size: 10px;">V3.1 SECURE ACCESS ENABLED</div>
    </footer>
  </div>

  <!-- Content Recovery -->
  <div class="content">
    <header class="d-flex justify-content-between align-items-center mb-5">
      <div>
        <h1 class="section-title mb-1" style="font-size: 2.2rem; margin-bottom: 0px !important;">Financial Operations</h1>
        <p class="text-gold opacity-50 mt-1 mb-0" style="letter-spacing: 3px; font-size: 0.85rem; font-weight: 700;">SECURE REVENUE HUD ENABLED</p>
      </div>
      <div class="user-profile text-end p-3 rounded" style="background: rgba(0,0,0,0.4); border: 1px solid var(--glass-border); min-width: 200px;">
          <span class="text-gold fw-bold d-block" style="color: var(--brand-gold); font-family: 'Kanit';">{{ Auth::user()->name }}</span>
          <small class="opacity-50 small" style="color: var(--brand-cream); text-transform: uppercase;">Authority: Cashier</small>
      </div>
    </header>

    <!-- Stat Dashboard -->
    <section class="dashboard-container mb-5">
      <div class="card stat-card shadow-lg">
        <h3><i class="bi bi-receipt me-2"></i>Total Actions</h3>
        <p id="stat-total-transactions">{{ $totalTransactions }}</p>
      </div>
      <div class="card stat-card shadow-lg">
        <h3><i class="bi bi-clock-history me-2"></i>Awaiting Sum</h3>
        <p id="stat-pending-payments">{{ $pendingPayments }}</p>
      </div>
      <div class="card stat-card highlight shadow-lg">
        <h3><i class="bi bi-calendar-check me-2"></i>Verified Today</h3>
        <p id="stat-paid-today">{{ $paidToday }}</p>
      </div>
      <div class="card stat-card shadow-lg">
        <h3 style="color: var(--brand-gold) !important;"><i class="bi bi-wallet2 me-2"></i>Revenue Baseline</h3>
        <p id="stat-total-income" style="color: var(--brand-gold) !important; font-weight: bold;">₱{{ number_format($totalIncome, 2) }}</p>
      </div>
    </section>

    <!-- Analytics Engine -->
    <section class="mb-5">
      <div class="chart-container shadow-lg">
        <h4 class="chart-title"><i class="bi bi-graph-up-arrow me-2" style="color: var(--brand-gold);"></i> Revenue Intelligence Center</h4>
        <div style="height: 380px; position: relative;">
            <canvas id="revenueChart"></canvas>
        </div>
      </div>
    </section>

    <!-- Services Registry -->
    <section id="transactions" class="mb-5 pt-4">
      <div class="mb-1">
        <h2 class="section-title"><i class="bi bi-layers-half me-3"></i>Registry Management</h2>
      </div>

      <div id="ajax-alerts" class="mb-3"></div>

      <!-- Max Visibility Filter Bar -->
      <form action="{{ url('/cashier') }}" method="GET" id="filter-form" class="mb-4">
        <div class="filter-bar shadow-lg">
          <div class="row g-3 align-items-center">
            <div class="col-lg-5">
              <div class="input-group luxury-input-group">
                <span class="input-group-text"><i class="bi bi-search"></i></span>
                <input type="text" name="booking_id" class="form-control" 
                       placeholder="Search by ID, Guest Name or Keyword..." 
                       value="{{ request()->input('booking_id') }}">
              </div>
            </div>
            <div class="col-lg-7">
              <div class="d-flex align-items-center gap-4 justify-content-lg-end flex-wrap">
                <span class="filter-label">Sort Status:</span>
                @foreach(['' => 'Complete', 'pending' => 'Pending', 'paid' => 'Verified', 'refunded' => 'Refunded'] as $val => $label)
                <div class="form-check custom-radio">
                  <input class="form-check-input filter-radio" type="radio" name="payment_status"
                         id="filter-{{ $val ?: 'all' }}" value="{{ $val }}"
                         {{ request()->payment_status == $val ? 'checked' : '' }}>
                  <label class="form-check-label" for="filter-{{ $val ?: 'all' }}">{{ $label }}</label>
                </div>
                @endforeach
                <a href="{{ url('/cashier') }}" class="btn btn-sm px-4" style="border: 2px solid var(--brand-gold); color: var(--brand-gold); font-weight: 700; border-radius: 8px;">
                  <i class="bi bi-arrow-counterclockwise"></i> RESET
                </a>
              </div>
            </div>
          </div>
        </div>
      </form>

      <!-- Registry Table -->
      <div class="table-responsive">
        <table class="table custom-table">
          <thead>
            <tr>
              <th class="ps-4">CUSTOMER NAME</th>
              <th>CLASSIFICATION</th>
              <th>DATE</th>
              <th>METHOD</th>
              <th>STATUS</th>
              <th>TOTAL SUM</th>
              <th class="pe-4 text-center">ACTION</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($availed_services as $service)
            <tr id="service-row-{{ $service->id }}">
              <td class="ps-4 fw-bold" style="color: var(--brand-cream);">{{ $service->guest_name }}</td>
              <td>
                <small class="text-gold d-block fw-bold" style="font-size: 0.75rem; opacity: 0.8; font-family: 'Aboreto';">REF:{{ $service->booking_id }}</small>
                <span style="font-size: 0.95rem; opacity: 0.9;">{{ $service->service_id == 0 ? 'Accommodation' : ($service->service ? $service->service->service_name : 'Service Fee') }}</span>
              </td>
              <td class="text-muted small">{{ \Carbon\Carbon::parse($service->service_date)->format('M d, Y') }}</td>
              <td><span class="badge" style="background: rgba(191,167,93,0.1); border: 1px solid var(--brand-gold); color: var(--brand-gold); font-size: 0.65rem;">{{ strtoupper($service->payment_method ?: 'DIRECT') }}</span></td>
              <td>
                @php
                  $s = strtolower($service->payment_status);
                  $sc = ['pending' => 'bg-warning text-dark', 'paid' => 'bg-success', 'refunded' => 'bg-secondary text-white'][$s] ?? 'bg-dark';
                @endphp
                <span class="badge rounded-pill {{ $sc }}" style="letter-spacing: 1px; padding: 7px 14px; font-size: 0.7rem; font-weight: 700;">
                  {{ strtoupper($service->payment_status) }}
                </span>
              </td>
              <td class="fw-bold fs-6">₱{{ number_format($service->total_price, 2) }}</td>
              <td class="pe-4 text-center action-cell">
                @if(strtolower($service->payment_status) == 'pending')
                    <button type="button" class="btn btn-success btn-sm ajax-action-btn shadow-sm" 
                            data-url="{{ route('mark.as.paid', ['id' => $service->id, 'booking_id' => $service->booking_id]) }}"
                            data-id="{{ $service->id }}">
                      <i class="bi bi-wallet2 me-1"></i>VERIFY
                    </button>
                @elseif (strtolower($service->payment_status) == 'paid')
                    <button type="button" class="btn btn-outline-warning btn-sm ajax-action-btn" 
                            data-url="{{ route('service.refund', $service->id) }}"
                            data-id="{{ $service->id }}">
                      <i class="bi bi-arrow-return-left me-1"></i>REFUND
                    </button>
                @else
                    <i class="bi bi-lock-fill opacity-25" title="Transaction Closed"></i>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="empty-state">
                <i class="bi bi-cloud-check fs-1 mb-3 d-inline-block"></i><br>
                All Financial Records are in Perfect Sync
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="d-flex justify-content-center mt-4">
        {{ $availed_services->links('pagination::bootstrap-5') }}
      </div>
    </section>

    <!-- Financial Ledger -->
    <section id="income-tracker" class="mb-5 pt-4">
      <div class="chart-container shadow-lg">
        <h2 class="chart-title mb-4"><i class="bi bi-journal-text me-3" style="color: var(--brand-gold);"></i>Verified Audit Trail</h2>
        <div class="table-responsive">
          <table class="table custom-table">
            <thead>
              <tr>
                <th class="ps-4">ACCOUNT NAME</th>
                <th>CLASSIFICATION</th>
                <th>REVENUE</th>
                <th>INTERNAL REF</th>
                <th>SYNC TIMESTAMP</th>
              </tr>
            </thead>
            <tbody id="income-tracker-body">
              @forelse ($incomeTracker as $income)
              <tr>
                <td class="ps-4 fw-bold" style="color: var(--brand-cream);">{{ $income->customer_name }}</td>
                <td><span style="color: var(--brand-gold); font-size: 0.85rem; font-weight: 600;">{{ $income->availed_service }}</span></td>
                <td class="text-success fw-bold" style="font-size: 1.1rem;">₱{{ number_format($income->price, 2) }}</td>
                <td><code class="text-gold" style="font-size: 0.75rem;">BOOKING:{{ $income->booking_id }}</code></td>
                <td class="text-muted small">{{ $income->created_at ? $income->created_at->format('M d, h:i A') : 'MANUAL DATA' }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="empty-state">
                  <i class="bi bi-clipboard-x fs-2 mb-2 d-inline-block"></i><br>
                  No ledger entries recorded
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="mt-4">
          {{ $incomeTracker->links('pagination::bootstrap-5') }}
        </div>
      </div>
    </section>

  </div>

  <!-- Synchronization Layer -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
  <script>
    let revenueChart;

    async function refreshDashboard() {
      try {
        const statsRes = await fetch('{{ route("api.stats") }}');
        
        // Critical Fix: If API redirects back to login page (returns HTML), stop and redirect
        const contentType = statsRes.headers.get('content-type');
        if (contentType && contentType.includes('text/html')) {
            console.warn("Session Lost: Terminating Terminal Connection.");
            window.location.href = '{{ route("login") }}';
            return;
        }

        const stats = await statsRes.json();
        document.getElementById('stat-total-transactions').textContent = stats.totalTransactions;
        document.getElementById('stat-pending-payments').textContent = stats.pendingPayments;
        document.getElementById('stat-paid-today').textContent = stats.paidToday;
        document.getElementById('stat-total-income').textContent = '₱' + new Intl.NumberFormat().format(stats.totalIncome);
        
        const chartRes = await fetch('{{ route("api.revenue.chart") }}');
        const chartData = await chartRes.json();
        if (revenueChart) {
            revenueChart.data.labels = chartData.labels;
            revenueChart.data.datasets[0].data = chartData.data;
            revenueChart.update();
        }
      } catch (e) { console.error("Telemetry Sync Interrupted:", e); }
    }

    document.addEventListener('DOMContentLoaded', () => {
      const ctx = document.getElementById('revenueChart').getContext('2d');
      const gradient = ctx.createLinearGradient(0, 0, 0, 400);
      gradient.addColorStop(0, 'rgba(191, 167, 93, 0.6)');
      gradient.addColorStop(1, 'rgba(22, 14, 8, 0)');

      revenueChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: [],
          datasets: [{
            label: 'Consolidated Revenue',
            data: [],
            borderColor: '#BFA75D',
            borderWidth: 4,
            backgroundColor: gradient,
            fill: true,
            tension: 0.45,
            pointBackgroundColor: '#FEF3E2',
            pointBorderColor: '#BFA75D',
            pointRadius: 6,
            pointHoverRadius: 9,
            pointBorderWidth: 2
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1E140C',
                titleColor: '#BFA75D',
                bodyColor: '#FEF3E2',
                borderColor: 'rgba(191, 167, 93, 0.5)',
                borderWidth: 1,
                padding: 16,
                displayColors: false,
                callbacks: {
                    label: function(context) { return ' ₱' + new Intl.NumberFormat().format(context.parsed.y); }
                }
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              grid: { color: 'rgba(254, 243, 226, 0.08)', drawBorder: false },
              ticks: { color: 'rgba(254, 243, 226, 0.7)', callback: v => '₱' + new Intl.NumberFormat().format(v) }
            },
            x: { grid: { display: false }, ticks: { color: 'rgba(254, 243, 226, 0.7)' } }
          }
        }
      });
      
      refreshDashboard();
      setInterval(refreshDashboard, 30000); // 30s Heartbeat

      document.querySelectorAll('.filter-radio').forEach(radio => { radio.addEventListener('change', () => { document.getElementById('filter-form').submit(); }); });

      document.querySelectorAll('.ajax-action-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
          const url = this.dataset.url;
          const id = this.dataset.id;
          const original = this.innerHTML;
          this.disabled = true;
          this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> SYNCING...';

          try {
            const res = await fetch(url, {
              method: 'POST',
              headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'X-Requested-With': 'XMLHttpRequest' }
            });
            const result = await res.json();
            if (result.success) {
              refreshDashboard();
              setTimeout(() => { location.reload(); }, 600);
            } else { throw new Error(result.message); }
          } catch (e) { 
            console.error(e); 
            this.disabled = false; 
            this.innerHTML = original; 
            alert('CRITICAL ERROR: Operation failed to verify. ' + e.message);
          }
        });
      });
    });
  </script>
</body>
</html>