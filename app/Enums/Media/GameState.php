<?php

namespace App\Enums\Media;

use App\Models\Media;

enum GameState: string
{
    case Favorite = 'is_favorite';
    case Active = 'is_active';
    case Backlog = 'in_backlog';
    case Completed = 'is_completed';
    case TotalCompletion = 'total_completion';

    public function label(): string
    {
        return match ($this) {
            self::Favorite => 'Favorite',
            self::Active => 'Playing',
            self::Backlog => 'Backlog',
            self::Completed => 'Played Before',
            self::TotalCompletion => '100%-ed',
        };
    }

    public function getValue(Media $media): bool
    {
        if ($this === self::TotalCompletion) {
            return (bool) ($media->data['total_completion'] ?? false);
        }

        return (bool) $media->{$this->value};
    }
}
