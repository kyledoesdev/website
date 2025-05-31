<?php

namespace Database\Factories;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asset>
 */
class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        
        return [
            'type_id' => $this->faker->randomElement([Asset::PHOTO, Asset::RESUME]),
            'name' => $name,
            'slug' => Str::slug($name),
            'path' => $this->faker->filePath(),
            'mime_type' => 'image/jpeg',
            'data' => [
                'size' => $this->faker->numberBetween(1024, 5242880),
                'original_name' => $this->faker->word() . '.jpg',
                'captured_at' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * Create a photo asset
     */
    public function photo(): static
    {
        return $this->state(fn (array $attributes) => [
            'type_id' => Asset::PHOTO,
            'mime_type' => $this->faker->randomElement([
                'image/jpeg',
                'image/png',
                'image/gif',
                'image/webp'
            ]),
            'data' => array_merge($attributes['data'] ?? [], [
                'width' => $this->faker->numberBetween(800, 4000),
                'height' => $this->faker->numberBetween(600, 3000),
                'original_name' => $this->faker->word() . '.' . $this->faker->randomElement(['jpg', 'png', 'gif']),
            ]),
        ]);
    }

    public function resume(): static
    {
        return $this->state(fn (array $attributes) => [
            'type_id' => Asset::RESUME,
            'mime_type' => $this->faker->randomElement([
                'application/pdf',
            ]),
            'data' => array_merge($attributes['data'] ?? [], [
                'pages' => $this->faker->numberBetween(1, 10),
                'original_name' => $this->faker->lastName() . '_resume.' . $this->faker->randomElement(['pdf', 'doc', 'docx']),
            ]),
        ]);
    }

    public function withoutCapturedAt(): static
    {
        return $this->state(function (array $attributes) {
            $data = $attributes['data'] ?? [];
            unset($data['captured_at']);
            
            return ['data' => $data];
        });
    }

    public function capturedAt(string $date): static
    {
        return $this->state(fn (array $attributes) => [
            'data' => array_merge($attributes['data'] ?? [], [
                'captured_at' => $date,
            ]),
        ]);
    }

    public function minimal(): static
    {
        return $this->state(fn (array $attributes) => [
            'data' => [
                'size' => $this->faker->numberBetween(1024, 102400),
            ],
        ]);
    }
}