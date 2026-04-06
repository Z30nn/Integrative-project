<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ApiLog;
use App\Models\Guest;
use App\Models\Room;
use App\Models\IncomeTracker;
use Illuminate\Http\JsonResponse;

class DashboardApiController extends Controller
{
    /**
     * GET /api/v1/dashboard
     * System health and stats for monitoring. (Admin only)
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'system' => [
                    'status'     => 'healthy',
                    'php_version'=> phpversion(),
                    'laravel_version' => app()->version(),
                    'timestamp'  => now()->toIso8601String(),
                ],
                'stats'  => [
                    'total_rooms'    => Room::count(),
                    'total_guests'   => Guest::count(),
                    'total_revenue'  => IncomeTracker::sum('price'),
                ],
                'api_logs' => [
                    'total_requests_today' => ApiLog::whereDate('created_at', today())->count(),
                    'avg_response_ms'      => round(ApiLog::whereDate('created_at', today())->avg('duration_ms'), 2),
                    'error_count_today'    => ApiLog::whereDate('created_at', today())
                        ->where('status_code', '>=', 400)->count(),
                ],
                'recent_activity' => ActivityLog::with('user')
                    ->latest()
                    ->take(10)
                    ->get()
                    ->map(fn($log) => [
                        'action'      => $log->action,
                        'description' => $log->description,
                        'user'        => $log->user_name,
                        'time'        => $log->created_at->diffForHumans(),
                    ]),
            ],
        ]);
    }
    /**
     * GET /api/v1/cashier-stats
     * Stats for the cashier dashboard. (Admin and Cashier)
     */
    public function cashierIndex(): JsonResponse
    {
        $today = today()->toDateString();

        return response()->json([
            'success' => true,
            'data'    => [
                'today_stats' => [
                    'check_ins'  => Guest::whereDate('check_in', $today)->count(),
                    'check_outs' => Guest::whereDate('check_out', $today)->count(),
                    'pending_payments' => \Illuminate\Support\Facades\DB::table('availed_services')
                        ->where('payment_status', 'pending')
                        ->count(),
                ],
                'summary' => [
                    'active_guests' => Guest::where('check_in', '<=', $today)
                        ->where('check_out', '>=', $today)
                        ->count(),
                    'total_revenue' => IncomeTracker::sum('price'),
                ]
            ]
        ]);
    }
}
