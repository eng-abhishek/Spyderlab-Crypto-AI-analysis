<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelegramTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sub_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('package_id')->nullable();
            $table->enum('sub_type',['custom','package'])->nullable();
            $table->bigInteger('no_of_request')->nullable();
            $table->decimal('payment_amount',12,8);
            $table->decimal('payment_amount_in_usd',6,3);
            $table->enum('payment_type',['crypto','fiat'])->default('crypto');
            $table->enum('coin_type',['BTC','ETH'])->default('BTC');
            $table->text('coin_address')->nullable();
            $table->enum('txn_status',['paid','pending','cancel'])->default('pending');
            $table->text('checkout_url')->nullable();
            $table->text('status_url')->nullable();
            $table->text('qrcode_url')->nullable();
            $table->text('txn_id')->nullable();
            $table->text('txn_hash')->nullable();
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
        Schema::dropIfExists('telegram_transactions');
    }
}
