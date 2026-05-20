<?php

namespace App\Livewire\Pages\Technologies;

use App\Livewire\Forms\TechnologyForm;
use App\Livewire\Traits\TableHelpers;
use App\Models\Technology;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Edit extends Component
{
    use TableHelpers;
    use WithPagination;

    public TechnologyForm $createForm;

    public function mount(): void
    {
        $this->sortBy = 'name';
        $this->sortDirection = 'asc';
    }

    public function render()
    {
        return view('livewire.pages.technologies.edit');
    }

    #[Computed]
    public function technologies()
    {
        return Technology::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    public function store(): void
    {
        $this->createForm->store();
    }

    #[On('technology-deleted')]
    public function refreshTechnologies(): void
    {
        unset($this->technologies);
    }
}
