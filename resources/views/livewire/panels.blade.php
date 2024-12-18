<div>
    @foreach ($this->panels as $panel)
        <h5 class="mx-1 mb-4">{{ $panel->display_name }}</h5>

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
</div>
