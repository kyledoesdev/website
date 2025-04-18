<?php

namespace App\Livewire\Photos;

use App\Livewire\Forms\PhotoForm;
use App\Models\Asset;
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
        return Asset::where('type_id', Asset::PHOTO)->paginate(6);
    }

    public function destroy($id)
    {
        $this->form->destroy($id);

        $this->dispatch('photos-updated');
    }
}
