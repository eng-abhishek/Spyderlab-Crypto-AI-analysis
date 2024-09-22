<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestigationTxnHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investigation_txn_histories', function (Blueprint $table) {
            $table->id();
            $table->datetime('txn_time')->nullable();
            $table->string('txn_has',225);
            $table->string('txn_id',225);
            $table->string('txn_amount',150);
            $table->string('token',25);
            $table->string('address',225);
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
        Schema::dropIfExists('investigation_txn_histories');
    }
}
