<div>
    <x-slot name="header">3D Printing</x-slot>

    <flux:card>
        <x-markdown-content :content="App\Models\Panel::firstWhere('name', '3d_printing')->content" />
    </flux:card>

    <livewire:photos.gallery
        :type="App\Enums\AssetType::THREE_D_PRINTS->value"
        :header="'3D Printed Creations'"
        :emptyMessage="'No Creations'"
    />
</div>
