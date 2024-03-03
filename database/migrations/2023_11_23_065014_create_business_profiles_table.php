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
        Schema::create('business_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_type');
            $table->string('phone');
            $table->string('fax');
            $table->string('email');
            $table->string('mobile');
            $table->string('physical_street');
            $table->string('physical_city');
            $table->string('physical_state');
            $table->string('physical_postal_code');
            $table->string('physical_country');
            $table->string('postal_street');
            $table->string('postal_city');
            $table->string('postal_state');
            $table->string('postal_postal_code');
            $table->string('postal_country');
            $table->string('business_number');
            $table->string('company_number');
            $table->string('accountants_number');
            $table->string('software_name');
            $table->string('api_key');
            $table->string('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_profiles');
    }
};
