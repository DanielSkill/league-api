<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Frame extends Model
{
    /**
     * Array of protected attributes
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Each frame has a participant frame which details the participants
     * current stats at the given time.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participantFrames()
    {
        return $this->hasMany('App\Models\ParticipantFrame');
    }

    /**
     * Each frame has events that happened in the game
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }
}
