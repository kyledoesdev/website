<?php

namespace Database\Seeders;

use App\Models\WeatherReportCity;
use Illuminate\Database\Seeder;

class WeatherReportCitySeeder extends Seeder
{
    /**
     * @var array<int, array{city: string, state: string, latitude: float, longitude: float}>
     */
    private const array CITIES = [
        ['city' => 'Philadelphia', 'state' => 'PA', 'latitude' => 39.9526, 'longitude' => -75.1652],
    ];

    public function run(): void
    {
        foreach (self::CITIES as $city) {
            WeatherReportCity::firstOrCreate(
                ['city' => $city['city'], 'state' => $city['state']],
                $city
            );
        }
    }
}
