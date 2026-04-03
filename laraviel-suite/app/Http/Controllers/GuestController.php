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
            'guestCount' => 'required|integer',
            'discountOption' => 'nullable|string',
            'email' => 'required|email',
            'contactNumber' => 'required|string|max:20',
            'address' => 'required|string',
            'checkIn' => 'required|date',
            'checkOut' => 'required|date',
            'bookedRooms' => 'required|string',
            'priceTotal' => 'required|numeric   ',
        ]);

        // Save the data into the database
        $guest = Guest::create([
            'booking_id' => $validatedData['bookingId'],
            'lastname' => $validatedData['lastname'],
            'firstname' => $validatedData['firstname'],
            'salutation' => $validatedData['salutation'],
            'birthdate' => $validatedData['birthdate'],
            'gender' => $validatedData['gender'],
            'guest_count' => $validatedData['guestCount'],
            'discount_option' => $validatedData['discountOption'],
            'email' => $validatedData['email'],
            'contact_number' => $validatedData['contactNumber'],
            'address' => $validatedData['address'],
            'check_in' => $validatedData['checkIn'],
            'check_out' => $validatedData['checkOut'],
            'booked_rooms' => $validatedData['bookedRooms'],
            'price_total' => $validatedData['priceTotal'],
        ]);

        IncomeTracker::create([
            'customer_name' => $validatedData['firstname'] . ' ' . $validatedData['lastname'],
            'price' => $validatedData['priceTotal'],
            'availed_service' => 'Booking Reservation',
            'booking_id' => $validatedData['bookingId'],
        ]);

        User::create([
            'name' => $validatedData['firstname'],
            'email' => $validatedData['email'],
            'role' => 'guest',
            'password' => Hash::make($validatedData['bookingId']),
        ]);

        session(['password' => $validatedData['bookingId']]);
        // Send the booking confirmation email using SendReceipt
        Mail::to($guest->email)->send(new SendReceipt($validatedData));

        return response()->json(['message' => 'Guest information submitted successfully and email sent!', 'data' => $guest], 201);
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
        $request->validate([
            'lastname' => 'required|string|max:255',
            'contact_number' => 'required|string|max:15',
            'email' => 'required|email',
            'check_in' => 'required|date',
            'check_out' => 'required|date',
            // Room validations
            'standard_v1' => 'required|integer|min:0',
            'standard_v2' => 'required|integer|min:0',
            'standard_v3' => 'required|integer|min:0',
            'deluxe_v1' => 'required|integer|min:0',
            'deluxe_v2' => 'required|integer|min:0',
            'deluxe_v3' => 'required|integer|min:0',
            'luxury_v1' => 'required|integer|min:0',
            'luxury_v2' => 'required|integer|min:0',
            'luxury_v3' => 'required|integer|min:0',
        ]);
    
        // Generate the booked rooms string
        $bookedRooms = [];
        foreach (['Standard', 'Deluxe', 'Luxury'] as $roomType) {
            foreach (['v1', 'v2', 'v3'] as $subtype) {
                $field = strtolower($roomType) . '_' . $subtype;
                $count = $request->$field;
                if ($count > 0) {
                    $bookedRooms = array_merge($bookedRooms, array_fill(0, $count, $roomType . ' ' . strtoupper($subtype)));
                }
            }
        }
    
        $bookedRoomsString = implode(',', $bookedRooms);
    
        // Update guest data
        $guest->update([
            'lastname' => $request->lastname,
            'contact_number' => $request->contact_number,
            'email' => $request->email,
            'discount_option' => $request->discount_options,
            'booked_rooms' => $bookedRoomsString,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'price_total' => $request->price_total, // Ensure this is calculated as needed
        ]);

        // Find the corresponding IncomeTracker entry by booking_id
        $incomeTracker = IncomeTracker::where('booking_id', $booking_id)->first();
    
        if ($incomeTracker) {
            // Update the price in IncomeTracker based on the total price
            $incomeTracker->update([
                'price' => $request->price_total, // Assuming price_total is calculated and passed
            ]);
        } else {
            // Optionally, you could create a new IncomeTracker entry if no match is found
            IncomeTracker::create([
                'booking_id' => $request->booking_id,
                'customer_name' => $guest->lastname, // You can adjust this to match the required field
                'availed_service' => 'Room Booking', // Adjust this as needed
                'price' => $request->price_total,
            ]);
        }
    
        return redirect()->back()->with('guestAlert', 'Guest information updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guest = Guest::find($id);

        if ($guest) {
            $guest->delete();
            return redirect()->back()->with('guestAlert', 'Guest deleted successfully');
        }

        return redirect()->back()->with('error', 'Guest not found');
    }
}
