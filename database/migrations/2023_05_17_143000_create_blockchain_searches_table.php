<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockchainSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blockchain_searches', function (Blueprint $table) {
            $table->id();
            $table->string('search_key', 255)->nullable();;
            $table->string('keyword', 255);
            $table->string('status_code', 50);
            $table->string('message', 255)->nullable();
            $table->longText('result')->nullable();
            $table->datetime('created_at');
            $table->datetime('updated_at')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blockchain_searches');
    }
}
