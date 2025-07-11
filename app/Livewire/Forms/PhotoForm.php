<?php

namespace App\Livewire\Forms;

use App\Models\Asset;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PhotoForm extends Form
{
    #[Validate('required|string')]
    public ?string $name;

    #[Validate('nullable|date')]
    public ?string $capturedAt;

    #[Validate('nullable|string|max:255')]
    public ?string $description;

    #[Validate('required|integer|in:1,3', message: 'The Photo Type is Required')]
    public int $type = Asset::PHOTO;

    #[Validate('image:mimes:png,jpg,jpeg,gif,jfif')]
    public $photo;

    public function store()
    {
        $this->validate();

        $this->processImage();

        $path = $this->photo->storePubliclyAs(
            $this->getStorageDirectory(),
            $this->generateFilename(),
            $this->getStorageDisk()
        );

        Asset::create([
            'type_id' => $this->type,
            'name' => $this->name,
            'slug' => Str::uuid(),
            'path' => $path,
            'mime_type' => $this->photo->getClientOriginalExtension(),
            'data' => [
                'captured_at' => $this->capturedAt,
                'description' => $this->description,
            ],
        ]);

        $this->reset();

        Flux::toast(variant: 'success', text: 'Photo Uploaded!', duration: 3000);
    }

    public function destroy($id)
    {
        $photo = Asset::findOrFail($id);

        if (Storage::disk($this->getStorageDisk())->exists($photo->path)) {
            Storage::disk($this->getStorageDisk())->delete($photo->path);
        }

        $photo->delete();

        Flux::toast(variant: 'success', text: 'Photo Deleted!', duration: 3000);
    }

    private function getStorageDirectory(): string
    {
        return match ($this->type) {
            Asset::THREE_D_PRINTS => '3D_prints',
            default => 'photos',
        };
    }

    private function generateFilename(): string
    {
        return now()->format('Y-m-d').'-'.Str::uuid().'.'.$this->photo->getClientOriginalExtension();
    }

    private function getStorageDisk(): string
    {
        return app()->environment('production') ? 's3' : 'public';
    }

    private function processImage(): void
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->photo->getRealPath());
        
        if ($image->width() > 2000 || $image->height() > 1500) {
            $image->scaleDown(width: 2000, height: 1500);
            $image->save($this->photo->getRealPath());
        }
    }
}
