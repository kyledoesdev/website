<div>
    <x-slot name="header">Blog Post Views</x-slot>

    <flux:card class="mt-4">
        <flux:table :paginate="$this->views">
            @forelse ($this->views as $view)
                @if ($loop->first)
                    <flux:table.columns>
                        <flux:table.column sortable :sorted="$sortBy === 'ip_address'" :direction="$sortDirection" wire:click="sort('ip_address')">IP Address</flux:table.column>
                        <flux:table.column sortable :sorted="$sortBy === 'timezone'" :direction="$sortDirection" wire:click="sort('timezone')">Timezone</flux:table.column>
                        <flux:table.column sortable :sorted="$sortBy === 'created_at'" :direction="$sortDirection" wire:click="sort('created_at')">First Viewed At</flux:table.column>
                        <flux:table.column sortable :sorted="$sortBy === 'last_viewed_at'" :direction="$sortDirection" wire:click="sort('last_viewed_at')">Last Viewed At</flux:table.column>
                    </flux:table.columns>
                @endif

                <flux:table.row :key="$view->getKey()">
                    <flux:table.cell>
                        {{ $view->ip_address }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $view->timezone }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $view->first_viewed_at }}
                    </flux:table.cell>

                    <flux:table.cell>
                        {{ $view->last_viewed_at }}
                    </flux:table.cell>
                </flux:table.row>
            @empty
            @endforelse
        </flux:table>
    </flux:card>
</div>
