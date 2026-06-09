<?php

namespace App\Enums;

enum AssetType: string
{
    case PHOTO = 'photo';
    case RESUME = 'resume';
    case THREE_D_PRINTS = 'three_d_prints';

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
