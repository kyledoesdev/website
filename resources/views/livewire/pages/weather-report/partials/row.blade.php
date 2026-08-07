<flux:table.row>
    <flux:table.cell class="whitespace-nowrap">{{ $city->city }}</flux:table.cell>

    <flux:table.cell>{{ $city->state }}</flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">{{ $city->latitude }}</flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">{{ $city->longitude }}</flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">{{ $city->created_at }}</flux:table.cell>

    <flux:table.cell class="whitespace-nowrap">{{ $city->updated_at }}</flux:table.cell>

    <flux:table.cell>
        <flux:button
            variant="danger"
            size="sm"
            icon="trash"
            inset="top bottom"
            wire:click="destroy"
            wire:confirm="Are you sure you want to remove this city from the weather report?"
        />
    </flux:table.cell>
</flux:table.row>
