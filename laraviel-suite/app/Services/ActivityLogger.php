<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Log a user action.
     */
    public static function log(
        string $action,
        string $description = '',
        ?string $modelType = null,
        ?int $modelId = null,
        array $properties = []
    ): void {
        try {
            ActivityLog::create([
                'user_id'    => Auth::id(),
                'user_name'  => Auth::user()?->name ?? 'System',
                'action'     => $action,
                'model_type' => $modelType,
                'model_id'   => $modelId,
                'description'=> $description,
                'ip_address' => Request::ip(),
                'properties' => $properties,
            ]);
        } catch (\Exception $e) {
            // Logging should never crash the application
        }
    }
}
