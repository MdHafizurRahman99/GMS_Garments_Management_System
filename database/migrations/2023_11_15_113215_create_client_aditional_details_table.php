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
        Schema::create('client_aditional_details', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('activity_statement')->nullable();
            $table->string('tax_form')->nullable();
            $table->string('ato_client')->nullable();
            $table->string('verification_document')->nullable();
            $table->string('document_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('client_aditional_details');
    }
};
