<?php

namespace Database\Factories;

use App\Models\SteamGame;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SteamGame>
 */
class SteamGameFactory extends Factory
{
    public function definition(): array
    {
        $total = fake()->numberBetween(10, 100);
        $unlocked = fake()->numberBetween(0, $total);

        return [
            'app_id' => fake()->unique()->numberBetween(10000, 999999),
            'name' => fake()->words(3, true),
            'img_icon_url' => fake()->md5(),
            'playtime_forever_minutes' => fake()->numberBetween(0, 50000),
            'playtime_2weeks_minutes' => fake()->numberBetween(0, 2000),
            'last_played_at' => fake()->dateTimeBetween('-2 years', 'now'),
            'achievement_total' => $total,
            'achievement_unlocked' => $unlocked,
            'achievement_completion_pct' => $total > 0 ? round(($unlocked / $total) * 100, 1) : 0,
            'achievement_details' => null,
            'priority_score' => 0,
            'priority_tier' => null,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn () => [
            'achievement_total' => 50,
            'achievement_unlocked' => 50,
            'achievement_completion_pct' => 100,
            'priority_tier' => 'completed',
            'priority_score' => 0,
        ]);
    }

    public function neverPlayed(): static
    {
        return $this->state(fn () => [
            'playtime_forever_minutes' => 0,
            'playtime_2weeks_minutes' => 0,
            'last_played_at' => null,
            'achievement_unlocked' => 0,
            'achievement_completion_pct' => 0,
            'priority_tier' => 'never_played',
        ]);
    }

    public function active(): static
    {
        return $this->state(fn () => [
            'playtime_2weeks_minutes' => 600,
            'last_played_at' => now(),
            'priority_tier' => 'active',
        ]);
    }

    public function closeToComplete(): static
    {
        return $this->state(fn () => [
            'achievement_total' => 50,
            'achievement_unlocked' => 44,
            'achievement_completion_pct' => 88.0,
            'priority_tier' => 'close_to_complete',
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn () => [
            'playtime_forever_minutes' => 3000,
            'achievement_total' => 50,
            'achievement_unlocked' => 15,
            'achievement_completion_pct' => 30.0,
            'priority_tier' => 'in_progress',
        ]);
    }

    public function backlog(): static
    {
        return $this->state(fn () => [
            'playtime_forever_minutes' => 120,
            'achievement_total' => 30,
            'achievement_unlocked' => 0,
            'achievement_completion_pct' => 0,
            'priority_tier' => 'backlog',
        ]);
    }

    public function excluded(): static
    {
        return $this->state(fn () => [
            'achievement_total' => 0,
            'achievement_unlocked' => 0,
            'achievement_completion_pct' => 0,
            'priority_tier' => 'excluded',
            'priority_score' => 0,
        ]);
    }

    public function withAchievementDetails(): static
    {
        return $this->state(function (array $attributes) {
            $total = $attributes['achievement_total'] ?? 20;
            $unlocked = $attributes['achievement_unlocked'] ?? 10;
            $details = [];

            for ($i = 0; $i < $total; $i++) {
                $details[] = [
                    'api_name' => "achievement_{$i}",
                    'achieved' => $i < $unlocked,
                    'unlock_time' => $i < $unlocked ? now()->subDays(fake()->numberBetween(1, 365))->format('Y-m-d H:i:s') : null,
                    'global_pct' => fake()->randomFloat(2, 1, 95),
                ];
            }

            return ['achievement_details' => $details];
        });
    }
}
