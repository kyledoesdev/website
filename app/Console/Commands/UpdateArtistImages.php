<?php

namespace App\Console\Commands;

use App\Enums\ConnectionType;
use App\Enums\MediaType;
use App\Livewire\Actions\Api\Spotify\RefreshToken;
use App\Models\Media;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class UpdateArtistImages extends Command
{
    protected $signature = 'artists:update-images';

    protected $description = 'Update Artist Profile Images';

    public function handle()
    {
        $user = User::first();

        (new RefreshToken)->handle($user);

        /* Loop through every artist in chunks of 50 and attempt to update their image. */
        Media::query()
            ->where('type_id', MediaType::ARTIST->value)
            ->get()
            ->chunk(50)
            ->each(function ($chunk) use ($user) {
                $ids = $chunk->pluck('media_id')->implode(',');

                $response = (new Client)->request(
                    'GET',
                    "https://api.spotify.com/v1/artists?ids={$ids}", [
                        'headers' => [
                            'Authorization' => 'Bearer '. $user->connections->firstWhere('type_id', ConnectionType::SPOTIFY->value)->token,
                        ],
                    ]
                );

                $artists = collect(collect(json_decode($response->getBody()))->get('artists'))
                    ->filter(fn ($artist) => $artist !== null);

                if (count($artists)) {
                    $artists = collect($artists->map(fn ($artist) => [
                        'media_id' => $artist->id,
                        'cover' => data_get($artist, 'images.0.url'),
                    ]));

                    foreach ($artists as $artist) {
                        Media::query()
                            ->where('media_id', $artist['media_id'])
                            ->first()
                            ?->update(['cover' => $artist['cover']]);
                    }
                }
            });

        return Command::SUCCESS;
    }
}