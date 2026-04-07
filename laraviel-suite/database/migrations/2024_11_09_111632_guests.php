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
        if (!Schema::hasTable('guests')) {
            Schema::create('guests', function (Blueprint $table) {
                $table->id();
                $table->string('booking_id')->unique();
                $table->string('lastname');
                $table->string('firstname');
                $table->string('salutation')->nullable();
                $table->date('birthdate')->nullable();
                $table->string('gender')->nullable();
                $table->integer('guest_count');
                $table->string('discount_option')->nullable();
                $table->string('email');
                $table->string('contact_number');
                $table->text('address');
                $table->date('check_in');
                $table->date('check_out');
                $table->string('booked_rooms');
                $table->decimal('price_total', 8, 2);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
