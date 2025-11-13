<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Revenue Report</title>
    @include('dashboard.style')

    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { background-color: #f5f7fb; font-family: 'Segoe UI', sans-serif; }
        .stats-card { text-align: center; padding: 1.5rem; border-radius: 12px; color: white; box-shadow: 0 4px 10px rgba(0,0,0,0.08); }
        .stats-card.primary { background: linear-gradient(135deg, #4361ee, #3f37c9); }
        .stats-card.success { background: linear-gradient(135deg, #4cc9f0, #4895ef); }
        .stats-card.info { background: linear-gradient(135deg, #7209b7, #4361ee); }
        .stats-value { font-size: 2rem; font-weight: 700; }
        .stats-label { font-size: 0.9rem; opacity: 0.9; }
        .status-badge { padding: 0.4rem 0.8rem; border-radius: 50px; font-size: 0.8rem; text-transform: capitalize; }
        .status-finished { background-color: rgba(40,167,69,0.15); color: #28a745; }
        @media (max-width: 768px) {
    .table-responsive {
        border-radius: 8px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table th, table td {
        white-space: nowrap;
        font-size: 0.85rem;
    }

    .card-header span {
        display: block;
        text-align: center;
        margin-bottom: 5px;
    }
}

    </style>
</head>

<body>
@include('dashboard.sidebar')

<div class="home-section">
@include('dashboard.header')

<div class="home-content p-4">

    <!-- Alerts -->
    @if ($errors->any())
        <div class="alert alert-warning">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="container-fluid">

        <!-- Filters -->
        <div class="card mb-3 p-3">
            <form method="GET" action="{{ route('order_report.revenue') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date', $startDate->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date', $endDate->format('Y-m-d')) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Search</label>
                    <input type="text" name="search" class="form-control" placeholder="Driver or Passenger" value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100"><i class="bx bx-search"></i> Filter</button>
                </div>
            </form>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="stats-card primary">
                    <div class="stats-value">{{ number_format($orderscount)}}</div>
                    <div class="stats-label">Total Orders</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card success">
                    <div class="stats-value">ZMW {{ number_format($totalRevenue, 2) }}</div>
                    <div class="stats-label">Total Revenue</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card info">
                    <div class="stats-value">{{ $startDate->format('d M') }} - {{ $endDate->format('d M Y') }}</div>
                    <div class="stats-label">Date Range</div>
                </div>
            </div>
        </div>

        <!-- Group Data for Chart -->
        @php
        $groupedData = $orders->groupBy('driver_name')->map(function($driverOrders) {
            return $driverOrders->sum(function($order) {
                $rateValue = floatval(preg_replace('/[^0-9.]/', '', $order->driver_rate_plan));
                return $rateValue > 0 ? ($order->total_cost / $rateValue) : 0;
            });
        });

        $driverNames = $groupedData->keys()->toArray();
        $revenues = $groupedData->values()->map(fn($val) => round($val, 2))->toArray();
        @endphp

        <!-- Revenue Chart -->
        <div class="card mb-4 p-3">
            <div class="card-header">Revenue by Driver</div>
            <div class="card-body">
                <canvas id="revenueChart" height="120"></canvas>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card">
            <div class="card-header">
                <span>Usage-Based Subscription Orders</span>
                <span class="badge bg-primary">{{ $listorders->total() }} Orders</span>
            </div>
            <div class="card-body p-0">
               <div class="table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
    <table class="table table-hover table-bordered table-striped align-middle text-nowrap">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Driver</th>
                                <th>Passenger</th>
                                <th>Rate Plan</th>
                                <th>Status</th>
                                <th>Final Cost</th>
                                <th>Coupon Discount</th>
                                <th>Revenue (Calc)</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($listorders as $order)
                                @php
                                    $rateValue = floatval(preg_replace('/[^0-9.]/', '', $order->driver_rate_plan));
                                    $revenue = $rateValue > 0 ?  ($order->total_cost * ($rateValue / 100)): 0;
                                    
                                @endphp
                                <tr>
                                    <td><strong>#{{ $order->id }}</strong></td>
                                    <td>{{ $order->driver_name ?? '-' }}</td>
                                    <td>{{ $order->passenger_name ?? '-' }}</td>
                                    <td>{{ $order->driver_rate_plan }}</td>
                                    <td><span class="status-badge status-finished">{{ $order->order_status }}</span></td>
                                    <td>ZMW {{ number_format($order->total_cost, 2) }}</td>
                                    <td>ZMW {{ number_format($order->coupon_discount, 2) }}</td>
                                    <td><strong>ZMW {{ number_format($revenue, 2) }}</strong></td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">  {{ $listorders->appends(request()->query())->links('pagination::bootstrap-5') }}</div>
            </div>
        </div>
    </div>
</div>
</div>

@include('dashboard.script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
const ctx = document.getElementById('revenueChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($driverNames),
        datasets: [{
            label: 'Revenue (ZMW)',
            data: @json($revenues),
            borderWidth: 1,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            title: { display: true, text: 'Revenue by Driver (Usage-Based Subscriptions)' }
        },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
</body>
</html>
