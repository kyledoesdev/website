<?php

namespace App\Livewire\Media\Games;

use App\Livewire\Actions\Api\SearchCategories;
use App\Livewire\Forms\MediaForm;
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

    public $searchedGames = [];

    public $selectedGame = null;

    public MediaForm $form;

    public function render()
    {
        return view('livewire.pages.media.games.edit');
    }

    #[Computed]
    public function games()
    {
        return Media::query()
            ->where('type_id', MediaType::VIDEO_GAME)
            ->paginate(10);
    }

    public function search()
    {
        $categories = (new SearchCategories)->search(
            auth()->user(),
            $this->phrase,
            MediaType::VIDEO_GAME
        );

        if ($categories->isEmpty()) {
            Flux::toast(variant: 'danger', text: "No games found for search term: {$this->phrase}.", duration: 3000);

            $this->phrase = '';
        }

        $this->searchedGames = $categories;
    }

    public function selectGame($gameId)
    {
        $games = collect($this->searchedGames);

        if ($games->where('media_id', $gameId)->isEmpty()) {
            Flux::toast(variant: 'danger', text: 'You can not add a game that was not in the returned list.', duration: 3000);

            return;
        }

        $this->selectedGame = $games->firstWhere('media_id', $gameId);
        $this->searchedGames = [];
    }

    public function store()
    {
        $this->form->store($this->selectedGame);

        $this->selectedGame = null;

        Flux::modal('create-video_game')->close();
        Flux::toast(variant: 'success', text: 'Successfully added game.');
    }

    public function edit($id)
    {
        $this->form->edit($id);

        Flux::modal('edit-video_game')->show();
    }

    public function update()
    {
        $this->form->update();

        Flux::modal('edit-video_game')->close();
        Flux::toast(variant: 'success', text: 'Successfully updated the game.');
    }

    public function destroy($id)
    {
        Media::findOrFail($id)->delete();
    }
}
