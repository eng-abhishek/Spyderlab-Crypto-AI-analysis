<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockchainAddressTxnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockchain_address_txn', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('address_detail_id');
            $table->string('txn_id', 255);
            $table->string('block_hash', 255);
            $table->integer('block_height');
            $table->decimal('amount', 64, 0)->comment('In Satoshi');
            $table->decimal('fees', 64, 0)->comment('In Satoshi');
            $table->datetime('confirmed_at');
            $table->text('inputs')->nullable();
            $table->text('outputs')->nullable();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blockchain_address_txn');
    }
}
