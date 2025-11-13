<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Dashboard</title>

    @include('dashboard.style')
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .card-header {
            background-color: #f8f9fa;
        }
        .stats-card {
            border-left: 5px solid #0d6efd;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .stats-card h3 {
            font-size: 2rem;
            margin: 0;
        }
        .stats-card p {
            margin: 0;
            color: #6c757d;
        }
        .table-responsive {
            overflow-x: auto;
        }
        @media (max-width: 768px) {
            .stats-card {
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
    <h2 class="mb-4 fw-bold">Employee Dashboard</h2>

    {{-- ✅ Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card p-3 border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $totalEmployees }}</h3>
                        <p>Total Employees</p>
                    </div>
                    <i class='bx bx-group bx-lg text-primary'></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stats-card p-3 border-0" style="border-left-color:#198754;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $activeEmployees }}</h3>
                        <p>Active Employees</p>
                    </div>
                    <i class='bx bx-check-circle bx-lg text-success'></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stats-card p-3 border-0" style="border-left-color:#dc3545;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3>{{ $inactiveEmployees }}</h3>
                        <p>Inactive Employees</p>
                    </div>
                    <i class='bx bx-x-circle bx-lg text-danger'></i>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Corporate User View --}}
    @if($user->role === 'corporate')
        <div class="card mb-5 shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">My Employees — Corporate ID: {{ $corporate_id }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Department</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($employees as $emp)
                            <tr>
                                <td>{{ $emp->id }}</td>
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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $employees->links() }}
            </div>
        </div>
    @endif

    {{-- ✅ System Admin View --}}
    @if($user->role === 'system_admin' && $corporates)
        <hr class="my-5">
        <h3 class="text-secondary mb-3">All Employees by Corporate Account</h3>
        @foreach ($corporates as $corp)
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">{{ $corp->name }} ({{ $corp->corporate_id }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($corp->employees as $emp)
                                <tr>
                                    <td>{{ $emp->id }}</td>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No employees found.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $corporates->links() }}
    @endif
</div>

</div>
</div>

@include('dashboard.script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
