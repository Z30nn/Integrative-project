<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationMessage extends Model
{
    protected $fillable = [
        'message_key',
        'topic',
        'event_type',
        'aggregate_type',
        'aggregate_id',
        'payload',
        'status',
        'attempts',
        'max_attempts',
        'available_at',
        'processed_at',
        'dead_letter_at',
        'last_error',
    ];

    protected $casts = [
        'payload' => 'array',
        'available_at' => 'datetime',
        'processed_at' => 'datetime',
        'dead_letter_at' => 'datetime',
    ];
}
