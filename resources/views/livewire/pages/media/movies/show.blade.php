<div>
    <x-slot name="header">Movies</x-slot>

    <div class="space-y-4 mt-4">
        <flux:card style="overflow-y: auto; max-height: 400px;">
            <x-markdown-content :content="$panel" :scroll="true" />
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
