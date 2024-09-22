<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->double('monthly_price', 10, 2);
            $table->double('yearly_price', 10, 2);
            $table->enum('is_free',['Y','N'])->default('N');
            $table->unsignedBigInteger('duration');
            $table->enum('is_featured_plan', ['Y', 'N'])->default('N');
            $table->text('feature')->nullable();
            $table->text('description')->nullable();
            $table->enum('is_active', ['Y', 'N'])->default('Y');
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
        Schema::dropIfExists('crypto_plans');
    }
}
