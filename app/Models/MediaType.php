<?php

namespace App\Models;

use App\Models\Model;


class MediaType extends Model
{
    const MOVIE = 1;
    const TV = 2;

    protected $fillable = [
        'name'
    ];

    public function isMovie(): bool
    {
        return $this->getKey() == self::MOVIE;
    }

    public function isTV(): bool
    {
        return $this->getKey() == self::TV;
    }
}
