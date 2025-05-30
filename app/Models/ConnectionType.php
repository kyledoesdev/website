<?php

namespace App\Models;

class ConnectionType extends Model
{
    const SPOTIFY = 1;

    const TWITCH = 2;

    protected $fillable = [
        'name',
    ];
}
