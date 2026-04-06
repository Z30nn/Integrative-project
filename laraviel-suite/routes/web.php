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


Route::get('/', function () {
    $feedbacks = Feedback::latest()->take(10)->get();
    return view('categories.index', compact('feedbacks'));
})->name('landing');

// Define routes for your views
Route::view('/accommodation', 'categories.accommodation');
Route::view('/offers', 'categories.offers')->name('offers');
Route::view('/about', 'categories.about');
Route::view('/book-now', 'categories.book-now');


Route::get('/api/room-prices', [RoomPriceController::class, 'getRoomPrices']);
Route::get('/api/room-prices/{roomType}', function ($roomType) {
    $roomPrice = RoomPrices::where('room_type', $roomType)->first();

    if ($roomPrice) {
        return response()->json([
            'price' => $roomPrice->price,
            'id' => $roomPrice->id
        ]);
    }

    return response()->json(['message' => 'Room type not found'], 404);
});

Route::view('/privacy-policy', 'categories.privacy-policy');
Route::get('/view-booking', [BookingController::class, 'showBooking'])->name('view-booking');
Route::post('/add-income', [IncomeTrackerController::class, 'addincome'])->name('add-income');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
// Route for rooms
Route::get('/rooms', [RoomController::class, 'index']);
Route::post('/submit-guest-info', [GuestController::class, 'store']);

Route::post('/services/submit', [ServiceController::class, 'submit'])->name('services.submit');

// ── Protected Admin/Cashier Routes ──────────────────────────────────────
Route::middleware(['auth', 'roletype:admin,cashier'])->group(function () {

    // Guest management
    Route::put('/guest/{id}/{booking_id}', [GuestController::class, 'update'])->name('guest.update');
    Route::delete('/guest/{id}', [GuestController::class, 'destroy'])->name('guest.destroy');

    // Room management
    Route::get('/room/{id}/edit', [RoomController::class, 'edit'])->name('room.edit');
    Route::put('/room/{id}', [RoomController::class, 'update'])->name('room.update');
    Route::post('/rooms', [RoomController::class, 'store'])->name('room.store');
    Route::delete('/room/{id}', [RoomController::class, 'destroy'])->name('room.destroy');

    // Service management
    Route::post('/mark-as-paid/{id}/{booking_id}', [ServiceController::class, 'markAsPaid'])->name('mark.as.paid');
    Route::delete('/service/{service_id}', [ServiceController::class, 'destroy'])->name('service.destroy');
    Route::post('/refund/{id}', [ServiceController::class, 'refund'])->name('service.refund');
    Route::put('/service-update/{id}', [ServiceController::class, 'update'])->name('service.update');
    Route::delete('/service-delete/{id}', [ServiceController::class, 'delete'])->name('service.delete');

    // Room service
    Route::post('create-room-service', [RoomServiceController::class,'createRoomService'])->name('room.create');

    // Stats API for real-time updates
    Route::get('/api/dashboard-stats', function() {
        $availedIncome = AvailedService::where('payment_status', 'paid')->sum('total_price');
        $trackerIncome = IncomeTracker::sum('price');
        $totalIncome = max($trackerIncome, $availedIncome);

        return response()->json([
            'totalTransactions' => AvailedService::count(),
            'pendingPayments' => AvailedService::where('payment_status', 'pending')->count(),
            'paidToday' => AvailedService::where('payment_status', 'paid')
                                        ->whereDate('updated_at', \Carbon\Carbon::today())
                                        ->count(),
            'totalIncome' => $totalIncome
        ]);
    })->name('api.stats');

    // Revenue Analytics API
    Route::get('/api/revenue-chart', function() {
        $labels = [];
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = \Carbon\Carbon::today()->subDays($i);
            $labels[] = $date->format('M d');
            
            // Sum from both sources for robustness during transition
            $dailyTracker = IncomeTracker::whereDate('created_at', $date)->sum('price');
            $dailyAvailed = AvailedService::where('payment_status', 'paid')
                                        ->whereDate('updated_at', $date)
                                        ->sum('total_price');
            
            $data[] = max($dailyTracker, $dailyAvailed);
        }
        return response()->json(['labels' => $labels, 'data' => $data]);
    })->name('api.revenue.chart');
});

// Admin-specific routes
Route::get('/admin', function(Request $request) {
   
    $rooms = Room::all();
    $guests = Guest::paginate(10);
    $totalRooms = Room::count();
    $totalGuests = Guest::count();

    $search = $request->input('search');

    // Query guests with optional search filter
    $guests = Guest::when($search, function ($query, $search) {
        return $query->where('lastname', 'like', "%{$search}%")
                     ->orWhere('email', 'like', "%{$search}%")
                     ->orWhere('booking_id', 'like', "%{$search}%");
    })->paginate(10);

    $totalGuestPayments = IncomeTracker::sum('price');
    $roomServices = Service::all();

    // Get room types that are currently booked (check_out is today or future)
    $bookedRoomTypes = Guest::where('check_out', '>=', now()->toDateString())
        ->pluck('booked_rooms')
        ->flatMap(fn($rooms) => collect(explode(',', $rooms))->map(fn($r) => trim($r)))
        ->filter()
        ->unique()
        ->toArray();

    return view('categories.admincit301_laraviel_suite', compact('rooms', 'guests', 'totalRooms', 'totalGuests', 'totalGuestPayments', 'roomServices', 'bookedRoomTypes'));
})->middleware(['auth', 'verified', 'roletype:admin'])->name('admin');

Route::get('/cashier', function (Request $request) {
    $search = $request->input('booking_id'); // Input for search
    $paymentStatus = $request->input('payment_status'); // Input for payment status

    $totalTransactions = AvailedService::count();
    $pendingPayments = AvailedService::where('payment_status', 'pending')->count();
    $paidToday = AvailedService::where('payment_status', 'paid')
                                ->whereDate('updated_at', \Carbon\Carbon::today())
                                ->count();

    $availed_services = AvailedService::when($search, function ($query, $search) {
        return $query->where('booking_id', 'like', "%{$search}%")
                     ->orWhere('guest_name', 'like', "%{$search}%");
    })
    ->when($paymentStatus, function ($query, $paymentStatus) {
        return $query->where('payment_status', $paymentStatus);
    })
    ->paginate(5);

    $incomeTracker = IncomeTracker::orderBy('created_at', 'desc')->paginate(10);
    $totalIncome = max(IncomeTracker::sum('price'), AvailedService::where('payment_status', 'paid')->sum('total_price'));

    return view('categories.cashier', compact('availed_services', 'incomeTracker', 'totalTransactions', 'pendingPayments', 'paidToday', 'totalIncome'));
})->middleware(['auth', 'verified', 'roletype:cashier'])->name('cashier');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';