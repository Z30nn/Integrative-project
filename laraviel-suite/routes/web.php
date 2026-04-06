<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\IncomeTrackerController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\RoomServiceController;
use App\Http\Controllers\RoomPriceController;
use App\Models\AvailedService;
use Illuminate\Support\Facades\Route;
use App\Models\Room;
use App\Models\Guest;
use App\Models\Feedback;
use App\Models\IncomeTracker;
use App\Models\RoomPrices;
use Illuminate\Http\Request;
use App\Models\Service;

/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Lobby)
|--------------------------------------------------------------------------
| Anyone can access these. No middleware needed.
*/
Route::get('/', function () {
    $feedbacks = Feedback::latest()->take(10)->get();
    return view('categories.index', compact('feedbacks'));
})->name('landing');

Route::view('/accommodation', 'categories.accommodation');
Route::view('/offers', 'categories.offers')->name('offers');
Route::view('/about', 'categories.about');
Route::view('/book-now', 'categories.book-now');
Route::view('/privacy-policy', 'categories.privacy-policy');

// Public API and Booking Actions
Route::get('/api/room-prices', [RoomPriceController::class, 'getRoomPrices']);
Route::get('/api/room-prices/{roomType}', function ($roomType) {
    $roomPrice = RoomPrices::where('room_type', $roomType)->first();
    return $roomPrice ? response()->json(['price' => $roomPrice->price, 'id' => $roomPrice->id]) 
                      : response()->json(['message' => 'Room type not found'], 404);
});

Route::get('/view-booking', [BookingController::class, 'showBooking'])->name('view-booking');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
Route::get('/rooms', [RoomController::class, 'index']);
Route::post('/submit-guest-info', [GuestController::class, 'store']);
Route::post('/services/submit', [ServiceController::class, 'submit'])->name('services.submit');

/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATED USER ROUTES (General Access)
|--------------------------------------------------------------------------
| Requires login, but works for Admin, Cashier, and Registered Guests.
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| 3. CASHIER ONLY AREA (The Front Desk)
|--------------------------------------------------------------------------
| Only staff with 'cashier' role can process money and check-ins.
*/
Route::middleware(['auth', 'verified', 'roletype:cashier'])->group(function () {
    
    // *** REARRANGED: This is the logic you had in a raw Closure, now protected ***
    Route::get('/cashier', function (Request $request) {
        $search = $request->input('booking_id');
        $paymentStatus = $request->input('payment_status');
        $availed_services = AvailedService::when($search, function ($query, $search) {
            return $query->where('booking_id', 'like', "%{$search}%")->orWhere('guest_name', 'like', "%{$search}%");
        })->when($paymentStatus, function ($query, $paymentStatus) {
            return $query->where('payment_status', $paymentStatus);
        })->paginate(5);
        $incomeTracker = IncomeTracker::paginate(10);
        return view('categories.cashier', compact('availed_services', 'incomeTracker'));
    })->name('cashier');

    // *** REARRANGED: Financial operations moved here for security ***
    Route::post('/mark-as-paid/{id}/{booking_id}', [ServiceController::class, 'markAsPaid'])->name('mark.as.paid');
    Route::post('/add-income', [IncomeTrackerController::class, 'addincome'])->name('add-income');
    Route::post('/refund/{id}', [ServiceController::class, 'refund'])->name('service.refund');
});

/*
|--------------------------------------------------------------------------
| 4. ADMIN ONLY AREA (The Back Office)
|--------------------------------------------------------------------------
| High-level management: deleting data and system settings.
*/
Route::middleware(['auth', 'verified', 'roletype:admin'])->group(function () {
    
    // *** REARRANGED: Main Admin Dashboard logic ***
    Route::get('/admin', function(Request $request) {
        $rooms = Room::all();
        $totalRooms = Room::count();
        $totalGuests = Guest::count();
        $search = $request->input('search');
        $guests = Guest::when($search, function ($query, $search) {
            return $query->where('lastname', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")->orWhere('booking_id', 'like', "%{$search}%");
        })->paginate(10);
        $totalGuestPayments = IncomeTracker::sum('price');
        $incomeTracker = IncomeTracker::paginate(10);
        $roomServices = Service::all();
        return view('categories.admincit301_laraviel_suite', compact('rooms', 'guests', 'totalRooms', 'totalGuests', 'totalGuestPayments', 'incomeTracker', 'roomServices'));
    })->name('admin');

    // *** REARRANGED: Dangerous CRUD operations moved here ***
    Route::delete('/guest/{id}', [GuestController::class, 'destroy'])->name('guest.destroy');
    Route::delete('/room/{id}', [RoomController::class, 'destroy'])->name('room.destroy');
    Route::delete('/service/{service_id}', [ServiceController::class, 'destroy'])->name('service.destroy');
    Route::delete('/service-delete/{id}', [ServiceController::class, 'delete'])->name('service.delete');
    
    Route::get('/room/{id}/edit', [RoomController::class, 'edit'])->name('room.edit');
    Route::put('/room/{id}', [RoomController::class, 'update'])->name('room.update');
    Route::post('/rooms', [RoomController::class, 'store'])->name('room.store');
    Route::put('/guest/{id}/{booking_id}', [GuestController::class, 'update'])->name('guest.update');
    Route::put('/service-update/{id}', [ServiceController::class, 'update'])->name('service.update');
    Route::post('create-room-service', [RoomServiceController::class,'createRoomService'])->name('room.create');
});

require __DIR__.'/auth.php';