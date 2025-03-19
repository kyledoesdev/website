<?php

namespace App\Livewire;

use App\Models\Panel;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Panels extends Component
{
    public string $type;
    public array $content = [];

    public function mount()
    {
        Panel::query()
            ->where('type', $this->type)
            ->get()
            ->each(function (Panel $panel) {
                $this->content[$panel->name] = Str::of($panel->content)->markdown();
            });
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
        return Panel::where('type', $this->type)->get();
    }
}
