<flux:table.row>
    <flux:table.cell>
        <i class="text-4xl md:text-6xl px-1 {{ $technology->icon }}"></i>
    </flux:table.cell>

    <flux:table.cell>
        <flux:input wire:model.blur="name" size="sm" />
    </flux:table.cell>

    <flux:table.cell>
        <flux:input wire:model.blur="description" size="sm" />
    </flux:table.cell>

    <flux:table.cell>
        <flux:input wire:model.blur="icon" size="sm" />
    </flux:table.cell>

    <flux:table.cell>
        <flux:button
            variant="ghost"
            size="sm"
            icon="trash"
            inset="top bottom"
            wire:click="destroy"
            wire:confirm="Are you sure you want to delete this technology?"
        />
    </flux:table.cell>
</flux:table.row>
