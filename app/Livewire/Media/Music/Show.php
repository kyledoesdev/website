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

    public int $artistsPage = 1;
    public int $tracksPage = 1;

    public function render()
    {
        return view('livewire.pages.media.music.show', [
            'favoriteArtists' => Media::query()
                ->where('type_id', MediaType::ARTIST)
                ->paginate(10, ['*'], 'artists', $this->artistsPage),
            'favoriteTracks' => Media::query()
                ->where('type_id', MediaType::TRACK)
                ->paginate(6, ['*'], 'tracks', $this->tracksPage),
            'panel' => Panel::where('name', 'music')->first()->content
        ]);
    }

    public function setArtistsPage($page)
    {
        $this->artistsPage = $page;
    }
    
    public function setTracksPage($page)
    {
        $this->tracksPage = $page;
    }
}
