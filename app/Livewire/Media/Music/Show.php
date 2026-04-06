<?php

namespace App\Livewire\Media\Music;

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
        return view('livewire.pages.media.music.show', [
            'favoriteArtists' => Media::query()
                ->where('type_id', MediaType::ARTIST->value)
                ->paginate(20, pageName: 'artists'),
            'favoriteTracks' => Media::query()
                ->where('type_id', MediaType::TRACK->value)
                ->paginate(9, pageName: 'tracks'),
            'panel' => Panel::where('name', 'music')->first()->content,
        ]);
    }
}
