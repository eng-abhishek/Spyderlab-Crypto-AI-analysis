<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockchainAddressTxnInoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockchain_address_txn_inouts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('address_detail_id');
            $table->string('txn_id', 255);
            $table->string('from', 255);
            $table->string('to', 255);
            $table->decimal('amount', 64, 0)->comment('In Satoshi');
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
        Schema::dropIfExists('blockchain_address_txn_inouts');
    }
}
