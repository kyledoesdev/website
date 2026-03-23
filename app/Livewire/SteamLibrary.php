<?php

namespace App\Livewire;

use App\Models\SteamGame;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SteamLibrary extends Component
{
    public string $search = '';

    public string $tierFilter = 'all';

    public string $sortBy = 'priority';

    public bool $showCompleted = false;

    public function render()
    {
        return view('livewire.steam-library');
    }

    #[Computed]
    public function games(): Collection
    {
        $games = Cache::get('steam:library');

        if (! $games) {
            $games = SteamGame::query()
                ->orderByDesc('priority_score')
                ->get();
        }

        return $games
            ->when($this->search, fn (Collection $c) => $c->filter(
                fn (SteamGame $g) => str_contains(strtolower($g->name), strtolower($this->search))
            ))
            ->when(! $this->showCompleted, fn (Collection $c) => $c->filter(
                fn (SteamGame $g) => $g->priority_tier !== 'completed'
            ))
            ->when($this->tierFilter !== 'all', fn (Collection $c) => $c->filter(
                fn (SteamGame $g) => $g->priority_tier === $this->tierFilter
            ))
            ->pipe(fn (Collection $c) => $this->applySorting($c));
    }

    #[Computed]
    public function topRecommendations(): Collection
    {
        $games = Cache::get('steam:library');

        if (! $games) {
            $games = SteamGame::query()
                ->orderByDesc('priority_score')
                ->get();
        }

        return $games
            ->filter(fn (SteamGame $g) => $g->priority_score > 0 && $g->priority_tier !== 'completed')
            ->sortByDesc('priority_score')
            ->take(3)
            ->values();
    }

    #[Computed]
    public function stats(): array
    {
        $all = Cache::get('steam:library');

        if (! $all) {
            $all = SteamGame::query()->get();
        }

        return [
            'total' => $all->count(),
            'completed' => $all->where('priority_tier', 'completed')->count(),
            'in_progress' => $all->whereIn('priority_tier', ['active', 'close_to_complete', 'in_progress'])->count(),
            'never_played' => $all->where('priority_tier', 'never_played')->count(),
            'total_hours' => number_format(round($all->sum('playtime_forever_minutes') / 60, 1), 1),
            'recent_hours' => number_format(round($all->sum('playtime_2weeks_minutes') / 60, 1), 1),
        ];
    }

    public function updatedSearch(): void
    {
        unset($this->games);
    }

    public function updatedTierFilter(): void
    {
        unset($this->games);
    }

    public function updatedSortBy(): void
    {
        unset($this->games);
    }

    public function updatedShowCompleted(): void
    {
        unset($this->games);
    }

    private function applySorting(Collection $games): Collection
    {
        return match ($this->sortBy) {
            'playtime' => $games->sortByDesc('playtime_forever_minutes')->values(),
            'completion' => $games->sortByDesc('achievement_completion_pct')->values(),
            'name' => $games->sortBy('name')->values(),
            'last_played' => $games->sortByDesc(fn (SteamGame $g) => $g->last_played_at?->timestamp ?? 0)->values(),
            default => $games->sortByDesc('priority_score')->values(),
        };
    }
}
