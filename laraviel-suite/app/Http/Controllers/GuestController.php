<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use App\Models\IncomeTracker;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendReceipt;  // Use your SendReceipt Mailable
use App\Models\Feedback;
use App\Models\User;
use App\Models\AvailedService;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedbacks = Feedback::with('guest')->latest()->take(10)->get();
        return view('categories.index', compact('feedbacks'));
    }

    public function totalCustomer() {
        $totalGuest = Guest::count(); // Count total number of guests
        return view('categories.admincit301_laraviel_suite', compact('totalGuest')); // Pass the totalGuest to the view
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bookingId' => 'required|string|unique:guests,booking_id|max:50',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'salutation' => 'nullable|string|max:50',
            'birthdate' => 'nullable|date',
            'gender' => 'nullable|string|max:10',
            'guestCount' => 'nullable|integer',
            'discountOption' => 'nullable|string',
            'email' => 'required|email',
            'contactNumber' => 'required|string|max:20',
            'address' => 'required|string',
            'checkIn' => 'required|date',
            'checkOut' => 'required|date',
            'bookedRooms' => 'required|string',
            'priceTotal' => 'required|numeric',
            'paymentMethod' => 'nullable|string',
            'paymentStatus' => 'nullable|string',
        ]);

        $rawPaymentMethod = $request->input('paymentMethod', 'over_the_counter');
        // Map JS payment methods to DB-compatible values
        $paymentMethod = ($rawPaymentMethod === 'over_the_counter') ? 'over_the_counter' : 'online_payment';
        $paymentStatus = $request->input('paymentStatus', 'pending');
        $guestCount = $request->input('guestCount', 1);
        $discountOption = $request->input('discountOption');

        // Save the data into the database
        $guest = Guest::create([
            'booking_id' => $validatedData['bookingId'],
            'lastname' => $validatedData['lastname'],
            'firstname' => $validatedData['firstname'],
            'salutation' => $validatedData['salutation'] ?? null,
            'birthdate' => $validatedData['birthdate'] ?? null,
            'gender' => $validatedData['gender'] ?? null,
            'guest_count' => $guestCount,
            'discount_option' => $discountOption,
            'email' => $validatedData['email'],
            'contact_number' => $validatedData['contactNumber'],
            'address' => $validatedData['address'],
            'check_in' => $validatedData['checkIn'],
            'check_out' => $validatedData['checkOut'],
            'booked_rooms' => $validatedData['bookedRooms'],
            'price_total' => $validatedData['priceTotal'],
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentStatus,
        ]);

        AvailedService::create([
            'booking_id' => $validatedData['bookingId'],
            'guest_name' => $validatedData['firstname'] . ' ' . $validatedData['lastname'],
            'service_id' => 0, // 0 for Room Booking
            'service_date' => $validatedData['checkIn'],
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentStatus,
            'total_price' => $validatedData['priceTotal'],
        ]);

        if ($paymentStatus === 'paid') {
            IncomeTracker::create([
                'customer_name' => $validatedData['firstname'] . ' ' . $validatedData['lastname'],
                'price' => $validatedData['priceTotal'],
                'availed_service' => 'Room Booking',
                'booking_id' => $validatedData['bookingId'],
            ]);
        }

        User::firstOrCreate(
            ['email' => $validatedData['email']],
            [
                'name' => $validatedData['firstname'],
                'role' => 'guest',
                'password' => Hash::make($validatedData['bookingId']),
            ]
        );

        session(['password' => $validatedData['bookingId']]);
        
        // Send the booking confirmation email using SendReceipt
        try {
            Mail::to($guest->email)->send(new SendReceipt($validatedData));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Email failed: ' . $e->getMessage());
        }

        return response()->json(['message' => 'Guest information submitted successfully.', 'data' => $guest], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $booking_id)
    {
        $guest = Guest::findOrFail($id);
    
        // Validate input
        $validatedData = $request->validate([
            'lastname' => 'required|string|max:255',
            'contact_number' => 'required|string|max:25',
            'email' => 'required|email',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            'standard_v1' => 'nullable|integer|min:0',
            'standard_v2' => 'nullable|integer|min:0',
            'standard_v3' => 'nullable|integer|min:0',
            'deluxe_v1' => 'nullable|integer|min:0',
            'deluxe_v2' => 'nullable|integer|min:0',
            'deluxe_v3' => 'nullable|integer|min:0',
            'luxury_v1' => 'nullable|integer|min:0',
            'luxury_v2' => 'nullable|integer|min:0',
            'luxury_v3' => 'nullable|integer|min:0',
            'price_total' => 'required|numeric',
        ]);
    
        // Generate the booked rooms string
        $bookedRooms = [];
        foreach (['Standard', 'Deluxe', 'Luxury'] as $roomType) {
            foreach (['v1', 'v2', 'v3'] as $subtype) {
                $field = strtolower($roomType) . '_' . $subtype;
                $count = $request->input($field, 0);
                if ($count > 0) {
                    $bookedRooms = array_merge($bookedRooms, array_fill(0, (int)$count, $roomType . ' ' . strtoupper($subtype)));
                }
            }
        }
    
        $bookedRoomsString = implode(',', $bookedRooms);
    
        // Update guest data
        $guest->update([
            'lastname' => $validatedData['lastname'],
            'contact_number' => $validatedData['contact_number'],
            'email' => $validatedData['email'],
            'discount_option' => $request->input('discount_options', $guest->discount_option),
            'booked_rooms' => $bookedRoomsString,
            'check_in' => $validatedData['check_in'],
            'check_out' => $validatedData['check_out'],
            'price_total' => $validatedData['price_total'],
        ]);
    
        // Update corresponding AvailedService (Room Booking entry)
        $availedService = AvailedService::where('booking_id', $booking_id)
            ->where('service_id', 0)
            ->first();
        if ($availedService) {
            $availedService->update([
                'total_price' => $validatedData['price_total'],
            ]);
        }
    
        // Update IncomeTracker record
        $incomeTracker = IncomeTracker::where('booking_id', $booking_id)->first();
        if ($incomeTracker) {
            $incomeTracker->update([
                'customer_name' => $validatedData['lastname'],
                'price' => $validatedData['price_total'],
            ]);
        } else {
            IncomeTracker::create([
                'booking_id' => $booking_id,
                'customer_name' => $validatedData['lastname'],
                'availed_service' => 'Room Booking',
                'price' => $validatedData['price_total'],
            ]);
        }
    
        return redirect()->back()->with('guestAlert', 'Guest information updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $guest = Guest::findOrFail($id);
            $bookingId = $guest->booking_id;
            
            // Clean up related history
            AvailedService::where('booking_id', $bookingId)->delete();
            IncomeTracker::where('booking_id', $bookingId)->delete();
            Feedback::where('guest_id', $id)->delete();
            
            $guest->delete();
            return redirect()->back()->with('guestAlert', 'Guest and related history deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting guest: ' . $e->getMessage());
        }
    }
}
