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
        Schema::create('date_overrides', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->date('date');
            $table->boolean('is_closed')->comment('1 is closed');
            $table->time('custom_start_time')->nullable();
            $table->time('custom_end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('date_overrides');
    }
};
