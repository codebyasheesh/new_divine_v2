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
        Schema::create('block_time_ranges', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->enum('type', ['weekly', 'date', 'range']);
            $table->tinyInteger('day_of_week')->nullable()->comment('1 for Monday... 7 for Sunday');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_full_day')->comment('1 for fullday block');
            $table->string('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('block_time_ranges');
    }
};
