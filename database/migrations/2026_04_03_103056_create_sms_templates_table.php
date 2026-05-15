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
        Schema::create('sms_templates', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('sms_key', length: 50)->unique();
            $table->string('template_name', length: 100);
            $table->string('body', length:350);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_templates');
    }
};
