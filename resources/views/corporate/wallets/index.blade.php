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


<div class="container py-4">
    <h2 class="mb-4 text-orange">Corporate Wallets (Prepaid Accounts)</h2>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Corporate ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Balance (K)</th>
                    <th>Last Updated</th>
                    @if(Auth::user()->group_id == 1)
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse($wallets as $wallet)
                    <tr>
                        <td>{{ $wallet->corporate_id }}</td>
                        <td>{{ $wallet->name }}</td>
                        <td>{{ $wallet->email }}</td>
                        <td>{{ $wallet->phone }}</td>
                        <td><strong>K{{ number_format($wallet->balance, 2) }}</strong></td>
                        <td>{{ $wallet->last_updated ? $wallet->last_updated : '—' }}</td>

                        @if(auth()->user()->role === 'system_admin')
                        <td>
                            <form method="POST" action="{{ route('corporate.wallets.topup', $wallet->corporate_id) }}" class="d-flex gap-2">
                                @csrf
                                <input type="number" step="0.01" name="amount" class="form-control form-control-sm w-50" placeholder="Amount">
                                <button type="submit" class="btn btn-orange btn-sm">Add</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center">No prepaid corporate accounts found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<style>
    .btn-orange {
        background-color: #f68b1f;
        color: #fff;
        border: none;
        transition: background-color 0.2s ease-in-out;
    }
    .btn-orange:hover {
        background-color: #e07a1f;
        color: #fff;
    }
    .text-orange { color: #f68b1f; }
</style>


        </div>
    </div>

    @include('dashboard.script')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
