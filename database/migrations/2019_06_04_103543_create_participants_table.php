<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('summoner_id');
            $table->unsignedBigInteger('match_id');
            $table->integer('team_id');
            $table->integer('champion_id');
            $table->integer('summoner_spell_1');
            $table->integer('summoner_spell_2');
            $table->string('highest_achieved_season_tier')->nullable();
            $table->json('stats');
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
        Schema::dropIfExists('participants');
    }
}
