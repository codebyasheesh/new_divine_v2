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
        Schema::create('holiday_lists', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('holiday_name', length: 100);
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('holiday_range', length: 150);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holiday_lists');
    }
};
