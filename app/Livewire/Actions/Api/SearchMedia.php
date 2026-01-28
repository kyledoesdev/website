<?php

namespace App\Livewire\Actions\Api;

use App\Enums\MediaType;
use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Http;

final class SearchMedia
{
    public function search(User $user, string $phrase, MediaType $mediaType)
    {
        $type = $mediaType->value == MediaType::MOVIE->value ? 'movie' : 'tv';

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.config('services.movie_db.access_token'),
            'accept' => 'application/json',
        ])->get("https://api.themoviedb.org/3/search/{$type}", [
            'query' => $phrase,
            'include_adult' => false,
            'language' => 'en-US',
            'page' => 1,
        ]);

        if ($response->successful()) {
            $existingMedia = Media::where('type_id', $mediaType)->pluck('media_id')->toArray();

            return collect($response->json('results'))->map(function ($media) use ($existingMedia, $mediaType) {
                if (in_array($media['id'], $existingMedia)) {
                    return;
                }

                return [
                    'type_id' => $mediaType,
                    'media_id' => $media['id'],
                    'name' => $mediaType->value == MediaType::MOVIE->value ? $media['original_title'] : $media['original_name'],
                    'cover' => 'https://image.tmdb.org/t/p/original'.$media['poster_path'],
                ];
            })->filter();
        }

        return collect();
    }
}
