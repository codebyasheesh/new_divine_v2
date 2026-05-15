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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('service_name', length: 40)->unique();
            $table->integer('parent_id')->comment('This column define the parent child relationship');
            $table->float('price', 6,2);
            $table->integer('duration')->comment('Duration in minutes'); // It is in minutes
            $table->tinyInteger('status')->default('1')->comment('1 = active, 0 = inactive');  // 1 = active, 0 = inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
