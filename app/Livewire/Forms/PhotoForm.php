<?php

namespace App\Livewire\Forms;

use App\Enums\AssetType;
use App\Models\Asset;
use Flux\Flux;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Livewire\Form;

class PhotoForm extends Form
{
    public string $name = '';

    public string $capturedAt = '';

    public string $description = '';

    public string $type = AssetType::PHOTO->value;

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
            'type' => $this->type,
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
        return AssetType::from($this->type)->storageDirectory();
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
        $manager = new ImageManager(new Driver);
        $image = $manager->read($this->photo->getRealPath());

        if ($image->width() > 2000 || $image->height() > 1500) {
            $image->scaleDown(width: 2000, height: 1500);
            $image->save($this->photo->getRealPath());
        }
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string',
            'capturedAt' => 'nullable|date',
            'description' => 'nullable|string|max:255',
            'type' => [
                'required',
                'string',
                Rule::in([AssetType::PHOTO->value, AssetType::THREE_D_PRINTS->value]),
            ],
            'photo' => 'image:mimes:png,jpg,jpeg,gif,jfif',
        ];
    }

    protected function messages(): array
    {
        return [
            'type.in' => 'The Photo Type is Required',
        ];
    }
}
