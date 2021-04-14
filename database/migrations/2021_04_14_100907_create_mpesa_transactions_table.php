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
            $table->string('first_name', 25)->nullable();
            $table->string('middle_name', 25)->nullable();
            $table->string('last_name', 25)->nullable();
            $table->string('transaction_type', 25)->nullable();
            $table->string('transaction_id', 25)->nullable();
            $table->string('transaction_time', 25)->nullable();
            $table->string('business_shortcode', 25)->nullable();
            $table->string('bill_ref_number', 25)->nullable();
            $table->string('invoice_number', 25)->nullable();
            $table->string('third_party_transaction_id', 25)->nullable();
            $table->string('msisdn', 25)->nullable();
            $table->string('organisation_account_balance', 25)->nullable();
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
