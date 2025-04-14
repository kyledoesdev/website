<?php

namespace App\Livewire\Media\Games;

use App\Models\Media;
use App\Models\MediaType;
use App\Models\Panel;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    use WithoutUrlPagination;

    public $favoritesPage = 1;
    public $activePage = 1;
    public $backlogPage = 1;
    public $completedPage = 1;

    public function render()
    {
        return view('livewire.pages.media.games.show', [
            'favorites' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME)
                ->where('is_favorite', true)
                ->paginate(1, ['*'], 'favorites', $this->favoritesPage),
            'current' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME)
                ->where('is_active', true)
                ->paginate(1, ['*'], 'currentlyPlaying', $this->activePage),
            'backlog' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME)
                ->where('in_backlog', true)
                ->paginate(1, ['*'], 'backlog', $this->backlogPage),
            'completed' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME)
                ->where('is_completed', true)
                ->paginate(1, ['*'], 'completed', $this->completedPage),
            'panel' => Panel::where('name', 'video_games')->first()->content
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

    public function setCompletedPage($page)
    {
        $this->completedPage = $page;
    }
}
