<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoPlanSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_plan_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('plan_id');
            $table->foreign('plan_id')->references('id')->on('crypto_plans')->onDelecte('cascade');
            $table->enum('plan_type',['Y','M'])->nullable();
            $table->enum('is_active', ['Y', 'N'])->default('Y');
            $table->double('purchese_price',10,2);
            $table->datetime('started_date');
            $table->datetime('expired_date');
            $table->integer('terms_in_month');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
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
        Schema::dropIfExists('crypto_plan_subscriptions');
    }
}
