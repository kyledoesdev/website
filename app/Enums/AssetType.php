<?php

namespace App\Enums;

enum AssetType: int
{
    case PHOTO = 1;
    case RESUME = 2;
    case THREE_D_PRINTS = 3;

    public function label(): string
    {
        return match ($this) {
            self::PHOTO => 'Photo',
            self::RESUME => 'Resume',
            self::THREE_D_PRINTS => '3D Print',
        };
    }

    public function storageDirectory(): string
    {
        return match ($this) {
            self::THREE_D_PRINTS => '3D_prints',
            default => 'photos',
        };
    }
}
