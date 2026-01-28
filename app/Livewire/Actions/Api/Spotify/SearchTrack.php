<?php

namespace App\Livewire\Actions\Api\Spotify;

use App\Enums\ConnectionType;
use App\Enums\MediaType;
use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

final class SearchTrack
{
    public function handle(User $user, string $phrase): Collection
    {
        (new RefreshToken)->handle($user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->connections->firstWhere('type_id', ConnectionType::SPOTIFY->value)->token,
            'Content-Type' => 'application/json',
            'Client-Id' => config('services.spotify.client_id'),
        ])->get('https://api.spotify.com/v1/search', [
            'q' => $phrase,
            'type' => 'track',
            'limit' => 10,
        ]);

        if ($response->successful()) {
            $tracks = Media::query()
                ->where('type_id', MediaType::TRACK->value)
                ->pluck('media_id')
                ->toArray();

            return collect($response->json('tracks.items'))->map(function ($track) use ($tracks) {
                $cover = data_get($track, 'album.images.0.url');

                if (in_array($track['id'], $tracks) || is_null($cover)) {
                    return;
                }

                return [
                    'type_id' => MediaType::TRACK->value,
                    'media_id' => $track['id'],
                    'name' => $track['name'],
                    'cover' => $cover,
                    'data' => [
                        'artist_name' => data_get($track, 'artists.0.name'),
                        'album_name' => data_get($track, 'album.name'),
                    ],
                ];
            })->filter();
        }

        return collect();
    }
}
