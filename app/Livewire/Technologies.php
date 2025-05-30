<?php

namespace App\Livewire;

use App\Livewire\Forms\TechnologyForm;
use App\Livewire\Traits\TableHelpers;
use App\Models\Technology;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class Technologies extends Component
{
    use TableHelpers;
    use WithPagination;

    public TechnologyForm $createForm;

    public TechnologyForm $editForm;

    public function render()
    {
        return view('livewire.technologies');
    }

    #[Computed]
    public function technologies()
    {
        return Technology::query()
            ->tap(fn ($query) => $this->sortBy ? $query->orderBy($this->sortBy, $this->sortDirection) : $query)
            ->paginate(10);
    }

    public function store()
    {
        $this->createForm->store();
    }

    public function edit(int $technologyId)
    {
        $this->editForm->edit($technologyId);
    }

    public function update()
    {
        $this->editForm->update();
    }

    public function destroy($id)
    {
        Technology::findOrFail($id)->delete();

        Flux::toast(variant: 'success', text: 'Technology Deleted!', duration: 3000);
    }
}
