<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Service;

class BookingController extends Controller
{
    public function showBooking(Request $request)
    {
        // 1. Get the booking ID from the URL query or Request Header
        // We REMOVED session('password') because REST APIs must be stateless.
        $bookingId = $request->query('bookingId'); 

        if (empty($bookingId)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Booking ID is required.'
            ], 400);
        }

        // 2. Fetch guest details with relationships (Eager Loading)
        $guest = Guest::where('booking_id', $bookingId)->with('services')->first();

        // 3. Handle "Not Found" with a proper API Status Code
        if (!$guest) {
            return response()->json([
                'status' => 'error',
                'message' => 'Booking not found.',
                'booking_id' => $bookingId
            ], 404);
        }

        // 4. Return JSON Data instead of a View
        // This allows the same data to be used by a Website or a Mobile App.
        return response()->json([
            'status' => 'success',
            'data' => [
                'guest_info' => $guest,
                'available_services' => Service::all()
            ]
        ], 200);
    }
}