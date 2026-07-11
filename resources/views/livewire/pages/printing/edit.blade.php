<div>
    <x-slot name="header">3D Printing</x-slot>

    <div class="space-y-6">
        <livewire:panels :type="'3d_printing'" :header="'3D Printing'" />

        <livewire:photos.uploader
            :header="'Upload 3D Prints'"
            :showGallery="true"
            :galleryType="App\Enums\AssetType::THREE_D_PRINTS->value"
        />
    </div>
</div>
