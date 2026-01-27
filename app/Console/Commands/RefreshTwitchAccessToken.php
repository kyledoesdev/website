<?php

namespace App\Console\Commands;

use App\Livewire\Actions\Api\Twitch\RefreshToken;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RefreshTwitchAccessToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'twitch:refresh-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes Twitch Access Token';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        (new RefreshToken)->handle(User::first());

        Log::channel('discord-internal-updates')->info("Twitch Token updated automatically.");
    }
}
