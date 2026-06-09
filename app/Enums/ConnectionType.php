<?php

namespace App\Enums;

enum ConnectionType: string
{
    case SPOTIFY = 'spotify';
    case TWITCH = 'twitch';

    public function label(): string
    {
        return match ($this) {
            self::SPOTIFY => 'Spotify',
            self::TWITCH => 'Twitch',
        };
    }
}
