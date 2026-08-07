<?php

namespace Database\Factories;

use App\Models\WeatherReportCity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WeatherReportCity>
 */
class WeatherReportCityFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city' => $this->faker->unique()->city(),
            'state' => $this->faker->stateAbbr(),
            'latitude' => $this->faker->latitude(25, 49),
            'longitude' => $this->faker->longitude(-124, -67),
        ];
    }

    public function philadelphia(): static
    {
        return $this->state(fn () => [
            'city' => 'Philadelphia',
            'state' => 'PA',
            'latitude' => 39.9526,
            'longitude' => -75.1652,
        ]);
    }
}
