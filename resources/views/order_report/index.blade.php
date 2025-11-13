<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Reports</title>
    
    @include('dashboard.style')
    
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/dashboard/style.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --border-radius: 12px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }
        
        body {
            background-color: #f5f7fb;
            color: var(--dark);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .home-content {
            padding: 20px;
        }
        
        .page-title {
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .page-title i {
            color: var(--primary);
            font-size: 1.8rem;
        }
        
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            transition: var(--transition);
            margin-bottom: 1.5rem;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid var(--light-gray);
            padding: 1.25rem 1.5rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0 !important;
            font-weight: 600;
            color: var(--dark);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .filter-card {
            background-color: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            margin-bottom: 2rem;
            box-shadow: var(--box-shadow);
        }
        
        .filter-card h5 {
            color: var(--primary);
            margin-bottom: 1.2rem;
            font-weight: 600;
        }
        
        .form-label {
            font-weight: 500;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.6rem 0.75rem;
            border: 1px solid #dee2e6;
            transition: var(--transition);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary);
            border-color: var(--secondary);
            transform: translateY(-2px);
        }
        
        .table-responsive {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }
        
        .table {
            margin-bottom: 0;
        }
        
        .table thead th {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        
        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #dee2e6;
        }
        
        .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }
        
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 500;
            text-transform: capitalize;
        }
        
        .status-completed {
            background-color: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }
        
        .status-pending {
            background-color: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }
        
        .status-cancelled {
            background-color: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }
        
        .status-in-progress {
            background-color: rgba(0, 123, 255, 0.15);
            color: #007bff;
        }
        
        .chart-container {
            background-color: white;
            border-radius: var(--border-radius);
            padding: 5.5rem;
            box-shadow: var(--box-shadow);
            height: 500px;
        }
        
        .chart-title {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1.2rem;
            font-size: 1.1rem;
        }
        
        .stats-card {
            text-align: center;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            color: white;
            margin-bottom: 1.5rem;
        }
        
        .stats-card.primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }
        
        .stats-card.success {
            background: linear-gradient(135deg, #4cc9f0, #4895ef);
        }
        
        .stats-card.warning {
            background: linear-gradient(135deg, #f8961e, #f3722c);
        }
        
        .stats-card.danger {
            background: linear-gradient(135deg, #f94144, #f3722c);
        }
        
        .stats-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .no-orders {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--gray);
        }
        
        .no-orders i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #dee2e6;
        }
        
        .alert {
            border-radius: var(--border-radius);
            border: none;
            padding: 1rem 1.5rem;
        }
        
        .alert-success {
            background-color: rgba(40, 167, 69, 0.15);
            color: #155724;
        }
        
        .alert-warning {
            background-color: rgba(255, 193, 7, 0.15);
            color: #856404;
        }
        
        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .stats-card {
                margin-bottom: 1rem;
            }
        }
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
    @if ($errors->any())
        <div class="alert alert-warning">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="container-fluid">
        <h1 class="page-title">
            <i class='bx bx-bar-chart-alt-2'></i> Order Report
        </h1>

      <!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="stats-card primary">
            <div class="stats-value">{{ $orders->count() }}</div>
            <div class="stats-label">Total Orders</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stats-card success">
            <div class="stats-value">ZMK{{ number_format($orders->sum('total_cost'), 2) }}</div>
            <div class="stats-label">Total Revenue</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stats-card warning">
            <div class="stats-value">{{ $orders->where('order_status', 'FINISHED_PAID')->count() }}</div>
            <div class="stats-label">Completed Orders</div>
        </div>
    </div>

    <div class="col-md-3">
        @php
            $cancelledStatuses = [
                'CANCELLED_BY_OPERATOR',
                'CANCELLED_BY_DRIVER',
                'CANCELLED_NO_CUSTOMER',
                'OBSOLETE_CANCELLED_PASSENGER_OUT_OF_CONDITION',
                'CANCELLED_DECIDED_NOT_TO_GO',
                'CANCELLED_NO_TAXI',
                'OBSOLETE_CANCELLED_ORDER_KILLED',
                'CANCELLED_DRIVER_OFFLINE',
                'CANCELLED_SEARCH_EXCEEDED',
                'OBSOLETE_CANCELLED_NO_RADIO_CAR',
                'OBSOLETE_CANCELLED_NO_CONFIRM',
                'CANCELLED_EXPIRED',
                'CANCELLED_BY_SYSTEM',
                'DISPOSED'
            ];

            $cancelledCount = $orders->whereIn('order_status', $cancelledStatuses)->count();
        @endphp

        <div class="stats-card danger">
            <div class="stats-value">{{ $cancelledCount }}</div>
            <div class="stats-label">Cancelled Orders</div>
        </div>
    </div>
