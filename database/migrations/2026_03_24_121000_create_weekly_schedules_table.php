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
        Schema::create('weekly_schedules', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->tinyInteger('day_of_week')->comment('1 for Monday... 7 for Sunday');
            $table->tinyInteger('is_closed')->comment('1 for close');
            $table->time('start_time');
            $table->time('end_time');
            $table->time('lunch_start')->nullable();
            $table->time('lunch_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_schedules');
    }
};
