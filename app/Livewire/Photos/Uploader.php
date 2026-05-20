<?php

namespace App\Livewire\Photos;

use App\Enums\AssetType;
use App\Livewire\Forms\PhotoForm;
use Livewire\Component;
use Livewire\WithFileUploads;

class Uploader extends Component
{
    use WithFileUploads;

    public PhotoForm $form;

    public string $header = 'Photo Manager';

    public bool $showGallery = true;

    public array|int $galleryType = AssetType::PHOTO->value;

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
