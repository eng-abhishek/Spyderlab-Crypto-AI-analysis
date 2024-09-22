<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockchainSearchResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockchain_search_results', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id', 100);
            $table->unsignedBigInteger('search_id');
            $table->string('type', 100);
            $table->text('chain')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('url', 100)->nullable();
            $table->string('domain', 100)->nullable();
            $table->string('ip', 50)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('symbol', 100)->nullable();
            $table->text('anti_fraud')->nullable();
            $table->text('labels')->nullable();
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
        Schema::dropIfExists('blockchain_search_results');
    }
}
