<?php

namespace App\Http\Controllers\Api;

use App\Events\BookingCreated;
use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\IncomeTracker;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuestApiController extends Controller
{
    /**
     * GET /api/v1/guests
     * List guests with search/pagination. (Admin only)
     */
    public function index(Request $request): JsonResponse
    {
        $query = Guest::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('lastname', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('booking_id', 'like', "%{$search}%");
            });
        }

        $guests = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data'    => $guests,
        ]);
    }

    /**
     * GET /api/v1/guests/{id}
     */
    public function show(int $id): JsonResponse
    {
        $guest = Guest::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $guest,
        ]);
    }

    /**
     * POST /api/v1/guests
     * Create a guest booking and fire BookingCreated event.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'bookingId'      => 'required|string|unique:guests,booking_id|max:50',
            'lastname'       => 'required|string|max:255',
            'firstname'      => 'required|string|max:255',
            'salutation'     => 'nullable|string|max:50',
            'birthdate'      => 'nullable|date',
            'gender'         => 'nullable|string|max:10',
            'guestCount'     => 'required|integer|min:1',
            'discountOption' => 'nullable|string',
            'email'          => 'required|email',
            'contactNumber'  => 'required|string|max:20',
            'address'        => 'required|string',
            'checkIn'        => 'required|date',
            'checkOut'       => 'required|date|after:checkIn',
            'bookedRooms'    => 'required|string',
            'priceTotal'     => 'required|numeric|min:0',
        ]);

        $guest = Guest::create([
            'booking_id'     => $validated['bookingId'],
            'lastname'       => $validated['lastname'],
            'firstname'      => $validated['firstname'],
            'salutation'     => $validated['salutation'] ?? null,
            'birthdate'      => $validated['birthdate'] ?? null,
            'gender'         => $validated['gender'] ?? null,
            'guest_count'    => $validated['guestCount'],
            'discount_option'=> $validated['discountOption'] ?? null,
            'email'          => $validated['email'],
            'contact_number' => $validated['contactNumber'],
            'address'        => $validated['address'],
            'check_in'       => $validated['checkIn'],
            'check_out'      => $validated['checkOut'],
            'booked_rooms'   => $validated['bookedRooms'],
            'price_total'    => $validated['priceTotal'],
        ]);

        IncomeTracker::create([
            'customer_name'  => $validated['firstname'] . ' ' . $validated['lastname'],
            'price'          => $validated['priceTotal'],
            'availed_service'=> 'Booking Reservation',
        ]);

        User::firstOrCreate(['email' => $validated['email']], [
            'name'     => $validated['firstname'],
            'role'     => 'guest',
            'password' => Hash::make($validated['bookingId']),
        ]);

        // Fire event — listeners handle email + room availability update via queue
        event(new BookingCreated($guest, $validated));

        ActivityLogger::log('guest.created', "Guest {$guest->booking_id} created", Guest::class, $guest->id);

        return response()->json([
            'success' => true,
            'message' => 'Booking created. Confirmation email queued.',
            'data'    => $guest,
        ], 201);
    }

    /**
     * PUT /api/v1/guests/{id}
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $guest = Guest::findOrFail($id);

        $validated = $request->validate([
            'lastname'       => 'sometimes|string|max:255',
            'contact_number' => 'sometimes|string|max:20',
            'email'          => 'sometimes|email',
            'check_in'       => 'sometimes|date',
            'check_out'      => 'sometimes|date',
            'price_total'    => 'sometimes|numeric',
        ]);

        $guest->update($validated);

        ActivityLogger::log('guest.updated', "Guest {$guest->booking_id} updated", Guest::class, $guest->id);

        return response()->json([
            'success' => true,
            'message' => 'Guest updated.',
            'data'    => $guest->fresh(),
        ]);
    }

    /**
     * DELETE /api/v1/guests/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $guest = Guest::findOrFail($id);
        $bookingId = $guest->booking_id;
        $guest->delete();

        ActivityLogger::log('guest.deleted', "Guest {$bookingId} deleted", Guest::class, $id);

        return response()->json([
            'success' => true,
            'message' => 'Guest deleted.',
        ]);
    }
}
