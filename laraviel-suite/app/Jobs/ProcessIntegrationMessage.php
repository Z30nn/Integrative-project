<?php

namespace App\Jobs;

use App\Models\AvailedService;
use App\Models\Guest;
use App\Models\IntegrationMessage;
use App\Services\ErpInvoicingService;
use App\Services\IntegrationMessageConsumer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessIntegrationMessage implements ShouldQueue
{
    use Queueable;

    public int $tries = 5;
    public string $queue = 'integrations';

    public function __construct(public int $messageId)
    {
    }

    public function handle(): void
    {
        $message = IntegrationMessage::find($this->messageId);
        if (!$message) {
            return;
        }

        if (in_array($message->status, ['processed', 'dead_letter'], true)) {
            return;
        }

        $message->status = 'processing';
        $message->attempts = (int) $message->attempts + 1;
        $message->save();

        try {
            IntegrationMessageConsumer::consume($message);

            $message->status = 'processed';
            $message->processed_at = now();
            $message->last_error = null;
            $message->save();
        } catch (\Throwable $e) {
            $message->last_error = $e->getMessage();

            if ((int) $message->attempts >= (int) $message->max_attempts) {
                $message->status = 'dead_letter';
                $message->dead_letter_at = now();
            } else {
                $message->status = 'failed';
                $message->available_at = now()->addSeconds(30 * (int) $message->attempts);
            }

            $message->save();

            Log::channel('api')->error('Integration message processing failed', [
                'message_id' => $message->id,
                'event_type' => $message->event_type,
                'attempts' => $message->attempts,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
