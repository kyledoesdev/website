<div>
    <x-slot name="header">{{ $header }}</x-slot>

    <flux:card>
        @foreach ($this->panels as $panel)
            <flux:heading class="mb-4" size="xl">
                {{ $panel->display_name }}
            </flux:heading>

            <div class="mb-2">
                <flux:editor wire:model="content.{{ $panel->name }}" />
            </div>

            <div class="flex justify-end">
                <flux:button
                    variant="primary"
                    size="sm"
                    wire:click="update({{ $panel }})"
                >
                    Update
                </flux:button>
            </div>
        @endforeach
    </flux:card>
</div>
