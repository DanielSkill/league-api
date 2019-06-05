<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Summoner extends Model
{
    /**
     * Array of protected attributes
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Relationship to get all matches summoner has been a participant in
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function matches()
    {
        return $this->hasManyThrough('App\Models\Match', 'App\Models\Participant', 'summoner_id', 'game_id', 'summoner_id', 'match_id');
    }
}
