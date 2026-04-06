<?php

namespace App\Providers;

use App\Events\BookingCreated;
use App\Listeners\SendBookingConfirmation;
use App\Listeners\UpdateRoomAvailability;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ── Event Listeners (Queue-based) ──────────────────────────────────
        Event::listen(BookingCreated::class, SendBookingConfirmation::class);
        Event::listen(BookingCreated::class, UpdateRoomAvailability::class);

        // ── API Rate Limiting ──────────────────────────────────────────────
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(100)->by(
                $request->user()?->id ?: $request->ip()
            );
        });
    }
}
