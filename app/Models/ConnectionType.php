<?php

namespace App\Models;

use App\Models\Model;

class ConnectionType extends Model
{
    const SPOTIFY = 1;
    const TWITCH = 2;

    protected $fillable = [
        'name'
    ];
}
