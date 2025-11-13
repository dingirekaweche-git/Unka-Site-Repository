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
    <h2>Employees — {{ $corporate->name }}</h2>
    <a href="{{ route('corporate_employees.create', $corporate->corporate_id) }}" class="btn btn-primary mb-3">Add Employee</a>
    <a href="{{ route('corporate_accounts.index') }}" class="btn btn-secondary mb-3">Back to Corporates</a>

  
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Corporate</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Department</th>
                <th>Status</th>
                <th>Added On</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($employees as $emp)
            <tr>
                <td>{{ $emp->id }}</td>
                <td>{{ $emp->corporateAccount->name }}</td>
                <td>{{ $emp->name }}</td>
                <td>{{ $emp->email }}</td>
                <td>{{ $emp->phone }}</td>
                <td>{{ $emp->department }}</td>
                <td>
                    @if($emp->active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </td>
       <td>{{ $emp->created_at->format('d M Y H:i') }}</td>
                <td>
                   
                    <a href="{{ route('corporate_employees.edit', [$corporate->corporate_id, $emp->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('corporate_employees.destroy', [$corporate->corporate_id, $emp->id]) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $employees->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>


</div>


        </div>
    </div>

    @include('dashboard.script')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
