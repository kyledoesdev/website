<?php

namespace App\Livewire\Forms;

use App\Models\Photo;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PhotoForm extends Form
{
    #[Validate('required|string')]
    public ?string $name;

    #[Validate('required|date')]
    public ?string $capturedAt;

    #[Validate('image:mimes:png,jpg,jpeg,gif,jfif')]
    public $photo;

    public ?Photo $selectedPhoto = null;

    public function store()
    {
        $this->validate();

        $path = $this->photo->storePubliclyAs(
            'photos',
            now()->format('Y-m-d') . '-' . Str::uuid() . '.' . $this->photo->getClientOriginalExtension(),
            'public'
        );

        Photo::create([
            'name' => $this->name,
            'captured_at' => $this->capturedAt,
            'path' => $path
        ]);

        $this->reset();

        Flux::toast(variant: 'success', text: 'Photo Uploaded!', duration: 3000);
    }

    public function confirm($id)
    {
        $this->selectedPhoto = Photo::findOrFail($id);

        Flux::modal('destroy-photo')->show();
    }

    public function destroy()
    {
        if (Storage::disk('public')->exists($this->selectedPhoto->path)) {            
            Storage::disk('public')->delete($this->selectedPhoto->path);
        }

        $this->selectedPhoto->forceDelete();

        Flux::modal('destroy-photo')->close();
        Flux::toast(variant: 'success', text: 'Photo Deleted!', duration: 3000);
    }
}
