<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvailedServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('availed_services')) {
            Schema::create('availed_services', function (Blueprint $table) {
                $table->bigIncrements('id');  // Auto incrementing primary key
                $table->string('guest_name');  // Name of the guest
                $table->bigInteger('service_id');  // Foreign key reference to services table
                $table->date('service_date');  // Date of service
                $table->enum('payment_method', ['over_the_counter', 'online_payment']);  // Payment method
                $table->enum('payment_status', ['pending', 'paid'])->default('pending');  // Payment status
                $table->decimal('total_price', 10, 2);  // Total price for the service
                $table->timestamps();  // Created at and updated at timestamps
                $table->string('booking_id');  // Booking ID, assumed to be integer
                
                // Optionally, you can add foreign key constraints for relationships (e.g., to the services table)
                // $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('availed_services');
    }
}
