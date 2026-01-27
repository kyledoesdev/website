<?php

namespace App\Console\Commands;

use App\Enums\ConnectionType;
use App\Livewire\Actions\Api\Twitch\RefreshToken;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckTwitchLiveStatus extends Command
{
    protected $signature = 'twitch:check-live';
    protected $description = 'Check if spacelampsix is live on Twitch and notify Discord';

    public function handle(): int
    {
        $token = User::first()->connections->firstWhere('type_id', ConnectionType::TWITCH->value)->token ?? null;

        if (! $token) {
            return self::FAILURE;
        }

        $stream = $this->getStreamData($token);

        if (! $stream) {
            $this->info('spacelampsix is not currently live.');
            return self::SUCCESS;
        }

        $startedAt = $stream['started_at'];

        if ($this->alreadyNotified($startedAt)) {
            $this->info('Already notified for this stream session.');
            return self::SUCCESS;
        }

        $this->notifyDiscord($stream);
        $this->recordNotification($startedAt);

        $this->info('Discord notification sent!');
        return self::SUCCESS;
    }

    private function getStreamData(string $token): ?array
    {
        $response = Http::withHeaders([
            'Client-ID' => config('services.twitch.client_id'),
            'Authorization' => 'Bearer ' . $token,
        ])->get('https://api.twitch.tv/helix/streams', [
            'user_login' => 'spacelampsix',
        ]);

        return $response->json('data.0');
    }

    private function alreadyNotified(string $startedAt): bool
    {
        return DB::table('twitch_notifications')
            ->where('stream_started_at', $startedAt)
            ->exists();
    }

    private function recordNotification(string $startedAt): void
    {
        DB::table('twitch_notifications')->insert([
            'stream_started_at' => $startedAt,
            'notified_at' => now(),
        ]);
    }

    private function notifyDiscord(array $stream): void
    {
        $title = $stream['title'] ?? 'Untitled Stream';
        $game = $stream['game_name'] ?? 'Unknown Game';

        Http::post(config('services.discord.live_now'), [
            'content' => "@everyone 🔴 **spacelampsix is LIVE!**\n\n**{$title}**\nPlaying: {$game}\n\nhttps://twitch.tv/spacelampsix",
            'allowed_mentions' => [
                'parse' => ['everyone'],
            ],
        ]);

        Log::channel('discord-internal-updates')->info("Discord notified of live stream successfully. Have a great stream!");
    }
}