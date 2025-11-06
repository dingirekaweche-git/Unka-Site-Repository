<!-- Redesigned Driver Activation Dashboard -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Driver Activation Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
@include('dashboard.style')
<style>
    body { background:#f4f6fa; font-family: "Segoe UI", sans-serif; }
    .header-bar {
        background:linear-gradient(90deg,#0061ff,#60efff);
        padding:18px 25px;
        border-radius:12px;
        margin-bottom:30px;
        color:#fff;
        box-shadow:0 4px 20px rgba(0,0,0,0.07);
    }
    .stat-card{
        border-radius:14px;
        padding:20px;
        text-align:center;
        background:#fff;
        box-shadow:0 4px 12px rgba(0,0,0,0.05);
        transition:.3s;
    }
    .stat-card:hover{ transform:translateY(-5px); }
    .driver-box{
        background:#fff;
        border-radius:12px;
        padding:18px;
        box-shadow:0 3px 10px rgba(0,0,0,0.06);
        transition:.3s;
        height:100%;
    }
    .driver-box:hover{ transform:translateY(-3px); }
    .badge-state{ font-size:11px; padding:6px 12px; border-radius:6px; }
    .section-title{font-weight:600;margin-top:32px;margin-bottom:15px;}
    .view-more-btn{ margin-top:-10px; }
</style>
</head>
<body>
@include('dashboard.sidebar')
<div class="home-section">
@include('dashboard.header')
<div class="container py-4">

<div class="header-bar">
    <h4 class="mb-0"><i class='bx bxs-dashboard me-2'></i>Driver Activation Dashboard</h4>
</div>

{{-- Stats --}}
<div class="row g-3 mb-3">
    <div class="col-md-3"><div class="stat-card"><h6>Total Drivers</h6><h3>{{ $stats['total'] }}</h3></div></div>
    <div class="col-md-3"><div class="stat-card border-warning border-2"><h6>Not Activated</h6><h3 class="text-warning">{{ $stats['not_activated'] }}</h3></div></div>
    <div class="col-md-3"><div class="stat-card border-success border-2"><h6>Active</h6><h3 class="text-success">{{ $stats['active'] }}</h3></div></div>
    <div class="col-md-3"><div class="stat-card border-danger border-2"><h6>Suspended</h6><h3 class="text-danger">{{ $stats['suspended'] }}</h3></div></div>
</div>

{{-- Driver Lists --}}
@foreach(['not_activated', 'active', 'suspended'] as $state)
@if(!$driversGrouped[$state]->isEmpty())
    <div class="d-flex justify-content-between align-items-center section-title">
        <span>
            @if($state === 'not_activated') <i class='bx bx-time text-warning'></i>
            @elseif($state === 'active') <i class='bx bx-check-circle text-success'></i>
            @else <i class='bx bx-block text-danger'></i> @endif
            {{ ucwords(str_replace('_',' ',$state)) }} Drivers
        </span>
        <span class="badge bg-dark">{{ $driversGrouped[$state]->count() }}</span>
    </div>

    @php $displayDrivers = ($state==='active') ? $driversGrouped[$state]->take(12) : $driversGrouped[$state]; @endphp

    <div class="row g-3 mb-2">
        @foreach($displayDrivers as $driver)
        <div class="col-md-4">
            <div class="driver-box">
                <h5 class="mb-1"><i class='bx bx-user-circle text-primary me-1'></i> {{ $driver->name }}</h5>
                <small class="text-muted d-block">{{ $driver->fullName }}</small>
                <p class="mt-2 mb-1"><b>Phone:</b> {{ $driver->phone }}</p>
                <p class="mb-1"><b>Board:</b> {{ $driver->association->boardNumber ?? 'Self Registration' }}</p>
                <p class="mb-1"><b>Association:</b> {{ $driver->association->name ?? 'Self Registration' }}</p>
                <p class="mb-1"><b>Reg Date:</b> {{ $driver->created_at }}</p>
                <span class="badge-state
                    @if($driver->state==='NOT_ACTIVATED') bg-warning text-dark
                    @elseif($driver->state==='ACTIVE') bg-success
                    @else bg-danger @endif">
                    {{ $driver->state }}
                </span>
            </div>
        </div>
        @endforeach
    </div>

    @if($state==='active' && $driversGrouped[$state]->count()>12)
        <div class="text-center mb-4">
            <a href="#" class="btn btn-outline-primary btn-sm view-more-btn">View All</a>
        </div>
    @endif
@endif
@endforeach

</div>
</div>
@include('dashboard.script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
