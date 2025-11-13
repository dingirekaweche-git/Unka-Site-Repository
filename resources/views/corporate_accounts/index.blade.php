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


<div class="container my-4">
    <h2 class="mb-3">Corporate Accounts</h2>
    <a href="{{ route('corporate_accounts.create') }}" class="btn btn-primary mb-3">Add Corporate Account</a>

    <!-- Card wrapper -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <!-- Responsive table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Balance</th>
                            <th>Employees</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($corporates as $corp)
                        <tr>
                            <td>
                                <a href="{{ route('corporate_employees.index', $corp->corporate_id) }}">
                                    {{ $corp->name }}
                                </a>
                            </td>
                            <td>{{ $corp->email }}</td>
                            <td>{{ $corp->phone }}</td>
                            <td>{{ ucfirst($corp->account_type) }}</td>
                            <td>K{{ number_format($corp->balance, 2) }}</td>
                            <td>{{ $corp->employees_count }}</td>
                            <td>
                                <a href="{{ route('corporate_accounts.edit', $corp->corporate_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('corporate_accounts.destroy', $corp->corporate_id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- /.table-responsive -->
        </div> <!-- /.card-body -->
    </div> <!-- /.card -->

    <!-- Pagination -->
    <div class="mt-3">
        {{ $corporates->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>



        </div>
    </div>

    @include('dashboard.script')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
