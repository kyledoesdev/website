<?php

namespace App\Actions\Api\Geocodio;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

final class SearchCities
{
    private const string ENDPOINT = 'https://api.geocod.io/v1.9/geocode';

    private const int LIMIT = 5;

    private const int MINIMUM_PHRASE_LENGTH = 3;

    /**
     * @return Collection<int, array{city: string, state: string, latitude: float, longitude: float}>
     */
    public function handle(string $phrase): Collection
    {
        $phrase = trim($phrase);

        if (strlen($phrase) < self::MINIMUM_PHRASE_LENGTH) {
            return collect();
        }

        $response = Http::timeout(10)->get(self::ENDPOINT, [
            'q' => $phrase,
            'api_key' => config('services.geocodio.api_key'),
            'limit' => self::LIMIT,
        ]);

        if ($response->failed()) {
            return collect();
        }

        return collect($response->json('results') ?? [])
            ->map(fn (array $result): ?array => $this->toCity($result))
            ->filter()
            ->unique(fn (array $city): string => "{$city['city']}, {$city['state']}")
            ->values();
    }

    /**
     * @param  array<string, mixed>  $result
     * @return array{city: string, state: string, latitude: float, longitude: float}|null
     */
    private function toCity(array $result): ?array
    {
        $city = data_get($result, 'address_components.city');
        $state = data_get($result, 'address_components.state');
        $latitude = data_get($result, 'location.lat');
        $longitude = data_get($result, 'location.lng');

        if (! is_string($city) || ! is_string($state) || ! is_numeric($latitude) || ! is_numeric($longitude)) {
            return null;
        }

        return [
            'city' => $city,
            'state' => $state,
            'latitude' => round((float) $latitude, 7),
            'longitude' => round((float) $longitude, 7),
        ];
    }
}
