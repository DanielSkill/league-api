<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    /**
     * Array of protected attributes
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Participants relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany('App\Models\Participant', 'match_id', 'game_id');
    }

    /**
     * Teams relationship (2 teams per game)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany('App\Models\Team', 'match_id', 'game_id');
    }
}
