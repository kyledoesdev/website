<?php

namespace App\Livewire\Media\Music;

use App\Livewire\Actions\Api\SearchSpotify;
use App\Livewire\Traits\TableHelpers;
use App\Models\Media;
use App\Models\MediaType;
use Flux\Flux;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Edit extends Component
{
    use TableHelpers;
    use WithPagination;

    public string $phrase = '';
    public string $searchArtists = '';
    public string $searchTracks = '';

    public $searchedMedia = [];

    public function render()
    {
        return view('livewire.pages.media.music.edit', [
            'mediaTypes' => MediaType::all(),
        ]);
    }

    #[Computed]
    public function artists()
    {
        return Media::query()
            ->where('type_id', MediaType::ARTIST)
            ->when($this->searchArtists != '', fn (Builder $query) => $query->where('name', 'LIKE', "%$this->searchArtists%"))
            ->paginate(10);
    }

    #[Computed]
    public function tracks()
    {
        return Media::query()
            ->where('type_id', MediaType::TRACK)
            ->when($this->searchTracks != '', fn (Builder $query) => $query->where('name', 'LIKE', "%$this->searchTracks%"))
            ->paginate(10);
    }

    public function searchSpotify(MediaType $mediaType)
    {
        $media = (new SearchSpotify)->search(
            auth()->user(),
            $this->phrase,
            $mediaType
        );

        if ($media->isEmpty()) {
            Flux::toast(variant: 'danger', text: "No records found for search term: {$this->phrase}.", duration: 3000);

            $this->phrase = '';
        }

        $this->searchedMedia = $media;
    }

    public function store($mediaId)
    {
        $selectedMedia = collect($this->searchedMedia)->firstWhere('media_id', $mediaId);

        $media = Media::create([
            'type_id' => $selectedMedia['type_id'],
            'media_id' => $selectedMedia['media_id'],
            'name' => $selectedMedia['name'],
            'cover' => $selectedMedia['cover'],
            'data' => $selectedMedia['data'],
        ]);

        $this->phrase = '';

        Flux::toast(variant: 'success', text: "{$media->type->name} added!", duration: 3000);
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        $media->delete();

        Flux::toast(variant: 'success', text: "{$media->type->name} deleted.", duration: 3000);
    }
}
