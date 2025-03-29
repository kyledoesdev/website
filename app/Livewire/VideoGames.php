<?php

namespace App\Livewire;

use App\Livewire\Actions\Api\SearchCategories;
use App\Livewire\Forms\VideoGameForm;
use App\Livewire\Traits\TableHelpers;
use App\Models\VideoGame;
use Flux\Flux;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class VideoGames extends Component
{
    use TableHelpers;
    use WithPagination;

    public string $phrase = '';
    public $searchedGames = [];
    public $selectedGame = null;

    public VideoGameForm $form;

    public function render()
    {
        return view('livewire.video-games');
    }

    #[Computed]
    public function games()
    {
        return VideoGame::paginate(10);
    }

    public function search()
    {
        $categories = (new SearchCategories)->search(auth()->user(), $this->phrase);

        if ($categories->isEmpty()) {
            Flux::toast(variant: 'danger', text: "No games found for search term: {$this->phrase}.", duration: 3000);

            $this->phrase = '';
        }

        $this->searchedGames = $categories;
    }

    public function selectGame($gameId)
    {
        $games = collect($this->searchedGames);

        if ($games->where('twitch_id', $gameId)->isEmpty()) {
            Flux::toast(variant: 'danger', text: 'You can not add a game that was not in the returned list.', duration: 3000);
            return;
        }

        $this->selectedGame = $games->firstWhere('twitch_id', $gameId);
        $this->searchedGames = [];
    }

    public function store()
    {
        $this->form->store($this->selectedGame);

        $this->selectGame = null;

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
        VideoGame::findOrFail($id)->delete();
    }
}
