<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Schema;

class ErpPayment extends Model
{
    use HasFactory;

    protected $table = 'erp_payments';

    protected $fillable = [
        'invoice_id',
        'invoice_booking_id',
        'source',
        'source_reference',
        'amount',
        'method',
        'status',
        'paid_at',
        'payment_key',
    ];

    public function invoice()
    {
        if (!Schema::hasTable('erp_invoices')) {
            return $this->belongsTo(ErpInvoice::class, 'invoice_id', 'id')->whereRaw('1=0');
        }

        return $this->belongsTo(ErpInvoice::class, 'invoice_id', 'id');
    }
}

