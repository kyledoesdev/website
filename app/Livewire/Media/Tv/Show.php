<?php

namespace App\Livewire\Media\Tv;

use App\Models\Media;
use App\Models\MediaType;
use App\Models\Panel;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Show extends Component
{
    use WithPagination;
    use WithoutUrlPagination;

    public function render()
    {
        return view('livewire.pages.media.tv.show', [
            'favorites' => Media::query()
                ->where('type_id', MediaType::TV)
                ->where('is_favorite', true)
                ->paginate(10),
            'current' => Media::query()
                ->where('type_id', MediaType::TV)
                ->where('is_active', true)
                ->paginate(10),
            'backlog' => Media::query()
                ->where('type_id', MediaType::TV)
                ->where('in_backlog', true)
                ->paginate(10),
            'completed' => Media::query()
                ->where('type_id', MediaType::TV)
                ->where('is_completed', true)
                ->paginate(10),
            'panel' => Panel::where('name', 'tv')->first()->content,
        ]);
    }
}
