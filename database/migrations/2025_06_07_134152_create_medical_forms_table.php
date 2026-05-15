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
        Schema::create('medical_forms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('booking_id');
            $table->bigInteger('customer_id');
            $table->string('first_name', length: 50);
            $table->string('last_name', length: 50);
            $table->date('dob');
            $table->string('email');
            $table->string('address', length: 150);
            $table->string('city', length: 30);
            $table->string('postal_code', length: 6);
            $table->string('primary_phone', length: 10);
            $table->string('other_phone', length: 10)->nullable();
            $table->string('occupation', length:20);
            $table->string('emergency_contact_name', length:40);
            $table->string('emergency_contact_phone', length:10);
            $table->string('source_of_referral', length: 100);
            $table->enum('extended_health_care_benefit', ['Yes','No'])->default('Yes');
            $table->string('benefits_insurance_company_name', length: 150)->nullable();
            $table->enum('primary_member',['Yes','No'])->default('Yes')->nullable();
            $table->string('primary_member_name', length: 40)->nullable();
            $table->date('primary_member_dob')->comment('in case no primary member then primary member DOB')->nullable();
            $table->string('contract_policy_plan_no', length: 20)->nullable();
            $table->string('member_certificate_no', length: 20)->nullable();
            $table->enum('authorize_us_to_direct_bill', ['Yes','No'])->default('Yes');
            $table->enum('second_insurance_coverage', ['Yes','No'])->default('No');
            $table->string('second_insu_comp_name', length: 100)->nullable();
            $table->string('primary_member_name_2', length:40)->nullable();
            $table->date('primary_member_dob_2')->nullable();
            $table->string('contract_policy_plan_no_2', length: 20)->nullable();
            $table->string('member_certificate_no_2', length:20)->nullable();

            $table->enum('v_accident_or_injured',['Yes','No'])->default('No');
            $table->string('all_pertinent_infomation', length: 255)->nullable();
            $table->string('other_current_injuries', length: 150)->nullable();
            $table->string('primary_complaint', length: 100);
            $table->enum('refer_by_practitioner', ['Yes', 'No'])->default('Yes');
            $table->string('health_cre_profess_name', length:50);
            $table->string('family_doc_addrs', length: 150);
            $table->enum('received_massage_before', ['Yes','No']);
            $table->enum('received_treatment_from_another', ['Yes','No']);
            $table->string('if_yes_treatment_type', length: 40)->nullable();
            $table->string('current_medications', length: 50)->nullable();
            $table->enum('any_allergies', ['Yes', 'No'])->default('No');
            $table->string('allergy_lst', length: 100);
            $table->string('list_all_surgeries', length: 150);
            $table->string('cardiovascular',length: 100);
            $table->string('gastrointestinal', length: 100);
            $table->string('head_neck', length: 100);
            $table->string('respiratory', length: 100);
            $table->string('skin', length: 100);
            $table->string('muscle_joint', length: 100);
            $table->string('other_medical_conditions', length: 100);
            $table->enum('is_family_history', ['Yes','No']);
            $table->enum('internal_pin_wire_joint', ['Yes','No']);
            $table->string('joint_or_pin_text', length:150)->nullable();
            $table->enum('good_health', ['Good','Fair','Poor']);
            $table->enum('pregnant',['Yes', 'No'])->default('No');
            $table->string('acknowlege_name', length:40);
            $table->date('choose_date');
            $table->string('acknowledge_text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_forms');
    }
};
