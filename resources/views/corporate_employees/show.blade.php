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
    <h2>Employee Details — {{ $employee->name }}</h2>

    <table class="table table-bordered">
        <tr><th>Corporate</th><td>{{ $corporate->name }}</td></tr>
        <tr><th>Name</th><td>{{ $employee->name }}</td></tr>
        <tr><th>Email</th><td>{{ $employee->email }}</td></tr>
        <tr><th>Phone</th><td>{{ $employee->phone }}</td></tr>
        <tr><th>Department</th><td>{{ $employee->department }}</td></tr>
        <tr><th>Status</th><td>{{ $employee->active ? 'Active' : 'Inactive' }}</td></tr>
        <tr><th>Added On</th><td>{{ $employee->created_at->format('d M Y H:i') }}</td></tr>
    </table>

    <a href="{{ route('corporate_employees.edit', [$corporate->corporate_id, $employee->id]) }}" class="btn btn-warning">Edit</a>
    <a href="{{ route('corporate_employees.index', $corporate->corporate_id) }}" class="btn btn-secondary">Back</a>
</div>


</div>


        </div>
    </div>

    @include('dashboard.script')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
