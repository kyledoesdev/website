<div>
    <x-slot name="header">TV Shows</x-slot>

    <div class="space-y-4 mt-4">
        <flux:card>
            <x-markdown-content :content="$panel" />
        </flux:card>

        <flux:card class="space-y-4">
            <flux:heading size="xl">
                TV Show Catalog
            </flux:heading>

            <flux:separator />

            <flux:accordion transition>
                <x-media-accordian-item
                    :collection="$favorites"
                    :title="'My Favorites'"
                />
                <x-media-accordian-item
                    :collection="$current"
                    :title="'Currently Watching'"
                />
                <x-media-accordian-item
                    :collection="$backlog"
                    :title="'In Backlog'"
                />
                <x-media-accordian-item
                    :collection="$completed"
                    :title="'Watched'"
                />
            </flux:accordion>
        </flux:card>
    </div>
</div>
