<?php

namespace App\Livewire\Media\Movies;

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

    public $backlogPage = 1;

    public $completedPage = 1;

    public function render()
    {
        return view('livewire.pages.media.movies.show', [
            'favorites' => Media::query()
                ->where('type_id', MediaType::MOVIE->value)
                ->where('is_favorite', true)
                ->paginate(9, ['*'], 'favorites', $this->favoritesPage),
            'backlog' => Media::query()
                ->where('type_id', MediaType::MOVIE->value)
                ->where('in_backlog', true)
                ->paginate(9, ['*'], 'backlog', $this->backlogPage),
            'completed' => Media::query()
                ->where('type_id', MediaType::MOVIE->value)
                ->where('is_completed', true)
                ->paginate(9, ['*'], 'completed', $this->completedPage),
            'panel' => Panel::where('name', 'movies')->first()->content,
        ]);
    }

    public function setFavoritesPage($page)
    {
        $this->favoritesPage = $page;
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
