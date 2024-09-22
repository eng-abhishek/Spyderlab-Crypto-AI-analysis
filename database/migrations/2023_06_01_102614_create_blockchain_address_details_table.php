<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockchainAddressDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockchain_address_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('search_id');
            $table->string('currency', 100);
            $table->string('address', 255);
            $table->decimal('total_received', 64, 0)->comment('In Satoshi');
            $table->decimal('total_sent', 64, 0)->comment('In Satoshi');
            $table->decimal('balance', 64, 0)->comment('In Satoshi');
            $table->integer('total_txn');
            $table->integer('incoming_txn');
            $table->integer('outgoing_txn');
            $table->datetime('first_seen_at')->nullable();
            $table->datetime('last_seen_at')->nullable();
            $table->datetime('created_at');
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
        Schema::dropIfExists('blockchain_address_details');
    }
}
