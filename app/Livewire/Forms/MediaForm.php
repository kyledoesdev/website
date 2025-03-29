<?php

namespace App\Livewire\Forms;

use App\Models\Media;
use Livewire\Attributes\Validate;
use Livewire\Form;

class MediaForm extends Form
{
    public array $states = [];
    public string $name = '';

    public ?Media $media = null;

    public function store($media)
    {
        $states = collect($this->states);

        Media::create([
            'type_id'      => $media['type_id'],
            'media_id'     => $media['media_id'],
            'name'         => $media['name'],
            'cover'        => $media['cover'],
            'is_favorite'  => $states->contains('is_favorite'),
            'in_backlog'   => $states->contains('in_backlog'),
            'is_completed' => $states->contains('is_completed'),
        ]);

        $this->reset();
    }

    public function edit($id)
    {
        $this->media = Media::findOrFail($id);

        $this->name = $this->media->name;
        $this->states[] = $this->media->is_favorite ? 'is_favorite' : '';
        $this->states[] = $this->media->in_backlog ? 'in_backlog' : '';
        $this->states[] = $this->media->is_completed ? 'is_completed' : '';
    }

    public function update()
    {
        $states = collect($this->states);

        $this->media->update([
            'is_favorite'  => $states->contains('is_favorite'),
            'in_backlog'   => $states->contains('in_backlog'),
            'is_completed' => $states->contains('is_completed'),
        ]);
    }
}
