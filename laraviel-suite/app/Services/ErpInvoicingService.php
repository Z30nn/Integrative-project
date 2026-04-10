<?php

namespace App\Services;

use App\Models\AvailedService;
use App\Models\ErpInvoice;
use App\Models\ErpInvoiceLine;
use App\Models\ErpPayment;
use App\Models\Guest;
use App\Models\Service;
use Illuminate\Support\Facades\Schema;

class ErpInvoicingService
{
    protected static function tablesReady(): bool
    {
        return Schema::hasTable('erp_invoices')
            && Schema::hasTable('erp_invoice_lines')
            && Schema::hasTable('erp_payments');
    }

    protected static function normalizePaymentStatus(?string $status): string
    {
        $s = strtolower(trim((string) $status));
        if ($s === 'paid') {
            return 'paid';
        }
        if ($s === 'refunded') {
            return 'refunded';
        }
        // Covers: null, pending, 'Pending', etc.
        if ($s === '' || $s === 'pending') {
            return 'pending';
        }
        return $s;
    }

    protected static function computeInvoiceStatusFromLines(array $lineStatuses): string
    {
        $statuses = array_values(array_unique($lineStatuses));
        if (count($statuses) === 0) {
            return 'pending';
        }
        if (count($statuses) === 1) {
            return $statuses[0];
        }
        // Any mixture is treated as partial in the MVP.
        return 'partial';
    }

    protected static function recomputeInvoiceTotals(int $invoiceId): void
    {
        if (!self::tablesReady()) {
            return;
        }

        $lines = ErpInvoiceLine::where('invoice_id', $invoiceId)->get(['status', 'line_total']);
        $sum = (float) $lines->sum('line_total');
        $lineStatuses = $lines->pluck('status')->all();

        $invoice = ErpInvoice::find($invoiceId);
        if (!$invoice) {
            return;
        }

        $invoice->subtotal = $sum;
        $invoice->total = $sum;
        $invoice->status = self::computeInvoiceStatusFromLines($lineStatuses);

        $invoice->save();
    }

    protected static function upsertInvoice(Guest $guest, ?string $forcedPaymentStatus = null): ErpInvoice
    {
        $bookingId = $guest->booking_id;
        $customerName = trim(($guest->firstname ?? '') . ' ' . ($guest->lastname ?? ''));
        if ($customerName === '') {
            $customerName = 'Guest';
        }

        $paymentStatus = self::normalizePaymentStatus(
            $forcedPaymentStatus ?? ($guest->payment_status ?? null)
        );

        $invoiceStatus = $paymentStatus === 'paid' ? 'paid' : ($paymentStatus === 'refunded' ? 'refunded' : 'pending');

        return ErpInvoice::updateOrCreate(
            ['booking_id' => $bookingId],
            [
                'customer_name' => $customerName,
                'subtotal' => (float) $guest->price_total,
                'total' => (float) $guest->price_total,
                'status' => $invoiceStatus,
                'payment_method' => $guest->payment_method,
                'issued_at' => now(),
                'paid_at' => $paymentStatus === 'paid' ? now() : null,
            ]
        );
    }

    public static function syncRoomBookingFromGuest(Guest $guest, ?string $forcedPaymentStatus = null): void
    {
        if (!self::tablesReady()) {
            return;
        }

        $invoice = self::upsertInvoice($guest, $forcedPaymentStatus);

        $roomAvailed = AvailedService::where('booking_id', $guest->booking_id)
            ->where('service_id', 0)
            ->first();

        $normalizedGuestStatus = self::normalizePaymentStatus(
            $forcedPaymentStatus ?? ($guest->payment_status ?? null)
        );

        $lineKey = $roomAvailed
            ? ('availed_service_' . $roomAvailed->id)
            : ('booking_' . $guest->booking_id . '_room_booking');

        ErpInvoiceLine::updateOrCreate(
            ['line_key' => $lineKey],
            [
                'invoice_id' => $invoice->id,
                'invoice_booking_id' => $guest->booking_id,
                'line_type' => 'room_booking',
                'service_id' => $roomAvailed ? (int) $roomAvailed->service_id : null,
                'availed_service_id' => $roomAvailed ? (int) $roomAvailed->id : null,
                'description' => 'Room Booking',
                'quantity' => 1,
                'unit_price' => (float) $guest->price_total,
                'line_total' => (float) $guest->price_total,
                'status' => $normalizedGuestStatus,
            ]
        );

        // Create payment only when paid.
        if ($normalizedGuestStatus === 'paid') {
            $paymentSourceReference = $roomAvailed ? (string) $roomAvailed->id : ('booking_' . $guest->booking_id);
            $method = $roomAvailed ? $roomAvailed->payment_method : $guest->payment_method;
            $paymentStatus = 'paid';
            $amount = (float) $guest->price_total;

            $paymentKey = md5($guest->booking_id . '|room_booking|' . $paymentSourceReference . '|' . $paymentStatus);

            ErpPayment::updateOrCreate(
                ['payment_key' => $paymentKey],
                [
                    'invoice_id' => $invoice->id,
                    'invoice_booking_id' => $guest->booking_id,
                    'source' => 'room_booking',
                    'source_reference' => $paymentSourceReference,
                    'amount' => $amount,
                    'method' => $method,
                    'status' => $paymentStatus,
                    'paid_at' => now(),
                ]
            );
        }

        self::recomputeInvoiceTotals($invoice->id);
    }

