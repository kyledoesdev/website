<?php

namespace App\Livewire\Actions\Api;

use App\Models\ConnectionType;
use App\Models\Media;
use App\Models\MediaType;
use App\Models\User;
use App\Models\VideoGame;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class SearchMedia
{
    public function search(User $user, string $phrase, MediaType $mediaType)
    {
        $type = $mediaType->isMovie() ? 'movie' : 'tv';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.movie_db.access_token'),
            'accept' => 'application/json',
        ])->get("https://api.themoviedb.org/3/search/{$type}", [
            'query' => $phrase,
            'include_adult' => false,
            'language' => 'en-US',
            'page' => 1
        ]);

        if ($response->successful()) {
            $existingMedia = Media::where('type_id', $mediaType->getKey())->pluck('media_id')->toArray();

            return collect($response->json('results'))->map(function($media) use ($existingMedia, $mediaType) {
                if (in_array($media['id'], $existingMedia)) {
                    return;
                }

                return [
                    'type_id'  => $mediaType->getKey(),
                    'media_id' => $media['id'],
                    'name'     => $mediaType->isMovie() ? $media['original_title'] : $media['original_name'],
                    'cover'    => "https://image.tmdb.org/t/p/original" . $media['poster_path'],
                ];
            })->filter();
        }

        return collect();
    }
}