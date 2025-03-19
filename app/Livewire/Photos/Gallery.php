<?php

namespace App\Livewire\Photos;

use App\Livewire\Forms\PhotoForm;
use App\Models\Photo;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Gallery extends Component
{
    use WithPagination;

    public PhotoForm $form;

    public function render()
    {
        return view('livewire.photos.gallery');
    }

    #[Computed]
    #[On('photos-updated')]
    public function photos()
    {
        return Photo::paginate(6);
    }

    public function confirm($id)
    {
        $this->form->confirm($id);
    }

    public function destroy()
    {
        $this->form->destroy();

        $this->dispatch('photos-updated');
    }
}
