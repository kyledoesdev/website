<div>
    <div class="flex flex-col mb-2">
        <div class="font-semibold text-xl leading-tight mt-2">
            <h5 class="mb-4">Photo Manager</h5>
            <flux:separator />
        </div>
    </div>

    <div class="flex flex-col my-4">
        <div class="flex justify-center">
            <div class="mx-4">
                <flux:input wire:model="form.name" label="Name" desription="The photo's name/caption." required />
            </div>
            <div class="mx-4">
                <flux:input wire:model="form.capturedAt" type="date" label="Captured At" requried />
            </div>
            <div class="mx-4">
                <flux:input wire:model="form.photo" type="file" label="Photo" />
            </div>
        </div>
    </div>

    <div class="flex justify-center mb-4">
        <flux:button variant="primary" size="xs" wire:click="store" icon="arrow-up-tray">Upload</flux:button>
    </div>

    <flux:separator />

    <div>
        <livewire:photos.gallery />
    </div>
</div>
