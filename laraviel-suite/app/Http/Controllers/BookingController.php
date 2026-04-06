<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Service; // Don't forget to include the Service model

class BookingController extends Controller
{
    public function showBooking(Request $request)
    {
        // Get the booking ID from the query parameter
        $bookingId = $request->query('bookingId'); // Get bookingId from the URL query string

        // Check if bookingId is empty
        if (empty($bookingId)) {
            // Use the password from the session if bookingId is empty
            $bookingId = session('password');
        }

        // Fetch the guest details using the booking ID
        $guest = Guest::where('booking_id', $bookingId)->first();
        $avail = Guest::where('booking_id', $bookingId)->with('services')->first();

        // Fetch all services
        $services = Service::all(); // Retrieve all services from the 'services' table

        // Return the view with both guest details and the services
        if ($guest) {
            return view('categories.view_booking', compact('guest', 'services', 'avail'));
        } else {
            $guest = (object) ['booking_id' => 404]; // Create a guest object with 404 as the booking ID
            return view('categories.view_booking', compact('guest', 'services'));
        }
    }
}
