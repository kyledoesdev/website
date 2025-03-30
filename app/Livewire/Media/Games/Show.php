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

    public function render()
    {
        return view('livewire.pages.media.games.show', [
            'favorites' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME)
                ->where('is_favorite', true)
                ->paginate(9),
            'current' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME)
                ->where('is_active', true)
                ->paginate(9),
            'backlog' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME)
                ->where('in_backlog', true)
                ->paginate(9),
            'completed' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME)
                ->where('is_completed', true)
                ->paginate(9),
            'panel' => Panel::where('name', 'video_games')->first()->content
        ]);
    }
}
