<?php

namespace App\Livewire;

use App\Models\Panel;
use Flux\Flux;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Panels extends Component
{
    public ?string $type = null;

    public ?string $header = null;

    public array $content = [];

    public function mount()
    {
        if (is_null($this->type) && is_null($this->header)) {
            $this->getRoutePanel();
        }

        Panel::query()
            ->when(! is_null($this->type), fn ($query) => $query->where('name', $this->type))
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
        return Panel::query()
            ->when(! is_null($this->type), fn ($query) => $query->where('name', $this->type))
            ->get();
    }

    private function getRoutePanel()
    {
        switch (Route::currentRouteName()) {
            case 'education.edit':
                $this->type = 'education';
                $this->header = 'Education';
                break;
            case 'projects.edit':
                $this->type = 'projects';
                $this->header = 'Projects';
                break;
            case 'board_games.edit':
                $this->type = 'board_games';
                $this->header = 'Board Games';
                break;
            case 'music.edit':
                $this->type = 'music';
                $this->header = 'Bands & Music';
                break;
            case 'work_history.edit':
                $this->type = 'work_history';
                $this->header = 'Work History';
                break;
            default:
                $this->header = 'Panels';
                break;
        }
    }
}
