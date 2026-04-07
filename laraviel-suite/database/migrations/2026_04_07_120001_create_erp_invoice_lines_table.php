<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('erp_invoice_lines', function (Blueprint $table) {
            $table->id();

            // We intentionally avoid FK constraints for non-breaking upgrades.
            $table->unsignedBigInteger('invoice_id')->index();
            $table->string('invoice_booking_id')->index();

            $table->string('line_type'); // room_booking | service
            $table->unsignedBigInteger('service_id')->nullable()->index();
            $table->unsignedBigInteger('availed_service_id')->nullable()->index();

            $table->string('line_key')->unique(); // idempotency key
            $table->string('description')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('line_total', 10, 2)->default(0);

            // pending | paid | refunded
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('erp_invoice_lines');
    }
};

