<?php

namespace App\Livewire;

use App\Livewire\Actions\Api\SearchMedia;
use App\Livewire\Forms\MediaForm;
use App\Livewire\Traits\TableHelpers;
use App\Models\Media as MediaModel;
use App\Models\MediaType;
use Flux\Flux;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Media extends Component
{
    use TableHelpers;
    use WithPagination;

    public MediaType $mediaType;
    public string $phrase = '';

    public $searchedMedia = [];
    public $selectedMedia = null;

    public MediaForm $form;

    public function mount()
    {
        $this->mediaType = Route::currentRouteName() == 'movies.edit'
            ? MediaType::firstWhere('name', 'Movies')
            : MediaType::firstWhere('name', 'TV Shows');
    }

    public function render()
    {
        return view('livewire.media');
    }

    #[Computed]
    public function medias()
    {
        return MediaModel::query()
            ->where('type_id', $this->mediaType->getKey())
            ->paginate(10);
    }

    public function search()
    {
        $media = (new SearchMedia)->search(
            auth()->user(),
            $this->phrase,
            $this->mediaType
        );

        if ($media->isEmpty()) {
            Flux::toast(variant: 'danger', text: "No media was found for search term: {$this->phrase}.", duration: 3000);

            $this->phrase = '';
        }

        $this->searchedMedia = $media;
    }

    public function selectMedia($mediaId)
    {
        $media = collect($this->searchedMedia);

        if ($media->where('media_id', $mediaId)->isEmpty()) {
            Flux::toast(variant: 'danger', text: 'You can not add a game that was not in the returned list.', duration: 3000);
            return;
        }

        $this->selectedMedia = $media->firstWhere('media_id', $mediaId);
        $this->searchedMedia = [];
    }

    public function store()
    {
        $this->form->store($this->selectedMedia);

        $this->selectedMedia = null;

        $mediaType = $this->mediaType->isMovie()
            ? 'movie' 
            : 'tv show';

        Flux::modal('create-media')->close();
        Flux::toast(variant: 'success', text: "Successfully added {$mediaType}.");
    }

    public function edit($id)
    {
        $this->form->edit($id);

        Flux::modal('edit-media')->show();
    }

    public function update()
    {
        $this->form->update();

        $mediaType = $this->mediaType->isMovie()
            ? 'movie' 
            : 'tv show';

        Flux::modal('edit-media')->close();
        Flux::toast(variant: 'success', text: "Successfully updated the {$mediaType}.");
    }

    public function destroy($id)
    {
        MediaModel::findOrFail($id)->delete();
    }
}
