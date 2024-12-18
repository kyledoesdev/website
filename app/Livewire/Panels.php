<?php

namespace App\Livewire;

use App\Models\Panel;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Panels extends Component
{
    public array $content = [];

    public function mount()
    {
        foreach (Panel::all() as $panel) {
            $this->content[$panel->name] = Str::of($panel->content)->markdown();
        }
    }

    public function render()
    {
        return view('livewire.panels');
    }

    public function update(Panel $panel)
    {
        $panel->update(['content' => $this->content[$panel->name]]);

        Flux::toast(variant: 'success', text: 'Successfully Updated.');
    }

    #[Computed]
    public function panels()
    {
        return Panel::all();
    }
}
