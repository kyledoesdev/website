<?php

namespace App\Livewire\Pages\Technologies\Tables;

use App\Models\Technology;
use Flux\Flux;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Row extends Component
{
    public Technology $technology;

    #[Validate('required|string|min:3')]
    public string $name = '';

    #[Validate('required|string|max:16')]
    public string $description = '';

    #[Validate('required|string')]
    public string $icon = '';

    public function mount(Technology $technology): void
    {
        $this->technology = $technology;
        $this->name = $technology->name;
        $this->description = $technology->description;
        $this->icon = $technology->icon;
    }

    public function updated(string $property): void
    {
        if (! in_array($property, ['name', 'description', 'icon'], true)) {
            return;
        }

        $this->validateOnly($property);

        $this->technology->update([$property => $this->{$property}]);

        Flux::toast(variant: 'success', text: 'Technology Updated!', duration: 2000);
    }

    public function destroy(): void
    {
        $this->technology->delete();

        Flux::toast(variant: 'success', text: 'Technology Deleted!', duration: 3000);

        $this->dispatch('technology-deleted');
    }

    public function render()
    {
        return view('livewire.pages.technologies.partials.row');
    }
}
