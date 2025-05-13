<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable('incomes')) { // ✅ Prevent duplicate creation
            Schema::create('incomes', function (Blueprint $table) {
                $table->id();
                $table->decimal('amount', 10, 2);
                $table->string('income_source');
                $table->foreignId('payment_method_id')->constrained();
                $table->string('bank_name')->nullable();
                $table->string('transaction_id')->nullable();
                $table->text('details')->nullable();
                $table->date('date');
                $table->foreignId('user_id')->constrained();
                $table->foreignId('customer_id')->nullable()->constrained();
                $table->foreignId('order_id')->nullable()->constrained();
                $table->string('image_path')->nullable();
                $table->string('income_type');
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('incomes');
    }
};


