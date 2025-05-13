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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('HourlyRate', 10, 2)->nullable();
            $table->decimal('Salary', 15, 2)->nullable();
            $table->string('BankAccountNumber')->nullable();
            $table->string('TaxFileNumber')->nullable();        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['HourlyRate', 'Salary', 'BankAccountNumber', 'TaxFileNumber']);
        });
    }
};
