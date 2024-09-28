<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Rental Details - MoveOn</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #555;
        }
        .car-details {
            font-size: 18px;
            color: #000;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #999;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $customerName }} Your Rental Details</h1>
        <p>Thank you for renting with <strong>MoveOn</strong>!</p>
        <p class="car-details">
            <strong>Car:</strong> {{ $rental->car->name }}<br>
            <strong>From:</strong> {{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/Y') }}<br>
            <strong>To:</strong> {{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/Y') }}<br>
            <strong>Status:</strong> {{ $status }}<br>
            <strong>Total Cost:</strong> ৳{{ $total_cost }}<br>
            
        </p>
        <div class="footer">
            <p>If you have any questions, feel free to contact us.</p>
        </div>
    </div>
</body>
</html>