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
        Schema::create('client_tax_company_details', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('tax_file_number');
            $table->string('business_number');
            $table->string('company_number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_tax_company_details');
    }
};
