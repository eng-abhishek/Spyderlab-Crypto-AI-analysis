<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_credits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->double('purchase_price', 10, 2)->default(0);
            $table->integer('received_credits')->default(0);
            $table->integer('available_credits')->default(0);
            $table->enum('is_free', ['Y', 'N']); //Y = Free, N = Paid
            $table->datetime('expired_at')->nullable();
            $table->datetime('created_at');
            $table->unsignedBigInteger('created_by')->nullable();
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
        Schema::dropIfExists('user_credits');
    }
}
