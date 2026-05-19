<?php

namespace App\Enums\Media;

use App\Models\Media;

enum TvState: string
{
    case Favorite = 'is_favorite';
    case Active = 'is_active';
    case Backlog = 'in_backlog';
    case Completed = 'is_completed';

    public function label(): string
    {
        return match ($this) {
            self::Favorite => 'Favorite',
            self::Active => 'Watching',
            self::Backlog => 'Backlog',
            self::Completed => 'Completed',
        };
    }

    public function getValue(Media $media): bool
    {
        return (bool) $media->{$this->value};
    }
}
