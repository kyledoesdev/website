<?php

namespace App\Services;

use App\Models\SteamGame;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SteamService
{
    private const BASE_URL = 'https://api.steampowered.com';

    /** @var int[] */
    private const EXCLUDED_APP_IDS = [
        431960,  // Wallpaper Engine
        404790,  // Godot Engine
    ];

    public function fetchOwnedGames(): ?array
    {
        $response = Http::get(self::BASE_URL.'/IPlayerService/GetOwnedGames/v1/', [
            'key' => config('services.steam.api_key'),
            'steamid' => config('services.steam.steam_id'),
            'include_appinfo' => 1,
            'include_played_free_games' => 1,
            'format' => 'json',
        ]);

        return $response->successful() ? $response->json('response') : null;
    }

    public function fetchPlayerAchievements(int $appId): ?array
    {
        try {
            $response = Http::get(self::BASE_URL.'/ISteamUserStats/GetPlayerAchievements/v1/', [
                'key' => config('services.steam.api_key'),
                'steamid' => config('services.steam.steam_id'),
                'appid' => $appId,
                'l' => 'en',
            ]);

            if ($response->successful() && $response->json('playerstats.success')) {
                return $response->json('playerstats.achievements', []);
            }
        } catch (\Exception) {
            // Game might not have achievements
        }

        return null;
    }

    public function fetchGlobalAchievementPercentages(int $appId): ?array
    {
        try {
            $response = Http::get(self::BASE_URL.'/ISteamUserStats/GetGlobalAchievementPercentagesForApp/v2/', [
                'gameid' => $appId,
                'format' => 'json',
            ]);

            if ($response->successful()) {
                return $response->json('achievementpercentages.achievements', []);
            }
        } catch (\Exception) {
            // Game might not have achievements
        }

        return null;
    }

    /**
     * Merge player achievement data with global percentages.
     *
     * @return array<int, array{api_name: string, achieved: bool, unlock_time: string|null, global_pct: float|null}>
     */
    public function mergeAchievementData(?array $playerAchievements, ?array $globalAchievements): array
    {
        $globalMap = collect($globalAchievements ?? [])->keyBy('name');

        return collect($playerAchievements ?? [])->map(function (array $achievement) use ($globalMap) {
            $globalPct = $globalMap->get($achievement['apiname']);

            return [
                'api_name' => $achievement['apiname'],
                'achieved' => (bool) $achievement['achieved'],
                'unlock_time' => $achievement['unlocktime'] > 0
                    ? date('Y-m-d H:i:s', $achievement['unlocktime'])
                    : null,
                'global_pct' => $globalPct ? round($globalPct['percent'], 2) : null,
            ];
        })->all();
    }

    /**
     * @return array{score: float, tier: string}
     */
    public function calculatePriorityScore(SteamGame $game): array
    {
        if ($game->achievement_total > 0 && $game->achievement_completion_pct >= 100) {
            return ['score' => 0, 'tier' => 'completed'];
        }

        if ($this->isExcluded($game)) {
            return ['score' => 0, 'tier' => 'excluded'];
        }

        $tier = $this->determineTier($game);
        $score = $this->computeScore($game);

        return ['score' => round($score, 2), 'tier' => $tier];
    }

    public function calculateAllPriorityScores(): void
    {
        SteamGame::query()->chunk(200, function ($games) {
            foreach ($games as $game) {
                $result = $this->calculatePriorityScore($game);
                $game->update([
                    'priority_score' => $result['score'],
                    'priority_tier' => $result['tier'],
                ]);
            }
        });
    }

    private function isExcluded(SteamGame $game): bool
    {
        if (in_array($game->app_id, self::EXCLUDED_APP_IDS)) {
            return true;
        }

        return $game->achievement_total === 0
            && $game->playtime_forever_minutes > 0
            && $game->achievement_details === null;
    }

    private function determineTier(SteamGame $game): string
    {
        if ($game->playtime_2weeks_minutes >= 480) {
            return 'active';
        }

        if ($game->achievement_total > 0 && $game->achievement_completion_pct >= 70) {
            return 'close_to_complete';
        }

        if ($game->playtime_forever_minutes > 0 && $game->achievement_unlocked > 0 && $game->achievement_completion_pct < 70) {
            return 'in_progress';
        }

        if ($game->playtime_forever_minutes > 0 && ($game->achievement_unlocked === 0 || $game->achievement_total === 0)) {
            return 'backlog';
        }

        return 'never_played';
    }

    private function computeScore(SteamGame $game): float
    {
        $activeBoost = $this->calculateActiveBoost($game);
        $completionScore = $this->calculateCompletionScore($game);
        $feasibilityScore = $this->calculateFeasibilityScore($game);
        $countBonus = $this->calculateCountBonus($game);
        $recency = $this->calculateRecency($game);

        return $activeBoost + $completionScore + $feasibilityScore + $countBonus + $recency;
    }

    private function calculateActiveBoost(SteamGame $game): float
    {
        if ($game->playtime_2weeks_minutes >= 480) {
            return 50;
        }

        if ($game->playtime_2weeks_minutes > 0) {
            return ($game->playtime_2weeks_minutes / 480) * 30;
        }

        return 0;
    }

    private function calculateCompletionScore(SteamGame $game): float
    {
        if ($game->achievement_total > 0) {
            return ($game->achievement_completion_pct / 100) * 30;
        }

        return 0;
    }

    private function calculateFeasibilityScore(SteamGame $game): float
    {
        $remaining = $game->remaining_achievements;

        if ($remaining <= 0 || ! $game->achievement_details) {
            return 5;
        }

        $unachieved = collect($game->achievement_details)
            ->filter(fn (array $a) => ! $a['achieved'])
            ->pluck('global_pct')
            ->filter(fn ($pct) => $pct !== null);

        if ($unachieved->isEmpty()) {
            return 5;
        }

        $avgRemainingGlobalPct = $unachieved->avg();
        $feasibility = ($avgRemainingGlobalPct / 100) * 20;

        $ultraHardCount = $unachieved->filter(fn ($pct) => $pct < 5)->count();
        $ultraHardRatio = $ultraHardCount / $remaining;
        $feasibility = $feasibility * (1 - ($ultraHardRatio * 0.5));

        return $feasibility;
    }

    private function calculateCountBonus(SteamGame $game): float
    {
        if ($game->achievement_total > 0 && $game->remaining_achievements > 0) {
            $remainingRatio = $game->remaining_achievements / $game->achievement_total;

            return (1 - $remainingRatio) * 10;
        }

        return 0;
    }

    private function calculateRecency(SteamGame $game): float
    {
        if (! $game->last_played_at) {
            return -5;
        }

        $daysSincePlayed = $game->last_played_at->diffInDays(Carbon::today());

        if ($daysSincePlayed <= 30) {
            return 5;
        }

        if ($daysSincePlayed <= 90) {
            return 3;
        }

        if ($daysSincePlayed <= 365) {
            return 0;
        }

        return -3;
    }
}
