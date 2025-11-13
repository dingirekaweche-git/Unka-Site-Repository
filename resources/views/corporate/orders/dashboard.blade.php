<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Unka Go Corporate</title>
    
    @include('dashboard.style')
    
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/dashboard/style.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

 
</head>
<body>
@include('dashboard.sidebar')
<div class="home-section"> 
    
@include('dashboard.header')

<div class="home-content p-3">
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
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif 


<div class="container-fluid p-4">
    <h2 class="mb-3">Corporate Orders — Trips Report</h2>

    {{-- Filter form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('corporate.orders.index') }}" class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', optional($start)->format('Y-m-d') ?? request('start_date')) }}" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date', optional($end)->format('Y-m-d') ?? request('end_date')) }}" class="form-control">
                </div>

                @if(isset($corporates) && $corporates->count())
                    <div class="col-md-4">
                        <label class="form-label">Corporate Account</label>
                        <select name="corporate_account" class="form-select">
                            <option value="">-- All Corporates --</option>
                            @foreach($corporates as $c)
                                <option value="{{ $c->corporate_id }}" @if(request('corporate_account') == $c->corporate_id) selected @endif>
                                    {{ $c->name }} ({{ $c->corporate_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary stats --}}
    <div class="row mb-4">
        <div class="col-md-3 mb-2">
            <div class="card p-3">
                <h5>Total Trips</h5>
                <h3>{{ $globalStats['total_trips'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card p-3">
                <h5>Completed Trips</h5>
                <h3>{{ $globalStats['total_completed'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card p-3">
                <h5>Cancelled Trips</h5>
                <h3>{{ $globalStats['total_cancelled'] ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="card p-3">
                <h5>Total Cost (Completed)</h5>
                <h3>{{ number_format($globalStats['total_cost'] ?? 0, 2) }}</h3>
            </div>
        </div>
    </div>

    {{-- Corporate user view --}}
    @if($user->role === 'corporate' && isset($report))
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <strong>My Employees — {{ $corporate_id }}</strong>
            </div>
            <div class="card-body">
                @if($report->isEmpty())
                    <div class="text-muted">No employees or trips found for the selected period.</div>
                @else
                    <div class="table-responsive mb-3">
                        <table class="table table-striped table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Employee</th>
                                    <th>Phone</th>
                                    <th>Trips</th>
                                    <th>Completed</th>
                                    <th>Cancelled</th>
                                    <th>Cost (Completed)</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($report as $row)
                                <tr>
                                    <td>{{ $row->employee->name }}</td>
                                    <td>{{ $row->phone }}</td>
                                    <td>{{ $row->trips_count }}</td>
                                    <td>{{ $row->completed_count }}</td>
                                    <td>{{ $row->cancelled_count }}</td>
                                    <td>{{ number_format($row->completed_total_cost, 2) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#empTrips{{ $loop->index }}">
                                            View Trips
                                        </button>
                                    </td>
                                </tr>

                                <tr class="collapse-row">
                                    <td colspan="7" class="p-0">
                                        <div class="collapse" id="empTrips{{ $loop->index }}">
                                            <div class="p-3">
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Order Ref</th>
                                                                <th>Origin</th>
                                                                <th>Destination</th>
                                                                <th>Started At</th>
                                                                <th>Arrived At</th>
                                                                <th>Status</th>
                                                                <th>Cost</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($row->trip_details as $t)
                                                            <tr>
                                                                <td>{{ $t['id'] }}</td>
                                                                <td>{{ $t['order_ref'] ?? '-' }}</td>
                                                                <td>{{ $t['origin_address'] }}</td>
                                                                <td>{{ $t['destination_address'] }}</td>
                                                                <td>{{ optional($t['started_at'])->format('Y-m-d H:i') ?? '-' }}</td>
                                                                <td>{{ optional($t['arrived_at'])->format('Y-m-d H:i') ?? '-' }}</td>
                                                                <td>{{ $t['order_status'] }}</td>
                                                                <td>{{ number_format($t['total_cost'] ?? 0, 2) }}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Admin: all corporates --}}
    @if($user->role === 'system_admin' && isset($reportByCorporate))
        @forelse ($reportByCorporate as $block)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>{{ $block['corporate']->name }} ({{ $block['corporate']->corporate_id }})</strong>
                    <div>
                        <small>Trips: {{ $block['corporate_trips'] }}</small>
                        &nbsp;|&nbsp;
                        <small>Completed: {{ $block['corporate_completed'] }}</small>
                        &nbsp;|&nbsp;
                        <small>Cancelled: {{ $block['corporate_cancelled'] }}</small>
                        &nbsp;|&nbsp;
                        <strong>K{{ number_format($block['corporate_cost'], 2) }}</strong>
                    </div>
                </div>
                <div class="card-body">
                    @if($block['employees']->isEmpty())
                        <div class="text-muted">No employees or trips found.</div>
                    @else
                        <div class="table-responsive mb-3">
                            <table class="table table-striped table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Employee</th>
                                        <th>Phone</th>
                                        <th>Trips</th>
                                        <th>Completed</th>
                                        <th>Cancelled</th>
                                        <th>Cost (Completed)</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($block['employees'] as $row)
                                        <tr>
                                            <td>{{ $row->employee->name }}</td>
                                            <td>{{ $row->phone }}</td>
                                            <td>{{ $row->trips_count }}</td>
                                            <td>{{ $row->completed_count }}</td>
                                            <td>{{ $row->cancelled_count }}</td>
                                            <td>{{ number_format($row->completed_total_cost, 2) }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#corpEmp{{ $block['corporate']->corporate_id }}_{{ $loop->index }}">
                                                    View Trips
                                                </button>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="7" class="p-0">
                                                <div class="collapse" id="corpEmp{{ $block['corporate']->corporate_id }}_{{ $loop->index }}">
                                                    <div class="p-3">
                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-bordered mb-0">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Order Ref</th>
                                                                        <th>Origin</th>
                                                                        <th>Destination</th>
                                                                        <th>Started At</th>
                                                                        <th>Arrived At</th>
                                                                        <th>Status</th>
                                                                        <th>Cost</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($row->trip_details as $t)
                                                                    <tr>
                                                                        <td>{{ $t['id'] }}</td>
                                                                        <td>{{ $t['order_ref'] ?? '-' }}</td>
                                                                        <td>{{ $t['origin_address'] }}</td>
                                                                        <td>{{ $t['destination_address'] }}</td>
                                                                        <td>{{ optional($t['started_at'])->format('Y-m-d H:i') ?? '-' }}</td>
                                                                        <td>{{ optional($t['arrived_at'])->format('Y-m-d H:i') ?? '-' }}</td>
                                                                        <td>{{ $t['order_status'] }}</td>
                                                                        <td>{{ number_format($t['total_cost'] ?? 0, 2) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="alert alert-info">No corporate accounts found for the selected filters.</div>
        @endforelse
    @endif

</div>



        </div>
    </div>

    @include('dashboard.script')
    <script>
    // Bootstrap collapse elements are driven by data-bs-* attributes used above.
    // Optional: scroll to opened panel
    document.addEventListener('shown.bs.collapse', function (e) {
        const el = e.target;
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
    });
</script>

</body>
</html>
