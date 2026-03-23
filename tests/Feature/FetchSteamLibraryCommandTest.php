<?php

use App\Models\SteamGame;
use App\Models\SteamSnapshot;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    config([
        'services.steam.api_key' => 'test-api-key',
        'services.steam.steam_id' => '12345678901234567',
    ]);
});

it('fails when steam credentials are missing', function () {
    config(['services.steam.api_key' => null]);

    $this->artisan('steam:fetch')
        ->expectsOutputToContain('Missing STEAM_API_KEY or STEAM_ID')
        ->assertExitCode(1);
});

it('fails when the steam api returns an error', function () {
    Http::fake([
        'api.steampowered.com/*' => Http::response(null, 500),
    ]);

    $this->artisan('steam:fetch')
        ->expectsOutputToContain('Failed to fetch owned games')
        ->assertExitCode(1);
});

it('fetches and stores games from the steam api', function () {
    Http::fake([
        'api.steampowered.com/IPlayerService/GetOwnedGames/*' => Http::response([
            'response' => [
                'game_count' => 2,
                'games' => [
                    [
                        'appid' => 220,
                        'name' => 'Half-Life 2',
                        'img_icon_url' => 'abc123',
                        'playtime_forever' => 1200,
                        'playtime_2weeks' => 60,
                        'rtime_last_played' => 1711238400,
                    ],
                    [
                        'appid' => 440,
                        'name' => 'Team Fortress 2',
                        'img_icon_url' => 'def456',
                        'playtime_forever' => 0,
                        'playtime_2weeks' => 0,
                        'rtime_last_played' => 0,
                    ],
                ],
            ],
        ]),
    ]);

    $this->artisan('steam:fetch')
        ->assertExitCode(0);

    expect(SteamGame::count())->toBe(2);
    expect(SteamSnapshot::count())->toBe(2);

    $hl2 = SteamGame::query()->where('app_id', 220)->first();
    expect($hl2->name)->toBe('Half-Life 2');
    expect($hl2->playtime_forever_minutes)->toBe(1200);
    expect($hl2->img_icon_url)->toBe('abc123');

    $tf2 = SteamGame::query()->where('app_id', 440)->first();
    expect($tf2->playtime_forever_minutes)->toBe(0);
    expect($tf2->priority_tier)->toBe('never_played');
});

it('fetches achievement data with the achievements flag', function () {
    Http::fake([
        'api.steampowered.com/IPlayerService/GetOwnedGames/*' => Http::response([
            'response' => [
                'game_count' => 1,
                'games' => [
                    [
                        'appid' => 220,
                        'name' => 'Half-Life 2',
                        'img_icon_url' => 'abc123',
                        'playtime_forever' => 1200,
                        'playtime_2weeks' => 60,
                        'rtime_last_played' => 1711238400,
                    ],
                ],
            ],
        ]),
        'api.steampowered.com/ISteamUserStats/GetPlayerAchievements/*' => Http::response([
            'playerstats' => [
                'success' => true,
                'achievements' => [
                    ['apiname' => 'ach1', 'achieved' => 1, 'unlocktime' => 1711238400],
                    ['apiname' => 'ach2', 'achieved' => 0, 'unlocktime' => 0],
                ],
            ],
        ]),
        'api.steampowered.com/ISteamUserStats/GetGlobalAchievementPercentagesForApp/*' => Http::response([
            'achievementpercentages' => [
                'achievements' => [
                    ['name' => 'ach1', 'percent' => 85.5],
                    ['name' => 'ach2', 'percent' => 12.3],
                ],
            ],
        ]),
    ]);

    $this->artisan('steam:fetch --achievements')
        ->assertExitCode(0);

    $game = SteamGame::query()->where('app_id', 220)->first();
    expect($game->achievement_total)->toBe(2);
    expect($game->achievement_unlocked)->toBe(1);
    expect((float) $game->achievement_completion_pct)->toBe(50.0);
    expect($game->achievement_details)->toHaveCount(2);
});

it('recalculates priority scores with the calculate flag', function () {
    SteamGame::factory()->create([
        'playtime_forever_minutes' => 5000,
        'playtime_2weeks_minutes' => 600,
        'achievement_total' => 50,
        'achievement_unlocked' => 40,
        'achievement_completion_pct' => 80.0,
        'last_played_at' => now(),
        'priority_score' => 0,
        'priority_tier' => null,
    ]);

    $this->artisan('steam:fetch --calculate')
        ->assertExitCode(0);

    $game = SteamGame::query()->first();
    expect($game->priority_score)->toBeGreaterThan(0);
    expect($game->priority_tier)->toBe('active');
});
