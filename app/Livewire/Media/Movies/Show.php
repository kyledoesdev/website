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

    public function render()
    {
        return view('livewire.pages.media.movies.show', [
            'favorites' => Media::query()
                ->where('type_id', MediaType::MOVIE->value)
                ->where('is_favorite', true)
                ->paginate(27, pageName: 'favorites'),
            'backlog' => Media::query()
                ->where('type_id', MediaType::MOVIE->value)
                ->where('in_backlog', true)
                ->paginate(27, pageName: 'backlog'),
            'completed' => Media::query()
                ->where('type_id', MediaType::MOVIE->value)
                ->where('is_completed', true)
                ->paginate(27, pageName: 'completed'),
            'panel' => Panel::where('name', 'movies')->first()->content,
        ]);
    }
}
