<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempSearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_searches', function (Blueprint $table) {
            $table->string('name',225)->nullable();
            $table->string('mobile',225)->nullable();
            $table->string('email',225)->nullable();
            $table->string('city',225)->nullable();
            $table->string('state',225)->nullable();
            $table->string('country',225)->nullable();
            $table->string('gender',225)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_searches');
    }
}
