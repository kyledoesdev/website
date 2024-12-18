<?php

namespace App\Livewire;

use App\Models\Photo;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PhotoUpload extends Component
{
    use WithPagination;
    use WithFileUploads;

    #[Validate('required|string')]
    public string $name;

    #[Validate('required|date')]
    public string $capturedAt;

    #[Validate('image:mimes:png,jpg,jpeg,gif,jfif')]
    public $photo;

    public ?Photo $selectedPhoto = null;

    public function render()
    {
        return view('livewire.photo-upload');
    }

    #[Computed]
    public function photos()
    {
        return Photo::paginate(6);
    }

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
