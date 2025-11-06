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

<div class="container">
    <h2 class="mb-4 text-center">Driver Applications</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="statusTabs">
        <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#pending">Pending</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#approved">Approved</button></li>
        <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#rejected">Rejected</button></li>
    </ul>

    <div class="tab-content">
        <!-- Pending -->
        <div class="tab-pane fade show active" id="pending">
            @include('drivers.partials.table', ['drivers' => $pending, 'status' => 'pending', 'user' => $user])
        </div>

        <!-- Approved -->
        <div class="tab-pane fade" id="approved">
            @include('drivers.partials.table', ['drivers' => $approved, 'status' => 'approved', 'user' => $user])
        </div>

        <!-- Rejected -->
        <div class="tab-pane fade" id="rejected">
            @include('drivers.partials.table', ['drivers' => $rejected, 'status' => 'rejected', 'user' => $user])
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="driverModal" tabindex="-1" aria-labelledby="driverModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title">Driver Application Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="driverDetails"></div>
      </div>
    </div>
  </div>
</div>

<script>
    // Pass the authenticated user role from Blade to JS
    const currentUserRole = @json(auth()->user()->role);

    function viewDriver(driver) {
        // Create a unique modal for each driver dynamically
        let existingModal = document.getElementById(`driverModal${driver.id}`);
        if (existingModal) {
            existingModal.remove(); // Remove old modal if exists
        }

        const driverHTML = `
        <!-- Modal -->
        <div class="modal fade" id="driverModal${driver.id}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Driver Application - ${driver.name}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Phone:</strong> ${driver.phone_number}</p>
                        <p><strong>Email:</strong> ${driver.email ?? 'N/A'}</p>
                        <p><strong>License No:</strong> ${driver.license_number}</p>
                        <p><strong>Vehicle Model:</strong> ${driver.vehicle_model}</p>
                        <p><strong>Plate Number:</strong> ${driver.plate_number}</p>
                        <p><strong>Seats:</strong> ${driver.number_of_passenger_seats}</p>
                        <p><strong>Color:</strong> ${driver.color}</p>

                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <img src="/storage/${driver.vehicle_image}" class="img-fluid rounded shadow-sm mb-2">
                                <br>
                                <a href="/storage/${driver.vehicle_image}" download>Download Vehicle Image</a>
                            </div>
                            <div class="col-md-6">
                                <img src="/storage/${driver.license_front_image}" class="img-fluid rounded shadow-sm mb-2">
                                <br>
                                <a href="/storage/${driver.license_front_image}" download>Download License Front</a>
                                <br>
                                <img src="/storage/${driver.license_back_image}" class="img-fluid rounded shadow-sm mb-2">
                                <br>
                                <a href="/storage/${driver.license_back_image}" download>Download License Back</a>
                            </div>
                        </div>

                        ${driver.status === 'pending' && currentUserRole === 'system_admin' ? `
                            <hr>
                            <div class="text-center mt-3">
                                <form method="POST" action="/drivers/${driver.id}/approve" style="display:inline">
                                    @csrf
                                    <button class="btn btn-success">Approve</button>
                                </form>
                                <form method="POST" action="/drivers/${driver.id}/reject" style="display:inline">
                                    @csrf
                                    <button class="btn btn-danger">Reject</button>
                                </form>
                            </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        </div>
        `;

        // Append modal to body
        document.body.insertAdjacentHTML('beforeend', driverHTML);

        // Show the modal using Bootstrap
        const modal = new bootstrap.Modal(document.getElementById(`driverModal${driver.id}`));
        modal.show();
    }
</script>

    @include('dashboard.script')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
