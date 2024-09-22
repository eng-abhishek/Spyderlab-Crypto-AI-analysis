<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveAttackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_attackers', function (Blueprint $table) {
            $table->id();
            $table->datetime('timestamp')->nullable();
            $table->string('attacker');
            $table->string('attacker_ip');
            $table->string('attacker_geo');
            $table->string('target_geo');
            $table->string('attacker_type');
            $table->string('port');
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
        Schema::dropIfExists('live_attackers');
    }
}
