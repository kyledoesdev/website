<?php

namespace App\Livewire\Media\Movies;

use App\Livewire\Actions\Api\SearchMedia;
use App\Livewire\Forms\MediaForm;
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

    public $searchedMedia = [];

    public $selectedMedia = null;

    public MediaForm $form;

    public function render()
    {
        return view('livewire.pages.media.movies.edit');
    }

    #[Computed]
    public function medias()
    {
        return Media::query()
            ->where('type_id', MediaType::MOVIE)
            ->when($this->search != '', fn (Builder $query) => $query->where('name', 'LIKE', "%$this->search%"))
            ->paginate(10);
    }

    public function search()
    {
        $media = (new SearchMedia)->search(
            auth()->user(),
            $this->phrase,
            MediaType::MOVIE
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

        Flux::modal('create-media')->close();
        Flux::toast(variant: 'success', text: 'Successfully added the movie!');
    }

    public function edit($id)
    {
        $this->form->edit($id);

        Flux::modal('edit-media')->show();
    }

    public function update()
    {
        $this->form->update();

        Flux::modal('edit-media')->close();
        Flux::toast(variant: 'success', text: 'Successfully updated the movie.');
    }

    public function destroy($id)
    {
        Media::findOrFail($id)->delete();

        Flux::toast(variant: 'success', text: 'Successfully deleted the movie.');
    }
}
