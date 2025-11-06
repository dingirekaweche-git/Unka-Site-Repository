<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Driver Performance Dashboard</title>
    
    @include('dashboard.style')
    
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/dashboard/style.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .card-header {
            background-color: #f8f9fa;
        }
        .driver-badge {
            font-size: 0.85rem;
        }
        .table-responsive {
            max-height: 300px;
            overflow-y: auto;
        }
        .filter-card {
            background-color: #f1f3f5;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .no-orders {
            font-style: italic;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            .driver-badge {
                margin-top: 0.5rem;
            }
            .filter-card .row > [class^="col-"] {
                margin-bottom: 1rem;
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
            <ul>
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
        <h2 class="mb-4">Driver Performance</h2>

        {{-- Filter Form --}}
        <div class="filter-card">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-12 col-md-2">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-12 col-md-2">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-12 col-md-2">
                    <label>Period</label>
                    <select name="period" class="form-select">
                        <option value="">--Select--</option>
                        <option value="daily" {{ request('period') == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ request('period') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ request('period') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                    </select>
                </div>
                <div class="col-12 col-md-3">
                    <label>Driver Name</label>
                    <input type="text" name="driver_name" class="form-control" value="{{ request('driver_name') }}" placeholder="Search driver">
                </div>
                <div class="col-12 col-md-3 d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('driver-performance.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>
        </div>

        {{-- Drivers Performance Cards --}}
        <div class="row g-4">
        @foreach($driversPerformance as $dp)
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h5 class="mb-1">{{ $dp['driver']->fullName }} ({{ $dp['driver']->phone }})</h5>
                            <small>Association: {{ $dp['driver']->association->name ?? 'N/A' }}</small>
                        </div>
                        <span class="badge bg-info text-dark driver-badge">
                            Total Orders: {{ $dp['total_orders'] }}
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="row text-center mb-3 g-2">
                            <div class="col-6 col-sm-3">
                                <span class="badge bg-success">FINISHED_PAID: {{ $dp['finished_paid'] }}</span>
                            </div>
                            <div class="col-6 col-sm-3">
                                <span class="badge bg-warning text-dark">FINISHED_UNPAID: {{ $dp['finished_unpaid'] }}</span>
                            </div>
                            <div class="col-6 col-sm-3">
                                <span class="badge bg-danger">CANCELLED_BY_DRIVER: {{ $dp['cancelled_by_driver'] }}</span>
                            </div>
                            <div class="col-6 col-sm-3">
                                <span class="badge bg-secondary">CANCELLED_NO_PASSENGER: {{ $dp['cancelled_no_passenger'] }}</span>
                            </div>
                        </div>

                        @if($dp['orders']->count())
                            <div class="table-responsive">
                                <table class="table table-hover table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Status</th>
                                            <th>Passenger</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($dp['orders'] as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->order_status }}</td>
                                                <td>{{ $order->passenger_name ?? 'N/A' }}</td>
                                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($dp['total_orders'] > 3)
                                    <small class="text-muted d-block mt-1">Showing 3 latest orders. Filter by period to see others.</small>
                                @endif
                            </div>
                        @else
                            <p class="no-orders">No orders for selected period.</p>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        </div>

        {{-- Driver pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $drivers->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@include('dashboard.script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
