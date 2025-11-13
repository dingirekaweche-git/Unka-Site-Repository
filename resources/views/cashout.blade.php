<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Out</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

<div class="container">
    <div class="card shadow p-4 mx-auto" style="max-width: 500px;">
        <h3 class="text-center mb-4">💸 Cash Out</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('cashout.process') }}">
            @csrf
            <div class="mb-3">
                <label for="msisdn" class="form-label">MSISDN (Phone Number)</label>
                <input type="text" name="msisdn" id="msisdn" class="form-control" placeholder="26097XXXXXXX" required>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Amount (ZMW)</label>
                <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Submit Cash Out</button>
        </form>
    </div>
</div>

</body>
</html>
