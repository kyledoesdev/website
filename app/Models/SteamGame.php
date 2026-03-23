<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SteamGame extends Model
{
    protected $fillable = [
        'app_id',
        'name',
        'img_icon_url',
        'playtime_forever_minutes',
        'playtime_2weeks_minutes',
        'last_played_at',
        'achievement_total',
        'achievement_unlocked',
        'achievement_completion_pct',
        'achievement_details',
        'priority_score',
        'priority_tier',
    ];

    public function casts(): array
    {
        return [
            'achievement_details' => 'array',
            'last_played_at' => 'date',
        ];
    }

    public function snapshots(): HasMany
    {
        return $this->hasMany(SteamSnapshot::class);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('achievement_total', '>', 0)
            ->where('achievement_completion_pct', 100);
    }

    public function scopeNeverPlayed(Builder $query): Builder
    {
        return $query->where('playtime_forever_minutes', 0);
    }

    public function scopeInProgress(Builder $query): Builder
    {
        return $query->where('playtime_forever_minutes', '>', 0)
            ->where(function (Builder $q) {
                $q->where('achievement_total', 0)
                    ->orWhere('achievement_completion_pct', '<', 100);
            });
    }

    public function scopeHasAchievements(Builder $query): Builder
    {
        return $query->where('achievement_total', '>', 0);
    }

    public function scopeByTier(Builder $query, string $tier): Builder
    {
        return $query->where('priority_tier', $tier);
    }

    public function getPlaytimeHoursAttribute(): float
    {
        return round($this->playtime_forever_minutes / 60, 1);
    }

    public function getRecentPlaytimeHoursAttribute(): float
    {
        return round($this->playtime_2weeks_minutes / 60, 1);
    }

    public function getSteamUrlAttribute(): string
    {
        return "https://store.steampowered.com/app/{$this->app_id}";
    }

    public function getIconUrlAttribute(): ?string
    {
        if (! $this->img_icon_url) {
            return null;
        }

        return "https://media.steampowered.com/steamcommunity/public/images/apps/{$this->app_id}/{$this->img_icon_url}.jpg";
    }

    public function getRemainingAchievementsAttribute(): int
    {
        return $this->achievement_total - $this->achievement_unlocked;
    }

    public function getAvgRemainingDifficultyAttribute(): ?float
    {
        if (! $this->achievement_details || $this->remaining_achievements <= 0) {
            return null;
        }

        $unachieved = collect($this->achievement_details)
            ->filter(fn (array $a) => ! $a['achieved'])
            ->pluck('global_pct')
            ->filter(fn ($pct) => $pct !== null);

        if ($unachieved->isEmpty()) {
            return null;
        }

        return round($unachieved->avg(), 2);
    }
}
