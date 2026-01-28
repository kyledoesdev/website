<?php

namespace App\Enums;

enum MediaType: int
{
    case MOVIE = 1;
    case TV = 2;
    case ARTIST = 3;
    case TRACK = 4;
    case VIDEO_GAME = 5;

    public function label(): string
    {
        return match($this) {
            self::MOVIE => 'Movie',
            self::TV => 'Tv',
            self::ARTIST => 'Artist',
            self::TRACK => 'Track',
            self::VIDEO_GAME => 'Video Game',
        };
    }
}
