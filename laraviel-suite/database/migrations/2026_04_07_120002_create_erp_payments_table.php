<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('erp_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('invoice_id')->index();
            $table->string('invoice_booking_id')->index();

            $table->string('source'); // room_booking | availed_service
            $table->string('source_reference')->nullable(); // numeric id as string or booking_id marker

            // signed amount: paid => +, refunded => -
            $table->decimal('amount', 10, 2)->default(0);

            $table->string('method')->nullable();
            $table->string('status')->default('paid'); // paid | refunded
            $table->timestamp('paid_at')->nullable();

            $table->string('payment_key')->unique(); // idempotency key

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('erp_payments');
    }
};

