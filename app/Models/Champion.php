<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Champion extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'passive' => 'object',
        'skins' => 'array',
        'spells' => 'array',
        'info' => 'object',
        'image' => 'object',
        'tags' => 'array',
        'stats' => 'object'
    ];
}
