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
        Schema::create('room_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal("price", 10, 2);
            $table->timestamps();
        });

        Schema::create('rooms', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('room_type'); // Room type
            $table->text('description'); // Suite description
            $table->string('image_path'); // Path to the image
            $table->unsignedBigInteger('room_price_id'); // Foreign key to room_prices
            $table->foreign('room_price_id') // Define the foreign key constraint
                  ->references('id')
                  ->on('room_prices')
                  ->onDelete('cascade'); // Optional: cascade delete when a room_price is deleted
            $table->timestamps(); // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
