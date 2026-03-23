<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SteamSnapshot extends Model
{
    protected $fillable = [
        'steam_game_id',
        'playtime_forever_minutes',
        'playtime_2weeks_minutes',
        'achievement_unlocked',
        'achievement_completion_pct',
        'priority_score',
        'fetched_at',
    ];

    public function casts(): array
    {
        return [
            'fetched_at' => 'datetime',
        ];
    }

    public function steamGame(): BelongsTo
    {
        return $this->belongsTo(SteamGame::class);
    }
}
