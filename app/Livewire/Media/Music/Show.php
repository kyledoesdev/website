<?php

namespace App\Livewire\Media\Music;

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
        return view('livewire.pages.media.music.show', [
            'favoriteArtists' => Media::query()
                ->where('type_id', MediaType::ARTIST)
                ->paginate(10),
            'favoriteTracks' => Media::query()
                ->where('type_id', MediaType::TRACK)
                ->paginate(6),
            'panel' => Panel::where('name', 'music')->first()->content
        ]);
    }
}
