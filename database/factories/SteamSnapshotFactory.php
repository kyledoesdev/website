<?php

namespace Database\Factories;

use App\Models\SteamGame;
use App\Models\SteamSnapshot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SteamSnapshot>
 */
class SteamSnapshotFactory extends Factory
{
    public function definition(): array
    {
        return [
            'steam_game_id' => SteamGame::factory(),
            'playtime_forever_minutes' => fake()->numberBetween(0, 50000),
            'playtime_2weeks_minutes' => fake()->numberBetween(0, 2000),
            'achievement_unlocked' => fake()->numberBetween(0, 50),
            'achievement_completion_pct' => fake()->randomFloat(1, 0, 100),
            'priority_score' => fake()->randomFloat(2, 0, 100),
            'fetched_at' => now(),
        ];
    }
}
