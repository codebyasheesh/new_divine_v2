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
        Schema::create('tbl_reservations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('old_customer_id');
            $table->string('full_name', length:50);
            $table->string('email', length:80)->nullable();
            $table->string('mobile', length:10)->nullable();
            $table->string('services', length:255)->nullable();
            $table->date('appointment_date');
            $table->mediumInteger('timeslot_id');
            $table->mediumInteger('physio_timeslot_id');
            $table->mediumInteger('massage_timeslot_id');
            $table->mediumInteger('aesthetic_timeslot_id');
            $table->text('message')->nullable();
            $table->enum('status', ['pending','confirmed','canceled','declined']);
            $table->tinyInteger('reminder_status')->default(0)->comment('0 => reminder not sent, 1 => first reminder sent');
            $table->tinyInteger('sms_reminder_status')->default('0');
            $table->string('pre_screening', length: 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_reservations');
    }
};
