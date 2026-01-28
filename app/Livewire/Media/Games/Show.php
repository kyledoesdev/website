<?php

namespace App\Livewire\Media\Games;

use App\Enums\MediaType;
use App\Models\Media;
use App\Models\Panel;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Show extends Component
{
    use WithoutUrlPagination;
    use WithPagination;

    public $favoritesPage = 1;

    public $activePage = 1;

    public $backlogPage = 1;

    public $playedBeforePage = 1;

    public $totalCompletionPage = 1;

    public function render()
    {
        return view('livewire.pages.media.games.show', [
            'favorites' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME->value)
                ->where('is_favorite', true)
                ->paginate(18, ['*'], 'favorites', $this->favoritesPage),
            'current' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME->value)
                ->where('is_active', true)
                ->paginate(18, ['*'], 'currentlyPlaying', $this->activePage),
            'backlog' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME->value)
                ->where('in_backlog', true)
                ->paginate(18, ['*'], 'backlog', $this->backlogPage),
            'playedBefore' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME->value)
                ->where('is_completed', true)
                ->paginate(18, ['*'], 'completed', $this->playedBeforePage),
            'completed' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME->value)
                ->where('data->total_completion', true)
                ->paginate(18, ['*'], 'total_completion', $this->totalCompletionPage),
            'panel' => Panel::where('name', 'video_games')->first()->content,
        ]);
    }

    public function setFavoritesPage($page)
    {
        $this->favoritesPage = $page;
    }

    public function setActivePage($page)
    {
        $this->activePage = $page;
    }

    public function setBacklogPage($page)
    {
        $this->backlogPage = $page;
    }

    public function setPlayedBeforePage($page)
    {
        $this->playedBeforePage = $page;
    }

    public function setCompletedPage($page)
    {
        $this->totalCompletionPage = $page;
    }
}
