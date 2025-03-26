<?php

namespace App\Models;

use App\Models\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;

class VideoGame extends Model
{
    protected $fillable = [
        'twitch_id',
        'name',
        'rank',
        'cover',
        'is_favorite',
        'is_active',
        'in_backlog',
        'is_completed',
    ];

    public function casts(): array
    {
        return [
            'is_favorite' => 'boolean',
            'is_active' => 'boolean',
            'in_backlog' => 'boolean',
            'is_completed' => 'boolean',
        ];
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('default_order', fn (Builder $query) => $query->orderBy('rank', 'asc')->orderBy('name', 'asc'));
    }
}
