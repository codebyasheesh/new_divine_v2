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
        Schema::create('block_dates', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('time_slot', length:20);
            $table->enum('day', ['Monday','Tuesday', 'Wednesday','Thursday','Friday','Saturday','Sunday'])->nullable();
            $table->string('block_date')->default('');
            $table->string('date_type', length:40)->nullable();
            $table->string('holiday_range')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('block_dates');
    }
};
