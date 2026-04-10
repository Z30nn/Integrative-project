<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $fillable = [
        'method',
        'url',
        'ip',
        'user_id',
        'status_code',
        'duration_ms',
        'user_agent',
    ];

    protected $casts = [
        'duration_ms' => 'float',
        'status_code' => 'integer',
    ];
}
