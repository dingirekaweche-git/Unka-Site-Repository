<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Association</th>
            <th>Vehicle</th>
            <th>Service Type</th>
            <th>Subscription</th>
            <th>Status</th>
            @if($user->role === 'system_admin' && $status === 'pending')
                <th>Action</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($drivers as $index => $driver)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $driver->name }}</td>
                <td>{{ $driver->phone_number }}</td>
                <td>{{ $driver->association->name ?? 'N/A' }}</td>
                <td>{{ $driver->vehicle_model }} ({{ $driver->plate_number }})</td>
                <td>{{ ucfirst($driver->service_type) }}</td>
                <td>{{ ucfirst($driver->subscription_plan) }}</td>
                <td>
                    @if($driver->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($driver->status === 'approved')
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
                @if($user->role === 'system_admin' && $status === 'pending')
                    <td>
                        <button class="btn btn-info btn-sm"
                                onclick='viewDriver(@json($driver))'>
                            View
                        </button>
                    </td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">No {{ ucfirst($status) }} applications.</td>
            </tr>
        @endforelse
    </tbody>
</table>
