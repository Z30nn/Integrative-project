<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\RoomApiController;
use App\Http\Controllers\Api\GuestApiController;
use App\Http\Controllers\Api\ServiceApiController;
use App\Http\Controllers\Api\DashboardApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — LARAVEIL SUITES
|--------------------------------------------------------------------------
| RESTful API with JWT Authentication
|
| Auth endpoints: /api/v1/auth/*
| Protected endpoints require: Authorization: Bearer {token}
*/

Route::prefix('v1')->group(function () {

    // ── Auth (public) ────────────────────────────────────────────────────
    Route::prefix('auth')->name('api.auth.')->group(function () {
        Route::post('/login',   [AuthApiController::class, 'login'])->name('login');
        Route::post('/logout',  [AuthApiController::class, 'logout'])->middleware('auth:api')->name('logout');
        Route::post('/refresh', [AuthApiController::class, 'refresh'])->middleware('auth:api')->name('refresh');
        Route::get('/me',       [AuthApiController::class, 'me'])->middleware('auth:api')->name('me');
    });

    // ── Protected Routes (JWT required) ──────────────────────────────────
    Route::middleware(['auth:api', 'api.log'])->group(function () {

        // Rooms (admin: all, others: GET only)
        Route::get('/rooms',       [RoomApiController::class, 'index'])->name('api.rooms.index');
        Route::get('/rooms/{id}',  [RoomApiController::class, 'show'])->name('api.rooms.show');

        Route::middleware('role.api:admin')->group(function () {
            Route::post('/rooms',         [RoomApiController::class, 'store'])->name('api.rooms.store');
            Route::put('/rooms/{id}',     [RoomApiController::class, 'update'])->name('api.rooms.update');
            Route::delete('/rooms/{id}',  [RoomApiController::class, 'destroy'])->name('api.rooms.destroy');
        });

        // Guests
        Route::get('/guests',       [GuestApiController::class, 'index'])->middleware('role.api:admin,cashier')->name('api.guests.index');
        Route::get('/guests/{id}',  [GuestApiController::class, 'show'])->middleware('role.api:admin,cashier')->name('api.guests.show');
        Route::post('/guests',      [GuestApiController::class, 'store'])->middleware('role.api:admin,cashier')->name('api.guests.store');
        Route::put('/guests/{id}',  [GuestApiController::class, 'update'])->middleware('role.api:admin,cashier')->name('api.guests.update');
        Route::delete('/guests/{id}', [GuestApiController::class, 'destroy'])->middleware('role.api:admin')->name('api.guests.destroy');

        // Services
        Route::get('/services',           [ServiceApiController::class, 'index'])->name('api.services.index');
        Route::get('/services/{id}',      [ServiceApiController::class, 'show'])->name('api.services.show');
        Route::get('/availed-services',   [ServiceApiController::class, 'availedIndex'])->name('api.availed.index');
        Route::post('/availed-services/{id}/mark-paid', [ServiceApiController::class, 'markPaid'])
            ->middleware('role.api:cashier,admin')
            ->name('api.availed.markpaid');

        // Dashboard / Monitoring
        Route::get('/dashboard', [DashboardApiController::class, 'index'])
            ->middleware('role.api:admin')
            ->name('api.dashboard');

        Route::get('/cashier-stats', [DashboardApiController::class, 'cashierIndex'])
            ->middleware('role.api:cashier,admin')
            ->name('api.cashier.stats');
    });
});
