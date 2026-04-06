<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            if (!Schema::hasColumn('guests', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('price_total');
                $table->string('payment_status')->nullable()->after('payment_method');
            }
        });

        // To modify enum in Laravel, it's safer to just change the column type to string
        // or execute a raw DB query for MySQL enum modification, but changing to string is robust
        // Let's just modify the column to be a string type for flexibility
        Schema::table('availed_services', function (Blueprint $table) {
            $table->string('payment_status')->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_status']);
        });
        
        // Reverting string to enum
        Schema::table('availed_services', function (Blueprint $table) {
            // Note: going back to enum can be tricky if data has 'Refunded'
            // We'll leave it as string in down or try to revert if sure.
        });
    }
};
