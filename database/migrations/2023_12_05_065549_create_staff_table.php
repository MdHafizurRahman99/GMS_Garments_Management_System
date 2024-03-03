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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('start_date')->nullable();
            $table->string('possion_title')->nullable();
            $table->string('gender')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('address')->nullable();
            $table->string('suburb')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('employee_tax_file')->nullable();
            $table->string('super_fund')->nullable();
            $table->string('member_no')->nullable();
            $table->string('contractor')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('business_number')->nullable();
            $table->string('abn_entity_name')->nullable();
            $table->string('abn_address')->nullable();
            $table->string('abn_status')->nullable();
            $table->string('abn_business_name')->nullable();
            $table->string('company_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('bsb_number')->nullable();
            $table->string('account_number')->nullable();
            $table->string('aus_citizen')->nullable();
            $table->string('permanent_resident')->nullable();
            $table->string('visa_expiry_date')->nullable();
            $table->string('restriction')->nullable();
            $table->string('next_of_kin')->nullable();
            $table->string('relationship')->nullable();
            $table->string('kin_address')->nullable();
            $table->string('kin_suburb')->nullable();
            $table->string('kin_state')->nullable();
            $table->string('kin_postcode')->nullable();
            $table->string('kin_phone')->nullable();
            $table->string('kin_mobile')->nullable();
            $table->string('kin_work')->nullable();
            $table->string('about_validate_file')->nullable();
            $table->string('address_validate_file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
