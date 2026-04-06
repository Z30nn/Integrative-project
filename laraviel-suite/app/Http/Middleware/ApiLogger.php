<?php

namespace App\Http\Middleware;

use App\Models\ApiLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiLogger
{
    /**
     * Handle an incoming request and log API activity.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        /** @var Response $response */
        $response = $next($request);

        $duration = round((microtime(true) - $startTime) * 1000, 2); // ms

        $logData = [
            'method'      => $request->method(),
            'url'         => $request->fullUrl(),
            'ip'          => $request->ip(),
            'user_id'     => Auth::id(),
            'status_code' => $response->getStatusCode(),
            'duration_ms' => $duration,
            'user_agent'  => $request->userAgent(),
        ];

        Log::channel('api')->info('API Request', $logData);

        // Also persist to DB for the monitoring dashboard
        try {
            ApiLog::create($logData);
        } catch (\Exception $e) {
            // Silently fail — logging should never break the application
        }

        return $response;
    }
}
