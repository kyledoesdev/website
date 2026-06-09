<?php

namespace App\Enums;

enum MediaType: string
{
    case MOVIE = 'movie';
    case TV = 'tv';
    case ARTIST = 'artist';
    case TRACK = 'track';
    case VIDEO_GAME = 'video_game';

    public function label(): string
    {
        return match ($this) {
            self::MOVIE => 'Movie',
            self::TV => 'Tv',
            self::ARTIST => 'Artist',
            self::TRACK => 'Track',
            self::VIDEO_GAME => 'Video Game',
        };
    }
}
