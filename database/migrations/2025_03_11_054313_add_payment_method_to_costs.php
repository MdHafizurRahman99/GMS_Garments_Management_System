<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('costs', function (Blueprint $table) {
            $table->foreignId('payment_method_id')->nullable()->constrained()->after('expense_type');
        });
    }

    public function down()
    {
        Schema::table('costs', function (Blueprint $table) {
            $table->dropForeign(['payment_method_id']);
            $table->dropColumn('payment_method_id');
        });
    }
};

