<?php

namespace App\Events;

use App\Models\Guest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Guest $guest;
    public array $validatedData;

    /**
     * Create a new event instance.
     */
    public function __construct(Guest $guest, array $validatedData)
    {
        $this->guest = $guest;
        $this->validatedData = $validatedData;
    }
}
