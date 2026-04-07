<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('income_trackers')) {
            Schema::create('income_trackers', function (Blueprint $table) {
                $table->id();
                $table->string("customer_name");
                $table->string("availed_service");
                $table->decimal("price", 10, 2);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_trackers');
    }
};
