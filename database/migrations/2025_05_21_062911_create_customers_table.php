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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name', length: 40);
            $table->string('email', length: 100)->unique();
            $table->string('mobile', length: 10)->nullable();
            $table->string('address', length: 150)->nullable();
            $table->date('dob')->nullable();
            $table->string('remark', length:200)->nullable();
            $table->integer('user_id')->nullable()->comment('Users table primary key'); // Users table primary key
            $table->integer('parent_id')->default(0)->comment('this table primary key For set parent and child customers'); // this table primary key For set parent and child customers
            $table->tinyInteger('status')->default(1)->comment('1 = active, 0 = inactive'); // 1 = active, 0 = inactive
            $table->string('soap_note_link', length:150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
