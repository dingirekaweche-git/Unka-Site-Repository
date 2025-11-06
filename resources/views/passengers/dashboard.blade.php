<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Dashboard</title>
    @include('dashboard.style')
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/dashboard/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stat-card {
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.08);
            transition: 0.3s;
        }
        .stat-card:hover {
            transform: translateY(-4px);
        }
        .page-title {
            font-weight: 700;
            font-size: 26px;
        }
        .filter-box input, .filter-box button {
            height: 45px;
        }
    </style>
</head>
<body>
@include('dashboard.sidebar')
<div class="home-section">
@include('dashboard.header')
<div class="container-fluid p-4">

@if ($errors->any())
<div class="alert alert-warning"><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
@if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

<h2 class="page-title mb-4">Passenger Dashboard</h2>

<form method="GET" class="row g-3 filter-box mb-4">
    <div class="col-md-4"><input type="date" name="from" value="{{ $from->toDateString() }}" class="form-control"></div>
    <div class="col-md-4"><input type="date" name="to" value="{{ $to->toDateString() }}" class="form-control"></div>
    <div class="col-md-4 d-grid"><button class="btn btn-primary">Filter</button></div>
</form>

<div class="row g-4 mb-4">
    <div class="col-6 col-lg-3"><div class="stat-card border-start border-success border-4"><h6 class="text-muted">Invited</h6><h2 class="text-success">{{ $report->invited }}</h2></div></div>
    <div class="col-6 col-lg-3"><div class="stat-card border-start border-primary border-4"><h6 class="text-muted">Active</h6><h2 class="text-primary">{{ $report->active }}</h2></div></div>
    <div class="col-6 col-lg-3"><div class="stat-card border-start border-warning border-4"><h6 class="text-muted">Suspended</h6><h2 class="text-warning">{{ $report->suspended }}</h2></div></div>
    <div class="col-6 col-lg-3"><div class="stat-card border-start border-danger border-4"><h6 class="text-muted">Closed</h6><h2 class="text-danger">{{ $report->closed }}</h2></div></div>
    <div class="col-12 col-lg-3"><div class="stat-card border-start border-dark border-4"><h6 class="text-muted">Total</h6><h2 class="text-dark">{{ $report->total }}</h2></div></div>
</div>

<div class="card shadow p-4">
    <h5 class="fw-bold mb-3">Daily Passenger Joinings</h5>
    <canvas id="passengerTrendChart" height="500"></canvas>
</div>

</div>
</div>

<script>
const ctx = document.getElementById('passengerTrendChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($dates),
        datasets: [{
            label: 'Passengers Joined',
            data: @json($counts),
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    }
});
</script>
@include('dashboard.script')
</body>
</html>
