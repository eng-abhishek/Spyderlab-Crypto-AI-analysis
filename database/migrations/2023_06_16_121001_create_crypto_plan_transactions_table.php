<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoPlanTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_plan_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sub_id')->nullable();
            $table->foreign('sub_id')->references('id')->on('crypto_plan_subscriptions')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('crypto_plans')->onDelecte('cascade');
            $table->enum('plan_type',['Y','M'])->nullable();
            $table->datetime('started_date')->nullable();
            $table->datetime('expired_date')->nullable();
            $table->double('purchese_price',10,2);
            $table->enum('plan_change_type',['U','D','R','N'])->default('N');
            $table->string('transaction_id',250);
            
            $table->string('payment_gateway_id',250)->nullable();
            $table->enum('status',['Paid','Pending','Cancelled'])->default('Pending');

            $table->string('payment_id')->nullable();

            $table->string('payer_id')->nullable();

            $table->string('payer_email')->nullable();
            
            $table->integer('terms_in_month')->nullable();
            
            $table->enum('currency_type',['fiat','crypto'])->default('fiat');

            $table->datetime('coinpayment_expired_at')->nullable();
            $table->text('coinpayment_qrcode_url')->nullable();
            $table->text('coinpayment_address')->nullable();
            $table->double('final_price',10,2)->nullable();
            $table->double('final_price_in_crypto',10,8)->nullable();
            $table->string('currency')->default('USD');
            
            $table->unsignedBigInteger('created_by');
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
        Schema::dropIfExists('crypto_plan_transactions');
    }
}
