<div>
    <flux:card>
        <div class="flex flex-col mb-2">
            <div class="font-semibold text-xl leading-tight mt-2">
                <h5 class="mb-4">{{ $header }}</h5>
                <flux:separator />
            </div>
        </div>

        <div class="flex flex-col my-4 space-y-2">
            <flux:input wire:model="form.name" label="Name" desription="The photo's name/caption." required />
            <flux:input wire:model="form.description" label="Description" desription="What the photo is." required />
            <flux:input wire:model="form.capturedAt" type="date" label="Captured At" requried />
            <flux:radio.group wire:model="form.type" variant="buttons" class="w-full md:w-1/3 *:flex-1" label="Photo Type">
                <flux:radio icon="camera" :value="App\Models\Asset::PHOTO">Photo</flux:radio>
                <flux:radio icon="cube" :value="App\Models\Asset::THREE_D_PRINTS">3D Print</flux:radio>
            </flux:radio.group>

            <flux:input wire:model="form.photo" type="file" label="Photo" />
        </div>

        <flux:separator  class="my-4 "/>

        <div class="flex mb-4">
            <flux:button variant="primary" size="xs" wire:click="store" icon="arrow-up-tray">Upload</flux:button>
        </div>

        @if ($this->showGallery)
            <flux:separator />

            <div>
                <livewire:photos.gallery />
            </div>
        @endif
    </flux:card>
</div>
