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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');
            $table->string('customer_name', length:60);
            $table->string('customer_email', length:100);
            $table->string('customer_mobile', length:10);
            $table->string('services', length: 40);
            $table->date('booking_date');
            $table->string('time_slots', length:40);
            $table->float('total_amount', 6, 2)->default(0);
            $table->string('message', length:150)->nullable();
            $table->enum('booking_status',['pending', 'confirmed', 'completed', 'canceled','declined'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
