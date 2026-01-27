<?php

namespace App\Enums;

enum ConnectionType: int
{
    case SPOTIFY = 1;
    case TWITCH = 2;

    public function label()
    {
        return match($this) {
            self::SPOTIFY => 'Spotify',
            self::TWITCH => 'Twitch',
        };
    }

    public function slug()
    {
        return match($this) {
            self::SPOTIFY => 'spotify',
            self::TWITCH => 'twitch',
        };
    }
}
