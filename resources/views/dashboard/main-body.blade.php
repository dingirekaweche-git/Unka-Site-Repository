<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Management Dashboard</title>

    <style>
      
        
        body {
            background-color: #f5f7fb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .dashboard-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 1.5rem 0;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .stats-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            overflow: hidden;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .stats-card .card-body {
            padding: 1.5rem;
        }
        
        .stats-card h5 {
            font-size: 0.9rem;
            color: var(--gray);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .stats-card p {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0;
        }
        
        .card-total {
            border-top: 4px solid var(--primary);
        }
        
        .card-pending {
            border-top: 4px solid #ffc107;
        }
        
        .card-approved {
            border-top: 4px solid #28a745;
        }
        
        .card-rejected {
            border-top: 4px solid var(--danger);
        }
        
        .driver-card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            overflow: hidden;
            height: 100%;
        }
        
        .driver-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .driver-card .card-body {
            padding: 1.25rem;
        }
        
        .driver-status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-approved {
            background-color: #d1edff;
            color: #0c5460;
        }
        
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .driver-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--gray);
            margin-right: 1rem;
        }
        
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .section-title {
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }
        
        .search-filter {
            background-color: white;
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }
        
        .modal-content {
            border-radius: 12px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 12px 12px 0 0;
            padding: 1.25rem 1.5rem;
        }
        
        .modal-title {
            font-weight: 600;
        }
        
        .btn-close {
            filter: invert(1);
        }
        
        .driver-detail-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--light-gray);
        }
        
        .driver-detail-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .detail-label {
            font-weight: 600;
            color: var(--gray);
            margin-bottom: 0.25rem;
        }
        
        .detail-value {
            color: var(--dark);
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--gray);
        }
        
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--light-gray);
        }
        
        .badge-service {
            background-color: #e9ecef;
            color: var(--dark);
            font-weight: 500;
        }
        
        .bx {
            vertical-align: middle;
        }
        
        @media (max-width: 768px) {
            .stats-card p {
                font-size: 1.5rem;
            }
            
            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .section-actions {
                margin-top: 1rem;
                width: 100%;
            }
        }
    </style>
