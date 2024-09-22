<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockchainSearchHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockchain_search_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('search_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address', 50);
            $table->string('location', 100)->nullable();
            $table->text('user_agent')->nullable();
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
        Schema::dropIfExists('blockchain_search_histories');
    }
}
