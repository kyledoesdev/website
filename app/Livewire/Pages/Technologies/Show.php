<?php

namespace App\Livewire\Pages\Technologies;

use App\Models\Technology;
use Livewire\Component;

class Show extends Component
{
    public function render()
    {
        return view('livewire.pages.technologies.show', [
            'technologies' => Technology::query()->orderBy('name')->get(),
        ]);
    }
}