</head>
<body>    @auth
            @if(auth()->user()->role === 'user' || auth()->user()->role === 'association_admin')
    <div class="dashboard-header">
        <div class="container">
             <div class="dashboard-header mb-4">
  
    </div>

    {{-- Driver Statistics --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-secondary">Total Drivers</h6>
                    <h3 class="fw-bold text-dark">{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-warning">
                <div class="card-body">
                    <h6 class="text-secondary">Not Activated</h6>
                    <h3 class="fw-bold text-warning">{{ $stats['not_activated'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-success">
                <div class="card-body">
                    <h6 class="text-secondary">Active</h6>
                    <h3 class="fw-bold text-success">{{ $stats['active'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm border-danger">
                <div class="card-body">
                    <h6 class="text-secondary">Suspended</h6>
                    <h3 class="fw-bold text-danger">{{ $stats['suspended'] }}</h3>
                </div>
            </div>
        </div>
    </div>
          {{-- Driver Sections --}}
@foreach(['not_activated', 'active', 'suspended'] as $state)
    @if(!$driversGrouped[$state]->isEmpty())
        <div class="section-header mt-4">
            <h3 class="section-title d-flex align-items-center">
                @if($state === 'not_activated')
                    <i class='bx bx-time text-warning me-2'></i>
                @elseif($state === 'active')
                    <i class='bx bx-check-circle text-success me-2'></i>
                @else
                    <i class='bx bx-pause-circle text-danger me-2'></i>
                @endif
                {{ ucwords(str_replace('_', ' ', $state)) }} Drivers
            </h3>
            <div class="section-actions">
                <span class="badge 
                    @if($state === 'not_activated') bg-warning text-dark
                    @elseif($state === 'active') bg-success
                    @else bg-danger @endif">
                    {{ $driversGrouped[$state]->count() }} 
                    {{ $driversGrouped[$state]->count() === 1 ? 'Driver' : 'Drivers' }}
                </span>
            </div>
        </div>

        @php
            // Limit to 12 for active drivers only
            $displayDrivers = ($state === 'active') 
                ? $driversGrouped[$state]->take(12)
                : $driversGrouped[$state];
        @endphp

        <div class="row mt-3">
            @foreach($displayDrivers as $driver)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <i class='bx bx-user-circle fs-2 text-primary me-2'></i>
                                <h5 class="card-title mb-0">{{ $driver->name }}</h5>
                            </div>
                            <p class="card-text text-muted mb-1"><strong>Driver Name:</strong> {{ $driver->fullName }}</p>
                            <p class="card-text text-muted mb-1"><strong>Phone:</strong> {{ $driver->phone }}</p>
                            <p class="card-text text-muted mb-1"><strong>Board Number:</strong> {{ $driver->association->boardNumber ?? 'Self Registration' }}</p>
                            <p class="card-text text-muted mb-1"><strong>Association:</strong> {{ $driver->association->name ?? 'Self Registration' }}</p>
                            <p class="card-text text-muted mb-1"><strong>Registration Date:</strong> {{ $driver->created_at }}</p>
                            <p class="card-text text-muted"><strong>State:</strong> 
                                <span class="
                                    @if($driver->state === 'NOT_ACTIVATED') text-warning
                                    @elseif($driver->state === 'ACTIVE') text-success
                                    @else text-danger @endif fw-bold">
                                    {{ $driver->state }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Show "View All" if active drivers > 12 --}}
        @if($state === 'active' && $driversGrouped[$state]->count() > 12)
            <div class="text-center mb-4">
                <a href="#" class="btn btn-outline-primary btn-sm">
                    View All Active Drivers ({{ $driversGrouped[$state]->count() }})
                </a>
            </div>
        @endif
    @endif
@endforeach
 
    </div>
    @else
<div class="container-fluid">

    {{-- Dashboard Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            <i class="bx bxs-dashboard me-2"></i> Dashboard Overview
        </h2>
    </div>

    {{-- Date Filter --}}
    <form method="GET" class="card shadow-sm border-0 p-3 mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label small text-muted">Start Date</label>
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label small text-muted">End Date</label>
                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary w-100">
                    <i class="bx bx-filter"></i> Apply Filter
                </button>
            </div>
        </div>
    </form>

    {{-- DRIVER STATS --}}
    <h5 class="fw-semibold mb-2">Driver Statistics</h5>
    <div class="row g-3 mb-4">
        @php
            $driverStatsMap = [
                ['title' => 'Total Drivers', 'count' => $driverStats['total'], 'color' => 'primary', 'icon'=>'bx-user'],
                ['title' => 'Not Activated', 'count' => $driverStats['not_activated'], 'color' => 'warning', 'icon'=>'bx-user-x'],
                ['title' => 'Active', 'count' => $driverStats['active'], 'color' => 'success', 'icon'=>'bx-user-check'],
                ['title' => 'Suspended', 'count' => $driverStats['suspended'], 'color' => 'danger', 'icon'=>'bx-user-minus'],
            ];
        @endphp

        @foreach($driverStatsMap as $stat)
        <div class="col-md-3 col-6">
            <div class="dash-card border-start border-4 border-{{ $stat['color'] }}">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted small">{{ $stat['title'] }}</span>
                    <i class="bx {{ $stat['icon'] }} fs-4 text-{{ $stat['color'] }}"></i>
                </div>
                <h2 class="fw-bold mb-0">{{ number_format($stat['count']) }}</h2>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ORDERS STATS --}}
    <h5 class="fw-semibold mb-2">Orders Summary</h5>
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="dash-card border-start border-4 border-primary">
                <span class="text-muted small">Total Orders</span>
                <h2 class="fw-bold">{{ number_format($totalOrders) }}</h2>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="dash-card border-start border-4 border-success">
                <span class="text-muted small">Completed Orders</span>
                <h2 class="fw-bold">{{ number_format($completedOrders) }}</h2>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="dash-card border-start border-4 border-danger">
                <span class="text-muted small">Cancelled Orders</span>
                <h2 class="fw-bold">{{ number_format($cancelledCount) }}</h2>
            </div>
        </div>
        <div class="col-md-3 col-6">
          <div class="dash-card border-start border-4 border-info">
                <span class="text-muted small">Subscription Usage Revenue</span>
                <h2 class="fw-bold">ZMW {{ number_format($usageRevenue,2) }}</h2>
            </div>
        </div>
    </div>

 

    {{-- PASSENGER STATS --}}
    <h5 class="fw-semibold mb-2">Passenger Accounts</h5>
    <div class="row g-3 mb-5">
        @php
            $passengerStats = [
                ['label'=>'Invited', 'value'=>$report->invited, 'color'=>'success'],
                ['label'=>'Active', 'value'=>$report->active, 'color'=>'primary'],
                ['label'=>'Suspended', 'value'=>$report->suspended, 'color'=>'warning'],
                ['label'=>'Closed', 'value'=>$report->closed, 'color'=>'danger'],
            ];
        @endphp

        @foreach($passengerStats as $p)
        <div class="col-md-3 col-6">
            <div class="dash-card border-start border-4 border-{{ $p['color'] }}">
                <span class="text-muted small">{{ $p['label'] }}</span>
                <h2 class="fw-bold">{{ number_format($p['value']) }}</h2>
            </div>
        </div>
        @endforeach
    </div>

</div>

<style>
.dash-card {
    background:#fff;
    border-radius:14px;
    padding:18px;
    box-shadow:0 4px 14px rgba(0,0,0,.06);
    transition:.2s;
}
.dash-card:hover {
    transform:translateY(-2px);
    box-shadow:0 6px 20px rgba(0,0,0,.12);
}
</style>

@endif
@endauth
    <!-- Driver Details Modal Container -->
    <div id="driverModalContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>