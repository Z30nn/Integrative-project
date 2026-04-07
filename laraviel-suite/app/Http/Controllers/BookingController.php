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

        $services = Service::all(); // Available services for the portal

        // Stateless API behavior: return proper HTTP codes when client expects JSON.
        $expectsJson = $request->expectsJson();
        if (empty($bookingId)) {
            if ($expectsJson) {
                return response()->json([
                    'success' => false,
                    'message' => 'bookingId is required.',
                    'availableServices' => $services,
                ], 400);
            }

            // For normal web requests, fall back to the "not found" view state.
            $guest = (object) ['booking_id' => 404];
            return view('categories.view_booking', compact('guest', 'services'));
        }

        // Fetch guest details and eager-load nested service data for the Blade view.
        // Blade uses: $guest->services as $service -> $service->service->service_name
        $guest = Guest::with('services.service')
            ->where('booking_id', $bookingId)
            ->first();

        if ($guest) {
            if ($expectsJson) {
                return response()->json([
                    'success' => true,
                    'message' => 'Guest portal data found.',
                    'data' => [
                        'guest' => $guest,
                        'availedServices' => $guest->services,
                        'availableServices' => $services,
                    ],
                ], 200);
            }

            return view('categories.view_booking', compact('guest', 'services'));
        }

        if ($expectsJson) {
            return response()->json([
                'success' => false,
                'message' => 'Sanctuary not found for the given bookingId.',
                'availableServices' => $services,
            ], 404);
        }

        $guest = (object) ['booking_id' => 404]; // Create a guest object with 404 as the booking ID
        return view('categories.view_booking', compact('guest', 'services'));
    }
}
