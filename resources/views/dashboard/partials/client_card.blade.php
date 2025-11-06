<div class="row g-4">
    <!-- Account Info -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white d-flex align-items-center">
                <i class="bx bx-user me-2"></i>
                <h6 class="mb-0">Account Info</h6>
            </div>
            <div class="card-body">
                <p><i class="bx bx-envelope me-2 text-muted"></i><strong>Email:</strong> {{ $data['client']->contact_email }}</p>
                <p><i class="bx bx-id-card me-2 text-muted"></i><strong>Contact Person:</strong> {{ $data['client']->contact_person }}</p>
            </div>
        </div>
    </div>

    <!-- API Key Info -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white d-flex align-items-center">
                <i class="bx bx-key me-2"></i>
                <h6 class="mb-0">API Key Info</h6>
            </div>
            <div class="card-body">
                @if($data['clientKey'])
                    <p><i class="bx bx-barcode me-2 text-muted"></i><strong>UID:</strong> {{ $data['clientKey']->uid }}</p>
                    <p><i class="bx bx-code me-2 text-muted"></i><strong>API Key:</strong> {{ $data['clientKey']->api_key }}</p>
                @else
                    <p class="text-muted"><i class="bx bx-key me-2"></i>No API Key assigned.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Bought SMS Info -->
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-warning text-white d-flex align-items-center">
                <i class="bx bx-message-alt-detail me-2"></i>
                <h6 class="mb-0">Bought SMS</h6>
            </div>
            <div class="card-body p-2">
                @if($data['boughtSms']->count() > 0)
                    <table class="table table-sm table-borderless mb-0">
                        <thead>
                            <tr>
                                <th><i class="bx bx-sort-alt-2 me-1"></i>Qty</th>
                                <th><i class="bx bx-time me-1"></i>Remaining</th>
                                <th><i class="bx bx-info-circle me-1"></i>Status</th>
                                <th><i class="bx bx-calendar-alt me-1"></i>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data['boughtSms'] as $sms)
                                <tr>
                                    <td>{{ $sms->quantity }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                <div class="progress-bar 
                                                    @if($sms->remaining_sms/$sms->quantity > 0.7) bg-success
                                                    @elseif($sms->remaining_sms/$sms->quantity > 0.3) bg-warning
                                                    @else bg-danger @endif" 
                                                    role="progressbar" 
                                                    style="width: {{ ($sms->remaining_sms/$sms->quantity)*100 }}%"></div>
                                            </div>
                                            <span>{{ $sms->remaining_sms }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            {{ $sms->status == 'completed' ? 'bg-success' : ($sms->status=='pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                            {{ ucfirst($sms->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $sms->purchased_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted"><i class="bx bx-message-alt-detail me-1"></i>No SMS purchased yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Monthly SMS Activity -->
<div class="row mt-3">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex align-items-center">
                <i class="bx bx-line-chart me-2"></i>
                <h6 class="mb-0">Monthly SMS Activity</h6>
            </div>
            <div class="card-body text-center">
                @if($data['totalSent'] == 0)
                    <p class="text-muted"><i class="bx bx-error me-1"></i>No SMS activity this month.</p>
                @else
                    <div class="d-flex justify-content-around">
                        <div>
                            <h4>{{ $data['totalSent'] }}</h4>
                            <small><i class="bx bx-send me-1"></i>Sent</small>
                        </div>
                        <div>
                            <h4>{{ $data['totalDelivered'] }}</h4>
                            <small><i class="bx bx-check-circle me-1"></i>Delivered</small>
                        </div>
                        <div>
                            <h4>{{ $data['deliveryPercentage'] }}%</h4>
                            <small><i class="bx bx-pie-chart-alt-2 me-1"></i>Delivery Rate</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
