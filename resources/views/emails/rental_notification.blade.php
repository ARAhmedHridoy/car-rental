<!-- resources/views/emails/rental_notification.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $customerName }} - Car Rental Notification</title>
</head>
<body>
    <h2>New Car Rental Notification</h2>
    <p>Hello Admin,</p>
    <p>{{ $customerName }} has rented a car with the following details:</p>
    <ul>
        <li><strong>Name:</strong> {{ $customerName }}</li>
        <li><strong>Email:</strong> {{ $customerEmail }}</li>
        <li><strong>Phone:</strong> {{ $customerPhone }}</li>
        <li><strong>Address:</strong> {{ $customerAddress }}</li>
        <li><strong>Car:</strong> {{ $carDetails->car->name }}</li>
        <li>
            <strong>Rental Period:</strong> 
                From: {{ \Carbon\Carbon::parse($carDetails->start_date)->format('d/m/Y') }},  
                To: {{ \Carbon\Carbon::parse($carDetails->end_date)->format('d/m/Y') }}
        </li>
        <li><strong>Status:</strong> {{ $status }}</li>
        <li><strong>Total Cost:</strong> ৳{{ $carDetails->total_cost }}</li>
    </ul>
</body>
</html>
