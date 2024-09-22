<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelegramTmpChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('telegram_tmp_chats', function (Blueprint $table) {
            $table->id();
            $table->string('tm_user_id')->nullable();
            $table->string('action')->nullable();
            $table->enum('currency',['BTC','ETH'])->nullable();
            $table->BigInteger('no_of_request')->nullable();
            $table->BigInteger('amount')->nullable();
            $table->BigInteger('package_id')->nullable();
            $table->enum('sub_type',['custom','package'])->nullable();
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
        Schema::dropIfExists('telegram_tmp_chats');
    }
}
