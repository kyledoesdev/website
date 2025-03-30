<div>
    <x-slot name="header">Video Games</x-slot>

    <div class="space-y-4 mt-4">
        <flux:card>
            <x-markdown-content :content="$panel" />
        </flux:card>

        <flux:card class="space-y-4">
            <flux:heading size="xl">
                Video Game Catalog
            </flux:heading>

            <flux:separator />

            <flux:accordion transition>
                <x-media-accordian-item
                    :collection="$favorites"
                    :title="'My Favorites'"
                />
                <x-media-accordian-item
                    :collection="$current"
                    :title="'Currently Playing'"
                />
                <x-media-accordian-item
                    :collection="$backlog"
                    :title="'In Backlog'"
                />
                <x-media-accordian-item
                    :collection="$completed"
                    :title="'Completed'"
                />
            </flux:accordion>
        </flux:card>
    </div>
</div>
