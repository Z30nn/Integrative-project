<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('erp_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('booking_id')->unique();
            $table->string('customer_name');

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);

            // pending | paid | refunded | partial
            $table->string('status')->default('pending');

            $table->string('payment_method')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('paid_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('erp_invoices');
    }
};

