<?php

namespace App\Livewire\Actions\Api\Twitch;

use App\Enums\ConnectionType;
use App\Enums\MediaType;
use App\Models\Media;
use App\Models\User;
use Illuminate\Support\Facades\Http;

final class SearchCategories
{
    public function search(User $user, string $phrase, MediaType $mediaType)
    {
        (new RefreshToken)->handle($user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->connections->firstWhere('type_id', ConnectionType::TWITCH->value)->token,
            'Content-Type' => 'application/json',
            'Client-Id' => config('services.twitch.client_id'),
        ])->get('https://api.twitch.tv/helix/search/categories', [
            'query' => $phrase,
            'first' => 9,
        ]);

        if ($response->successful()) {
            $games = Media::where('type_id', $mediaType->value)->pluck('media_id')->toArray();

            return collect($response->json('data'))->map(function ($game) use ($games, $mediaType) {
                if (in_array($game['id'], $games)) {
                    return null;
                }

                return [
                    'type_id' => $mediaType->value,
                    'media_id' => $game['id'],
                    'name' => $game['name'],
                    'cover' => $this->fix_box_art($game['box_art_url']),
                ];
            })->filter();
        }

        return collect();
    }
    
    /* disgusting hack to get high rez images from this endpoint */
    private function fix_box_art(string $string): string
    {
        return str_replace(['-52', 'x72'], ['-285', 'x380'], $string);
    }
}
