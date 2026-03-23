<?php

namespace App\Console\Commands;

use App\Models\SteamGame;
use App\Models\SteamSnapshot;
use App\Services\SteamService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FetchSteamLibrary extends Command
{
    protected $signature = 'steam:fetch
        {--achievements : Fetch per-game achievement data (slow, ~400 API calls)}
        {--calculate : Recalculate priority scores without re-fetching from Steam}';

    protected $description = 'Fetch Steam library data, store in database, and calculate priority scores';

    public function __construct(private SteamService $steam)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        if (! config('services.steam.api_key') || ! config('services.steam.steam_id')) {
            $this->error('Missing STEAM_API_KEY or STEAM_ID in .env');

            return self::FAILURE;
        }

        if ($this->option('calculate')) {
            return $this->recalculateOnly();
        }

        return $this->fetchAndStore();
    }

    private function recalculateOnly(): int
    {
        $this->info('Recalculating priority scores...');
        $this->steam->calculateAllPriorityScores();
        $this->refreshCache();
        $this->info('Priority scores recalculated.');

        return self::SUCCESS;
    }

    private function fetchAndStore(): int
    {
        $this->info('Fetching owned games...');
        $data = $this->steam->fetchOwnedGames();

        if (! $data) {
            $this->error('Failed to fetch owned games. Is your profile public?');

            return self::FAILURE;
        }

        $games = collect($data['games'] ?? []);
        $this->info("Found {$games->count()} games.");

        $this->upsertGames($games);

        if ($this->option('achievements')) {
            $this->fetchAchievements($games);
        } else {
            $this->warn('Skipped achievement fetching. Run with --achievements to include achievement data.');
        }

        $this->info('Calculating priority scores...');
        $this->steam->calculateAllPriorityScores();

        $this->info('Creating snapshots...');
        $this->createSnapshots();

        $this->refreshCache();
        $this->outputSummary();

        return self::SUCCESS;
    }

    private function upsertGames($games): void
    {
        $bar = $this->output->createProgressBar($games->count());
        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% — Upserting games');

        foreach ($games as $game) {
            SteamGame::updateOrCreate(
                ['app_id' => $game['appid']],
                [
                    'name' => $game['name'] ?? "Unknown ({$game['appid']})",
                    'img_icon_url' => $game['img_icon_url'] ?? null,
                    'playtime_forever_minutes' => $game['playtime_forever'] ?? 0,
                    'playtime_2weeks_minutes' => $game['playtime_2weeks'] ?? 0,
                    'last_played_at' => isset($game['rtime_last_played']) && $game['rtime_last_played'] > 0
                        ? date('Y-m-d', $game['rtime_last_played'])
                        : null,
                ]
            );

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
    }

    private function fetchAchievements($games): void
    {
        $this->info('Fetching achievements for each game (this will take a few minutes)...');
        $bar = $this->output->createProgressBar($games->count());

        foreach ($games as $game) {
            $appId = $game['appid'];
            $steamGame = SteamGame::query()->where('app_id', $appId)->first();

            if (! $steamGame) {
                $bar->advance();

                continue;
            }

            $playerAchievements = $this->steam->fetchPlayerAchievements($appId);
            $globalAchievements = $this->steam->fetchGlobalAchievementPercentages($appId);

            if ($playerAchievements) {
                $total = count($playerAchievements);
                $unlocked = collect($playerAchievements)->where('achieved', 1)->count();
                $details = $this->steam->mergeAchievementData($playerAchievements, $globalAchievements);

                $steamGame->update([
                    'achievement_total' => $total,
                    'achievement_unlocked' => $unlocked,
                    'achievement_completion_pct' => $total > 0 ? round(($unlocked / $total) * 100, 1) : 0,
                    'achievement_details' => $details,
                ]);
            }

            $bar->advance();
            usleep(250000);
        }

        $bar->finish();
        $this->newLine();
    }

    private function createSnapshots(): void
    {
        $now = now();

        SteamGame::query()->chunk(200, function ($games) use ($now) {
            $snapshots = $games->map(fn (SteamGame $game) => [
                'steam_game_id' => $game->id,
                'playtime_forever_minutes' => $game->playtime_forever_minutes,
                'playtime_2weeks_minutes' => $game->playtime_2weeks_minutes,
                'achievement_unlocked' => $game->achievement_unlocked,
                'achievement_completion_pct' => $game->achievement_completion_pct,
                'priority_score' => $game->priority_score,
                'fetched_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ])->all();

            SteamSnapshot::insert($snapshots);
        });
    }

    private function refreshCache(): void
    {
        $games = SteamGame::query()
            ->orderByDesc('priority_score')
            ->get();

        Cache::put('steam:library', $games, now()->addHours(25));
    }

    private function outputSummary(): void
    {
        $total = SteamGame::query()->count();
        $neverPlayed = SteamGame::neverPlayed()->count();
        $completed = SteamGame::completed()->count();
        $totalHours = round(SteamGame::query()->sum('playtime_forever_minutes') / 60, 1);
        $recentHours = round(SteamGame::query()->sum('playtime_2weeks_minutes') / 60, 1);

        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Games', $total],
                ['Never Played', $neverPlayed],
                ['Completed (100%)', $completed],
                ['In Progress', SteamGame::inProgress()->count()],
                ['Total Playtime', "{$totalHours} hours"],
                ['Recent Playtime (2 weeks)', "{$recentHours} hours"],
            ]
        );
    }
}
