<?php

namespace App\Services;

use App\Jobs\ProcessIntegrationMessage;
use App\Models\IntegrationMessage;
use Illuminate\Support\Facades\Schema;

class IntegrationBus
{
    public static function publish(
        string $topic,
        string $eventType,
        array $payload,
        ?string $aggregateType = null,
        ?string $aggregateId = null,
        ?string $messageKey = null
    ): ?IntegrationMessage {
        if (!Schema::hasTable('integration_messages')) {
            return null;
        }

        $computedKey = $messageKey ?: md5(
            $topic . '|' . $eventType . '|' . ($aggregateType ?? '') . '|' . ($aggregateId ?? '') . '|' . json_encode($payload)
        );

        $message = IntegrationMessage::firstOrCreate(
            ['message_key' => $computedKey],
            [
                'topic' => $topic,
                'event_type' => $eventType,
                'aggregate_type' => $aggregateType,
                'aggregate_id' => $aggregateId,
                'payload' => $payload,
                'status' => 'pending',
                'available_at' => now(),
            ]
        );

        if ($message->status === 'pending') {
            ProcessIntegrationMessage::dispatch($message->id)->onQueue('integrations');
        }

        return $message;
    }
}
