<?php

namespace App\Livewire\Forms;

use App\Models\Media;
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
            'type_id' => $media['type_id'],
            'media_id' => $media['media_id'],
            'name' => $media['name'],
            'cover' => $media['cover'],
            'is_favorite' => $states->contains('is_favorite'),
            'is_active' => $states->contains('is_active'),
            'in_backlog' => $states->contains('in_backlog'),
            'is_completed' => $states->contains('is_completed'),
            'data' => [
                'total_completion' => $states->contains('total_completion'),
            ],
        ]);

        $this->reset();
    }

    public function edit($id)
    {
        $this->media = Media::findOrFail($id);

        $data = $this->media->data;

        $this->name = $this->media->name;
        $this->states[] = $this->media->is_favorite ? 'is_favorite' : null;
        $this->states[] = $this->media->is_active ? 'is_active' : null;
        $this->states[] = $this->media->in_backlog ? 'in_backlog' : null;
        $this->states[] = $this->media->is_completed ? 'is_completed' : null;
        $this->states[] = $data && isset($data['total_completion']) && $data['total_completion'] == true 
            ? 'total_completion'
            : null;

        $this->states = collect($this->states)->filter()->values()->toArray();
    }

    public function update()
    {
        $states = collect($this->states);

        $this->media->update([
            'is_favorite' => $states->contains('is_favorite'),
            'is_active' => $states->contains('is_active'),
            'in_backlog' => $states->contains('in_backlog'),
            'is_completed' => $states->contains('is_completed'),
            'data' => [
                'total_completion' => $states->contains('total_completion'),
            ],
        ]);
    }
}
