<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('match_id');
            $table->boolean('win');
            $table->boolean('first_blood');
            $table->boolean('first_dragon');
            $table->boolean('first_baron');
            $table->boolean('first_inhibitor');
            $table->boolean('first_tower');
            $table->boolean('first_rift_herald');
            $table->integer('baron_kills');
            $table->integer('dragon_kills');
            $table->integer('tower_kills');
            $table->integer('inhibitor_kills');
            $table->integer('rift_herald_kills');
            $table->integer('vilemaw_kills');
            $table->integer('team_id');
            $table->json('bans');
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
        Schema::dropIfExists('teams');
    }
}
