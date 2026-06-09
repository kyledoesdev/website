<?php

namespace Database\Factories;

use App\Enums\MediaType;
use App\Models\Media;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Media>
 */
class MediaFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => MediaType::VIDEO_GAME->value,
            'media_id' => (string) $this->faker->unique()->numberBetween(1, 1_000_000),
            'name' => $this->faker->words(3, true),
            'cover' => $this->faker->imageUrl(),
            'is_favorite' => false,
            'is_active' => false,
            'in_backlog' => false,
            'is_completed' => false,
            'data' => ['total_completion' => false],
        ];
    }

    public function videoGame(): static
    {
        return $this->state(fn () => ['type' => MediaType::VIDEO_GAME->value]);
    }

    public function movie(): static
    {
        return $this->state(fn () => ['type' => MediaType::MOVIE->value]);
    }

    public function tv(): static
    {
        return $this->state(fn () => ['type' => MediaType::TV->value]);
    }
}
