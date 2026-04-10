<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Schema;

class ErpInvoice extends Model
{
    use HasFactory;

    protected $table = 'erp_invoices';

    protected $fillable = [
        'booking_id',
        'customer_name',
        'subtotal',
        'total',
        'status',
        'payment_method',
        'issued_at',
        'paid_at',
    ];

    public function lines()
    {
        // No strict FK dependency; keep relationship best-effort.
        if (!Schema::hasTable('erp_invoice_lines')) {
            return $this->hasMany(ErpInvoiceLine::class, 'invoice_id', 'id')->whereRaw('1=0');
        }

        return $this->hasMany(ErpInvoiceLine::class, 'invoice_id', 'id');
    }
}

