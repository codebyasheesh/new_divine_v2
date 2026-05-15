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
        Schema::create('waitlist_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->comment('ID of the customer who made the booking');
            $table->string('customer_name', length: 50);
            $table->string('customer_email', length: 100);
            $table->string('customer_mobile', length: 10);
            $table->string('services', length: 100)->comment('Comma-separated list of service IDs booked'); 
            $table->date('booking_date')->comment('Date of the booking');
            $table->string('time_slots', length: 40)->comment('Comma-separated list of time slots booked');
            $table->integer('total_amount')->comment('Total amount for the booking');
            $table->string('message', length: 150)->nullable()->comment('Additional message from the customer');
            $table->enum('status', ['booked','pending'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waitlist_bookings');
    }
};
