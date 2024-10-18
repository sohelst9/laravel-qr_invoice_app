<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            padding: 20px;
        }
        .invoice {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .qr-code {
            width: 100px; /* Adjust as needed */
            height: 100px; /* Adjust as needed */
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="mb-4">User Invoice</h1>
    <a href="{{ route('users') }}" class="btn btn-secondary mb-3">Back to User List</a>
    
    <div class="invoice">
        <h3>User Information</h3>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>User ID:</strong> {{ $user->unique_id }}</p>
        <p><strong>User Number:</strong> {{ $user->phone }}</p>
        <p><strong>Bio Info:</strong> {{ $user->biodata }}</p>
        <p><strong>Status:</strong> {{ $user->status }}</p>
        
        <h3 class="mt-4">QR Code</h3>
        {!! $qrCode !!}
        <!-- Replace 'path/to/qr-code.png' with the actual path to your QR code image -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
