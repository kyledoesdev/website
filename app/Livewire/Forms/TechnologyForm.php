<?php

namespace App\Livewire\Forms;

use App\Models\Technology;
use Flux\Flux;
use Livewire\Attributes\Validate;
use Livewire\Form;

class TechnologyForm extends Form
{
    #[Validate('required|string|min:3')]
    public $name;

    #[Validate('required|string|max:16')]
    public $description;

    #[Validate('required|string')]
    public $icon;

    public ?int $technologyId;

    public function store()
    {
        $this->validate();

        Technology::create([
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
        ]);

        $this->reset();

        Flux::modal('create-technology')->close();

        Flux::toast(variant: 'success', text: 'Technology Created!', duration: 3000);
    }

    public function edit(int $technologyId)
    {
        $technology = Technology::findOrFail($technologyId);
        $this->technologyId = $technologyId;

        $this->name = $technology->name;
        $this->description = $technology->description;
        $this->icon = $technology->icon;

        Flux::modal('edit-technology')->show();
    }

    public function update()
    {
        $this->validate();

        Technology::findOrFail($this->technologyId)->update([
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
        ]);


        Flux::modal('edit-technology')->close();
        Flux::toast(variant: 'success', text: 'Technology Updated!', duration: 3000);
    }
}
