<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMpesaTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mpesa_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('merchant_request_id', 25)->nullable();
            $table->string('checkout_request_id', 25)->nullable();
            $table->string('result_code', 25)->nullable();
            $table->string('result_desc', 50)->nullable();
            $table->dateTime('transaction_date')->nullable();
            $table->string('phone_number', 25)->nullable();
            $table->string('mpesa_receipt_number', 25)->nullable();
            $table->float('amount')->nullable();
            $table->float('balance')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mpesa_transactions');
    }
}
