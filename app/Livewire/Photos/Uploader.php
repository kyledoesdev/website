<?php

namespace App\Livewire\Photos;

use App\Livewire\Forms\PhotoForm;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Uploader extends Component
{
    use WithFileUploads;

    public PhotoForm $form;
    
    public function render()
    {
        return view('livewire.photos.uploader');
    }

    public function store()
    {
        $this->form->store();

        $this->dispatch('photos-updated');
    }
}
