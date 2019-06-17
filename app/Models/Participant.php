<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    /**
     * Array of protected attributes
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'stats' => 'object',
    ];

    /**
     * The participants summoner details
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function summoner()
    {
        return $this->hasOne('App\Models\Summoner', 'summoner_id', 'summoner_id');
    }
}
