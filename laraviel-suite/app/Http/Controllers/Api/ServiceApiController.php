<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\AvailedService;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceApiController extends Controller
{
    /**
     * GET /api/v1/services
     * List all services.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Service::query();

        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $services = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data'    => $services,
        ]);
    }

    /**
     * GET /api/v1/services/{id}
     */
    public function show(int $id): JsonResponse
    {
        $service = Service::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $service,
        ]);
    }

    /**
     * GET /api/v1/availed-services
     * List all availed services (cashier module).
     */
    public function availedIndex(Request $request): JsonResponse
    {
        $query = AvailedService::query();

        if ($request->has('booking_id')) {
            $query->where('booking_id', 'like', '%' . $request->booking_id . '%');
        }

        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $availed = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data'    => $availed,
        ]);
    }

    /**
     * POST /api/v1/availed-services/{id}/mark-paid
     * Mark a service as paid.
     */
    public function markPaid(int $id): JsonResponse
    {
        $service = AvailedService::findOrFail($id);
        $service->update(['payment_status' => 'Paid']);

        ActivityLogger::log('service.paid', "Service #{$id} marked as paid", AvailedService::class, $id);

        return response()->json([
            'success' => true,
            'message' => 'Service marked as paid.',
            'data'    => $service->fresh(),
        ]);
    }
}
