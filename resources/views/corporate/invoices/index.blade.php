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


<div class="container">
    <h4 class="mb-4">Corporate Trip Invoices</h4>

    <form method="GET" action="{{ route('corporate.invoices.index') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" value="{{ $startDate }}">
            </div>
            <div class="col-md-3">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control" value="{{ $endDate }}">
            </div>
            @if($role === 'system_admin')
            <div class="col-md-3">
                <label>Corporate Account</label>
                <select name="corporate_account" class="form-select">
                    <option value="">Select Corporate</option>
                    @foreach($corporates as $corp)
                        <option value="{{ $corp->corporate_id }}" {{ $selectedCorporate == $corp->corporate_id ? 'selected' : '' }}>
                            {{ $corp->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>

    <div class="text-end mb-3">
        <form action="{{ route('corporate.invoices.download') }}" method="GET" target="_blank">
            <input type="hidden" name="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" value="{{ $endDate }}">
            @if($role === 'system_admin')
                <input type="hidden" name="corporate_account" value="{{ $selectedCorporate }}">
            @endif
            <button type="submit" class="btn btn-outline-success">Download Invoice PDF</button>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Trips</th>
                <th>Total Cost (K)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summary as $name => $data)
                <tr>
                    <td>{{ $name }}</td>
                    <td>{{ $data['trips'] }}</td>
                    <td>{{ number_format($data['total_cost'], 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

        </div>
    </div>

    @include('dashboard.script')
 

</body>
</html>
