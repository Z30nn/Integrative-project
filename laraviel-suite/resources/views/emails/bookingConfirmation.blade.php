<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .email-container {
            width: 100%;
            background-color: #ffffff;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            text-align: center;
            color: #333;
        }

        .email-header h1 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .email-content {
            margin-top: 20px;
            line-height: 1.6;
            color: #555;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
            color: #888;
        }

        .button {
            text-decoration: none;
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Booking Confirmation</h1>
        </div>
        <p>Dear {{ $guest['firstname'] }} {{ $guest['lastname'] }},</p>
        <div class="email-content">
            <p>Thank you for booking with us! Here are your booking details:</p>
            <ul>
                <li><strong>Booking ID:</strong> {{ $guest['bookingId'] }}</li>
                <li><strong>Check-in Date:</strong> {{ $guest['checkIn'] }}</li>
                <li><strong>Check-out Date:</strong> {{ $guest['checkOut'] }}</li>
                <li><strong>Booked Rooms:</strong> {{ $guest['bookedRooms'] }}</li>
                <li><strong>Total Price:</strong> Php {{ $guest['priceTotal'] }}</li>
            </ul>
            <h2>Use this credentials to track your stay</h2>
            <p>Email Address: {{ $guest['email'] }}</p>
            <p>Password: {{ $guest['bookingId'] }}</p>
            <p>If you have any questions, feel free to contact us!</p>
            <a href="{{ env('APP_URL') . '/view-booking?bookingId=' . $guest['bookingId'] }}" class="button">View Booking</a>
        </div>

        <div class="footer">
            <p>Thank you for choosing our service.</p>
            <p>&copy; Laraveil Suit</p>
        </div>
    </div>
</body>
</html>
