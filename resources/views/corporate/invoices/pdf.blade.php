<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Corporate Invoice</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; font-size: 12px; }
        .header, .section { width: 100%; margin-bottom: 20px; }
        .header table { width: 100%; }
        .header td { vertical-align: top; }
        .right { text-align: right; }
        .orange { color: #f68b1f; } /* primary orange */
        table.items, table.summary-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.items th, table.items td, table.summary-table th, table.summary-table td { border-bottom: 1px solid #ddd; padding: 8px; }
        table.items th, table.summary-table th { background-color: #f68b1f; color: #fff; }
        .total { text-align: right; margin-top: 20px; }
        .logo { max-width: 150px; margin-bottom: 10px; }
        .logo-orange {
            filter: invert(49%) sepia(85%) saturate(5000%) hue-rotate(6deg) brightness(1) contrast(1);
        }
        .footer {
            margin-top: 40px;
            border-top: 2px solid #f68b1f;
            padding-top: 15px;
        }
        .account-details {
            background: #fff7f0;
            padding: 10px 15px;
            border-left: 4px solid #f68b1f;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="invoice-box">
    <!-- Header -->
    <div class="header">
        <table>
            <tr>
                <td>
                    <img src="images/apple-touch-icon.png" class="logo logo-orange" alt="Unka Logo">

                    <h2 class="orange">INVOICE</h2>
                    <p><strong>Billed To:</strong><br>
                        {{ $corporate->name ?? 'Corporate Account' }}<br>
                        {{ $corporate->address ?? 'N/A' }}<br>
                        {{ $corporate->email ?? '' }}
                    </p>
                </td>
                <td class="right">
                    <p><strong>Unka Go Technologies</strong><br>
                    1234 Your Street<br>
                    City, Zambia<br>
                    +260 900 000 000</p>
                    <p><strong>Date Issued:</strong> {{ \Carbon\Carbon::now()->format('d/m/Y') }}<br>
                    <strong>Period:</strong> {{ $startDate }} - {{ $endDate }}<br>
                    <strong>Amount Due:</strong> K{{ number_format($total_cost, 2) }}</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- Summary per Employee -->
    <div class="section summary">
        <h3 class="orange">Summary Per Employee</h3>
        <table class="summary-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Number of Trips</th>
                    <th>Total Cost (K)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $overallTrips = 0;
                    $overallCost = 0;
                @endphp
                @foreach($summary as $employeePhone => $data)
                    @php
                        $overallTrips += $data['trips'];
                        $overallCost += $data['total_cost'];
                    @endphp
                    <tr>
                        <td>{{ $data['details'][0]->passenger_name }} ({{ $employeePhone }})</td>
                        <td>{{ $data['trips'] }}</td>
                        <td>{{ number_format($data['total_cost'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="section">
        <div class="total">
            <p>Subtotal: K{{ number_format($subtotal, 2) }}</p>
            <p>Tax: K{{ number_format($tax, 2) }}</p>
            <p><strong>Total: K{{ number_format($total_cost, 2) }}</strong></p>
        </div>
    </div>

    <!-- Notes & Payment Info -->
    <div class="footer">
        <p><strong>Notes:</strong> Thank you for your business!</p>

        <div class="account-details">
            <p><strong>Please make payment to:</strong></p>
            <p>
                <strong>Account Name:</strong> Unka Go Technologies Ltd<br>
                <strong>Bank:</strong> Zambia National Commercial Bank (Zanaco)<br>
                <strong>Account Number:</strong> 1234567890123<br>
                <strong>Branch:</strong> Cairo Road Branch<br>
                <strong>SWIFT Code:</strong> ZNCOZMLU<br>
            </p>
            <p>Kindly include your company name or invoice number as the payment reference.</p>
        </div>
    </div>
</div>
</body>
</html>
