<?php

namespace App\Services;

use App\Models\AvailedService;
use App\Models\Guest;
use App\Models\IntegrationMessage;
use Illuminate\Support\Facades\Log;

class IntegrationMessageConsumer
{
    public static function consume(IntegrationMessage $message): void
    {
        $payload = (array) $message->payload;

        switch ($message->event_type) {
            case 'booking.created':
                $bookingId = (string) ($payload['booking_id'] ?? '');
                if ($bookingId === '') {
                    throw new \RuntimeException('booking_id is required for booking.created');
                }

                $guest = Guest::where('booking_id', $bookingId)->first();
                if (!$guest) {
                    throw new \RuntimeException("Guest not found for booking_id {$bookingId}");
                }

                // Idempotent sync via updateOrCreate-based ERP service.
                ErpInvoicingService::syncRoomBookingFromGuest($guest, 'paid');
                break;

            case 'service.paid':
                $availedServiceId = (int) ($payload['availed_service_id'] ?? 0);
                if ($availedServiceId <= 0) {
                    throw new \RuntimeException('availed_service_id is required for service.paid');
                }

                $availedService = AvailedService::find($availedServiceId);
                if (!$availedService) {
                    throw new \RuntimeException("Availed service not found: {$availedServiceId}");
                }

                ErpInvoicingService::syncInvoiceForAvailedServicePayment($availedService);
                break;

            default:
                // Unknown topics are safely ignored but marked processed.
                Log::channel('api')->warning('Unknown integration event type ignored', [
                    'message_id' => $message->id,
                    'event_type' => $message->event_type,
                ]);
        }
    }
}
