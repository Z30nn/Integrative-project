<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation | LARAVEIL SUITES</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #1a1410;
            margin: 0;
            padding: 0;
            color: #f2e3d5;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #241c16;
            border: 1px solid #d4af37;
            border-radius: 4px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        .email-header {
            text-align: center;
            background-color: #1a1410;
            padding: 30px;
            border-bottom: 1px solid #d4af37;
        }

        .email-header h1 {
            font-size: 20px;
            margin: 0;
            color: #d4af37;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .email-content {
            padding: 40px;
            line-height: 1.8;
            color: #e0d0c1;
        }

        .email-content h2 {
            color: #d4af37;
            font-size: 18px;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 10px;
            margin-top: 30px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .details-table td {
            padding: 10px 0;
            border-bottom: 1px solid rgba(212, 175, 55, 0.1);
        }

        .details-table td:first-child {
            font-weight: bold;
            color: #d4af37;
            width: 40%;
        }

        .footer {
            background-color: #1a1410;
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #d4af37;
        }

        .button {
            display: block;
            width: fit-content;
            background-color: #d4af37;
            color: #1a1410 !important;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 4px;
            margin: 30px auto 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
        }

        .button:hover {
            background-color: #f1c94f;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Laraveil Suites</h1>
        </div>
        
        <div class="email-content">
            <p>Dear {{ $guest['firstname'] }} {{ $guest['lastname'] }},</p>
            <p>Thank you for choosing LARAVEIL SUITES. Your reservation has been successfully received. Below are the details of your stay.</p>
            
            <h2>Reservation Details</h2>
            <table class="details-table">
                <tr>
                    <td>Booking ID</td>
                    <td>{{ $guest['bookingId'] }}</td>
                </tr>
                <tr>
                    <td>Check-in Date</td>
                    <td>{{ $guest['checkIn'] }}</td>
                </tr>
                <tr>
                    <td>Check-out Date</td>
                    <td>{{ $guest['checkOut'] }}</td>
                </tr>
                <tr>
                    <td>Reserved Suites</td>
                    <td>{{ $guest['bookedRooms'] }}</td>
                </tr>
                <tr>
                    <td>Total Investment</td>
                    <td>₱{{ number_format($guest['priceTotal'], 2) }}</td>
                </tr>
            </table>

            <h2>Guest Portal Access</h2>
            <p>You can manage your reservation, view your balance, and explore room services through our exclusive Guest Portal using the credentials below:</p>
            <table class="details-table">
                <tr>
                    <td>Email Address</td>
                    <td>{{ $guest['email'] }}</td>
                </tr>
                <tr>
                    <td>Secure Password</td>
                    <td>{{ $guest['bookingId'] }}</td>
                </tr>
            </table>

            <a href="{{ env('APP_URL') . '/view-booking?bookingId=' . $guest['bookingId'] }}" class="button">Access Guest Portal</a>
        </div>

        <div class="footer">
            <p>Experience unparalleled sophistication at the heart of the city.</p>
            <p>&copy; {{ date('Y') }} LARAVEIL SUITES. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
