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
        Schema::create('client_contact_details', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('phone');
            $table->string('fax');
            $table->string('email');
            $table->string('website');
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
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_contact_details');
    }
};
