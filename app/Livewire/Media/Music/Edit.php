<?php

namespace App\Livewire\Media\Music;

use App\Livewire\Actions\Api\SearchSpotify;
use App\Livewire\Traits\TableHelpers;
use App\Models\Media;
use App\Models\MediaType;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Edit extends Component
{
    use TableHelpers;
    use WithPagination;

    public string $phrase = '';
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
        return Media::where('type_id', MediaType::ARTIST)->paginate(10);
    }

    #[Computed]
    public function tracks()
    {
        return Media::where('type_id', MediaType::TRACK)->paginate(10);
    }

    public function search(MediaType $mediaType)
    {
        $media = (new SearchSpotify)->search(
            auth()->user(),
            $this->phrase,
            $mediaType
        );

        if ($media->isEmpty()) {
            Flux::toast(variant: 'danger', text: "No games found for search term: {$this->phrase}.", duration: 3000);

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

        $this->reset();

        Flux::toast(variant: 'success', text: "{$media->type->name} added!", duration: 3000);
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        
        $media->delete();

        Flux::toast(variant: 'success', text: "{$media->type->name} deleted.", duration: 3000);
    }
}
