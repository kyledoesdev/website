<div>
    <x-slot name="header">Steam Backlog Tracker</x-slot>

    <div class="space-y-6 mt-4">
        {{-- Summary Stats --}}
        <flux:card>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <flux:heading size="xl">Steam Backlog Tracker</flux:heading>
                    <a href="https://steamcommunity.com/profiles/{{ config('services.steam.steam_id') }}" target="_blank" class="text-zinc-400 hover:text-zinc-200 transition-colors">
                        <flux:icon.arrow-top-right-on-square class="size-5" />
                    </a>
                </div>
                <div class="flex flex-wrap gap-2">
                    <flux:badge color="zinc">{{ $this->stats['total'] }} games</flux:badge>
                    <flux:badge color="green">{{ $this->stats['completed'] }} completed</flux:badge>
                    <flux:badge color="blue">{{ $this->stats['in_progress'] }} in progress</flux:badge>
                    <flux:badge color="yellow">{{ $this->stats['never_played'] }} never played</flux:badge>
                    <flux:badge color="zinc">{{ $this->stats['total_hours'] }} hrs total</flux:badge>
                    <flux:badge color="cyan">{{ $this->stats['recent_hours'] }} hrs recent</flux:badge>
                </div>
            </div>
        </flux:card>

        {{-- Top Recommendations --}}
        @if($this->topRecommendations->isNotEmpty())
            <flux:card>
                <flux:heading size="lg" class="mb-4">What to Play Next</flux:heading>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($this->topRecommendations as $rec)
                        <div wire:key="rec-{{ $rec->app_id }}" class="rounded-lg border border-zinc-200 dark:border-zinc-700 p-4 space-y-3">
                            <div class="flex items-center gap-3">
                                @if($rec->icon_url)
                                    <img src="{{ $rec->icon_url }}" alt="{{ $rec->name }}" class="size-10 rounded" />
                                @else
                                    <div class="size-10 rounded bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center">
                                        <flux:icon.puzzle-piece class="size-5 text-zinc-400" />
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <a href="{{ $rec->steam_url }}" target="_blank" class="font-semibold text-sm hover:underline truncate block">
                                        {{ $rec->name }}
                                    </a>
                                    <x-steam-tier-badge :tier="$rec->priority_tier" />
                                </div>
                            </div>

                            <div class="text-xs text-zinc-500 dark:text-zinc-400 space-y-1">
                                <p>{{ $rec->playtime_hours }} hrs played</p>
                                @if($rec->achievement_total > 0)
                                    <p>{{ $rec->achievement_unlocked }}/{{ $rec->achievement_total }} achievements ({{ $rec->achievement_completion_pct }}%)</p>
                                    @if($rec->remaining_achievements > 0)
                                        <p class="text-emerald-500 font-medium">
                                            {{ $rec->remaining_achievements }} achievement{{ $rec->remaining_achievements !== 1 ? 's' : '' }} to go!
                                        </p>
                                    @endif
                                    @if($rec->avg_remaining_difficulty !== null)
                                        <p>Avg remaining difficulty:
                                            @if($rec->avg_remaining_difficulty >= 50)
                                                <span class="text-green-500">Easy</span>
                                            @elseif($rec->avg_remaining_difficulty >= 20)
                                                <span class="text-yellow-500">Medium</span>
                                            @else
                                                <span class="text-red-500">Hard</span>
                                            @endif
                                        </p>
                                    @endif
                                @endif
                            </div>

                            @if($rec->achievement_total > 0)
                                <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2">
                                    <div class="bg-emerald-500 h-2 rounded-full transition-all" style="width: {{ $rec->achievement_completion_pct }}%"></div>
                                </div>
                            @endif

                            <div class="text-right">
                                <flux:badge size="sm" color="zinc">Score: {{ $rec->priority_score }}</flux:badge>
                            </div>
                        </div>
                    @endforeach
                </div>
            </flux:card>
        @endif

        {{-- Filters --}}
        <flux:card>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <flux:input icon="magnifying-glass" wire:model.live.debounce.300ms="search" placeholder="Search games..." />

                <flux:select wire:model.live="tierFilter">
                    <flux:select.option value="all">All Tiers</flux:select.option>
                    <flux:select.option value="active">Active</flux:select.option>
                    <flux:select.option value="close_to_complete">Close to Complete</flux:select.option>
                    <flux:select.option value="in_progress">In Progress</flux:select.option>
                    <flux:select.option value="backlog">Backlog</flux:select.option>
                    <flux:select.option value="never_played">Never Played</flux:select.option>
                    <flux:select.option value="excluded">Excluded</flux:select.option>
                    <flux:select.option value="completed">Completed</flux:select.option>
                </flux:select>

                <flux:select wire:model.live="sortBy">
                    <flux:select.option value="priority">Priority Score</flux:select.option>
                    <flux:select.option value="playtime">Playtime</flux:select.option>
                    <flux:select.option value="completion">Completion %</flux:select.option>
                    <flux:select.option value="name">Name</flux:select.option>
                    <flux:select.option value="last_played">Last Played</flux:select.option>
                </flux:select>

                <div class="flex items-center gap-2">
                    <flux:switch wire:model.live="showCompleted" />
                    <span class="text-sm text-zinc-600 dark:text-zinc-400">Show Completed</span>
                </div>
            </div>
        </flux:card>

        {{-- Game List --}}
        <flux:card>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @forelse($this->games as $game)
                    <div wire:key="game-{{ $game->app_id }}" class="rounded-lg border border-zinc-200 dark:border-zinc-700 p-4 space-y-3 hover:border-zinc-400 dark:hover:border-zinc-500 transition-colors">
                        <div class="flex items-center gap-3">
                            @if($game->icon_url)
                                <img src="{{ $game->icon_url }}" alt="{{ $game->name }}" class="size-8 rounded" loading="lazy" />
                            @else
                                <div class="size-8 rounded bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center">
                                    <flux:icon.puzzle-piece class="size-4 text-zinc-400" />
                                </div>
                            @endif
                            <div class="min-w-0 flex-1">
                                <a href="{{ $game->steam_url }}" target="_blank" class="font-medium text-sm hover:underline truncate block">
                                    {{ $game->name }}
                                </a>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-1.5">
                            <x-steam-tier-badge :tier="$game->priority_tier" />
                            @if($game->priority_tier === 'active')
                                <flux:badge size="sm" color="green">Playing now</flux:badge>
                            @endif
                        </div>

                        <div class="text-xs text-zinc-500 dark:text-zinc-400 space-y-0.5">
                            <p>{{ $game->playtime_hours }} hrs played</p>
                            <p>{{ $game->last_played_at ? $game->last_played_at->format('M j, Y') : 'Never' }}</p>
                        </div>

                        @if($game->achievement_total > 0)
                            <div class="space-y-1">
                                <div class="flex justify-between text-xs text-zinc-500 dark:text-zinc-400">
                                    <span>{{ $game->achievement_unlocked }}/{{ $game->achievement_total }}</span>
                                    <span>{{ $game->achievement_completion_pct }}%</span>
                                </div>
                                <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-1.5">
                                    <div class="bg-emerald-500 h-1.5 rounded-full transition-all" style="width: {{ $game->achievement_completion_pct }}%"></div>
                                </div>
                                @if($game->priority_tier === 'close_to_complete' && $game->remaining_achievements > 0)
                                    <p class="text-xs text-emerald-500 font-medium">
                                        {{ $game->remaining_achievements }} to go!
                                    </p>
                                @endif
                            </div>
                        @endif

                        @if($game->priority_score > 0)
                            <div class="text-right">
                                <span class="text-xs text-zinc-400">{{ $game->priority_score }} pts</span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full flex justify-center py-8">
                        <flux:badge>No games found.</flux:badge>
                    </div>
                @endforelse
            </div>
        </flux:card>
    </div>
</div>
