<?php

namespace App\Livewire\Actions\Api;

use App\Models\ConnectionType;
use App\Models\User;
use App\Models\VideoGame;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class SearchCategories
{
    public function search(User $user, string $phrase)
    {
        $this->refreshToken($user);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $user->connections->firstWhere('type_id', ConnectionType::TWITCH)->token,
            'Content-Type' => 'application/json',
            'Client-Id' => config('services.twitch.client_id'),
        ])->get("https://api.twitch.tv/helix/search/categories", [
            'query' => $phrase,
            'first' => 9
        ]);

        if ($response->successful()) {
            $games = VideoGame::pluck('twitch_id')->toArray();

            return collect($response->json('data'))->map(function($game) use ($games) {
                if (in_array($game['id'], $games)) {
                    return null;
                }

                return [
                    'twitch_id' => $game['id'],
                    'name' => $game['name'],
                    'cover' => $this->fix_box_art($game['box_art_url']),
                ];
            })->filter();
        }

        return collect();
    }

    private function refreshToken(User $user): void
    {
        try {
            $response = Http::asForm()->post('https://id.twitch.tv/oauth2/token', [
                'client_id' => config('services.twitch.client_id'),
                'client_secret' => config('services.twitch.client_secret'),
                'refresh_token' => $user->connections->firstWhere('type_id', ConnectionType::TWITCH)->refresh_token,
                'grant_type' => 'refresh_token',
            ]);

            if ($response->successful()) {
                $data = $response->json();
        
                $user->connections()
                    ->firstWhere('type_id', ConnectionType::TWITCH)
                    ->update(['token' => $data['access_token']]);
            }
        } catch(Exception $e) {
            Log::error("could not refresh user: {$user->name} token.");
            Log::error($e->getMessage());
        }
    }

    /* disgusting hack to get high rez images from this endpoint */
    private function fix_box_art(string $string): string
    {
        return str_replace(['-52', 'x72'], ['-285', 'x380'], $string);
    }
}