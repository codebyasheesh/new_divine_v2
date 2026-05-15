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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id');
            $table->float('total_amount', 8,2);
            $table->string('payment_via_1', length: 16);
            $table->string('payment_option_1', length: 20);
            $table->float('amount_1', 5, 2)->default(0)->nullable();

            $table->string('payment_via_2', length: 16);
            $table->string('payment_option_2', length: 20);
            $table->float('amount_2', 5, 2)->default(0)->nullable();

            $table->string('payment_via_3', length: 16);
            $table->string('payment_option_3', length: 20);
            $table->float('amount_3', 5, 2)->default()->nullable();

            $table->string('payment_via_4', length: 16);
            $table->string('payment_option_4', length: 20);
            $table->float('amount_4', 5, 2)->default(0)->nullable();

            $table->string('payment_via_5', length: 16);
            $table->string('payment_option_5', length: 20);
            $table->float('amount_5', 5, 2)->default(0)->nullable();

            $table->float('paid_amount', 5,2)->default(0)->nullable();
            $table->date('payment_date');
            $table->timestamp('invoice_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
