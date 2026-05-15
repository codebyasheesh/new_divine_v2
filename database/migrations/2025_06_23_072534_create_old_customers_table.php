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
        Schema::create('old_customers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', length: 50);
            $table->string('mobile', length: 10);
            $table->string('email', length: 80);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('old_customers');
    }
};