</div>


        <!-- Date Filter -->
        <div class="filter-card">
            <h5><i class='bx bx-filter-alt'></i> Filter Orders</h5>
            <form method="GET" action="{{ route('order_report.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            <i class='bx bx-filter'></i> Apply Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('order_report.index') }}" class="btn btn-outline-secondary w-100">
                            <i class='bx bx-reset'></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Charts -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Orders by Status</div>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <div class="chart-title">Revenue by Status</div>
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

       <!-- Orders Table -->
<div class="card mt-4">
    <div class="card-header">
        <span>Order Details</span>
        <span class="badge bg-primary">{{ $listorders->total() }} orders</span>
    </div>
    <div class="card-body p-0">
         <div class="table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl">
    <table class="table table-hover table-bordered table-striped align-middle text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Passenger</th>
                        <th>Driver</th>
                        <th>Created At</th>
                        <th>Total Cost</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listorders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong></td>
                            <td>
                                <span class="status-badge status-{{ str_replace(' ', '-', strtolower($order->order_status)) }}">
                                    {{ $order->order_status }}
                                </span>
                            </td>
                            <td>{{ $order->passenger_name ?? '-' }}</td>
                            <td>
                                @if($order->driver_name)
                                    <span class="badge bg-light text-dark">{{ $order->driver_name }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td><strong>ZMK{{ number_format($order->total_cost, 2) }}</strong></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="no-orders text-center p-3">
                                    <i class='bx bx-package fs-1'></i>
                                    <h5>No orders found</h5>
                                    <p>No orders match your selected criteria</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="p-3">
            {{ $listorders->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

    </div>
</div>

{{-- Charts Data --}}
@php
    $statusCounts = $orders->groupBy('order_status')->map->count();
    $statusLabels = $statusCounts->keys();
    $statusData = $statusCounts->values();

    $revenueByStatus = $orders->groupBy('order_status')->map(function($group){
        return $group->sum('total_cost');
    });
    $revenueLabels = $revenueByStatus->keys();
    $revenueData = $revenueByStatus->values();
@endphp>

{{-- Chart.js --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($statusLabels) !!},
                datasets: [{
                    label: 'Orders by Status',
                    data: {!! json_encode($statusData) !!},
                    backgroundColor: [
                        'rgba(67, 97, 238, 0.7)',
                        'rgba(76, 201, 240, 0.7)',
                        'rgba(248, 150, 30, 0.7)',
                        'rgba(249, 65, 68, 0.7)',
                        'rgba(106, 76, 147, 0.7)',
                        'rgba(41, 171, 135, 0.7)'
                    ],
                    borderColor: [
                        'rgba(67, 97, 238, 1)',
                        'rgba(76, 201, 240, 1)',
                        'rgba(248, 150, 30, 1)',
                        'rgba(249, 65, 68, 1)',
                        'rgba(106, 76, 147, 1)',
                        'rgba(41, 171, 135, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($revenueLabels) !!},
                datasets: [{
                    label: 'Revenue by Status',
                    data: {!! json_encode($revenueData) !!},
                    backgroundColor: [
                        'rgba(67, 97, 238, 0.7)',
                        'rgba(76, 201, 240, 0.7)',
                        'rgba(248, 150, 30, 0.7)',
                        'rgba(249, 65, 68, 0.7)',
                        'rgba(106, 76, 147, 0.7)',
                        'rgba(41, 171, 135, 0.7)'
                    ],
                    borderColor: [
                        'rgba(67, 97, 238, 1)',
                        'rgba(76, 201, 240, 1)',
                        'rgba(248, 150, 30, 1)',
                        'rgba(249, 65, 68, 1)',
                        'rgba(106, 76, 147, 1)',
                        'rgba(41, 171, 135, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    });
</script>

@include('dashboard.script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>