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
        Schema::create('tbl_time_slots', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('slot', length: 20);
            $table->mediumInteger('days_id');
            $table->string('block_date')->nullable();
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_time_slots');
    }
};
