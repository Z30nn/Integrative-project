<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessIntegrationMessage;
use App\Models\IntegrationMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class IntegrationApiController extends Controller
{
    public function health(): JsonResponse
    {
        if (!Schema::hasTable('integration_messages')) {
            return response()->json([
                'success' => false,
                'message' => 'Integration pipeline is unavailable (run migrations).',
            ], 501);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'total' => IntegrationMessage::count(),
                'pending' => IntegrationMessage::where('status', 'pending')->count(),
                'processing' => IntegrationMessage::where('status', 'processing')->count(),
                'processed' => IntegrationMessage::where('status', 'processed')->count(),
                'failed' => IntegrationMessage::where('status', 'failed')->count(),
                'dead_letter' => IntegrationMessage::where('status', 'dead_letter')->count(),
            ],
        ]);
    }

    public function messages(Request $request): JsonResponse
    {
        if (!Schema::hasTable('integration_messages')) {
            return response()->json([
                'success' => false,
                'message' => 'Integration messages are unavailable (run migrations).',
            ], 501);
        }

        $query = IntegrationMessage::query()->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('event_type')) {
            $query->where('event_type', $request->string('event_type')->toString());
        }

        return response()->json([
            'success' => true,
            'data' => $query->paginate(20),
        ]);
    }

    public function retry(int $id): JsonResponse
    {
        if (!Schema::hasTable('integration_messages')) {
            return response()->json([
                'success' => false,
                'message' => 'Integration messages are unavailable (run migrations).',
            ], 501);
        }

        $message = IntegrationMessage::findOrFail($id);

        $message->status = 'pending';
        $message->last_error = null;
        $message->available_at = now();
        $message->save();

        ProcessIntegrationMessage::dispatch($message->id)->onQueue('integrations');

        return response()->json([
            'success' => true,
            'message' => 'Integration message queued for retry.',
            'data' => $message->fresh(),
        ]);
    }
}
