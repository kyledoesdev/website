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

    public function store(): void
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
}
