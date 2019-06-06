<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('frame_id');
            $table->string('type');
            $table->integer('participant_id')->nullable();
            $table->string('event_type')->nullable();
            $table->unsignedInteger('team_id')->nullable();
            $table->string('tower_type')->nullable();
            $table->string('ascended_type')->nullable();
            $table->integer('killer_id')->nullable();
            $table->string('level_up_type')->nullable();
            $table->string('point_captured')->nullable();
            $table->json('assisting_participant_ids')->nullable();
            $table->string('ward_type')->nullable();
            $table->string('monster_type')->nullable();
            $table->integer('skill_shot')->nullable();
            $table->integer('victim_id')->nullable();
            $table->bigInteger('timestamp')->nullable();
            $table->integer('after_id')->nullable();
            $table->string('monster_sub_type')->nullable();
            $table->string('lane_type')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('building_type')->nullable();
            $table->integer('creator_id')->nullable();
            $table->integer('position_x')->nullable();
            $table->integer('position_y')->nullable();
            $table->integer('before_id')->nullable();
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
        Schema::dropIfExists('events');
    }
}
