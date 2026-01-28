<?php

namespace App\Livewire\Actions\Api\Spotify;

use App\Enums\ConnectionType;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class RefreshToken
{
    public function handle(User $user): bool
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
