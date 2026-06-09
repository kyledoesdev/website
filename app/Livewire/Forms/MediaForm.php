<?php

namespace App\Livewire\Forms;

use App\Enums\Media\GameState;
use App\Models\Media;
use Livewire\Form;

class MediaForm extends Form
{
    public array $states = [];

    public function store($media): void
    {
        $states = collect($this->states);

        Media::create([
            'type' => $media['type'],
            'media_id' => $media['media_id'],
            'name' => $media['name'],
            'cover' => $media['cover'],
            'is_favorite' => $states->contains(GameState::Favorite->value),
            'is_active' => $states->contains(GameState::Active->value),
            'in_backlog' => $states->contains(GameState::Backlog->value),
            'is_completed' => $states->contains(GameState::Completed->value),
            'data' => [
                'total_completion' => $states->contains(GameState::TotalCompletion->value),
            ],
        ]);

        $this->reset();
    }
}
