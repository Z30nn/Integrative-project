<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Services\ActivityLogger;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomApiController extends Controller
{
    /**
     * GET /api/v1/rooms
     * List all rooms with optional filters.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Room::query();

        if ($request->has('room_type')) {
            $query->where('room_type', 'like', '%' . $request->room_type . '%');
        }

        $rooms = $query->paginate(15);

        return response()->json([
            'success' => true,
            'data'    => $rooms,
        ]);
    }

    /**
     * GET /api/v1/rooms/{id}
     * Show a single room.
     */
    public function show(int $id): JsonResponse
    {
        $room = Room::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => $room,
        ]);
    }

    /**
     * POST /api/v1/rooms
     * Create a new room. (Admin only)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'room_type'     => 'required|string|max:100',
            'description'   => 'nullable|string',
            'image_path'    => 'nullable|string',
            'room_price_id' => 'required|exists:room_prices,id',
        ]);

        $room = Room::create($validated);

        ActivityLogger::log('room.created', "Room type {$room->room_type} created", Room::class, $room->id);

        return response()->json([
            'success' => true,
            'message' => 'Room created successfully.',
            'data'    => $room,
        ], 201);
    }

    /**
     * PUT /api/v1/rooms/{id}
     * Update a room. (Admin only)
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'room_type'     => 'sometimes|string|max:100',
            'description'   => 'nullable|string',
            'image_path'    => 'nullable|string',
            'room_price_id' => 'sometimes|exists:room_prices,id',
        ]);

        $room->update($validated);

        ActivityLogger::log('room.updated', "Room type {$room->room_type} updated", Room::class, $room->id);

        return response()->json([
            'success' => true,
            'message' => 'Room updated successfully.',
            'data'    => $room->fresh(),
        ]);
    }

    /**
     * DELETE /api/v1/rooms/{id}
     * Delete a room. (Admin only)
     */
    public function destroy(int $id): JsonResponse
    {
        $room = Room::findOrFail($id);
        $roomType = $room->room_type;
        $room->delete();

        ActivityLogger::log('room.deleted', "Room type {$roomType} deleted", Room::class, $id);

        return response()->json([
            'success' => true,
            'message' => 'Room deleted successfully.',
        ]);
    }
}
