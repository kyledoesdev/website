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

    public function render()
    {
        return view('livewire.pages.media.games.show', [
            'favorites' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME->value)
                ->where('is_favorite', true)
                ->paginate(27, pageName: 'favorites'),
            'current' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME->value)
                ->where('is_active', true)
                ->paginate(27, pageName: 'currentlyPlaying'),
            'backlog' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME->value)
                ->where('in_backlog', true)
                ->paginate(27, pageName: 'backlog'),
            'playedBefore' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME->value)
                ->where('is_completed', true)
                ->paginate(27, pageName: 'playedBefore'),
            'completed' => Media::query()
                ->where('type_id', MediaType::VIDEO_GAME->value)
                ->where('data->total_completion', true)
                ->paginate(27, pageName: 'totalCompletion'),
            'panel' => Panel::where('name', 'video_games')->first()->content,
        ]);
    }
}
