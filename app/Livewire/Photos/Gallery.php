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

    public string $header = 'Cool Photos';

    public string $emptyMessage = 'No Photos';

    public array|int $type = Asset::PHOTO;

    public PhotoForm $form;

    public function render()
    {
        return view('livewire.photos.gallery');
    }

    #[Computed]
    #[On('photos-updated')]
    public function photos()
    {
        return Asset::query()
            ->whereIn('type_id', is_array($this->type) ? $this->type : [$this->type])
            ->paginate(6);
    }

    public function destroy($id)
    {
        $this->form->destroy($id);

        $this->dispatch('photos-updated');
    }
}