    public static function syncInvoiceForAvailedServicePayment(AvailedService $availedService): void
    {
        if (!self::tablesReady()) {
            return;
        }

        $bookingId = $availedService->booking_id;
        $guest = Guest::where('booking_id', $bookingId)->first();

        $forcedCustomerName = $guest
            ? trim(($guest->firstname ?? '') . ' ' . ($guest->lastname ?? ''))
            : ($availedService->guest_name ?? 'Guest');
        if ($forcedCustomerName === '') {
            $forcedCustomerName = 'Guest';
        }

        $paymentStatus = self::normalizePaymentStatus($availedService->payment_status);

        // Ensure invoice exists.
        $invoice = ErpInvoice::updateOrCreate(
            ['booking_id' => $bookingId],
            [
                'customer_name' => $forcedCustomerName,
                'subtotal' => $guest ? (float) $guest->price_total : (float) $availedService->total_price,
                'total' => $guest ? (float) $guest->price_total : (float) $availedService->total_price,
                'status' => $paymentStatus === 'paid' ? 'paid' : ($paymentStatus === 'refunded' ? 'refunded' : 'pending'),
                'payment_method' => $availedService->payment_method,
                'issued_at' => now(),
                'paid_at' => $paymentStatus === 'paid' ? now() : null,
            ]
        );

        // Ensure invoice line exists (or is updated).
        $serviceName = 'Service';
        if ((int) $availedService->service_id === 0) {
            $serviceName = 'Room Booking';
        } else {
            $service = Service::where('service_id', $availedService->service_id)->first();
            if ($service && !empty($service->service_name)) {
                $serviceName = $service->service_name;
            }
        }

        ErpInvoiceLine::updateOrCreate(
            ['line_key' => 'availed_service_' . $availedService->id],
            [
                'invoice_id' => $invoice->id,
                'invoice_booking_id' => $bookingId,
                'line_type' => ((int) $availedService->service_id === 0) ? 'room_booking' : 'service',
                'service_id' => (int) $availedService->service_id,
                'availed_service_id' => (int) $availedService->id,
                'description' => $serviceName,
                'quantity' => 1,
                'unit_price' => (float) $availedService->total_price,
                'line_total' => (float) $availedService->total_price,
                'status' => $paymentStatus,
            ]
        );

        // Record payment when paid/refunded.
        if (in_array($paymentStatus, ['paid', 'refunded'], true)) {
            $sourceReference = (string) $availedService->id;
            $method = $availedService->payment_method;
            $amount = $paymentStatus === 'paid'
                ? (float) $availedService->total_price
                : -1 * (float) $availedService->total_price;

            $paymentKey = md5($bookingId . '|availed_service|' . $sourceReference . '|' . $paymentStatus);

            ErpPayment::updateOrCreate(
                ['payment_key' => $paymentKey],
                [
                    'invoice_id' => $invoice->id,
                    'invoice_booking_id' => $bookingId,
                    'source' => 'availed_service',
                    'source_reference' => $sourceReference,
                    'amount' => $amount,
                    'method' => $method,
                    'status' => $paymentStatus,
                    'paid_at' => now(),
                ]
            );
        }

        self::recomputeInvoiceTotals($invoice->id);
    }

    public static function syncInvoiceForGuest(Guest $guest): void
    {
        self::syncRoomBookingFromGuest($guest);
    }

    public static function deleteInvoiceForBooking(string $bookingId): void
    {
        if (!self::tablesReady()) {
            return;
        }

        $invoice = ErpInvoice::where('booking_id', $bookingId)->first();
        if (!$invoice) {
            return;
        }

        ErpPayment::where('invoice_booking_id', $bookingId)->delete();
        ErpInvoiceLine::where('invoice_booking_id', $bookingId)->delete();
        $invoice->delete();
    }
}

