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
    <h2>Edit Employee — {{ $employee->name }}</h2>
    <form action="{{ route('corporate_employees.update', [$corporate->corporate_id, $employee->id]) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $employee->name }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $employee->email }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ $employee->phone }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Department</label>
            <input type="text" name="department" value="{{ $employee->department }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="active" class="form-control">
                <option value="1" {{ $employee->active ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$employee->active ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('corporate_employees.index', $corporate->corporate_id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>


</div>


        </div>
    </div>

    @include('dashboard.script')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
