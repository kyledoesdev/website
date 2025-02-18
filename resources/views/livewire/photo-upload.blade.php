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
                <flux:input wire:model="name" label="Name" desription="The photo's name/caption." required />
            </div>
            <div class="mx-4">
                <flux:input type="date" wire:model="capturedAt" label="Captured At" requried />
            </div>
            <div class="mx-4">
                <flux:input type="file" wire:model="photo" label="Photo" />
            </div>
        </div>
    </div>

    <div class="flex justify-center mb-4">
        <flux:button variant="primary" size="xs" wire:click="store" icon="arrow-up-tray">Upload</flux:button>
    </div>

    <flux:separator />

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 space-y-4 mt-4">
        @foreach ($this->photos as $photo)
            <flux:card>
                <div class="flex flex-col items-center">
                    <img src="{{ $photo->path }}" alt="{{ $photo->name}}">

                    <div class="my-2 text-center">
                        <span>{{ $photo->name }} - {{ $photo->captured_at->format('F d, Y') }}</span>
                    </div>

                    <flux:button variant="danger" size="sm" icon="trash" wire:click="confirm({{ $photo->getKey() }})" />
                </div>
            </flux:card>
        @endforeach
    </div>

    <flux:separator class="my-2" />

    <div class="my-6">
        {{ $this->photos->links() }}
    </div>

    {{-- Destroy Confirm Modal --}}
    <flux:modal name="destroy-photo" class="md:w-96 space-y-6">
        <div>
            <flux:heading size="lg">Delete Photo: {{ $selectedPhoto?->name }}?</flux:heading>
            <flux:subheading>Are you sure you want to delete this photo?</flux:subheading>
        </div>

        <div class="flex">
            <flux:spacer />

            <form wire:submit="destroy">
                <flux:button type="submit" variant="danger" size="xs">Delete</flux:button>
            </form>
        </div>
    </flux:modal>
</div>
