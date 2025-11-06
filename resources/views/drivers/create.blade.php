<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ZedMobile SMS Portal</title>
    
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



  <div class="container">
<div class="container">
    <h2 class="mb-4 text-center">Driver Registration</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('drivers.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm bg-white">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label>Phone Number</label>
                <input type="text" name="phone_number" class="form-control" required>
                @error('phone_number') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label>Email (Optional)</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Subscription Plan</label>
                <select name="subscription_plan" class="form-select" required>
                    <option value="commision">Commission</option>
                    <option value="daily">Daily</option>
                    <option value="weekly">Weekly</option>
                    <option value="monthly">Monthly</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>License Number</label>
                <input type="text" name="license_number" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Service Type</label>
                <select name="service_type" class="form-select" required>
                    <option value="classic">Classic</option>
                    <option value="business">Business</option>
                    <option value="airport">Airport</option>
                    <option value="moto">Moto</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Plate Number</label>
                <input type="text" name="plate_number" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Vehicle Model</label>
                <input type="text" name="vehicle_model" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Color</label>
                <input type="text" name="color" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Board Number</label>
                <input type="text" name="board_number" class="form-control" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>No. of Passenger Seats</label>
                <input type="text" name="number_of_passenger_seats" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Association</label>
                <select name="association_id" class="form-select" required>
                    <option value="">-- Select Association --</option>
                    @foreach($associations as $association)
                        <option value="{{ $association->id }}">{{ $association->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Vehicle Image</label>
                <input type="file" name="vehicle_image" class="form-control" accept="image/*" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>License Front Image</label>
                <input type="file" name="license_front_image" class="form-control" accept="image/*" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>License Back Image</label>
                <input type="file" name="license_back_image" class="form-control" accept="image/*" required>
            </div>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-5">Register</button>
        </div>
    </form>
</div>

</div>


        </div>
    </div>

    @include('dashboard.script')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
