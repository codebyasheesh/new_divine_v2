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
        Schema::create('settings', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('profile_img', length:80);
            $table->string('backend_logo', length:100);
            $table->string('frontend_logo', length:100);
            $table->string('company_name', length:100);
            $table->string('title');
            $table->string('notes');
            $table->string('terms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
