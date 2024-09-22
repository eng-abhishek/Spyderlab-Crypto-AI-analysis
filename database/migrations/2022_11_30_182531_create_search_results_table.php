<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_results', function (Blueprint $table) {
            $table->id();
            $table->enum('search_key', ['phone', 'email', 'username']);
            $table->string('country_code', 5)->nullable();
            $table->string('search_value', 100);
            $table->string('status_code', 50);
            $table->string('message')->nullable();
            $table->longText('result')->nullable();
            $table->enum('record_type',['through_api','manual_entry'])->define('through_api');
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
        Schema::dropIfExists('search_results');
    }
}
