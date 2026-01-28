<?php

namespace App\Livewire\Actions\Api\Spotify;

use App\Enums\ConnectionType;
use App\Enums\MediaType;
use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Http;

final class SearchArtist
{
    public function handle(User $user, string $phrase)
    {
        (new RefreshToken)->handle($user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->connections->firstWhere('type_id', ConnectionType::SPOTIFY->value)->token,
            'Content-Type' => 'application/json',
            'Client-Id' => config('services.spotify.client_id'),
        ])->get('https://api.spotify.com/v1/search', [
            'q' => $phrase,
            'type' => 'artist',
            'limit' => 10,
        ]);

        if ($response->successful()) {
            $artists = Media::query()
                ->where('type_id', MediaType::ARTIST->value)
                ->pluck('media_id')
                ->toArray();

            return collect($response->json('artists.items'))->map(function ($artist) use ($artists) {
                $cover = data_get($artist, 'images.0.url');

                if (in_array($artist['id'], $artists) || is_null($cover)) {
                    return;
                }

                return [
                    'type_id' => MediaType::ARTIST->value,
                    'media_id' => $artist['id'],
                    'name' => $artist['name'],
                    'cover' => $cover,
                    'data' => null,
                ];
            })->filter();
        }

        return collect();
    }
}
