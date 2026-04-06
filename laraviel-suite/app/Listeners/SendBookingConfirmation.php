<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Mail\SendReceipt;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmation implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'emails';

    /**
     * Handle the event.
     */
    public function handle(BookingCreated $event): void
    {
        try {
            Mail::to($event->guest->email)->send(new SendReceipt($event->validatedData));
            Log::channel('api')->info('Booking confirmation email sent', [
                'guest_email' => $event->guest->email,
                'booking_id'  => $event->guest->booking_id,
            ]);
        } catch (\Exception $e) {
            Log::channel('api')->error('Failed to send booking confirmation email', [
                'guest_email' => $event->guest->email,
                'error'       => $e->getMessage(),
            ]);
            $this->fail($e);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(BookingCreated $event, \Throwable $exception): void
    {
        Log::channel('api')->error('SendBookingConfirmation listener failed permanently', [
            'booking_id' => $event->guest->booking_id,
            'error'      => $exception->getMessage(),
        ]);
    }
}
