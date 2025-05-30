<?php

namespace App\Livewire\Actions\Api;

use App\Models\ConnectionType;
use App\Models\Media;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class SearchCategories
{
    public function search(User $user, string $phrase, int $mediaType)
    {
        $this->refreshToken($user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$user->connections->firstWhere('type_id', ConnectionType::TWITCH)->token,
            'Content-Type' => 'application/json',
            'Client-Id' => config('services.twitch.client_id'),
        ])->get('https://api.twitch.tv/helix/search/categories', [
            'query' => $phrase,
            'first' => 9,
        ]);

        if ($response->successful()) {
            $games = Media::where('type_id', $mediaType)->pluck('media_id')->toArray();

            return collect($response->json('data'))->map(function ($game) use ($games, $mediaType) {
                if (in_array($game['id'], $games)) {
                    return null;
                }

                return [
                    'type_id' => $mediaType,
                    'media_id' => $game['id'],
                    'name' => $game['name'],
                    'cover' => $this->fix_box_art($game['box_art_url']),
                ];
            })->filter();
        }

        return collect();
    }

    public function refreshToken(User $user): bool
    {
        try {
            $twitchConnection = $user->connections->firstWhere('type_id', ConnectionType::TWITCH);

            $response = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
                'client_id' => config('services.twitch.client_id'),
                'client_secret' => config('services.twitch.client_secret'),
                'refresh_token' => $twitchConnection->refresh_token,
                'grant_type' => 'refresh_token',
            ]);

            if (! $response->successful()) {
                return false;
            }

            $twitchConnection->update(['token' => $response->json()['access_token']]);

            return true;
        } catch (Exception $e) {
            Log::error("Could not refresh user: {$user->name} token: {$e->getMessage()}");

            return false;
        }
    }

    /* disgusting hack to get high rez images from this endpoint */
    private function fix_box_art(string $string): string
    {
        return str_replace(['-52', 'x72'], ['-285', 'x380'], $string);
    }
}
