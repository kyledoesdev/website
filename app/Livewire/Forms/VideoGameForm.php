<?php

namespace App\Livewire\Forms;

use App\Models\VideoGame;
use Livewire\Attributes\Validate;
use Livewire\Form;

class VideoGameForm extends Form
{
    public array $states = [];
    public string $name = '';

    public ?VideoGame $game = null;

    public function store($game)
    {
        $states = collect($this->states);

        VideoGame::create([
            'twitch_id'    => $game['twitch_id'],
            'name'         => $game['name'],
            'cover'        => $game['cover'],
            'is_favorite'  => $states->contains('is_favorite'),
            'is_active'    => $states->contains('is_active'),
            'in_backlog'   => $states->contains('in_backlog'),
            'is_completed' => $states->contains('is_completed'),
        ]);

        $this->reset();
    }

    public function edit($id)
    {
        $this->game = VideoGame::findOrFail($id);

        $this->name = $this->game->name;
        $this->states[] = $this->game->is_favorite ? 'is_favorite' : '';
        $this->states[] = $this->game->is_active ? 'is_active' : '';
        $this->states[] = $this->game->in_backlog ? 'in_backlog' : '';
        $this->states[] = $this->game->is_completed ? 'is_completed' : '';
    }

    public function update()
    {
        $states = collect($this->states);

        $this->game->update([
            'is_favorite'  => $states->contains('is_favorite'),
            'is_active'    => $states->contains('is_active'),
            'in_backlog'   => $states->contains('in_backlog'),
            'is_completed' => $states->contains('is_completed'),
        ]);
    }
}
