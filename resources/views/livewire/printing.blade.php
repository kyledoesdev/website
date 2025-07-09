<div>
    <x-slot name="header">3D Printing</x-slot>

    @auth
        <div class="space-y-6">
            <livewire:panels :type="'3d_printing'" :header="'3D Printing'" />

            <livewire:photos.uploader
                :header="'Upload 3D Prints'"
                :showGallery="false"
            />
        </div>
    @endauth

    @guest
        <flux:card>
            <x-markdown-content :content="App\Models\Panel::firstWhere('name', '3d_printing')->content" />
        </flux:card>

        <livewire:photos.gallery
            :type="App\Models\Asset::THREE_D_PRINTS"
            :header="'3D Printed Creations'"
            :emptyMessage="'No Creations'"
        />
    @endguest
</div>
