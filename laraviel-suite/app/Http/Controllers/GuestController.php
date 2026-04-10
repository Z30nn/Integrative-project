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
use App\Services\ErpInvoicingService;

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

        // Populate homegrown ERP invoices/payments (non-breaking, guarded by table checks).
        ErpInvoicingService::syncInvoiceForGuest($guest);

        User::firstOrCreate(
            ['email' => $validatedData['email']],
            [
                'name' => $validatedData['firstname'],
                'role' => 'guest',
                'password' => Hash::make($validatedData['bookingId']),
            ]
        );

        // ... (existing code: User::firstOrCreate logic)

        // 1. Check if the user chose PayMongo
        if ($rawPaymentMethod === 'paymongo') {
            $response = \Illuminate\Support\Facades\Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode(config('services.paymongo.secret_key') . ':'),
            ])->post('https://api.paymongo.com/v1/checkout_sessions', [
                'data' => [
                    'attributes' => [
                        'send_email_receipt' => true,
                        'payment_method_types' => ['gcash', 'paymaya', 'card'],
                        'line_items' => [[
                            'currency' => 'PHP',
                            'amount' => (int)($validatedData['priceTotal'] * 100), // Convert to cents
                            'description' => 'Sanctuary Reservation - ' . $validatedData['bookingId'],
                            'name' => 'Room Booking',
                            'quantity' => 1,
                        ]],
                        'success_url' => route('payment.success', ['bookingId' => $validatedData['bookingId']]),
                        'cancel_url' => url()->previous(),
                    ]
                ]
            ]);

            $session = $response->json();

            if (isset($session['data']['attributes']['checkout_url'])) {
                // Exit here for PayMongo - we don't send the email yet!
                return response()->json([
                    'success' => true,
                    'redirect_url' => $session['data']['attributes']['checkout_url'],
                ], 200);
            }
        }

        // 2. Flow for "Pay at Counter" (This only runs if NOT PayMongo)
        session(['password' => $validatedData['bookingId']]);

        $mailSent = false;
        try {
            // We send the email immediately because they aren't going to a payment gateway
            Mail::to($guest->email)->send(new SendReceipt($validatedData));
            $mailSent = true;
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Booking confirmation email failed', [
                'message' => $e->getMessage(),
                'guest_email' => $guest->email,
            ]);
        }

        // Final Return for non-PayMongo users
        return response()->json([
            'message' => 'Guest information submitted successfully.',
            'mail_sent' => $mailSent,
            'data' => $guest,
        ], 201);
    } // End of store function
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

        // Keep ERP invoice totals in sync with updated guest pricing.
        ErpInvoicingService::syncInvoiceForGuest($guest);
    
        return redirect()->back()->with('guestAlert', 'Guest information updated successfully.');
    }

        public function paymentSuccess(Request $request)
        {
            $bookingId = $request->query('bookingId');    
            $guest = Guest::where('booking_id', $bookingId)->firstOrFail();

            // 1. Mark as paid in your DB
            $guest->update(['payment_status' => 'paid']);

            // 2. Add to Income Tracker (since it's now officially 'paid')
            IncomeTracker::create([
                'customer_name' => $guest->firstname . ' ' . $guest->lastname,
                'price' => $guest->price_total,
                'availed_service' => 'Room Booking',
                'booking_id' => $guest->booking_id,
            ]);

            // 3. Send the Gmail now that the money is confirmed
            // Note: We use the guest data for the receipt
            Mail::to($guest->email)->send(new SendReceipt($guest->toArray()));

            // 4. Show a nice "Thank You" view
            return view('categories.book-now', [
                    'guest' => $guest, 
                    'paymentSuccess' => true
                ]);
        }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $guest = Guest::findOrFail($id);
            $bookingId = $guest->booking_id;

            // Clean up ERP records first (best-effort).
            ErpInvoicingService::deleteInvoiceForBooking($bookingId);
            
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
