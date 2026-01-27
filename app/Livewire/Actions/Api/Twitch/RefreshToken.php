<?php

namespace App\Livewire\Actions\Api\Twitch;

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
            $twitchConnection = $user->connections->firstWhere('type_id', ConnectionType::TWITCH->value);

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
}
