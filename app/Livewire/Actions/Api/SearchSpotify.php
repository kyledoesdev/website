<?php

namespace App\Livewire\Actions\Api;

use App\Enums\ConnectionType;
use App\Models\Media;
use App\Models\MediaType;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class SearchSpotify
{
    public function search(User $user, string $phrase, MediaType $mediaType)
    {
        $this->refreshToken($user);

        $type = $mediaType->isArtist() ? 'artist' : 'track';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->connections->firstWhere('type_id', ConnectionType::SPOTIFY->value)->token,
            'Content-Type' => 'application/json',
            'Client-Id' => config('services.spotify.client_id'),
        ])->get('https://api.spotify.com/v1/search', [
            'q' => $phrase,
            'type' => $type,
            'limit' => 10,
        ]);

        if ($response->successful()) {
            $collection = null;

            if ($mediaType->isArtist()) {
                $artists = Media::where('type_id', MediaType::ARTIST)->pluck('media_id')->toArray();

                $collection = collect($response->json('artists.items'))->map(function ($artist) use ($artists) {
                    $cover = data_get($artist, 'images.0.url');

                    if (in_array($artist['id'], $artists) || is_null($cover)) {
                        return;
                    }

                    return [
                        'type_id' => MediaType::ARTIST,
                        'media_id' => $artist['id'],
                        'name' => $artist['name'],
                        'cover' => $cover,
                        'data' => null,
                    ];
                })->filter();
            } else {
                $tracks = Media::where('type_id', MediaType::TRACK)->pluck('media_id')->toArray();

                $collection = collect($response->json('tracks.items'))->map(function ($track) use ($tracks) {
                    $cover = data_get($track, 'album.images.0.url');

                    if (in_array($track['id'], $tracks) || is_null($cover)) {
                        return;
                    }

                    return [
                        'type_id' => MediaType::TRACK,
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

            return $collection;
        }

        return collect();
    }

    public function refreshToken(User $user): bool
    {
        try {
            $spotifyConnection = $user->connections->firstWhere('type_id', ConnectionType::SPOTIFY->value);

            $response = Http::asForm()->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => $spotifyConnection->refresh_token,
                'client_id' => config('services.spotify.client_id'),
                'client_secret' => config('services.spotify.client_secret'),
            ]);

            if (! $response->successful()) {
                return false;
            }

            $spotifyConnection->update(['token' => $response->json()['access_token']]);

            return true;
        } catch (Exception $e) {
            Log::error("Could not refresh user: {$user->name} token: {$e->getMessage()}");

            return false;
        }
    }
}
