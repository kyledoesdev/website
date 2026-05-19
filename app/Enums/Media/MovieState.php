<?php

namespace App\Enums\Media;

use App\Models\Media;

enum MovieState: string
{
    case Favorite = 'is_favorite';
    case Backlog = 'in_backlog';
    case Completed = 'is_completed';

    public function label(): string
    {
        return match ($this) {
            self::Favorite => 'Favorite',
            self::Backlog => 'Backlog',
            self::Completed => 'Completed',
        };
    }

    public function getValue(Media $media): bool
    {
        return (bool) $media->{$this->value};
    }
}
