<?php

namespace App\Models;

class MediaType extends Model
{
    const MOVIE = 1;

    const TV = 2;

    const ARTIST = 3;

    const TRACK = 4;

    const VIDEO_GAME = 5;

    protected $fillable = [
        'name',
    ];

    public function isMovie(): bool
    {
        return $this->getKey() == self::MOVIE;
    }

    public function isTV(): bool
    {
        return $this->getKey() == self::TV;
    }

    public function isArtist(): bool
    {
        return $this->getKey() == self::ARTIST;
    }
}
