<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParticipantFramesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participant_frames', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('frame_id');
            $table->unsignedInteger('participant_id');
            $table->integer('total_gold');
            $table->integer('team_score');
            $table->integer('level');
            $table->integer('current_gold');
            $table->integer('minions_killed');
            $table->integer('dominion_score');
            $table->integer('position_x');
            $table->integer('position_y');
            $table->integer('xp');
            $table->integer('jungle_minions_killed');
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
        Schema::dropIfExists('participant_frames');
    }
}
