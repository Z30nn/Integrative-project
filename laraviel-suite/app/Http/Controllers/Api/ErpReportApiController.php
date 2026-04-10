<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ErpInvoice;
use App\Models\ErpInvoiceLine;
use App\Models\ErpPayment;
use App\Models\Guest;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ErpReportApiController extends Controller
{
    public function revenue(): JsonResponse
    {
        $erpTablesReady = Schema::hasTable('erp_invoices') && Schema::hasTable('erp_payments');

        if ($erpTablesReady) {
            $totalPaid = (float) ErpPayment::where('status', 'paid')->sum('amount');
            // Refunded payments are stored as negative amounts, so sum() already returns net.
            $netRevenue = (float) ErpPayment::whereIn('status', ['paid', 'refunded'])->sum('amount');
            $totalRefunded = (float) ErpPayment::where('status', 'refunded')->sum('amount'); // negative number

            return response()->json([
                'success' => true,
                'data' => [
                    'erpEnabled' => true,
                    'totalPaid' => $totalPaid,
                    'totalRefunded' => abs($totalRefunded),
                    'netRevenue' => $netRevenue,
                    'invoicesCount' => ErpInvoice::count(),
                    'paymentsCount' => ErpPayment::count(),
                ],
            ]);
        }

        // Backward-compatible fallback to existing revenue source.
        $netRevenue = (float) DB::table('income_trackers')->sum('price');

        return response()->json([
            'success' => true,
            'data' => [
                'erpEnabled' => false,
                'netRevenue' => $netRevenue,
            ],
        ]);
    }

    public function stockRooms(): JsonResponse
    {
        if (!Schema::hasTable('rooms') || !Schema::hasTable('guests')) {
            return response()->json([
                'success' => false,
                'message' => 'Room stock is unavailable (missing rooms/guests tables).',
            ], 501);
        }

        $roomTypeGroups = Room::distinct()->pluck('room_type')->values()->all();
        $totalByType = [];
        foreach ($roomTypeGroups as $roomType) {
            $totalByType[$roomType] = Room::where('room_type', $roomType)->count();
        }

        // Occupied is computed from active guests' booked_rooms.
        $today = today()->toDateString();
        $activeGuests = Guest::whereDate('check_out', '>=', $today)->get(['booked_rooms']);

        $occupiedByType = array_fill_keys($roomTypeGroups, 0);

        foreach ($activeGuests as $guest) {
            $bookedRooms = explode(',', (string) $guest->booked_rooms);
            foreach ($bookedRooms as $token) {
                $token = trim($token);
                if ($token === '') {
                    continue;
                }

                foreach ($roomTypeGroups as $roomTypeGroup) {
                    // Match token -> room_type using substring logic.
                    if (stripos($roomTypeGroup, $token) !== false) {
                        $occupiedByType[$roomTypeGroup] = ($occupiedByType[$roomTypeGroup] ?? 0) + 1;
                        break;
                    }
                }
            }
        }

        $rooms = [];
        foreach ($roomTypeGroups as $roomTypeGroup) {
            $total = (int) ($totalByType[$roomTypeGroup] ?? 0);
            $occupied = (int) ($occupiedByType[$roomTypeGroup] ?? 0);
            $available = max($total - $occupied, 0);

            $rooms[] = [
                'roomType' => $roomTypeGroup,
                'total' => $total,
                'occupied' => $occupied,
                'available' => $available,
            ];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'asOf' => $today,
                'rooms' => $rooms,
            ],
        ]);
    }

    public function invoice(string $bookingId): JsonResponse
    {
        if (!Schema::hasTable('erp_invoices')) {
            return response()->json([
                'success' => false,
                'message' => 'ERP invoices are unavailable (run migrations).',
            ], 501);
        }

        $inv = ErpInvoice::where('booking_id', $bookingId)->first();
        if (!$inv) {
            return response()->json([
                'success' => false,
                'message' => 'Invoice not found.',
            ], 404);
        }

        $lines = ErpInvoiceLine::where('invoice_booking_id', $bookingId)->get();
        $payments = ErpPayment::where('invoice_booking_id', $bookingId)->get();

        return response()->json([
            'success' => true,
            'data' => [
                'invoice' => $inv,
                'lines' => $lines,
                'payments' => $payments,
            ],
        ]);
    }
}

