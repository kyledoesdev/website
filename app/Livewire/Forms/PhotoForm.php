<?php

namespace App\Livewire\Forms;

use App\Models\Asset;
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

    public function store()
    {
        $this->validate();

        $path = $this->photo->storePubliclyAs(
            'photos',
            now()->format('Y-m-d').'-'.Str::uuid().'.'.$this->photo->getClientOriginalExtension(),
            's3'
        );

        Asset::create([
            'type_id' => Asset::PHOTO,
            'name' => $this->name,
            'slug' => Str::uuid(),
            'path' => $path,
            'mime_type' => $this->photo->getClientOriginalExtension(),
            'data' => ['captured_at' => $this->capturedAt],
        ]);

        $this->reset();

        Flux::toast(variant: 'success', text: 'Photo Uploaded!', duration: 3000);
    }

    public function destroy($id)
    {
        $photo = Asset::findOrFail($id);

        if (Storage::disk('s3')->exists($photo->path)) {
            Storage::disk('s3')->delete($photo->path);
        }

        $photo->delete();

        Flux::toast(variant: 'success', text: 'Photo Deleted!', duration: 3000);
    }
}
