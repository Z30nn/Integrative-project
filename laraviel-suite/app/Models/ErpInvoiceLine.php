<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Schema;

class ErpInvoiceLine extends Model
{
    use HasFactory;

    protected $table = 'erp_invoice_lines';

    protected $fillable = [
        'invoice_id',
        'invoice_booking_id',
        'line_type',
        'service_id',
        'availed_service_id',
        'line_key',
        'description',
        'quantity',
        'unit_price',
        'line_total',
        'status',
    ];

    public function invoice()
    {
        if (!Schema::hasTable('erp_invoices')) {
            return $this->belongsTo(ErpInvoice::class, 'invoice_id', 'id')->whereRaw('1=0');
        }

        return $this->belongsTo(ErpInvoice::class, 'invoice_id', 'id');
    }
}

