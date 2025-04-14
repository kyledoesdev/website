<div>
    <x-slot name="header">Movies</x-slot>

    <div class="space-y-4 mt-4">
        <flux:card style="overflow-y: auto; max-height: 400px;">
            <x-markdown-content :content="$panel" />
        </flux:card>

        <flux:card class="space-y-4">
            <flux:heading size="xl">
                Movie Catalog
            </flux:heading>

            <flux:separator />

            <flux:accordion transition>
                <x-media-accordian-item
                    :collection="$favorites"
                    :title="'My Favorites'"
                    :pageName="'Favorites'"
                />
                <x-media-accordian-item
                    :collection="$backlog"
                    :title="'In Backlog'"
                    :pageName="'Backlog'"
                />
                <x-media-accordian-item
                    :collection="$completed"
                    :title="'Watched'"
                    :pageName="'Completed'"
                />
            </flux:accordion>
        </flux:card>
    </div>
</div>
