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
        Schema::create('service_providers', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->bigInteger('user_id');
            $table->string('first_name', length: 50);
            $table->string('last_name', length: 20);
            $table->string('email', length: 80);
            $table->string('mobile', length: 12);
            $table->enum('title', ['Registered Therapist','Wellness Practitioner','Aesthetician'])->default('Registered Therapist');
            $table->string('license', length: 20);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_providers');
    }
};
