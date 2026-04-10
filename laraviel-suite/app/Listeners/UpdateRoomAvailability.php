<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Models\Room;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateRoomAvailability implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'default';

    /**
     * Handle the event.
     */
    public function handle(BookingCreated $event): void
    {
        $bookedRooms = explode(',', $event->guest->booked_rooms);

        foreach ($bookedRooms as $roomType) {
            $roomType = trim($roomType);
            if (empty($roomType)) {
                continue;
            }

            // Mark matching rooms as occupied
            $room = Room::where('room_type', 'like', "%{$roomType}%")
                ->where('availability', 'Available')
                ->first();

            if ($room) {
                $room->update(['availability' => 'Occupied']);
                Log::channel('api')->info('Room marked as occupied', [
                    'room_id'    => $room->id,
                    'room_type'  => $roomType,
                    'booking_id' => $event->guest->booking_id,
                ]);
            }
        }
    }
}
