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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', length: 20)->unique();
            $table->bigInteger('booking_id')->nullable();
            $table->bigInteger('customer_id');
            $table->string('customer_name', length: 50);
            $table->string('customer_mobile', length: 10);
            $table->string('customer_email', length: 80);
            $table->string('therapist_name', length:40);
            $table->string('therapist_license', length:20);
            $table->date('invoice_date');
            $table->date('payment_due');
            $table->string('services', length:20); // comman seperated service ids
            $table->string('service_prices', length:50)->nullable();
            $table->date('booking_date')->nullable();
            $table->string('time_slots', length:100)->nullable();
            $table->float('subtotal', 8,2)->default(0)->nullable();
            $table->enum('discount_type', ['none','flat','percentage'])->default('none');
            $table->smallInteger('discount_type_val')->nullable();
            $table->float('discount_value', 5,2)->default(0)->nullable();
            $table->float('hst_tax', 5,2)->nullable();
            $table->float('final_amount', 8,2);
            $table->string('notes', length:150)->nullable();
            $table->enum('payment_status', ['pending','partial','paid','overpaid'])->default('pending');
            $table->timestamps();
            $table->softDeletes();  // this is used for soft delete Invoices
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
