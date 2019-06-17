<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('game_id');
            $table->string('platform_id');
            $table->unsignedBigInteger('game_creation');
            $table->unsignedInteger('game_duration');
            $table->unsignedInteger('queue_id');
            $table->unsignedInteger('map_id');
            $table->unsignedInteger('season_id');
            $table->string('game_version');
            $table->string('game_mode');
            $table->string('game_type');
            $table->json('timeline');
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
        Schema::dropIfExists('matches');
    }
}
