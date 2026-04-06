<?php

namespace App\Livewire\Media\Tv;

use App\Enums\MediaType;
use App\Models\Media;
use App\Models\Panel;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Show extends Component
{
    use WithoutUrlPagination;
    use WithPagination;

    public function render()
    {
        return view('livewire.pages.media.tv.show', [
            'favorites' => Media::query()
                ->where('type_id', MediaType::TV->value)
                ->where('is_favorite', true)
                ->paginate(27, pageName: 'favorites'),
            'current' => Media::query()
                ->where('type_id', MediaType::TV->value)
                ->where('is_active', true)
                ->paginate(27, pageName: 'currentlyWatching'),
            'backlog' => Media::query()
                ->where('type_id', MediaType::TV->value)
                ->where('in_backlog', true)
                ->paginate(27, pageName: 'backlog'),
            'completed' => Media::query()
                ->where('type_id', MediaType::TV->value)
                ->where('is_completed', true)
                ->paginate(27, pageName: 'completed'),
            'panel' => Panel::where('name', 'tv')->first()->content,
        ]);
    }
}
